# LaraVue Starter Kit

The **LaraVue Starter Kit** is an advanced project template that combines **Laravel 12** on the backend and **Vue 3** with **Quasar Framework** on the frontend, providing a solid foundation for scalable and modern web applications. This kit includes pre-configured authentication, user and permission management, an initial dashboard and a responsive side menu. It also supports automated testing and tools for monitoring and debugging.

## 📌 **Key Features**

- Laravel 12 - Robust and modern backend with RESTful API support.
- **⚡ Vue 3 + Quasar** - Progressive and reactive UI for dynamic interfaces.
- **🔑 Authentication** - Complete and ready-to-use login system.
- **👤 User Management** - Full control over users, roles and permissions.
- **Logs and Debugging**- Structured logs with Laravel Debugbar and auditing with Spatie Activity Log.
- **✅ Automated Testing** - Test coverage using **PestPHP** and **PHPUnit**.
- **🔍 Larastan** - Advanced static analysis to maintain code quality.
- **🗂️ Automatic Documentation** - Automatic generation of documentation with **Scramble**.

---

## ⚙️ **Technology Stack**

- **Laravel 12** | **PHP 8.4**
- **Vue 3.5** | **Quasar Framework**
- **Pinia (State Management)**
- **Spatial Permission**
- **PestPHP and PHPUnit**
- **Larastan (PHPStan for Laravel)**

---

## 🚀 **Project Architecture**

The architecture adopted minimizes complexity and improves testability. Laravel's native **Action Pattern** was used, eliminating the need for custom `Service Providers'.

📌 **Architecture Diagram**  
Application Architecture](./architecture.svg)

---

## 📊 **Database Schema Dump & ER Diagram**

The schema can be exported using the command:

```bash
pg_dump --schema-only --file=schema.sql “postgres://$(grep DB_USERNAME .env | cut -d ‘=’ -f2):$(grep DB_PASSWORD . env | cut -d '=' -f2)@$(grep DB_HOST .env | cut -d '=' -f2):$(grep DB_PORT .env | cut -d '=' -f2)/$(grep DB_DATABASE .env | cut -d '=' -f2)”
```

DER generation:

```bash
npx @liam-hq/cli erd build --input $(pwd)/schema.sql --format=postgres
mv $(pwd)/dist $(pwd)/public
```

The diagram will be accessible at `/der?key=access_key`. To do this, set `APP_DER_KEY` in `.env`.

---

## 🔄 **Commit Conventions**

We use **Conventional Commits** to keep a clean history and facilitate semantic versioning:

- **feat**: Adds a new feature
- **fix**: Fix a bug
- **docs**: Updates documentation
- **refactor**: Refactoring without changing behavior
- **test**: Addition or correction of tests
- **perf**: Performance improvements
- **build**: Changes to the build system
- **ci**: Changes to the CI/CD configuration
- **ops**: Infrastructure or deployment changes
- **chore**: Other changes not related to source code
- **revert**: Reversal of a previous commit

---

## 📝 **Code Standards**

- Variables in `camelCase`, no short abbreviations (`$q` → `$query`).
- Routes follow `{resource}.{action}` (example: `roles.index`).
- Methods must be descriptive and contain up to 5 words (`getUserProfile()`).
- Run **PHPStan** for static validation:
  ```bash
  ./vendor/bin/phpstan analyze
  ```
- Generate API documentation:
  ```bash
  php artisan scramble:export
  ```

---

## 📌 **To-Do List**

- [ ] Set phpstan max level(10), currently level is 8.
- [ ] Create **policies** for users and permissions.
- [ ] Create screen to display **application logs**.
- [ ] Fix **unit tests**.
