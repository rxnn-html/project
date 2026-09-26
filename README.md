# Task Manager (Laravel)

A lightweight, full-stack task management dashboard built with **Laravel** and **MySQL**. It lets a user create, track, and update tasks through a single-page style dashboard — complete with live stats, search, priority filtering, and status toggling — without a page reload for most actions.

**Project Code:** WST21-PM-2026-SF

**Student Name:** Ron Charl E. Canoy

**Course & Year:** BSIT2 — SEC-1

**Database Used:** MySQL

---

## Overview

The app follows a classic Laravel MVC structure: task records are stored in MySQL, served to the Blade view as JSON, and rendered client-side with vanilla JavaScript. All CRUD actions (create, edit, delete, status toggle) talk to Laravel routes via `fetch()` calls protected by the CSRF token, so the dashboard stays in sync with the database on every change.

## Features

- **Add Task**
  Create new tasks with a title, a detailed description, a priority level (`Urgent` or `Reminder`), and a due date. A modal form validates required fields before submission.

- **View Tasks**
  A dynamic dashboard displays real-time statistics — Total, Pending, and Completed task counts — alongside the full task registry. Tasks can be filtered by status (via the nav tabs), filtered by priority (via the dropdown), and searched by title or description.

- **Edit Task**
  Clicking the edit icon on any task reopens the same modal, pre-filled with that task's current data, so existing fields can be updated in place.

- **Delete Task**
  Tasks can be removed directly from the registry, guarded by a confirmation prompt to prevent accidental deletion.

- **Update Status**
  A single click toggles a task between Pending and Completed, instantly updating both the task card and the summary statistics.

## Tech Stack

| Layer      | Technology                        |
|------------|------------------------------------|
| Backend    | Laravel (PHP)                     |
| Database   | MySQL                             |
| Frontend   | Blade templates, Tailwind CSS, vanilla JavaScript |
| Icons      | Font Awesome                      |
| Fonts      | Google Fonts (Inter)              |

## Setup Instructions

1. **Install PHP dependencies**
   ```bash
   composer install
   ```

2. **Create the environment file**
   ```bash
   cp .env.example .env
   ```

3. **Generate the application key**
   ```bash
   php artisan key:generate
   ```

4. **Run fresh database migrations**
   ```bash
   php artisan migrate:fresh
   ```

5. **Start the development server**
   ```bash
   php artisan serve
   ```

6. **Open the app in your browser**
   ```
   http://127.0.0.1:8000
   ```

> Make sure your `.env` file has the correct `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` values set for your local MySQL instance before running the migration step.

## Screenshots

> _Add screenshots of the dashboard below to showcase the UI._

| Dashboard | Task Modal |
|-----------|------------|
| ![Dashboard view](screenshots/dashboard.png) | ![Add/Edit task modal](screenshots/task-modal.png) |

PROJECT SCREENSHOT
<img width="1909" height="945" alt="image" src="https://github.com/user-attachments/assets/b8826a4a-f7a3-4906-a099-bd9733a9c0d1" />
<img width="832" height="606" alt="image" src="https://github.com/user-attachments/assets/3fb719e1-00c3-4736-a964-258cc31bae7e" />
<img width="1897" height="934" alt="image" src="https://github.com/user-attachments/assets/20477d30-be44-48c3-8ebd-1ebbb41ab832" />
<img width="1267" height="422" alt="image" src="https://github.com/user-attachments/assets/eabf1a61-7bef-4a24-9b42-ebaf704ef108" />




