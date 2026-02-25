CREATE DATABASE agrosenyx;
USE agrosenyx;

-- USERS TABLE
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- FIELDS TABLE
CREATE TABLE fields (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    field_name VARCHAR(150),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- SENSORS TABLE
CREATE TABLE sensors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    field_id INT,
    soil_moisture FLOAT,
    soil_temp FLOAT,
    ph_value FLOAT,
    ec_value FLOAT,
    air_humidity FLOAT,
    rainfall FLOAT,
    last_updated DATETIME,
    FOREIGN KEY (field_id) REFERENCES fields(id) ON DELETE CASCADE
);