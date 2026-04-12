package com.NotificationService.task17CircuitBreaker.Repository;

import com.NotificationService.task17CircuitBreaker.Model.Payment;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.Optional;

@Repository
public interface PaymentRepository extends JpaRepository<Payment, String> {
    Optional<Payment> findByOrderId(String orderId);
    boolean existsByOrderId(String orderId);
}
