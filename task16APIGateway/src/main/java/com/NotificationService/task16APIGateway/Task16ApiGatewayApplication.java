package com.NotificationService.task16APIGateway;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.cloud.client.discovery.EnableDiscoveryClient;

@SpringBootApplication
@EnableDiscoveryClient
public class Task16ApiGatewayApplication {

	public static void main(String[] args) {
		SpringApplication.run(Task16ApiGatewayApplication.class, args);
	}

}
