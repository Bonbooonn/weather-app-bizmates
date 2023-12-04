# This App is a test to be submitted to Bizmates

### Pre-requisites

Before you begin the installation process, make sure you have the following software installed in your machine:

1. **PHP**: System Requires PHP 8.2 or higher.
2. **Composer**: A PHP dependency management tool. Install latest version from [https://getcomposer.org/download/](https://getcomposer.org/download/).
3. **MySQL**: A relational database management system. You'll need a running MySQL server.
4. **Node.js**: Required for asset compilation, Version 18.17.1 or higher
5. **npm**: Node.js package manager, Version 9.8.1 or higher

### Installation Steps

#### Install Dependencies:
```
composer install
```

#### Configure Environment:
```
cp .env.example .env
php artisan key:generate
npm install
```

#### Database Setup:

Create a new MySQL database for the application and update the .env with the database name, username, and password.

```
DB_PORT=your_database_port
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

#### Run the migrations:

This will create the tables needed

```
php artisan migrate
```

#### Weather and Places API

- For foursquare API, you should register to [https://location.foursquare.com/](https://location.foursquare.com/) to get your api key free
- For weather API, you should register to [https://openweathermap.org/](https://openweathermap.org/) to get your api key for free

```
FOURSQUARE_API_KEY=""
OPEN_WEATHER_API_KEY=""
```

#### To run the app

```
php artisan serve
npm run dev
```

- Once done, go to **http://127.0.0.1:8000**
    - if you use a vhost or a different port, you need to **change** the port in the **resources/js/vue/http/api.js** because the baseUrl is currently hardcoded.
