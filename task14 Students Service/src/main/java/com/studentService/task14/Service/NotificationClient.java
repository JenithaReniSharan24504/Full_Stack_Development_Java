package com.studentService.task14.Service;
import org.springframework.cloud.openfeign.FeignClient;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestParam;

@FeignClient(name = "notification-service", url = "${notification.service.url}")
public interface NotificationClient {

    @PostMapping("/api/notifications/send")
    void sendNotification(@RequestParam String to,
                          @RequestParam String subject,
                          @RequestParam String body);
}