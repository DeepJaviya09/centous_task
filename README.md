# Laravel Project Setup

This guide explains how to set up and configure this Laravel project on your local machine, including database connection and environment management.

---

## Prerequisites

Make sure you have the following installed:

- PHP >= 8.1
- Composer
- MySQL or any supported database
- Node.js & NPM (for frontend assets)

---

## Installation Steps

**1. Clone the repository**

```sh
git clone https://github.com/DeepJaviya09/centous_task.git

cd centous_task
```

**2. Install PHP dependencies using Composer**
```sh
composer install
```

**3. Copy the example environment file**
```sh
cp .env.example .env
```

**4. Set up your database in env**
```sh
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=centous_task_db
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

**5. Run database migrations**
```sh
php artisan migrate
```

**6. Start the Laravel development server**
```sh
php artisan serve
```

Visit http://localhost:8000 in your browser.