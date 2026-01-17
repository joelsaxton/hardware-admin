#!/usr/bin/env bash

set -e

echo "🚀 Setting up Laravel Filament Hardware Store project..."
echo ""

# Check if .env.example exists
if [ ! -f .env ]; then
    echo "📝 Copying .env.example to .env..."
    cp .env.example .env
    echo "WWWUSER=$(id -u)" >> .env
    echo "WWWGROUP=$(id -g)" >> .env
    echo "✅ .env created with user/group IDs"
else
    echo "⚠️  .env already exists, skipping..."
fi

# Install Laravel dependencies
if [ ! -d vendor ]; then
    echo "📦 Installing Laravel dependencies..."
    echo "This may take a few minutes..."
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        laravelsail/php84-composer:latest \
        composer install --ignore-platform-reqs
    echo "✅ Laravel dependencies installed"
else
    echo "⚠️  vendor already exists, skipping composer install..."
fi

echo ""
echo "✅ Setup complete!"
echo ""
echo "Next steps:"
echo "1. Start the application:"
echo "   ./vendor/bin/sail up -d"
echo ""
echo "2. Generate application key:"
echo "   ./vendor/bin/sail artisan key:generate"
echo ""
echo "3. Run migrations and seed database:"
echo "   ./vendor/bin/sail artisan migrate --seed"
echo ""
echo "4. Access the admin panel at http://localhost/admin"
echo "   Email: admin@example.com"
echo "   Password: password"
echo ""