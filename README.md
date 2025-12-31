# iPhone Online Store

A full-featured e-commerce web application for selling iPhones, built with Laravel 12 and Livewire 3. This platform provides a seamless shopping experience with modern design and functionality.

## Features

### Customer Features
- 📱 **Product Catalog** - Browse iPhone models with multiple images, ratings, and pricing
- 🛒 **Shopping Cart** - Session-based cart for guests, persistent cart for authenticated users
- 💝 **Wishlist** - Save favorite products for later
- 👤 **User Authentication** - Dual login (email/phone), registration with complete profile
- 🔍 **Global Search** - Real-time product search across name, brand, and description
- 📦 **Order Management** - View order history and track order status
- 🎨 **Dark/Light Theme** - Toggle between themes for comfortable browsing

### Admin Features
- 📊 **Admin Dashboard** - Overview of store metrics
- 🛍️ **Product Management** - CRUD operations with image upload support
- 📋 **Order Management** - View, update order status, and manage fulfillment
- 👥 **Customer Management** - View customer information and order history
- 🔐 **Role-Based Access** - Secure admin panel with middleware protection

## Tech Stack

- **Framework:** Laravel 12.x
- **Frontend:** Livewire 3.x, Alpine.js, Custom CSS
- **Database:** SQLite (development), MySQL/PostgreSQL (production)
- **Authentication:** Custom authentication with rate limiting
- **UI:** Wildberries-inspired design with responsive layout

## Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & NPM
- SQLite/MySQL/PostgreSQL

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/Abraham-Chileshe/IphoneOnline-Store.git
   cd IphoneOnline-Store
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database setup**
   ```bash
   php artisan migrate --seed
   ```

5. **Build assets**
   ```bash
   npm run build
   ```

6. **Start development server**
   ```bash
   php artisan serve
   ```

Visit `http://localhost:8000` to view the application.

## Testing

Run the test suite:
```bash
php artisan test
```

## Security Features

- Rate limiting on authentication and cart operations
- CSRF protection
- Password hashing with bcrypt
- SQL injection prevention via Eloquent ORM
- XSS protection via Blade templating
- Admin middleware for protected routes
- Secure session management

## Performance Optimizations

- Database indexes on frequently queried columns
- Eager loading to prevent N+1 queries
- Query optimization with proper relationships
- Asset compilation and minification

## Project Structure

```
app/
├── Http/
│   ├── Controllers/     # Traditional controllers
│   ├── Middleware/      # Custom middleware (Admin)
│   └── Requests/        # Form request validation
├── Livewire/           # Livewire components
│   ├── Admin/          # Admin panel components
│   ├── CartSummary.php
│   ├── ProductCard.php
│   └── UserProfile.php
└── Models/             # Eloquent models

database/
├── factories/          # Model factories for testing
├── migrations/         # Database migrations
└── seeders/           # Database seeders

resources/
├── css/               # Custom stylesheets
├── js/                # JavaScript files
└── views/             # Blade templates

tests/
├── Feature/           # Feature tests
└── Unit/              # Unit tests
```

## Default Admin Account

After seeding, create an admin user manually:
```bash
php artisan tinker
```
```php
User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'phone' => '+1234567890',
    'password' => Hash::make('password'),
    'role' => 'admin',
    'address' => '123 Admin St',
    'city' => 'Admin City',
    'postal_code' => '12345'
]);
```

## Contributing

Contributions are welcome! Please follow these steps:
1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Open a Pull Request

## License

This project is open-sourced software licensed under the MIT license.

## Author

Abraham Chileshe

## Acknowledgments

- Inspired by Wildberries e-commerce platform
- Built with Laravel and Livewire
