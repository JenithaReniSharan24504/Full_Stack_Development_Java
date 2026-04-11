package com.NotificationService.task14.Controller;
import com.NotificationService.task14.Service.NotificationService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

@RestController
@RequestMapping("/api/notifications")
public class NotificationController {

    @Autowired
    private NotificationService notificationService;

    @PostMapping("/send")
    public void sendNotification(@RequestParam String to,
                                 @RequestParam String subject,
                                 @RequestParam String body) {
        notificationService.sendNotification(to, subject, body);
    }
}