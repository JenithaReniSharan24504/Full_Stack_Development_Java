package com.NotificationService.task17CircuitBreaker.Service;
import com.NotificationService.task17CircuitBreaker.Model.Payment;
import com.NotificationService.task17CircuitBreaker.Model.PaymentStatus;
import com.NotificationService.task17CircuitBreaker.Repository.PaymentRepository;
import lombok.extern.slf4j.Slf4j;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import java.time.LocalDateTime;
import java.util.UUID;

@Service
@Slf4j
public class PaymentService {

    @Autowired
    private PaymentRepository paymentRepository;

    public Payment processPayment(String orderId, Double amount, String paymentMethod) {
        log.info("Processing payment for order: {}, amount: {}", orderId, amount);

        // Check if payment already exists
        if (paymentRepository.findByOrderId(orderId).isPresent()) {
            throw new RuntimeException("Payment already processed for this order");
        }

        Payment payment = new Payment();
        payment.setOrderId(orderId);
        payment.setAmount(amount);
        payment.setPaymentMethod(paymentMethod);
        payment.setPaymentDate(LocalDateTime.now());
        payment.setTransactionId("TXN-" + UUID.randomUUID().toString().substring(0, 8));

        // Simulate payment processing with 80% success rate for testing
        boolean paymentSuccess = Math.random() > 0.2;

        if (paymentSuccess) {
            payment.setStatus(PaymentStatus.SUCCESS);
            log.info("Payment successful for order: {}", orderId);
        } else {
            payment.setStatus(PaymentStatus.FAILED);
            payment.setFailureReason("Insufficient funds");
            log.error("Payment failed for order: {}", orderId);
        }

        return paymentRepository.save(payment);
    }

    public Payment getPaymentByOrderId(String orderId) {
        return paymentRepository.findByOrderId(orderId)
                .orElseThrow(() -> new RuntimeException("Payment not found for order: " + orderId));
    }

    public Payment refundPayment(String orderId) {
        Payment payment = getPaymentByOrderId(orderId);

        if (payment.getStatus() != PaymentStatus.SUCCESS) {
            throw new RuntimeException("Cannot refund failed payment");
        }

        payment.setStatus(PaymentStatus.REFUNDED);
        payment.setFailureReason("Refund processed");

        log.info("Payment refunded for order: {}", orderId);
        return paymentRepository.save(payment);
    }
}