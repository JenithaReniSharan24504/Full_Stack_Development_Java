package com.NotificationService.task17OrderService.Model;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class PaymentResponse {
    private String id;
    private String orderId;
    private Double amount;
    private String paymentMethod;
    private String status;
    private String paymentDate;
    private String transactionId;
    private String failureReason;
}