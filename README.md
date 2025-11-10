# 🚀 LaraVue Starter Kit

The **LaraVue Starter Kit** is a full-stack boilerplate combining **Laravel 12** and **Vue 3 + Quasar Framework**, built for scalable, testable, and maintainable web applications.
It provides a pre-configured environment for authentication, user and permission management, dashboards, REST APIs, automated testing, and development observability.

---

## 📑 Table of Contents

1. [Architecture Overview](#-architecture-overview)
2. [Installation](#-installation)
3. [Husky (Git Hooks)](#-husky-git-hooks)
4. [Database Configuration](#-database-configuration)
5. [Key Features](#-key-features)
6. [Technology Stack](#-technology-stack)
7. [Project Architecture](#-project-architecture)
8. [Docker Services](#-docker-services)
9. [Testing](#-testing)
10. [Best Practices](#-best-practices)
11. [Commit Conventions](#-commit-conventions)
12. [Code Standards](#-code-standards)

---

## ⚙️ Architecture Overview

This starter kit runs entirely in **Docker (Alpine)** containers for consistent local and CI environments.
It includes containers for the app, Nginx, PostgreSQL, Redis, and Mailpit, ensuring isolated and reproducible development.

---

## 📥 Installation

### 1️⃣ Clone the repository

```bash
git clone https://github.com/yanbrasiliano/starter-kit-laravue.git
cd starter-kit-laravue
```

### 2️⃣ Build and start containers

```bash
docker compose up -d --build --force-recreate --remove-orphans
```

### 3️⃣ Environment setup

```bash
cp .env.example .env
```

Verify your database settings:

```
DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=starterkit
DB_USERNAME=postgres
DB_PASSWORD=admin
```

### 4️⃣ Install dependencies

```bash
docker exec -it starterkit-app bash
composer install
npm install
php artisan migrate --seed
```

### 5️⃣ Fix permissions (Linux/Mac)

```bash
chmod +x permissions.sh
./permissions.sh
```

### 6️⃣ Run the app

```bash
docker exec -it starterkit-app npm run dev
```

Access: **http://localhost:8001**

---

## 🪝 Husky (Git Hooks)

The project uses **Husky** to enforce pre-commit and pre-push checks (lint, tests, commit validation).

### Setup

After dependencies installation:

```bash
npx husky init
```

> Do **not** overwrite existing hooks — this repository already includes custom `pre-commit` and `pre-push` scripts.

If Husky overwrites them, restore:

```bash
git restore .husky/pre-commit .husky/pre-push
```

---

## 🛠️ Database Configuration

> PostgreSQL 16 is the default database.
> Created automatically on first container startup.

To access manually inside the container:

```bash
docker exec -it starterkit-db psql -U postgres -d starterkit
```

---

## 📌 Key Features

- **Laravel 12** — Modular, RESTful backend
- **Vue 3 + Quasar** — Modern reactive UI
- **Spatie Permission** — Role & permission system
- **Spatie Activity Log** — Transparent audit trail
- **PestPHP** — Expressive test framework
- **Larastan + PHP Insights** — Static analysis & code quality
- **Scramble** — Automatic API documentation
- **Pulse + Telescope + Debugbar** — Monitoring and debugging

---

## ⚙️ Technology Stack

- **Backend:** Laravel 12 (PHP 8.4 on Alpine)
- **Frontend:** Vue 3.5 + Quasar Framework + Vite
- **Database:** PostgreSQL 16
- **Cache/Queue:** Redis 7
- **Mail:** Mailpit (SMTP emulator)
- **Containerization:** Docker Compose
- **Testing:** PestPHP
- **Static Analysis:** Larastan
- **Monitoring:** Pulse, Telescope, Debugbar

---

## 🚀 Project Architecture

The project applies **Action Pattern** to encapsulate business logic and ensure single-responsibility.
It follows an **Event-Driven Design** (EDD) pattern, allowing features such as logging, notifications, and integrations to run asynchronously or synchronously.

### 📡 Queues and Jobs

The system is queue-ready using **Redis** and **Supervisor**.
Heavy tasks (imports, notifications, integrations) should run via jobs dispatched with:

```php
dispatch(new ExampleJob())->onQueue('default');
```

Supervisor handles automatic restart, retry, and timeout policies.

---

## 🧱 Docker Services

All services are defined in `docker-compose.yml`.

---

## 🧪 Testing

### 1️⃣ Test Database

The test database (`starterkit_test`) is automatically created on the first container startup.

If it is **not created automatically**, run the `docker-entrypoint-initdb.sh` script manually **outside** the container:

#### Script

```bash
#!/usr/bin/env bash

docker exec -i starterkit-db psql -U postgres -tc "SELECT 1 FROM pg_database WHERE datname = 'starterkit_test';" | grep -q 1 && {
    echo "Database starterkit_test already exists."
    exit 0
}

docker exec -i starterkit-db psql -U postgres -c "CREATE DATABASE starterkit_test;"
echo "Database starterkit_test created."
```

#### Run

```bash
chmod +x docker-entrypoint-initdb.sh
./docker-entrypoint-initdb.sh
```

After execution, the `starterkit_test` database will be available for automated test runs.

---

### 2️⃣ Running Tests

Run the full test suite:

```bash
docker compose exec starterkit-app composer test
```

With coverage report:

```bash
docker compose exec starterkit-app composer test:coverage
```

Parallel execution:

```bash
docker compose exec starterkit-app env APP_ENV=testing php artisan test --parallel
```

---

## 🧠 Best Practices

### Security

- Set `APP_DEBUG=false` in production.
- Generate a unique secure `APP_KEY`.
- Protect routes using `auth:sanctum`.
- Mask sensitive data in logs.

### Performance

- Cache repetitive queries (use tags and short TTLs).
- Optimize auto-loaders and config caches.
- Use `DB::transaction()` for atomic operations.

### Code Quality

- Maintain test coverage ≥ 80%.
- Run Larastan and PHP Insights regularly.
- Keep controllers thin — logic belongs in Actions.

---

## 🔄 Commit Conventions

Follows **Conventional Commits** to maintain readable history and semantic versioning.

Format:

```
<type>: <Jira task ID> - <description>
```

**Types:**

- `feat` — New feature
- `fix` — Bug fix
- `docs` — Documentation update
- `refactor` — Code restructuring
- `test` — Add or modify tests
- `perf` — Performance improvement
- `build` — Build or dependency changes
- `ci` — CI/CD updates
- `ops` — Infrastructure or ops changes
- `chore` — Maintenance tasks (deps, cleanup)
- `revert` — Revert commit

---

## 📝 Code Standards

- `declare(strict_types=1);` in all PHP files
- Method names ≤ 5 words
- Use imperative verbs for methods
- Variables in `camelCase`
- Routes follow `{resource}.{action}` (e.g. `users.index`)
- Versioned APIs: `/api/v1/...`
- Test coverage ≥ 80 lines

### Static Analysis

```bash
docker exec -it starterkit-app composer run:phpstan
```

### Code Quality

```bash
docker exec -it starterkit-app composer run:phpinsights
```

### API Documentation

```bash
docker exec -it starterkit-app php artisan scramble:export
```

### Tests

```bash
docker exec -it starterkit-app composer test
docker exec -it starterkit-app composer test:coverage
```

#### Shortcuts for development

make help

╔═══════════════════════════════════════════╗
║ Shortcuts for development ║
╚═══════════════════════════════════════════╝

📦 Container Management:
make up - Start all containers
make down - Stop all containers
make restart - Restart all containers
make build - Rebuild containers
make ps - Show container status
make logs - Follow all logs

💻 Development:
make shell - Enter app container shell
make shell-root - Enter app container as root
make front - Run Vite dev server
make install - Install PHP and NPM dependencies
make fresh - Fresh database with seeds
make cache - Clear all Laravel caches
make optimize - Optimize for production

🗄️ Database:
make migrate - Run migrations
make rollback - Rollback last migration
make db-show - Show current database info
make db-table TABLE=users - Show table info
make db-shell - Enter PostgreSQL shell
make backup - Backup database
make restore FILE=backup.sql - Restore database

🧪 Testing:
make test - Run all tests (local)
make test-all - Run all tests (testing env, parallel)
make test-fresh - Clear cache + run tests (testing env)
make test-coverage - Generate test coverage report

✨ Code Quality:
make pint - Run Laravel Pint (format)
make check - Check code style without fixing
make ide - Generate IDE helper files

🛠️ Artisan & Tools:
make artisan ARGS="make:model Post" - Run artisan command
make tinker - Open Laravel Tinker
make queue - Run queue worker
make horizon - Open Laravel Horizon
make telescope - Open Laravel Telescope
make pulse - Open Laravel Pulse

⚡ Shortcuts:
make ta - test-all
make tf - test-fresh
make ds - db-show
make dt TABLE=x - db-table
make oc - optimize:clear
