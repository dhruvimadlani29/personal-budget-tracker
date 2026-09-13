# Tally - Personal Budget Tracker

A full-stack personal finance web application built with Laravel, Livewire, Tailwind CSS, and SQLite. Tally helps users manage their income and expenses through an intuitive dashboard with real-time updates, category management, and budget limit tracking.

Built as a capstone project for CST8257 Web Applications Development at Algonquin College.

---

## Features

- **User Authentication** — Secure registration and login using Laravel Breeze
- **Transaction Management** — Add, edit, and delete income and expense transactions
- **Category Management** — Organize transactions by custom categories
- **Dashboard** — Visual overview of income, expenses, and balance at a glance
- **Budget Limits** — Set spending limits per category and get notified when approaching them
- **Real-Time UI** — Livewire-powered components for seamless, no-refresh interactions
- **Responsive Design** — Fully responsive layout using Tailwind CSS

---

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | PHP, Laravel 11 |
| Frontend | Livewire, Tailwind CSS, Alpine.js |
| Database | SQLite |
| Auth | Laravel Breeze |
| Version Control | Git / GitHub |

---

## Team

| Name | Responsibilities |
|---|---|
| Dhruvi Madlani | Authentication, base layout, Budget Limits feature |
| Antoine Guirguis | Categories, Dashboard |
| Amal Elmi | Transactions |

---

## Getting Started

### Prerequisites

- PHP 8.2+
- Composer
- Node.js and npm

### Installation

```bash
# Clone the repository
git clone https://github.com/dhruvimadlani29/tally.git
cd tally

# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Run database migrations
php artisan migrate

# Build frontend assets
npm run dev

# Start the development server
php artisan serve
```

The application will be available at `http://localhost:8000`.

---

## Project Structure

```
tally/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   ├── Livewire/          # Livewire components
│   └── Models/
├── database/
│   ├── migrations/
│   └── database.sqlite
├── resources/
│   └── views/
│       ├── livewire/
│       └── layouts/
└── routes/
    └── web.php
```

---

## Course

**CST8257 — Web Applications Development**
Algonquin College of Applied Arts and Technology, Ottawa, ON
Winter 2026

---

## License

This project was developed for academic purposes at Algonquin College.
