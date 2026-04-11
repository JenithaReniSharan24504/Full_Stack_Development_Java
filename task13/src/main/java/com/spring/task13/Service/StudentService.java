package com.spring.task13.Service;
import com.spring.task13.Exception.ResourceNotFoundException;
import com.spring.task13.Model.Student;
import com.spring.task13.Repository.StudentRepository;
import org.springframework.beans.factory.annotation.Autowired;
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

    public Student getStudentById(Long id) {
        return repository.findById(id)
                .orElseThrow(() ->
                        new ResourceNotFoundException("Student not found with id: " + id));
    }

    public Student updateStudent(Long id, Student updatedStudent) {
        Student student = repository.findById(id)
                .orElseThrow(() ->
                        new ResourceNotFoundException("Student not found with id: " + id));

        student.setName(updatedStudent.getName());
        student.setDepartment(updatedStudent.getDepartment());
        student.setAge(updatedStudent.getAge());

        return repository.save(student);
    }

    public String deleteStudent(Long id) {
        Student student = repository.findById(id)
                .orElseThrow(() ->
                        new ResourceNotFoundException("Student not found with id: " + id));

        repository.delete(student);
        return "Student deleted successfully";
    }
}