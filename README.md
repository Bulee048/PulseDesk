# PulseDesk

PulseDesk is a modern, responsive helpdesk and ticketing system built with Laravel and Livewire. It provides an efficient platform for managing customer support requests, enabling seamless communication between customers and support agents.

## Features

- **Multi-Role System**: Distinct portals for Customers, Agents, and Administrators.
- **Ticket Management**: Customers can create and track tickets. Agents can view, assign, and respond to tickets.
- **Canned Responses**: Agents can use pre-defined responses for common queries.
- **Ticket Rating**: Customers can rate the support they received once a ticket is resolved.
- **Livewire Integration**: Dynamic, single-page application feel without writing complex JavaScript.

## Prerequisites

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL or PostgreSQL

## Installation

1. Clone the repository:
```bash
git clone https://github.com/Bulee048/PulseDesk.git
cd pulsedesk
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install NPM dependencies:
```bash
npm install
npm run build
```

4. Set up your environment file:
```bash
cp .env.example .env
```
Update your `.env` file with your database credentials.

5. Generate application key:
```bash
php artisan key:generate
```

6. Run database migrations and seeders:
```bash
php artisan migrate --seed
```

7. Start the local development server:
```bash
php artisan serve
```

## Usage

- **Customers**: Can register, create new support tickets, view their ticket history, and provide feedback on resolved tickets.
- **Agents**: Can log in to view assigned tickets, respond to customers, use canned responses, and update ticket statuses.
- **Admins**: Have full access to manage users, roles, and overall system settings.

## Technologies Used

- [Laravel](https://laravel.com/)
- [Livewire](https://laravel-livewire.com/)
- [Tailwind CSS](https://tailwindcss.com/)
- [Alpine.js](https://alpinejs.dev/)

## License

This project is open-source software.
