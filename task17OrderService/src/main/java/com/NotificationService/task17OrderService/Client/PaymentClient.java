package com.NotificationService.task17OrderService.Client;
import com.NotificationService.task17OrderService.Model.PaymentResponse;
import org.springframework.cloud.openfeign.FeignClient;
import org.springframework.web.bind.annotation.*;

@FeignClient(
        name = "payment-service",
        url = "${payment.service.url:http://localhost:8082}", // Fallback URL if service discovery is not used
        fallback = PaymentClientFallback.class  // Reference the fallback class
)
public interface PaymentClient {

    @PostMapping("/api/payments/process")
    PaymentResponse processPayment(@RequestParam String orderId,
                                   @RequestParam Double amount,
                                   @RequestParam String paymentMethod);

    @GetMapping("/api/payments/{orderId}")
    PaymentResponse getPaymentByOrderId(@PathVariable("orderId") String orderId);

    @PostMapping("/api/payments/refund/{orderId}")
    PaymentResponse refundPayment(@PathVariable("orderId") String orderId);
}