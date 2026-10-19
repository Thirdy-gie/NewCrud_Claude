-- CampusHub Student Management System
-- Import into MySQL/MariaDB on a fresh database.
-- This script does not DROP existing tables or erase existing records.
CREATE DATABASE IF NOT EXISTS flores_2ee CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE flores_2ee;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  student_no VARCHAR(30) NULL UNIQUE,
  full_name VARCHAR(100) NOT NULL,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','student') NOT NULL DEFAULT 'student',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS subjects (
  id INT AUTO_INCREMENT PRIMARY KEY,
  subject_code VARCHAR(20) NOT NULL UNIQUE,
  subject_name VARCHAR(100) NOT NULL,
  units INT NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS enrollments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  student_id INT NOT NULL,
  subject_id INT NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uq_student_subject (student_id, subject_id),
  CONSTRAINT fk_enrollment_student FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_enrollment_subject FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Demo accounts. Password hashes correspond to admin123 and student123.
INSERT IGNORE INTO users (student_no, full_name, username, password, role) VALUES
(NULL, 'System Administrator', 'admin', '$2y$12$kyGmVMqZHnhqCyh89Q9jxeVZ1Z9xoBCd4ZX/rIFo3I.laZWK0XJde', 'admin'),
('2026-0001', 'Juan Dela Cruz', 'juan', '$2y$12$K2wcAyd47mAWVY5dDxRGp.yFlRKWj73Rrzvc9jgYSrgb0PI0av9vW', 'student');

INSERT IGNORE INTO subjects (subject_code, subject_name, units) VALUES
('IT101', 'Introduction to Computing', 3),
('IT102', 'Computer Programming 1', 3),
('GE101', 'Mathematics in the Modern World', 3),
('GE102', 'Understanding the Self', 3);

-- Seed sample enrollments only when the expected demo records exist.
INSERT IGNORE INTO enrollments (student_id, subject_id)
SELECT u.id, s.id FROM users u JOIN subjects s ON s.subject_code IN ('IT101','IT102')
WHERE u.username='juan';
