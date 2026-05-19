<h1 align="center">🎓 EDVO — E-Learning Platform</h1>

<p align="center">
  A full-stack course management platform built with <strong>Laravel 12</strong>, designed for scalable online education with multi-role access, real-time communication, and automated certificate generation.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-red?style=for-the-badge&logo=laravel&logoColor=white" />
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" />
  <img src="https://img.shields.io/badge/TailwindCSS-v4-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" />
  <img src="https://img.shields.io/badge/Livewire-3.x-FB70A9?style=for-the-badge&logo=livewire&logoColor=white" />
  <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" />
</p>

<br/>

![EDVO Platform Preview](Mocup.png)

---

## 📖 Overview

**EDVO** is a comprehensive E-Learning and Course Management System built with **Laravel 12**. The platform is tailored for three distinct user roles — **Admin**, **Teacher**, and **Student** — each with dedicated dashboards and access controls. It is designed to deliver a structured, modern, and interactive learning experience suitable for online academies, training centers, and independent instructors.

---

## ✨ Key Features

| Feature | Description |
|---|---|
| 🛡️ **Multi-Role Access (RBAC)** | Separate dashboards and permissions for Admin, Teacher, and Student |
| 📚 **Course Management** | Full CRUD for Courses, Modules, Lessons, and rich Content |
| 📊 **Progress Tracking** | Automatic per-lesson and per-course completion tracking for students |
| 💬 **Real-Time Communication** | Live chat threads, discussions, and private messaging via Laravel Reverb |
| 📜 **Certificate Generation** | Auto-generated PDF certificates with embedded QR code verification upon course completion |
| 🔍 **Course Discovery** | Filter courses by category, level, and instructor |
| 🎨 **Modern Responsive UI** | Built with Tailwind CSS v4 and Alpine.js for a fast, interactive experience |

---

## 🛠️ Technology Stack

| Layer | Technology |
|---|---|
| **Backend** | [Laravel 12](https://laravel.com/) · PHP 8.2+ |
| **Frontend** | Blade Templates · [Tailwind CSS v4](https://tailwindcss.com/) · [Alpine.js](https://alpinejs.dev/) |
| **Realtime** | [Laravel Reverb](https://reverb.laravel.com/) · Laravel Echo · [Livewire 3](https://livewire.laravel.com/) |
| **Database** | SQLite *(default)* · MySQL · PostgreSQL |
| **PDF & QR** | `barryvdh/laravel-dompdf` · `endroid/qr-code` |
| **Asset Bundler** | [Vite](https://vitejs.dev/) |

---

## 🚀 Getting Started

### Prerequisites

Make sure you have the following installed:

- **PHP** >= 8.2
- **Composer**
- **Node.js** & **npm**
- SQLite, MySQL, or PostgreSQL

### Installation

**1. Clone the repository**
```bash
git clone https://github.com/RfqiAlan/Course-Platform.git
cd Course-Platform
```

**2. Install PHP dependencies**
```bash
composer install
```

**3. Install Node dependencies**
```bash
npm install
```

**4. Configure environment**
```bash
cp .env.example .env
php artisan key:generate
```

**5. Run database migrations & seeder**
```bash
php artisan migrate --seed
```

**6. Create storage symlink**
```bash
php artisan storage:link
```

**7. Build frontend assets**
```bash
npm run build
# Use `npm run dev` during development
```

**8. Start the development server**
```bash
php artisan serve
```

> The application will be available at **http://localhost:8000**

---

## 🔑 Default Credentials

After seeding the database, you can log in with the following accounts:

| Role | Email | Password |
|---|---|---|
| **Admin** | `admin@example.com` | `password` |
| **Teacher** | `teacher@example.com` | `password` |
| **Student** | `student@example.com` | `password` |

---

## 📁 Project Structure

```
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          # Admin-specific controllers
│   │   ├── Teacher/        # Teacher-specific controllers
│   │   └── Student/        # Student-specific controllers
│   └── Models/             # Eloquent models (Course, Lesson, Certificate, ChatThread, etc.)
├── resources/
│   └── views/              # Blade templates organized by role & feature
│       ├── admin/
│       ├── teacher/
│       ├── student/
│       ├── courses/
│       └── certificates/
└── routes/
    └── web.php             # Role-based routes and middleware
```

---

## 📄 License

This project is open-source and available under the [MIT License](https://opensource.org/licenses/MIT).

---

<p align="center">
  Built with ❤️ by <a href="https://github.com/RfqiAlan">Rifqi Alan Maulana</a>
</p>
