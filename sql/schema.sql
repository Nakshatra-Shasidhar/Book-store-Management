-- Book Store Management System Schema
-- MySQL 8.x

CREATE DATABASE IF NOT EXISTS bookstore_db
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_0900_ai_ci;

USE bookstore_db;

-- Drop in dependency order (safe re-run)
DROP VIEW IF EXISTS v_order_totals;
DROP TABLE IF EXISTS order_item;
DROP TABLE IF EXISTS `order`;
DROP TABLE IF EXISTS customer_phone;
DROP TABLE IF EXISTS book;
DROP TABLE IF EXISTS author;
DROP TABLE IF EXISTS customer;
DROP TABLE IF EXISTS employee;

CREATE TABLE author (
  author_id INT AUTO_INCREMENT PRIMARY KEY,
  author_name VARCHAR(120) NOT NULL,
  nationality VARCHAR(80)
) ENGINE=InnoDB;

CREATE TABLE book (
  book_id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  price DECIMAL(10,2) NOT NULL CHECK (price >= 0),
  genre VARCHAR(80),
  stock_count INT NOT NULL DEFAULT 0 CHECK (stock_count >= 0),
  author_id INT,
  CONSTRAINT fk_book_author
    FOREIGN KEY (author_id) REFERENCES author(author_id)
    ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE customer (
  customer_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(150),
  address_street VARCHAR(150),
  address_city VARCHAR(80),
  address_state VARCHAR(80),
  address_zip VARCHAR(20)
) ENGINE=InnoDB;

CREATE TABLE customer_phone (
  customer_id INT NOT NULL,
  phone_number VARCHAR(20) NOT NULL,
  PRIMARY KEY (customer_id, phone_number),
  CONSTRAINT fk_phone_customer
    FOREIGN KEY (customer_id) REFERENCES customer(customer_id)
    ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE employee (
  employee_id INT AUTO_INCREMENT PRIMARY KEY,
  employee_name VARCHAR(120) NOT NULL,
  role VARCHAR(60) NOT NULL,
  salary DECIMAL(10,2) NOT NULL CHECK (salary >= 0)
) ENGINE=InnoDB;

CREATE TABLE `order` (
  order_id INT AUTO_INCREMENT PRIMARY KEY,
  order_date DATE NOT NULL,
  payment_mode VARCHAR(40) NOT NULL,
  customer_id INT NOT NULL,
  employee_id INT NOT NULL,
  CONSTRAINT fk_order_customer
    FOREIGN KEY (customer_id) REFERENCES customer(customer_id)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_order_employee
    FOREIGN KEY (employee_id) REFERENCES employee(employee_id)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE order_item (
  order_id INT NOT NULL,
  book_id INT NOT NULL,
  quantity INT NOT NULL CHECK (quantity > 0),
  unit_price DECIMAL(10,2) NOT NULL CHECK (unit_price >= 0),
  PRIMARY KEY (order_id, book_id),
  CONSTRAINT fk_item_order
    FOREIGN KEY (order_id) REFERENCES `order`(order_id)
    ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT fk_item_book
    FOREIGN KEY (book_id) REFERENCES book(book_id)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

-- Indexes for faster search/navigation
CREATE INDEX idx_author_name ON author(author_name);
CREATE INDEX idx_book_title ON book(title);
CREATE INDEX idx_book_genre ON book(genre);
CREATE INDEX idx_customer_name ON customer(name);
CREATE INDEX idx_employee_name ON employee(employee_name);
CREATE INDEX idx_order_date ON `order`(order_date);

-- Derived totals per order
CREATE VIEW v_order_totals AS
SELECT
  o.order_id,
  o.order_date,
  o.payment_mode,
  o.customer_id,
  o.employee_id,
  COALESCE(SUM(oi.quantity * oi.unit_price), 0) AS total_amount
FROM `order` o
LEFT JOIN order_item oi ON oi.order_id = o.order_id
GROUP BY o.order_id, o.order_date, o.payment_mode, o.customer_id, o.employee_id;
