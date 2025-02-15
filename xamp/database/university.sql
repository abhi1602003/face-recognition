-- Create Database
CREATE DATABASE UniversityDB;

-- Use the created database
USE UniversityDB;

-- Create Department table
CREATE TABLE Department (
    department_no INT AUTO_INCREMENT PRIMARY KEY,
    department_name VARCHAR(100) NOT NULL UNIQUE
);

-- Create Department_Login table
CREATE TABLE Department_Login (
    department_no INT PRIMARY KEY,
    department_name VARCHAR(100) NOT NULL,
    department_password VARCHAR(255) NOT NULL,
    FOREIGN KEY (department_no) REFERENCES Department(department_no),
    FOREIGN KEY (department_name) REFERENCES Department(department_name)
);

-- Create Student table
CREATE TABLE Student (
    student_usn VARCHAR(20) PRIMARY KEY,
    student_name VARCHAR(100) NOT NULL,
    student_phone VARCHAR(15) NOT NULL,
    semester VARCHAR(20) NOT NULL,
    department_no INT,
    student_image BLOB,
    FOREIGN KEY (department_no) REFERENCES Department(department_no)
);

-- Create Teacher table
CREATE TABLE Teacher (
    teacher_id VARCHAR(20) PRIMARY KEY,
    teacher_name VARCHAR(100) NOT NULL,
    teacher_post VARCHAR(100) NOT NULL,
    teacher_phone VARCHAR(15) NOT NULL,
    department_no INT,
    teacher_image BLOB,
    FOREIGN KEY (department_no) REFERENCES Department(department_no)
);

-- Create Admin_Login table
CREATE TABLE Admin_Login (
    Admin_username VARCHAR(50) PRIMARY KEY,
    password VARCHAR(255) NOT NULL
);

-- Create Teacher_Login table
CREATE TABLE Teacher_Login (
    teacher_id VARCHAR(20) PRIMARY KEY,
    teacher_name VARCHAR(100) NOT NULL,
    teacher_password VARCHAR(255) NOT NULL,
    FOREIGN KEY (teacher_id) REFERENCES Teacher(teacher_id)
);

-- Create Student_Attendance table
CREATE TABLE Student_Attendance (
    attendance_id INT AUTO_INCREMENT PRIMARY KEY,
    student_usn VARCHAR(20),
    student_name VARCHAR(100),
    attendance_date DATE NOT NULL,
    attendance_time TIME NOT NULL,
    FOREIGN KEY (student_usn) REFERENCES Student(student_usn),
    INDEX (attendance_date)
);

-- Create Teacher_Attendance table
CREATE TABLE Teacher_Attendance (
    attendance_id INT AUTO_INCREMENT PRIMARY KEY,
    teacher_id VARCHAR(20),
    teacher_name VARCHAR(100),
    attendance_date DATE NOT NULL,
    attendance_time TIME NOT NULL,
    FOREIGN KEY (teacher_id) REFERENCES Teacher(teacher_id),
    INDEX (attendance_date)
);
