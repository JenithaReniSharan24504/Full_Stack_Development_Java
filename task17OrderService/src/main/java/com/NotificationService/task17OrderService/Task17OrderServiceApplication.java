package com.NotificationService.task17OrderService;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.cloud.openfeign.EnableFeignClients;

@SpringBootApplication
@EnableFeignClients
public class Task17OrderServiceApplication {

	public static void main(String[] args) {
		SpringApplication.run(Task17OrderServiceApplication.class, args);
	}

}
