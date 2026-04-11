package com.NotificationService.task14.Model;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;
import java.time.LocalDateTime;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class Notification {
    private String id;
    private String to;
    private String subject;
    private String body;
    private LocalDateTime timestamp;
    private NotificationStatus status;

    public enum NotificationStatus {
        SENT, FAILED, PENDING
    }
}