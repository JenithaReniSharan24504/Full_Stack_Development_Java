package com.studentService.task14;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.cloud.openfeign.EnableFeignClients;

@SpringBootApplication
@EnableFeignClients
public class Task14Application {

	public static void main(String[] args) {
		SpringApplication.run(Task14Application.class, args);
	}

}
