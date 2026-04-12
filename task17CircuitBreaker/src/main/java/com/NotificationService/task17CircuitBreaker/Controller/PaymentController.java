package com.NotificationService.task17CircuitBreaker.Controller;
import com.NotificationService.task17CircuitBreaker.Model.Payment;
import com.NotificationService.task17CircuitBreaker.Service.PaymentService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

@RestController
@RequestMapping("/api/payments")
public class PaymentController {

    @Autowired
    private PaymentService paymentService;

    @PostMapping("/process")
    public ResponseEntity<Payment> processPayment(@RequestParam String orderId,
                                                  @RequestParam Double amount,
                                                  @RequestParam String paymentMethod) {
        try {
            Payment payment = paymentService.processPayment(orderId, amount, paymentMethod);
            return ResponseEntity.ok(payment);
        } catch (Exception e) {
            return ResponseEntity.status(HttpStatus.BAD_REQUEST).build();
        }
    }

    @GetMapping("/{orderId}")
    public ResponseEntity<Payment> getPaymentByOrderId(@PathVariable String orderId) {
        try {
            Payment payment = paymentService.getPaymentByOrderId(orderId);
            return ResponseEntity.ok(payment);
        } catch (Exception e) {
            return ResponseEntity.notFound().build();
        }
    }

    @PostMapping("/refund/{orderId}")
    public ResponseEntity<Payment> refundPayment(@PathVariable String orderId) {
        try {
            Payment payment = paymentService.refundPayment(orderId);
            return ResponseEntity.ok(payment);
        } catch (Exception e) {
            return ResponseEntity.status(HttpStatus.BAD_REQUEST).body(null);
        }
    }
}
