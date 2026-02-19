# EventsWally Backend — Laravel API

## 🚀 Quick Start

```bash
# Install dependencies
composer install

# Copy environment file
cp .env.example .env
php artisan key:generate

# Run migrations and seed database
php artisan migrate --seed

# Start development server
php artisan serve --port=8000
```

**Admin Login:**
- Email: `admin@eventswally.com`
- Password: `password`

---

## 📚 API Documentation

**Base URL:** `http://localhost:8000/api/v1`

All responses follow this format:
```json
{
  "success": true,
  "message": "Optional message",
  "data": { ... },
  "meta": {
    "current_page": 1,
    "last_page": 5,
    "per_page": 15,
    "total": 72
  }
}
```

### 🔓 Public Endpoints (No Auth Required)

| Method | Endpoint | Description |
|--------|----------|-------------|
| `GET` | `/home` | Home screen data (banners, categories, vendors, cities) |
| `GET` | `/search?q=photographer` | Global search |
| `GET` | `/cities` | List all cities |
| `GET` | `/cities/{id\|slug}` | City details |
| `GET` | `/categories` | List all categories with vendor counts |
| `GET` | `/categories/{id\|slug}` | Category with vendors |
| `GET` | `/vendors` | List vendors with filters |
| `GET` | `/vendors/featured` | Featured vendors |
| `GET` | `/vendors/popular` | Popular vendors by bookings |
| `GET` | `/vendors/{id\|slug}` | Vendor details with reviews |
| `GET` | `/vendors/{id}/reviews` | Vendor reviews |
| `POST` | `/auth/register` | Register new user |
| `POST` | `/auth/login` | Login |

### 🔐 Protected Endpoints (Bearer Token Required)

| Method | Endpoint | Description |
|--------|----------|-------------|
| `POST` | `/auth/logout` | Logout (revoke token) |
| `GET` | `/auth/me` | Current user profile |
| `PUT` | `/auth/profile` | Update profile |
| `PUT` | `/auth/password` | Change password |
| `GET` | `/bookings` | My bookings |
| `POST` | `/bookings` | Create booking inquiry |
| `GET` | `/bookings/{id}` | Booking details |
| `PUT` | `/bookings/{id}/cancel` | Cancel booking |
| `POST` | `/reviews` | Submit review |
| `PUT` | `/reviews/{id}` | Update review |
| `DELETE` | `/reviews/{id}` | Delete review |
| `GET` | `/favorites` | My favorite vendors |
| `POST` | `/favorites/toggle` | Add/remove favorite |

### 🔍 Vendor Filters

```
GET /api/v1/vendors?city_id=1&category_id=2&search=royal&min_rating=4&price_min=10000&price_max=500000&is_verified=1&is_featured=1&sort_by=rating&sort_dir=desc&per_page=10
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `city_id` | int | Filter by city ID |
| `city_slug` | string | Filter by city slug |
| `category_id` | int | Filter by category ID |
| `category_slug` | string | Filter by category slug |
| `search` / `q` | string | Search name, description, address |
| `min_rating` | float | Minimum rating (1-5) |
| `price_min` | int | Minimum price |
| `price_max` | int | Maximum price |
| `is_verified` | bool | Only verified vendors |
| `is_featured` | bool | Only featured vendors |
| `sort_by` | string | `name`, `rating`, `price_min`, `total_reviews`, `total_bookings`, `created_at` |
| `sort_dir` | string | `asc` or `desc` |
| `per_page` | int | Results per page (max 50) |

---

## 🗄️ Database Schema

### Tables
- **users** — User accounts (clients, vendors, admins)
- **cities** — Pakistani cities
- **categories** — Vendor service categories
- **vendors** — Vendor profiles with pricing and ratings
- **category_vendor** — Many-to-many pivot
- **services** — Individual services per vendor
- **reviews** — User reviews with ratings
- **bookings** — Booking inquiries and orders
- **favorites** — User vendor wishlist
- **banners** — Promotional banners

---

## 🏗️ Architecture

```
app/
├── Models/           # Eloquent models
├── Http/
│   ├── Controllers/
│   │   └── Api/V1/   # Versioned API controllers
│   ├── Resources/    # API response transformers
│   └── Middleware/    # Custom middleware
├── routes/
│   └── api.php       # All API routes
└── database/
    ├── migrations/   # Schema definitions
    └── seeders/      # Sample data
```

---

## 🛡️ Authentication

Using **Laravel Sanctum** with Bearer tokens:

```bash
# Register
curl -X POST /api/v1/auth/register \
  -d '{"name":"Ali","email":"ali@test.com","password":"password123","password_confirmation":"password123"}'

# Login
curl -X POST /api/v1/auth/login \
  -d '{"email":"ali@test.com","password":"password123"}'
# Returns: { "token": "1|abc123..." }

# Use token for protected routes
curl -H "Authorization: Bearer 1|abc123..." /api/v1/auth/me
```

---

## 🌐 CORS

CORS is configured to allow requests from any origin (for Flutter app).

## 📦 Packages

- **laravel/sanctum** — API authentication
- **spatie/laravel-permission** — Roles & permissions
- **spatie/laravel-sluggable** — Auto-generate URL slugs
- **spatie/laravel-medialibrary** — File/image management
- **intervention/image-laravel** — Image processing
