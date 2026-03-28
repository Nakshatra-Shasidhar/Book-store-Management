USE bookstore_db;

INSERT INTO author (author_name, nationality) VALUES
('J. K. Rowling', 'British'),
('George Orwell', 'British'),
('Chetan Bhagat', 'Indian');

INSERT INTO book (title, price, genre, stock_count, author_id) VALUES
('Harry Potter and the Sorcerer''s Stone', 399.00, 'Fantasy', 12, 1),
('1984', 299.00, 'Dystopian', 8, 2),
('Animal Farm', 199.00, 'Political Satire', 15, 2),
('Half Girlfriend', 249.00, 'Romance', 10, 3);

INSERT INTO customer (name, email, address_street, address_city, address_state, address_zip) VALUES
('Aarav Mehta', 'aarav@example.com', '12 MG Road', 'Bengaluru', 'Karnataka', '560001'),
('Isha Sharma', 'isha@example.com', '88 Lake View', 'Chennai', 'Tamil Nadu', '600001');

INSERT INTO customer_phone (customer_id, phone_number) VALUES
(1, '9876543210'),
(1, '9123456780'),
(2, '9988776655');

INSERT INTO employee (employee_name, role, salary) VALUES
('Ravi Kumar', 'Manager', 45000.00),
('Neha Singh', 'Cashier', 28000.00);

INSERT INTO `order` (order_date, payment_mode, customer_id, employee_id) VALUES
('2026-03-28', 'UPI', 1, 2),
('2026-03-28', 'Cash', 2, 1);

INSERT INTO order_item (order_id, book_id, quantity, unit_price) VALUES
(1, 1, 1, 399.00),
(1, 2, 2, 299.00),
(2, 3, 1, 199.00);
