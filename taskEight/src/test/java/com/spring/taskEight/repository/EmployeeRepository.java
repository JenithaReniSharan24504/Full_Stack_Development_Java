package com.spring.taskEight.repository;

import com.spring.taskEight.Model.Employee;
import org.springframework.stereotype.Repository;

import java.util.ArrayList;
import java.util.List;
@Repository
public class EmployeeRepository {
    private List<Employee> employeeList = new ArrayList<>();

    public void addEmployee(Employee emp) {
        employeeList.add(emp);
    }

    public List<Employee> getAllEmployees() {
        return employeeList;
    }
}
