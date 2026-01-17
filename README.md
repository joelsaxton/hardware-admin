# Hardware Admin Panel

A Laravel 12 admin panel for hardware store inventory management, built with [Filament 5](https://filamentphp.com/).

## Notes

- The Spatie Query Builder package in `composer.json` was not needed for this Filament app, but I just left it in to show what I like to use.
- I changed PHP version from `8.5` -> `8.4` after setting up 8.5 due to not found Docker image.
- In answer to a previous question, I get some of my PHP information from signing up to `PHP.net`. I did read the version 8.5 docs a while back but I could not recall the new features during our interview (https://www.php.net/releases/8.5/en.php)
- I added a test, but it's really just testing Filament's innards.
- Lastly, the name of the Laravel admin panel I've used in the past is `Nova`

## Requirements

- Docker Desktop - ensure this is running before proceeding
- Git CLI

## Quick Start

### 1. Clone the Repository

```
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

**NOTE**: Ensure your Docker Desktop is running before this step
```
./setup.sh
```

### 3. Start Sail

```
./vendor/bin/sail up -d
```

### 4. Generate Application Key

```
./vendor/bin/sail artisan key:generate
```

### 5. Run Migrations & Seed Database with Hardware Products, Categories and Brands

```
./vendor/bin/sail artisan migrate --seed
```

## Accessing the Filament Admin Panel

- http://localhost/admin

### Admin Login Credentials

- **Email**: `admin@example.com`
- **Password**: `password`

### Sail Commands

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


#### Note - you can add/edit/delete `categories` and `brands`, too. You will receive a warning message if you're deleting a category or brand that is associated with existing products because they will cascade with the deletion.



## Packages Included

- [Filament 5](https://filamentphp.com/) - Admin panel framework
- [Spatie Laravel Query Builder](https://spatie.be/docs/laravel-query-builder) - API query building (I did not use this as Filament handled all my requirements without it, but I am a fan)
- [Laravel Pint](https://laravel.com/docs/pint) - Code style fixer. I used it many times in PHPStorm for fixing style issues. 

## Filament Features

I created resources for `Product`, `Category` and `Brand`.

- **Table View**: Sortable, searchable list with `SKU`, `title`, `category`, `brand`, `price`, and `stock`
- **Filters**: Filter by category, brand, low stock, or out of stock
- **Forms**: Create and edit products, categories and brands with validation
- **Global Search**: Search products by title, SKU, or description
- **Bulk Actions**: Delete multiple products at once, update multiple products' stock
- **TODO**: I went over time on this, but if I had more time I would have included the file export and image upload features.

## Coding Screen Capture

See the `screen capture video.mp4` file in the project root.

