# Laravel Weather API

This is a Laravel-based API that fetches weather data and stores it using an SQLite database.

## Prerequisites

Ensure the following are installed on your system:

- [Docker](https://docs.docker.com/get-docker/) (if using Docker)
- [Composer](https://getcomposer.org/download/)
- PHP 8.3 or higher
- SQLite (or included with PHP)

## Installation

### Step 1: Clone the Repository

```bash
git clone https://github.com/majidfeiz/oweather-backend.git
cd your-repo
```

### Step 2: Install Dependencies
```
composer install
```
### Step 3: Set Up Environment Variables

Copy the example ``.env`` file and configure the required keys.

```
cp .env.example .env
```

Update the following environment variables in your ```.env``` file:


```
APP_NAME=LaravelWeatherAPI
APP_ENV=local
APP_KEY=base64:yourGeneratedAppKey
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=sqlite
DB_DATABASE=/path_to_your_project/database/database.sqlite

WEATHER_API_KEY=your_api_key
WEATHER_API_URL=https://api.openweathermap.org/data/2.5/weather
```

### Step 4: Generate Application Key

```
php artisan key:generate
```

### Step 5: Prepare SQLite Database

```
touch database/database.sqlite
```

Run the migrations to create the necessary tables:

```
php artisan migrate
```

### Step 6: Start the Application

```
php artisan serve
```
The application will be accessible at ```http://localhost:8000```.

## API Endpoints
```
GET /api/weather?location={city}: Fetches the weather data for the specified location.
GET /api/weather-latlon?lat={lat}&lon={lon}: Fetches the weather data for the specified lat and long.

```
## Environment Variables
```
    WEATHER_API_KEY: Your weather API key.
    WEATHER_API_URL: The URL of the weather API provider.
    APP_KEY: Laravel application encryption key.
```

## Testing

Run the tests using PHPUnit:

```
php artisan test
```





















