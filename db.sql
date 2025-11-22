CREATE DATABASE ev_smart_route;
USE ev_smart_route;

-- Users table (User, Station Owner, Admin)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('user', 'owner', 'admin') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Charging stations table
CREATE TABLE stations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    owner_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    address TEXT NOT NULL,
    latitude DECIMAL(10, 7),
    longitude DECIMAL(10, 7),
    connector_type VARCHAR(100),
    power_kw INT,
    price_per_unit DECIMAL(10, 2),
    opening_time TIME,
    closing_time TIME,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (owner_id) REFERENCES users(id)
);

-- Insert one admin and some demo users (password = '123456')
INSERT INTO users (name, email, password_hash, role) VALUES
('Main Admin', 'admin@ev.com',  SHA2('123456', 256), 'admin'),
('EV User', 'user@ev.com',      SHA2('123456', 256), 'user'),
('Station Owner', 'owner@ev.com', SHA2('123456', 256), 'owner');
