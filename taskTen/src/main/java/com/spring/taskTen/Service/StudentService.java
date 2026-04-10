package com.spring.taskTen.Service;
import com.spring.taskTen.Model.Student;
import com.spring.taskTen.Repository.StudentRepository;
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
        return repository.findById(id).orElse(null);
    }
    public Student updateStudent(Long id, Student updatedStudent) {
        Student student = repository.findById(id).orElse(null);

        if (student != null) {
            student.setName(updatedStudent.getName());
            student.setDepartment(updatedStudent.getDepartment());
            student.setAge(updatedStudent.getAge());
            return repository.save(student);
        }
        return null;
    }

    public String deleteStudent(Long id) {
        repository.deleteById(id);
        return "Student deleted successfully!";
    }
}
