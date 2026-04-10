package com.spring.taskEleven.Controller;

import com.spring.taskEleven.Model.Student;
import com.spring.taskEleven.Service.StudentService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/students")
public class StudentController {

    @Autowired
    private StudentService service;
    @PostMapping
    public Student addStudent(@RequestBody Student student) {
        return service.saveStudent(student);
    }
    @GetMapping
    public List<Student> getAll() {
        return service.getAllStudents();
    }
    @GetMapping("/department/{dept}")
    public List<Student> getByDepartment(@PathVariable String dept) {
        return service.getByDepartment(dept);
    }
    @GetMapping("/age/{age}")
    public List<Student> getByAge(@PathVariable int age) {
        return service.getByAgeGreater(age);
    }
    @GetMapping("/sorted/{field}")
    public List<Student> getSorted(@PathVariable String field) {
        return service.getSortedStudents(field);
    }
    @GetMapping("/pagination")
    public Page<Student> getPagination(
            @RequestParam int page,
            @RequestParam int size) {
        return service.getStudentsWithPagination(page, size);
    }
    @GetMapping("/pagination-sort")
    public Page<Student> getPaginationSort(
            @RequestParam int page,
            @RequestParam int size,
            @RequestParam String field) {
        return service.getStudentsWithPaginationAndSort(page, size, field);
    }
}