package com.spring.taskEight.service;

import com.spring.taskEight.Model.Employee;
import com.spring.taskEight.repository.EmployeeRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;
@Service
public class EmployeeService {
    @Autowired
    private EmployeeRepository repository;

    public void createEmployee(int id, String name, double salary) {
        Employee emp = new Employee(id, name, salary);
        repository.addEmployee(emp);
    }

    public List<Employee> fetchEmployees() {
        return repository.getAllEmployees();
    }
}
