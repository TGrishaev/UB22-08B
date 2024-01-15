-- Создание базы данных
CREATE DATABASE IF NOT EXISTS sport_events;

-- Использование созданной базы данных
USE sport_events;

-- Создание таблицы видов спорта
CREATE TABLE IF NOT EXISTS sports (
    sport_id INT PRIMARY KEY AUTO_INCREMENT,
    sport_name VARCHAR(50) NOT NULL
);

-- Вставка примера данных в таблицу видов спорта
INSERT INTO sports (sport_name) VALUES
    ('Футбол'),
    ('Баскетбол'),
    ('Теннис');

-- Создание таблицы мероприятий
CREATE TABLE IF NOT EXISTS events (
    event_id INT PRIMARY KEY AUTO_INCREMENT,
    sport_id INT,
    event_name VARCHAR(100) NOT NULL,
    event_date DATE,
    event_location VARCHAR(200) NOT NULL,
    FOREIGN KEY (sport_id) REFERENCES sports(sport_id)
);

-- Создание таблицы ролей
CREATE TABLE IF NOT EXISTS roles (
    role_id INT PRIMARY KEY AUTO_INCREMENT,
    role_name VARCHAR(50) NOT NULL
);

-- Вставка примера данных в таблицу ролей
INSERT INTO roles (role_name) VALUES
    ('admin'),
    ('user');

-- Создание таблицы пользователей
CREATE TABLE IF NOT EXISTS users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role_id INT,
    FOREIGN KEY (role_id) REFERENCES roles(role_id)
);

-- Создание таблицы отзывов
CREATE TABLE IF NOT EXISTS reviews (
    review_id INT PRIMARY KEY AUTO_INCREMENT,
    event_id INT,
    user_id INT,
    comment TEXT NOT NULL,
    rating INT,
    FOREIGN KEY (event_id) REFERENCES events(event_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Создание таблицы регистраций пользователей на мероприятия
CREATE TABLE IF NOT EXISTS user_events (
    user_event_id INT PRIMARY KEY AUTO_INCREMENT,
    event_id INT,
    user_id INT,
    registration_date DATETIME,
    FOREIGN KEY (event_id) REFERENCES events(event_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);
