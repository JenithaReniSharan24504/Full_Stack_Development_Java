package com.NotificationService.task17OrderService.Repository;
import com.NotificationService.task17OrderService.Model.Order;
import com.NotificationService.task17OrderService.Model.OrderStatus;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;
import java.util.List;

@Repository
public interface OrderRepository extends JpaRepository<Order, String> {
    List<Order> findByCustomerEmail(String email);
    List<Order> findByStatus(OrderStatus status);
}