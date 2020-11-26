<p align="center">
    <img src="https://laravel.com/assets/img/components/logo-laravel.svg">
</p>

# No longer maintained, use https://github.com/MacsiDigital/laravel-zoom

# Zoom API Wrapper ( https://zoom.github.io/api/ ) 

No longer maintained, use https://github.com/MacsiDigital/laravel-zoom

## Installation

### Step 1: Composer

From the command line, run:

```
composer require macsidigital/zoom
```

### Step 2: Service Provider (For Laravel < 5.5)

For your Laravel app, open `config/app.php` and, within the `providers` array, append:

```
MacsiDigital\Zoom\ZoomServiceProvider::class
```

### Step 3: Publish Configs

From the command line, run:

```
php artisan vendor:publish --provider="MacsiDigital\Zoom\ZoomServiceProvider"
```

After that you will see `zoom.php` file in config directory, where you add value for api_key and api_secret

### Usage

```
$zoom = new MacsiDigital\Zoom\Zoom();

$zoom->users->list();
```

### RESOURCES
```
Meetings
Panelists
Registrants
Users
Webinars
```
