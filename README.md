# Book Store Management System (DBMS DA-II)

## Setup (MySQL)
1. Create database and tables:
   - Run `sql/schema.sql` in MySQL.
2. Seed sample data (optional):
   - Run `sql/seed.sql`.
3. Update DB credentials in `api/db.php` if needed.

## Run the App (PHP)
From the project folder:

```bash
php -S localhost:8000 -t public
```

Open in browser:
- `http://localhost:8000/index.html`

## Features
- View All / First / Last / Search
- Insert / Update / Delete
- Bill generation using `v_order_totals` view

## Files
- `sql/schema.sql` schema
- `sql/seed.sql` sample data
- `api/` PHP endpoints
- `public/` UI
