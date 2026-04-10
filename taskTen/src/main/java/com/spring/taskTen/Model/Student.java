package com.spring.taskTen.Model;

import jakarta.persistence.*;
import lombok.Data;

@Entity
@Table(name = "students")
@Data
public class Student {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    private String name;
    private String department;
    private int age;
    public Student() {}

    public Student(String name, String department, int age) {
        this.name = name;
        this.department = department;
        this.age = age;
    }
}
