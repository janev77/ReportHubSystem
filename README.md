# Report Hub System
<hr>

## Overview
Full Stack Laravel application for creating and distributing 
internal announcements to employees in a company. The app supports different categories, targeted users, 
timed announcements and email notification system.
<hr>

## Prerequisites

- PHP 8.0 or higher
- Composer
- MySQL 8.0 or higher
- Docker (optional, for containerized setup)

<hr>

## Getting started

1. Clone the repository:
```
git clone https://github.com/ljupce99/ReportHubSystem.git
cd ReportHubSystem
```
2. Install composer dependencies:
```
composer install
```

3. Add environment variables:
```
copy .env.example .env
```
- Set database connection settings (DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD) according to your local MySQL setup.
- You can also set the MAIL settings if you want to test email notifications.

4. Generate application key:
```
php artisan key:generate
```

5. Migrate the database and seed with initial data:
```
php artisan migrate --seed
```

6. Start the server and go to `http://localhost:8000` in your browser:
```
php artisan serve
```

Test the functionalities using the seeded admin user or create new users and announcements through the UI.
<br><br> email: admin@company.com <br>
password: password

<hr>

## Docker setup

This project also includes:
- `Dockerfile` for Laravel + Apache + Vite build
- `docker-compose.yml` for the app and MySQL 8.0
- `.env.docker.example` with Docker-ready app/database settings

### First time start with Docker

1. Build and start the containers.
2. Run the migrations and seed the database.
3. Open the app at `http://localhost:8000`.

```powershell
docker compose up -d --build
docker compose exec app php artisan migrate --seed
```

### Useful Docker commands

```powershell
docker compose down
docker compose down -v
docker compose exec app php artisan test
```

### Docker database connection

The Laravel app connects to the MySQL container with these values:
- Host: `mysql`
- Port: `3306`
- Database: `laravel_db`
- Username: `laravel_user`
- Password: `password`

If you want different values, edit `.env.docker.example` and `docker-compose.yml` together before running the containers.

<hr>

## Features
- User authentication and role-based access control (/admin for admin /feed for employees)
- CRUD announcements with categories and target users
- Schedule announcements to be published at specific times
- Email notifications when new announcements are published
- Responsive design for desktop and mobile
- Admin panel with announcements, categories and user engagement
- Search and filter announcements by category, date, and target users
- User management for admins to create and manage employee accounts

<hr>
<br>
<br>

### Made by:
- 221258 Александар Јанев
- 221277 Љупчо Јованов<br><br>
for the course "Implementation of free and open source systems" at Faculty of Computer Science and Engineering - Skopje
