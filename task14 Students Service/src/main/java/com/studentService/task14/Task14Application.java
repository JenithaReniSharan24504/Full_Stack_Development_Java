package com.studentService.task14;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.cloud.openfeign.EnableFeignClients;

@SpringBootApplication
@EnableFeignClients
@EnableDiscoveryClient
public class Task14Application {

	public static void main(String[] args) {
		SpringApplication.run(Task14Application.class, args);
		System.out.println("Student Service started on port 8081");
		System.out.println("Registered with Eureka at http://localhost:8761");
	}

}
