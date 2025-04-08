
# 🚀 Laravel Translation Management API

> 📌 **Note:** Use the Postman collection file **`Testing CRUD.postman_collection.json`** located in the root directory to test all API endpoints easily.  
> 📌 **Branch to Use:** Please make sure you're using the `feature/multi-language` branch to clone/download the latest version.

---

## 🌍 Laravel Translation Management API

A powerful, scalable, and secure API service to manage translations across multiple locales with contextual tagging, built using Laravel and Passport.

---

## ✨ Features

- ✅ Store translations in multiple locales (`en`, `fr`, `es`, etc.)
- ✅ Contextual tags like `mobile`, `web`, `desktop`
- ✅ Create, update, view, and search translations by key, tag, or content
- ✅ Export updated translations as JSON (ideal for Vue.js frontend)
- ✅ Fast response times (<200ms for most endpoints)
- ✅ JSON export handles 100k+ records in <500ms
- ✅ Factory and seeder support for performance testing
- ✅ Token-based API Authentication via Laravel Passport
- ✅ Follows **PSR-12** and **SOLID** principles

---

## 🧰 Installation Guide (Without Docker)

Follow these steps to install and run the project locally:

### 1. Clone the Repository

```bash
git clone https://github.com/umer-detech/product-inventory.git
cd product-inventory
```

---

### 2. Install PHP & JavaScript Dependencies

```bash
composer install
npm install && npm run build
```

---

### 3. Configure Environment Variables

```bash
cp .env.example .env
php artisan key:generate
```

Update `.env` with your database and other environment settings:

```env
DB_DATABASE=your_db
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

---

### 4. Run Migrations and Seeders

```bash
php artisan migrate --seed
```

To populate 100k+ test records for performance testing:

```bash
php artisan db:seed --class=TranslationSeeder
```

---

### 5. Install Laravel Passport

```bash
php artisan passport:install
```

Make sure `config/auth.php` is set to use passport for the API guard:

```php
'guards' => [
    'api' => [
        'driver' => 'passport',
        'provider' => 'users',
    ],
],
```

---

### 6. Start the Application

```bash
php artisan serve
```

The app will be available at:  
`http://localhost:8000`

---

## 🔐 Authentication

Use Passport to get access tokens from:

```
POST /oauth/token
```

Then use the token for all API requests as:

```
Authorization: Bearer {your-token}
```

---

## 🔗 API Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET    | /api/translations | List translations with filters and pagination |
| POST   | /api/translations | Create a new translation |
| PUT    | /api/translations/{id} | Update a translation |
| DELETE | /api/translations/{id} | Delete a translation |
| GET    | /api/translations/export/json | Export translations as JSON |

---

## ✅ Run Tests

```bash
php artisan test
```

> Make sure **Xdebug** or **PCOV** is installed for test coverage reports.

---

## 📁 JSON Export

- Always returns the **latest translations**
- Efficient even with **100,000+ records**
- Returns response in **< 500ms**

---

## 📜 License

MIT License. Free to use and modify.

---

## 👨‍💻 Developed by

**Umer Saleem**  
Senior Laravel Developer  
[Your GitHub Profile](https://github.com/umer-detech)