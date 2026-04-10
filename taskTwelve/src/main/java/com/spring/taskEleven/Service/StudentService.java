package com.spring.taskEleven.Service;

import com.spring.taskEleven.Model.Student;
import com.spring.taskEleven.Repository.StudentRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.*;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class StudentService {

    @Autowired
    private StudentRepository repository;
    public Student saveStudent(Student student) {
        return repository.save(student);
    }
    public List<Student> getAllStudents() {
        return repository.findAll();
    }
    public List<Student> getByDepartment(String dept) {
        return repository.findByDepartment(dept);
    }
    public List<Student> getByAgeGreater(int age) {
        return repository.findByAgeGreaterThan(age);
    }
    public List<Student> getSortedStudents(String field) {
        return repository.findAll(Sort.by(Sort.Direction.ASC, field));
    }
    public Page<Student> getStudentsWithPagination(int page, int size) {
        Pageable pageable = PageRequest.of(page, size);
        return repository.findAll(pageable);
    }
    public Page<Student> getStudentsWithPaginationAndSort(int page, int size, String field) {
        Pageable pageable = PageRequest.of(page, size, Sort.by(field));
        return repository.findAll(pageable);
    }
}
