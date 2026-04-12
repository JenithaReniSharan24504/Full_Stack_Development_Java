package com.NotificationService.task17OrderService.Client;
import com.NotificationService.task17OrderService.Model.PaymentResponse;
import lombok.extern.slf4j.Slf4j;
import org.springframework.stereotype.Component;

@Component
@Slf4j
public class PaymentClientFallback implements PaymentClient {

    @Override
    public PaymentResponse processPayment(String orderId, Double amount, String paymentMethod) {
        log.error("Fallback: Payment service is unavailable for order: {}", orderId);

        PaymentResponse fallbackResponse = new PaymentResponse();
        fallbackResponse.setOrderId(orderId);
        fallbackResponse.setAmount(amount);
        fallbackResponse.setStatus("FALLBACK");
        fallbackResponse.setFailureReason("Payment service is currently unavailable. Please try again later.");

        return fallbackResponse;
    }

    @Override
    public PaymentResponse getPaymentByOrderId(String orderId) {
        log.error("Fallback: Unable to fetch payment status for order: {}", orderId);

        PaymentResponse fallbackResponse = new PaymentResponse();
        fallbackResponse.setOrderId(orderId);
        fallbackResponse.setStatus("SERVICE_UNAVAILABLE");
        fallbackResponse.setFailureReason("Payment service is currently unavailable");

        return fallbackResponse;
    }

    @Override
    public PaymentResponse refundPayment(String orderId) {
        log.error("Fallback: Unable to process refund for order: {}", orderId);

        PaymentResponse fallbackResponse = new PaymentResponse();
        fallbackResponse.setOrderId(orderId);
        fallbackResponse.setStatus("REFUND_FAILED");
        fallbackResponse.setFailureReason("Payment service unavailable for refund processing");

        return fallbackResponse;
    }
}