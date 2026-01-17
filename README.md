# Hardware Admin Panel

A Laravel 12 admin panel for hardware store inventory management, built with [Filament 5](https://filamentphp.com/).

## Notes

- The Spatie Query Builder package in composer.json was not needed for this Filament app, but I just left it in to show what I like to use
- I changed PHP version from 8.5 -> 8.4 after setting up 8.5 due to not found Docker image.
- In answer to a previous question, I get my PHP information from PHP.net. I did read the 8.5 docs a while back but I could not recall the new features (https://www.php.net/releases/8.5/en.php)

## Requirements

- Docker Desktop
- Git

## Quick Start

### 1. Clone the Repository

```bash
git clone git@github.com:joelsaxton/hardware-admin.git
```
or 
```
git clone https://github.com/joelsaxton/hardware-admin.git
```
then
```
cd hardware-admin
```

### 2. Run the setup script
```bash
./setup.sh
```

### 3. Start Sail

```bash
./vendor/bin/sail up -d
```

### 4. Generate Application Key

```bash
./vendor/bin/sail artisan key:generate
```

### 5. Run Migrations & Seed Database

```bash
./vendor/bin/sail artisan migrate --seed
```

## Accessing the Filament Admin Panel

- http://localhost/admin

### Admin Login Credentials

- **Email**: `admin@example.com`
- **Password**: `password`

## Common Sail Commands

```bash
# Start containers
./vendor/bin/sail up -d

# Stop containers
./vendor/bin/sail down

# Run Artisan commands
./vendor/bin/sail artisan <command>

# Run Composer commands
./vendor/bin/sail composer <command>

# Access PostgreSQL
./vendor/bin/sail psql

# Run tests
./vendor/bin/sail test

# Run Laravel Pint (code formatting)
./vendor/bin/sail composer pint

# Fresh migration with seeding
./vendor/bin/sail artisan migrate:fresh --seed
```

## Project Structure

```
├── app/
│   ├── Filament/
│   │   └── Resources/
│   │       └── ProductResource.php    # Filament CRUD resource
│   ├── Http/
│   │   └── Controllers/
│   │       └── HardwareController.php # Traditional CRUD controller
│   └── Models/
│       ├── Brand.php
│       ├── Category.php
│       └── Product.php
├── database/
│   ├── migrations/
│   └── seeders/
│       └── DatabaseSeeder.php         # Seeds 100 products
└── docker-compose.yml                 # Sail + PostgreSQL
```

## Database Schema

### Products
| Column      | Type    | Description                    |
|-------------|---------|--------------------------------|
| id          | bigint  | Primary key                    |
| title       | varchar | Product name                   |
| description | text    | Product description            |
| category_id | bigint  | FK to categories               |
| brand_id    | bigint  | FK to brands                   |
| price       | integer | Price in cents                 |
| stock       | integer | Available inventory            |
| sku         | varchar | Stock Keeping Unit (SKU-XXXXX) |
| weight      | float   | Weight in pounds               |

### Categories
- Hammers, Wrenches, Screws, Drills, Nails

### Brands
- Acme, Brown, Charlie, Delta, Edman

## Packages Included

- [Filament 5](https://filamentphp.com/) - Admin panel framework
- [Spatie Laravel Query Builder](https://spatie.be/docs/laravel-query-builder) - API query building
- [Laravel Pint](https://laravel.com/docs/pint) - Code style fixer

## Filament Features

The ProductResource includes:

- **Table View**: Sortable, searchable list with SKU, title, category, brand, price, and stock
- **Filters**: Filter by category, brand, low stock, or out of stock
- **Forms**: Create and edit products with validation
- **Global Search**: Search products by title, SKU, or description
- **Bulk Actions**: Delete multiple products at once

## License

MIT
