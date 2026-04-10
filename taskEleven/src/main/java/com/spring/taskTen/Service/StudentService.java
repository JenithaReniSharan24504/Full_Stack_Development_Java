package com.spring.taskTen.Service;

import com.spring.taskTen.Model.Student;
import com.spring.taskTen.Repository.StudentRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.*;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class StudentService {

    @Autowired
    private StudentRepository repository;

    // Save student
    public Student saveStudent(Student student) {
        return repository.save(student);
    }

    // Get all students
    public List<Student> getAllStudents() {
        return repository.findAll();
    }

    // Find by department
    public List<Student> getByDepartment(String dept) {
        return repository.findByDepartment(dept);
    }

    // Find by age > given
    public List<Student> getByAgeGreater(int age) {
        return repository.findByAgeGreaterThan(age);
    }

    // Sorting
    public List<Student> getSortedStudents(String field) {
        return repository.findAll(Sort.by(Sort.Direction.ASC, field));
    }

    // Pagination
    public Page<Student> getStudentsWithPagination(int page, int size) {
        Pageable pageable = PageRequest.of(page, size);
        return repository.findAll(pageable);
    }

    // Pagination + Sorting
    public Page<Student> getStudentsWithPaginationAndSort(int page, int size, String field) {
        Pageable pageable = PageRequest.of(page, size, Sort.by(field));
        return repository.findAll(pageable);
    }
}
