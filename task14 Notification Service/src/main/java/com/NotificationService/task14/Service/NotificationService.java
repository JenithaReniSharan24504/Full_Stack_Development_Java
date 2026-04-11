package com.NotificationService.task14.Service;
import com.NotificationService.task14.Model.Notification;
import lombok.extern.slf4j.Slf4j;
import org.springframework.stereotype.Service;
import java.time.LocalDateTime;
import java.util.UUID;

@Service
@Slf4j
public class NotificationService {

    public void sendNotification(String to, String subject, String body) {
        // Create notification object
        Notification notification = new Notification(
                UUID.randomUUID().toString(),
                to,
                subject,
                body,
                LocalDateTime.now(),
                Notification.NotificationStatus.SENT
        );

        // Log the notification (in real implementation, send email/SMS)
        log.info("========================================");
        log.info("NOTIFICATION SENT:");
        log.info("To: {}", notification.getTo());
        log.info("Subject: {}", notification.getSubject());
        log.info("Body: {}", notification.getBody());
        log.info("Timestamp: {}", notification.getTimestamp());
        log.info("Status: {}", notification.getStatus());
        log.info("========================================");

        // Simulate email sending
        // In production, uncomment this:
        // sendEmail(to, subject, body);
    }

    private void sendEmail(String to, String subject, String body) {
        // Implement actual email sending logic here
        // Using JavaMailSender
        log.info("Sending actual email to: {}", to);
    }
}