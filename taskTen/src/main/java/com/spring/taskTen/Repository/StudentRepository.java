package com.spring.taskTen.Repository;

import com.spring.taskTen.Model.Student;
import org.springframework.data.jpa.repository.JpaRepository;

public interface StudentRepository extends JpaRepository<Student, Long> {
}
