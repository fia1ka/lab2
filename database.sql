CREATE DATABASE IF NOT EXISTS notebook_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE notebook_db;

DROP TABLE IF EXISTS contacts;

CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    surname VARCHAR(100) NOT NULL,
    name VARCHAR(100) NOT NULL,
    lastname VARCHAR(100) DEFAULT '',
    gender VARCHAR(20) NOT NULL,
    date DATE NOT NULL,
    phone VARCHAR(30) NOT NULL,
    location VARCHAR(255) DEFAULT '',
    email VARCHAR(100) DEFAULT '',
    comment TEXT
);

INSERT INTO contacts (surname, name, lastname, gender, date, phone, location, email, comment) VALUES
('Иванов', 'Иван', 'Иванович', 'мужской', '1995-05-12', '+79991112233', 'г. Москва, ул. Ленина, д. 1', 'ivanov@mail.ru', 'Одногруппник'),
('Петрова', 'Анна', 'Сергеевна', 'женский', '1998-11-23', '+79994445566', 'г. Москва, пр-т Мира, д. 10', 'petrova@mail.ru', 'Староста');
