# Book Store Management System

A web-based DBMS project to manage books, authors, customers, employees, and orders with full CRUD operations and bill generation.

## Features
- Dashboard with quick navigation
- Books: view all / first / last, search, insert, update, delete
- Authors: view all / first / last, search, insert, update, delete
- Customers: view all / first / last, search, insert, update, delete
- Customer phones (multi-valued attribute) management
- Employees: view all / first / last, search, insert, update, delete
- Orders: create order, view totals (bill generation), delete order
- Bill generation using total of order items

## Tech Stack
- Front-End: HTML, CSS, JavaScript
- Back-End: PHP
- Database: MySQL

## Key Folders
- `public/` UI pages
- `api/` PHP endpoints
- `sql/` schema and seed data

## Setup (Short)
1. Run `sql/schema.sql` in MySQL Workbench
2. Run `sql/seed.sql` (optional)
3. Update DB credentials in `api/db.php`
4. Start server: `php -S localhost:8000 -t public`
5. Open: `http://localhost:8000/index.html`
