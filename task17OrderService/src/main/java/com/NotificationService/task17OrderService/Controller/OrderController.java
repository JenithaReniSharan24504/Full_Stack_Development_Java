package com.NotificationService.task17OrderService.Controller;
import com.NotificationService.task17OrderService.Model.CreateOrderRequest;
import com.NotificationService.task17OrderService.Model.Order;
import com.NotificationService.task17OrderService.Model.PaymentResponse;
import com.NotificationService.task17OrderService.Service.OrderService;
import jakarta.validation.Valid;
import jakarta.validation.constraints.*;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;
import java.util.List;

@RestController
@RequestMapping("/api/orders")
public class OrderController {

    @Autowired
    private OrderService orderService;

    @PostMapping("/create")
    public ResponseEntity<Order> createOrder(@Valid @RequestBody CreateOrderRequest request) {
        Order order = orderService.createOrder(
                request.getCustomerName(),
                request.getCustomerEmail(),
                request.getItems(),
                request.getTotalAmount()
        );
        return new ResponseEntity<>(order, HttpStatus.CREATED);
    }

    @GetMapping("/{orderId}")
    public ResponseEntity<Order> getOrderById(@PathVariable String orderId) {
        return ResponseEntity.ok(orderService.getOrderById(orderId));
    }

    @GetMapping("/{orderId}/payment-status")
    public ResponseEntity<PaymentResponse> getPaymentStatus(@PathVariable String orderId) {
        PaymentResponse paymentStatus = orderService.getPaymentStatus(orderId);
        return ResponseEntity.ok(paymentStatus);
    }

    @PostMapping("/{orderId}/cancel")
    public ResponseEntity<Order> cancelOrder(@PathVariable String orderId) {
        Order cancelledOrder = orderService.cancelOrder(orderId);
        return ResponseEntity.ok(cancelledOrder);
    }

    @GetMapping
    public ResponseEntity<List<Order>> getAllOrders() {
        return ResponseEntity.ok(orderService.getAllOrders());
    }

    @GetMapping("/health")
    public ResponseEntity<String> health() {
        return ResponseEntity.ok("Order Service is UP");
    }
}
