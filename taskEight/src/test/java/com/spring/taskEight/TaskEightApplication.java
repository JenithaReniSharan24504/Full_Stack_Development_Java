package com.spring.taskEight;

import com.spring.taskEight.config.AppConfig;
import com.spring.taskEight.service.EmployeeService;
import org.springframework.beans.factory.BeanFactory;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.context.annotation.AnnotationConfigApplicationContext;

@SpringBootApplication
public class TaskEightApplication {
	public static void main(String[] args) {

		BeanFactory factory = new AnnotationConfigApplicationContext(AppConfig.class);

		EmployeeService service = factory.getBean(EmployeeService.class);

		service.createEmployee(1, "John", 50000);
		service.createEmployee(2, "Alice", 60000);

		service.fetchEmployees().forEach(System.out::println);
	}
}