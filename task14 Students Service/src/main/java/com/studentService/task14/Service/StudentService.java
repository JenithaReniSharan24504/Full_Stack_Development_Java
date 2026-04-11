package com.studentService.task14.Service;
import com.studentService.task14.Model.Student;
import com.studentService.task14.Repository.StudentRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import java.util.List;

@Service
public class StudentService {

    @Autowired
    private StudentRepository studentRepository;

    @Autowired
    private NotificationClient notificationClient;

    public Student createStudent(Student student) {
        if (studentRepository.existsByEmail(student.getEmail())) {
            throw new RuntimeException("Student with this email already exists");
        }

        Student savedStudent = studentRepository.save(student);

        // Send notification asynchronously
        notificationClient.sendNotification(
                savedStudent.getEmail(),
                "Welcome!",
                "Dear " + savedStudent.getName() + ", you have been registered successfully."
        );

        return savedStudent;
    }

    public List<Student> getAllStudents() {
        return studentRepository.findAll();
    }

    public Student getStudentById(Long id) {
        return studentRepository.findById(id)
                .orElseThrow(() -> new RuntimeException("Student not found with id: " + id));
    }

    public Student updateStudent(Long id, Student studentDetails) {
        Student existingStudent = getStudentById(id);

        existingStudent.setName(studentDetails.getName());
        existingStudent.setEmail(studentDetails.getEmail());
        existingStudent.setDepartment(studentDetails.getDepartment());
        existingStudent.setAge(studentDetails.getAge());
        existingStudent.setPhoneNumber(studentDetails.getPhoneNumber());

        Student updatedStudent = studentRepository.save(existingStudent);

        // Send update notification
        notificationClient.sendNotification(
                updatedStudent.getEmail(),
                "Profile Updated",
                "Your profile has been successfully updated."
        );

        return updatedStudent;
    }

    public void deleteStudent(Long id) {
        Student student = getStudentById(id);
        studentRepository.delete(student);

        // Send deletion notification
        notificationClient.sendNotification(
                student.getEmail(),
                "Account Deleted",
                "Your student account has been deleted."
        );
    }
}