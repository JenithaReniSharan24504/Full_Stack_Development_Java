package com.NotificationService.task15EurekaServer;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.cloud.netflix.eureka.server.EnableEurekaServer;

@SpringBootApplication
@EnableEurekaServer
public class Task15EurekaServerApplication {

	public static void main(String[] args) {
		SpringApplication.run(Task15EurekaServerApplication.class, args);
		System.out.println("Eureka Server started at http://localhost:8761");
	}

}
