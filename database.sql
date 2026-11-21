CREATE DATABASE IF NOT EXISTS notebook_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE notebook_db;

CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    surname VARCHAR(100) NOT NULL,
    name VARCHAR(100) NOT NULL,
    patronymic VARCHAR(100) DEFAULT '',
    gender VARCHAR(10) NOT NULL,
    birthdate DATE NOT NULL,
    phone VARCHAR(30) NOT NULL,
    address VARCHAR(255) DEFAULT '',
    email VARCHAR(100) DEFAULT '',
    comment TEXT
);
