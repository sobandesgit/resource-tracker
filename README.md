# Resource Tracker API

A secure RESTful API built with Laravel for tracking personal resources. Authenticated users can manage items, log activity, configure settings, and be organized into groups. Admin users have elevated permissions to manage groups.

## Technologies Used

- **Laravel** 13.11.2
- **PHP** 8.4.21
- **MySQL** 8.0.46
- **Laravel Sanctum** 4.3.2 (token-based authentication)

## Requirements

- PHP 8.2+
- Composer
- MySQL 8.0+

## Local Setup

### 1. Clone the repository

```bash
git clone https://github.com/sobandesgit/resource-tracker.git
cd resource-tracker
```

### 2. Install dependencies

```bash
composer install
```

### 3. Configure environment

```bash
cp .env.example .env
php artisan key:generate
```

Open `.env` and update the database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=resource_tracker
DB_USERNAME=root
DB_PASSWORD=your_mysql_password
```

### 4. Create the database

Log into MySQL and run:

```sql
CREATE DATABASE resource_tracker;
```

### 5. Run migrations and seed the database

```bash
php artisan migrate --seed
```

This creates all tables and seeds the following test accounts:

| Role  | Email               | Password    |
|-------|---------------------|-------------|
| Admin | admin@example.com   | password123 |
| User  | john@example.com    | password123 |
| User  | jane@example.com    | password123 |

### 6. Start the server

```bash
php artisan serve
```

The API will be available at `http://127.0.0.1:8000`

## Authentication

All endpoints except `/api/register` and `/api/login` require a Bearer token in the Authorization header:


```
Authorization: Bearer your_token_here
```


## API Endpoints

### Auth

| Method | Endpoint         | Description              | Auth Required |
|--------|-----------------|--------------------------|---------------|
| POST   | /api/register   | Register a new user      | No            |
| POST   | /api/login      | Login and get token      | No            |
| POST   | /api/logout     | Logout current session   | Yes           |

### Items

| Method | Endpoint            | Description              | Auth Required |
|--------|---------------------|--------------------------|---------------|
| GET    | /api/items          | List all your items      | Yes           |
| POST   | /api/items          | Create a new item        | Yes           |
| GET    | /api/items/{id}     | Get a single item        | Yes           |
| PUT    | /api/items/{id}     | Update an item           | Yes           |
| DELETE | /api/items/{id}     | Delete an item           | Yes           |

### Groups

| Method | Endpoint                      | Description                | Auth Required | Admin Only |
|--------|-------------------------------|----------------------------|---------------|------------|
| GET    | /api/groups                   | List all groups            | Yes           | No         |
| GET    | /api/groups/{id}              | Get a single group         | Yes           | No         |
| POST   | /api/groups                   | Create a group             | Yes           | Yes        |
| POST   | /api/groups/{id}/users        | Add user to group          | Yes           | Yes        |
| DELETE | /api/groups/{id}/users        | Remove user from group     | Yes           | Yes        |

### Logs

| Method | Endpoint            | Description              | Auth Required |
|--------|---------------------|--------------------------|---------------|
| GET    | /api/logs           | List all your logs       | Yes           |
| POST   | /api/logs           | Create a log entry       | Yes           |
| GET    | /api/logs/{id}      | Get a single log         | Yes           |

### Settings

| Method | Endpoint         | Description              | Auth Required |
|--------|-----------------|--------------------------|---------------|
| GET    | /api/settings   | Get your settings        | Yes           |
| POST   | /api/settings   | Create your settings     | Yes           |
| PUT    | /api/settings   | Update your settings     | Yes           |

## Example Requests

### Register
```bash
curl -X POST http://127.0.0.1:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{"name":"John Doe","email":"john@example.com","password":"password123","password_confirmation":"password123"}'
```

### Login
```bash
curl -X POST http://127.0.0.1:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"john@example.com","password":"password123"}'
```

### Create an Item
```bash
curl -X POST http://127.0.0.1:8000/api/items \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer your_token_here" \
  -d '{"name":"My Task","details":"Task details here","is_completed":false}'
```

### Create a Group (Admin only)
```bash
curl -X POST http://127.0.0.1:8000/api/groups \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer admin_token_here" \
  -d '{"name":"Engineering Team","description":"Core engineering team"}'
```

## Time Spent

Approximately 15 hours total including environment setup, development, and testing.