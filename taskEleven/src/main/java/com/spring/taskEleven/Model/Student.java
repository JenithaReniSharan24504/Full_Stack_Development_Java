package com.spring.taskEleven.Model;

import jakarta.persistence.*;
import lombok.Data;

@Data
@Entity
@Table(name = "students")
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