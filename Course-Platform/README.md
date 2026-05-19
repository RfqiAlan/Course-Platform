# 🎓 Course Platform

A comprehensive E-Learning and Course Management platform built with **Laravel 12**. This platform provides a rich set of features tailored for three primary roles: **Admin**, **Teacher**, and **Student**, making it an ideal solution for online academies, training centers, and independent instructors.

![EDVO Platform Preview](Mocup.png)

## ✨ Key Features

- **🛡️ Multi-Role System (RBAC)**: Dedicated dashboards and access levels for Admin, Teacher, and Student.
- **📚 Course Management**: Teachers and Admins can create and manage Courses, Modules, Lessons, and Contents.
- **📊 Progress Tracking**: Students can track their learning progress (Lesson & Course completion).
- **💬 Interactive Communication**: 
  - Real-time Discussions and Chat Threads.
  - Private Messaging between users.
- **📜 Certificate Generation**: Automatic generation of PDF certificates upon course completion (using DomPDF) with integrated QR codes for verification.
- **🎨 Modern UI**: Built using **Tailwind CSS** and **Alpine.js** for a responsive, fast, and interactive user experience.

## 🛠️ Technology Stack

| Layer | Technology |
|---|---|
| **Backend** | [Laravel 12](https://laravel.com/) (PHP 8.2+) |
| **Frontend** | Blade Templates, [Tailwind CSS v4](https://tailwindcss.com/), [Alpine.js](https://alpinejs.dev/) |
| **Database** | SQLite (Default for dev) / MySQL / PostgreSQL |
| **PDF & QR** | `barryvdh/laravel-dompdf`, `endroid/qr-code` |
| **Realtime** | Laravel Reverb, Laravel Echo, Livewire |
| **Asset Bundler** | Vite |

## 🚀 Getting Started

Follow these instructions to get a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

- **PHP** >= 8.2
- **Composer**
- **Node.js** & **npm** (or yarn/pnpm)
- SQLite (or any supported database)

### Installation Guide

1. **Clone the repository**
   ```bash
   git clone https://github.com/your-username/Course-Platform.git
   cd Course-Platform
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install NPM dependencies**
   ```bash
   npm install
   ```

4. **Environment Setup**
   Copy the example `.env` file and generate the application key.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database Setup**
   The project is configured to use `sqlite` by default. You can change this in your `.env` file if you prefer MySQL or PostgreSQL.
   Run migrations and seed the database with default roles and users:
   ```bash
   php artisan migrate --seed
   ```

6. **Storage Link**
   Create a symbolic link for the storage directory (important for uploaded files, course content, and certificates):
   ```bash
   php artisan storage:link
   ```

7. **Build Frontend Assets**
   ```bash
   npm run build
   # Or run `npm run dev` to watch for changes during development
   ```

8. **Start the Development Server**
   ```bash
   php artisan serve
   ```
   *Your application will be available at `http://localhost:8000`.*

---

## 🔑 Default Login Credentials

After running `php artisan migrate --seed`, the following default users will be available:

| Role | Email | Password |
|---|---|---|
| **Admin** | `rifqialanm@gmail.com` | `password` |
| **Teacher** | `teacher@example.com` | `password` |
| **Student** | `student@example.com` | `password` |

---

## 📁 Project Structure Highlights

- `app/Http/Controllers/`: Contains role-specific controllers (`Admin/`, `Teacher/`, `Student/`).
- `app/Models/`: Eloquent models defining relationships (`Course`, `Lesson`, `Certificate`, `ChatThread`, etc.).
- `resources/views/`: Blade templates structured by role and feature (`admin/`, `teacher/`, `student/`, `courses/`, `certificates/`, `pdf/`).
- `routes/web.php`: Defines the web routes, middleware, and role-based access control.

## 📄 License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT). This project's specific code is subject to its respective repository's license.
