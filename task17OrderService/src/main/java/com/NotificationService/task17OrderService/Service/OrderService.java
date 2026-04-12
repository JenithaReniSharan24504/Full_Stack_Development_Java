package com.NotificationService.task17OrderService.Service;
import com.NotificationService.task17OrderService.Client.PaymentClient;
import com.NotificationService.task17OrderService.Model.Order;
import com.NotificationService.task17OrderService.Model.OrderStatus;
import com.NotificationService.task17OrderService.Model.PaymentResponse;
import com.NotificationService.task17OrderService.Repository.OrderRepository;
import io.github.resilience4j.circuitbreaker.annotation.CircuitBreaker;
import io.github.resilience4j.retry.annotation.Retry;
import lombok.extern.slf4j.Slf4j;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;
import java.time.LocalDateTime;
import java.util.Arrays;
import java.util.List;

@Service
@Slf4j
public class OrderService {

    @Autowired
    private OrderRepository orderRepository;

    @Autowired
    private PaymentClient paymentClient;

    @Transactional
    public Order createOrder(String customerName, String customerEmail,
                             List<String> items, Double totalAmount) {
        log.info("Creating order for customer: {}", customerEmail);

        Order order = new Order();
        order.setCustomerName(customerName);
        order.setCustomerEmail(customerEmail);
        order.setItems(items);
        order.setTotalAmount(totalAmount);
        order.setStatus(OrderStatus.PENDING);
        order.setOrderDate(LocalDateTime.now());

        Order savedOrder = orderRepository.save(order);
        log.info("Order created with ID: {}", savedOrder.getId());

        // Process payment
        return processPaymentWithRetry(savedOrder);
    }

    @Retry(name = "paymentRetry", fallbackMethod = "handlePaymentFailure")
    @CircuitBreaker(name = "paymentService", fallbackMethod = "handlePaymentCircuitBreaker")
    private Order processPaymentWithRetry(Order order) {
        log.info("Processing payment for order: {}", order.getId());

        order.setStatus(OrderStatus.PAYMENT_PROCESSING);
        orderRepository.save(order);

        // Call payment service via REST
        PaymentResponse paymentResponse = paymentClient.processPayment(
                order.getId(),
                order.getTotalAmount(),
                "CREDIT_CARD"
        );

        if (paymentResponse != null && "SUCCESS".equals(paymentResponse.getStatus())) {
            order.setStatus(OrderStatus.PAID);
            order.setPaymentId(paymentResponse.getId());
            log.info("Payment successful for order: {}", order.getId());
        } else if (paymentResponse != null && "FALLBACK".equals(paymentResponse.getStatus())) {
            order.setStatus(OrderStatus.FAILED);
            order.setFailureReason(paymentResponse.getFailureReason());
            log.error("Payment fallback triggered for order: {}", order.getId());
        } else {
            order.setStatus(OrderStatus.FAILED);
            order.setFailureReason(paymentResponse != null ?
                    paymentResponse.getFailureReason() : "Payment processing failed");
            log.error("Payment failed for order: {}", order.getId());
        }

        return orderRepository.save(order);
    }

    // Fallback method for retry
    private Order handlePaymentFailure(Order order, Exception e) {
        log.error("Payment retry failed for order {}: {}", order.getId(), e.getMessage());

        order.setStatus(OrderStatus.FAILED);
        order.setFailureReason("Payment processing failed after retries: " + e.getMessage());

        return orderRepository.save(order);
    }

    // Fallback method for circuit breaker
    private Order handlePaymentCircuitBreaker(Order order, Exception e) {
        log.error("Circuit breaker open for payment service. Order {} cannot process payment",
                order.getId());

        order.setStatus(OrderStatus.FAILED);
        order.setFailureReason("Payment service is currently unavailable. Circuit breaker activated.");

        return orderRepository.save(order);
    }

    @CircuitBreaker(name = "paymentService", fallbackMethod = "getPaymentStatusFallback")
    public PaymentResponse getPaymentStatus(String orderId) {
        log.info("Fetching payment status for order: {}", orderId);
        return paymentClient.getPaymentByOrderId(orderId);
    }

    private PaymentResponse getPaymentStatusFallback(String orderId, Exception e) {
        log.error("Fallback: Unable to get payment status for order: {}", orderId);

        PaymentResponse fallbackResponse = new PaymentResponse();
        fallbackResponse.setOrderId(orderId);
        fallbackResponse.setStatus("SERVICE_UNAVAILABLE");
        fallbackResponse.setFailureReason("Payment service is currently unavailable");

        return fallbackResponse;
    }

    @Transactional
    @CircuitBreaker(name = "paymentService", fallbackMethod = "cancelOrderFallback")
    public Order cancelOrder(String orderId) {
        log.info("Cancelling order: {}", orderId);

        Order order = orderRepository.findById(orderId)
                .orElseThrow(() -> new RuntimeException("Order not found"));

        if (order.getStatus() == OrderStatus.PAID) {
            // Process refund
            PaymentResponse refundResponse = paymentClient.refundPayment(orderId);

            if (refundResponse != null && "REFUNDED".equals(refundResponse.getStatus())) {
                order.setStatus(OrderStatus.REFUNDED);
                log.info("Order cancelled and refunded: {}", orderId);
            } else {
                order.setStatus(OrderStatus.CANCELLED);
                order.setFailureReason("Refund processing failed");
                log.error("Refund failed for order: {}", orderId);
            }
        } else if (order.getStatus() == OrderStatus.PENDING) {
            order.setStatus(OrderStatus.CANCELLED);
            log.info("Order cancelled before payment: {}", orderId);
        } else {
            throw new RuntimeException("Cannot cancel order in status: " + order.getStatus());
        }

        return orderRepository.save(order);
    }

    private Order cancelOrderFallback(String orderId, Exception e) {
        log.error("Fallback: Unable to cancel order {} due to payment service unavailability", orderId);

        Order order = orderRepository.findById(orderId).orElse(null);
        if (order != null) {
            order.setStatus(OrderStatus.CANCELLED);
            order.setFailureReason("Cancellation initiated but refund pending due to service unavailability");
            return orderRepository.save(order);
        }

        throw new RuntimeException("Order cancellation failed: " + e.getMessage());
    }

    public Order getOrderById(String orderId) {
        return orderRepository.findById(orderId)
                .orElseThrow(() -> new RuntimeException("Order not found"));
    }

    public List<Order> getAllOrders() {
        return orderRepository.findAll();
    }
}