# StuDirect - API

StuDirect is a Tinder-like web application that matches students and companies for the Career Launch.  
The application was developed as part of the programming project and offers a pleasant user experience, modern technologies and features such as swiping, chatting and profiles.

![StuDirect UI](https://github.com/user-attachments/assets/8a2230b3-5fd6-4c3a-99ef-2bc7d66b84d1)

---

## Features

- Swipe functionality to match students and companies
- Real-time chat between matched parties
- Student profiles with interests, field of study and a CV
- Company profiles with internships, job openings, location and general information
- Admin panel for managing students, companies and logs
- Email verification and password reset
- Skill matching between students and companies
- RESTful API, JSON responses, rate limiting
- Separate versions for mobile, desktop and admin

![Laravel CI](https://github.com/nasrlol/studirect-api/actions/workflows/laravel.yml/badge.svg)

---

## Tech Stack

- Laravel (PHP framework)
- Laravel Sanctum (API authentication & RBAC)
- Eloquent ORM
- PHPUnit
- MySQL database
- Mailtrap (email testing)
- RESTful API, JSON
- CI via GitHub Actions

---

## Installation

1. **Clone the repository**

```bash
git clone https://github.com/nasrlol/studirect-api
cd studirect-api/source
```

2. **Install the Composer dependencies**

```bash
composer install
```

3. **Configure .env**

```bash
cp .env.example .env
```
Fill in your database credentials, Mailtrap settings and other environment variables in `.env`.

4. **Generate the app key**

```bash
php artisan key:generate
```

5. **Migrate and seed the database**

```bash
php artisan migrate:fresh --seed
```

6. **Start the server**

```bash
php artisan serve
```

---

## Using the API

See the [API documentation](./API-ROUTES.md) for all endpoints, authentication and usage examples.

- **Authentication:** via Laravel Sanctum tokens (Bearer); log in via `/api/students/login`, `/api/companies/login` or `/api/admins/login`
- **Rate limiting:** 300/min (default), 500/min for intensive endpoints (appointments, connections, skills)
- **All responses are JSON**
- **See [routes/api.php](./source/routes/api.php)** for the complete overview and current endpoints.

---

## Running the tests

```bash
php artisan test
```

---

## Main Directories

- `/source/app/Http/Controllers/Api/` – all API controllers
- `/source/routes/api.php` – API routes
- `/source/app/Models/` – model logic
- `/source/database/seeders/` – seeder data for test accounts

---

## Security & Best Practices

- Input validation, CSRF, XSS and SQL injection prevention, RBAC via policies/gates
- Rate limiting on all routes

---

## Learn more

- [API documentation](./docs/api.md)
- [Project documentation (wiki)](../../wiki)

---

© 2025 StuDirect — The API for the Career Launch.
