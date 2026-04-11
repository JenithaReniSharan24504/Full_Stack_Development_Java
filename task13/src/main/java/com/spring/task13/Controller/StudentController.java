package com.spring.task13.Controller;

import com.spring.task13.Model.Student;
import com.spring.task13.Service.StudentService;
import jakarta.validation.Valid;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.*;

@RestController
@RequestMapping("/student")
public class StudentController {
    @Autowired
    private StudentService service;
    @PostMapping("/student")
    public Student createStudent(@Valid @RequestBody Student student) {
        return service.saveStudent(student);
    }

    @PutMapping("/student/{id}")
    public Student updateStudent(@PathVariable Long id,
                                 @Valid @RequestBody Student student) {
        return service.updateStudent(id, student);
    }
}
