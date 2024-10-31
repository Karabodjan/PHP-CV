-- Create database
CREATE DATABASE port_db;

-- Use the database
USE port_db;

CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    pseudo VARCHAR(50),
    lastname VARCHAR(50),
    firstname VARCHAR(50),
    email VARCHAR(100),
    password VARCHAR(255),
    role ENUM('admin', 'user') DEFAULT 'user',
    address VARCHAR(255) DEFAULT NULL,
    phone VARCHAR(20) DEFAULT NULL,
    profile_description TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



-- Insert default data
INSERT INTO personal_info (pseudo, lastname, firstname, email, address, phone, profile_description) 
VALUES ('John Doe', 'Web Developer | Programmer | Tech Enthusiast', 'johndoe@example.com','34 rue luanda 31000 Paris', '(123) 456-7890', 'I am a passionate web developer with experience in creating dynamic websites and applications.');

CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    title VARCHAR(255),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE favorites (
    user_id INT,
    project_id INT,
    PRIMARY KEY (user_id, project_id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (project_id) REFERENCES projects(id)
);

CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT,
    user_id INT,
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

