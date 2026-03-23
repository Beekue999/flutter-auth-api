# 🔐 Flutter Auth API

A Laravel REST API backend for Flutter authentication — register, login, and access protected routes using **Sanctum tokens**.

---

## 🚀 Quick Start (For Your Friends)

### 1. Clone the Project

```bash
git clone https://github.com/YOUR_USERNAME/flutter-auth-api.git
cd flutter-auth-api
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure Database

Open `.env` and update:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=flutter_auth
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5. Run Migrations

```bash
php artisan migrate
```

### 6. Start the Server

```bash
php artisan serve
```

> API is now running at **http://127.0.0.1:8000**

---

## 📡 API Endpoints

Base URL: `http://127.0.0.1:8000/api`

| Method | Endpoint        | Auth Required | Description         |
|--------|-----------------|---------------|---------------------|
| POST   | `/register`     | ❌ No         | Register a new user |
| POST   | `/login`        | ❌ No         | Login & get token   |
| GET    | `/me`           | ✅ Yes        | Get current user    |
| POST   | `/logout`       | ✅ Yes        | Logout user         |

---

## 🧪 Test API with Terminal (curl)

### ▶ Register

```bash
curl -X POST http://127.0.0.1:8000/api/register \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"name": "Vee", "email": "vee@gmail.com", "password": "123456"}'
```

### ▶ Login (Get Token)

```bash
curl -X POST http://127.0.0.1:8000/api/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"email": "vee@gmail.com", "password": "123456"}'
```

**Response:**
```json
{
  "token": "1|abc123yourtokenhere",
  "user": {
    "id": 1,
    "name": "Vee",
    "email": "vee@gmail.com"
  }
}
```

> 📋 **Copy the token** — you'll need it for protected routes below.

### ▶ Get Current User (Protected)

```bash
curl -X GET http://127.0.0.1:8000/api/me \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

### ▶ Logout

```bash
curl -X POST http://127.0.0.1:8000/api/logout \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

---

## 📱 Connect from Flutter

In your Flutter project, set the base URL:

```dart
const String baseUrl = 'http://127.0.0.1:8000/api';
```

> ⚠️ For Android Emulator use `http://10.0.2.2:8000/api` instead of `127.0.0.1`

### Flutter HTTP Example

```dart
import 'dart:convert';
import 'package:http/http.dart' as http;

// Login
Future<String> login(String email, String password) async {
  final response = await http.post(
    Uri.parse('$baseUrl/login'),
    headers: {'Content-Type': 'application/json', 'Accept': 'application/json'},
    body: jsonEncode({'email': email, 'password': password}),
  );
  final data = jsonDecode(response.body);
  return data['token']; // Save this token
}

// Get current user (protected)
Future<void> getMe(String token) async {
  final response = await http.get(
    Uri.parse('$baseUrl/me'),
    headers: {
      'Authorization': 'Bearer $token',
      'Accept': 'application/json',
    },
  );
  print(jsonDecode(response.body));
}
```

---

## 🛠 Tech Stack

- **Laravel 10+** — PHP Framework
- **Laravel Sanctum** — Token Authentication
- **MySQL** — Database

---

## ⚙️ Requirements

| Tool       | Version  |
|------------|----------|
| PHP        | >= 8.1   |
| Composer   | Latest   |
| MySQL      | >= 5.7   |

---

## 📂 Project Structure

```
flutter-auth-api/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── AuthController.php   ← Register, Login, Me, Logout
│   └── Models/
│       └── User.php
├── routes/
│   └── api.php                      ← All API routes
├── database/
│   └── migrations/
├── .env.example                     ← Copy this to .env
└── README.md
```

---

## 🤝 Contributing

1. Fork this repo
2. Create your branch: `git checkout -b feature/your-feature`
3. Commit changes: `git commit -m "Add your feature"`
4. Push: `git push origin feature/your-feature`
5. Open a Pull Request

---

## 📄 License

MIT License — free to use and modify.
