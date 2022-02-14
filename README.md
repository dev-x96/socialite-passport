# Socialite Passport

 This package provides an easy way to authenticate users via a central identity provider that uses Laravel Passport.

## Installation

You can install the package via composer:

```bash
composer require x96/socialite-passport
```

Publish the configuration

```bash
php artisan vendor:publish --provider="x96\SocialitePassport\SocialitePassportServiceProvider" --tag="config"
````
Run migration

```bash
php artisan migrate
````

Next, the following environment variables should be added to `.env`, where `CLIENT_ID` and `CLIENT_SECRET` are obtained from the Laravel Passport identity provider.
The `REDIRECT_URI` variable will automatically map the correct callback route in the routes file. Therefore, this can be anything you'd like (convention is to use `login/[name-of-service]/callback`. 
  
```
LARAVELPASSPORT_CLIENT_ID=
LARAVELPASSPORT_CLIENT_SECRET=
LARAVELPASSPORT_REDIRECT_URI=/callback
LARAVELPASSPORT_HOST=https://auth.example.com
```

## Usage
