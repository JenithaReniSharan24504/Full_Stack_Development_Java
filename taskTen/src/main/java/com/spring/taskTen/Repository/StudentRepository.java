package com.spring.taskTen.Repository;

import com.spring.taskTen.Model.Student;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import java.util.List;

public interface StudentRepository extends JpaRepository<Student, Long> {

    List<Student> findByDepartment(String department);
    List<Student> findByAgeGreaterThan(int age);
    List<Student> findByDepartmentAndAgeGreaterThan(String department, int age);
    @Query("SELECT s FROM Student s WHERE s.age < :age")
    List<Student> findStudentsYoungerThan(int age);
    Page<Student> findByDepartment(String department, Pageable pageable);
}
