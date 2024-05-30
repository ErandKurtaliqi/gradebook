-- Create the database
CREATE DATABASE gradebook;

-- Use the database
USE gradebook;

-- Create the users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('instructor', 'student') NOT NULL
);

-- Create the grades table
CREATE TABLE grades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    course VARCHAR(100) NOT NULL,
    grade INT NOT NULL,
    FOREIGN KEY (student_id) REFERENCES users(id)
);

CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    instructor_id INT NOT NULL,
    FOREIGN KEY (instructor_id) REFERENCES users(id)
);

ALTER TABLE grades
ADD COLUMN course_id INT,
ADD CONSTRAINT fk_course_id FOREIGN KEY (course_id) REFERENCES courses(id);

SET FOREIGN_KEY_CHECKS=0;

INSERT INTO courses (name, instructor_id) VALUES
('Introduction to Programming', 1),            -- Instructor ID: 1
('Data Structures and Algorithms', 1),         -- Instructor ID: 1
('Software Engineering', 2),                   -- Instructor ID: 2
('Digital Electronics', 3),                    -- Instructor ID: 3
('Computer Networks', 3),                      -- Instructor ID: 3
('Web Development', 4),                        -- Instructor ID: 4
('Database Management Systems', 4),            -- Instructor ID: 4
('Operating Systems', 5),                      -- Instructor ID: 5
('Embedded Systems', 6),                       -- Instructor ID: 6
('Artificial Intelligence', 7),                -- Instructor ID: 7
('Computer Architecture', 8),                  -- Instructor ID: 8
('Mobile Application Development', 9),         -- Instructor ID: 9
('Network Security', 10),                      -- Instructor ID: 10
('Cloud Computing', 11),                       -- Instructor ID: 11
('Machine Learning', 12),
('Introduction to Python Programming', 13),       -- Instructor ID: 13
('Advanced Data Structures', 14),                -- Instructor ID: 14
('Software Testing and Quality Assurance', 15),  -- Instructor ID: 15
('Analog Electronics', 16),                      -- Instructor ID: 16
('Wireless Communication', 17),                  -- Instructor ID: 17
('Full-Stack Web Development', 18),               -- Instructor ID: 18
('Big Data Analytics', 19),                       -- Instructor ID: 19
('Linux Administration', 20),                    -- Instructor ID: 20
('Embedded Linux Systems', 21),                   -- Instructor ID: 21
('Natural Language Processing', 22),              -- Instructor ID: 22
('Computer Graphics', 23),                        -- Instructor ID: 23
('iOS App Development', 24),                      -- Instructor ID: 24
('Cybersecurity Fundamentals', 25),               -- Instructor ID: 25
('Internet of Things (IoT)', 26),                 -- Instructor ID: 26
('Blockchain Technology', 27),                    -- Instructor ID: 27
('Data Mining and Warehousing', 28),              -- Instructor ID: 28
('Virtual Reality Development', 29),              -- Instructor ID: 29
('Quantum Computing', 30),                        -- Instructor ID: 30
('Robotics and Automation', 31),                  -- Instructor ID: 31
('Ethical Hacking', 32);                          -- Instructor ID: 12
