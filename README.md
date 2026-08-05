

# PlayGround Project

## Overview

PlayGround Booking System consists of two main components: 
- Admin Dashboard (Blade).
- User API (REST API).

## Description

PlayGround Booking System is a Laravel-based sports facility reservation platform that enables users to search for sports playgrounds, check real-time availability, and book playgrounds by the hour through a RESTful API.

The project also provides a dedicated administrative dashboard built with Laravel Blade for managing playgrounds, owners, bookings, locations, coupons, payment methods, and reports. The booking system prevents scheduling conflicts, supports hourly reservations, discount coupons, favorites, booking history, and user reviews.


## Dependencies

- Laravel Sanctum
- php 8.3
- Composer
- Laravel 13
- MySQL

## Installing

- Clone the repository:
```bash
    git clone <repository-url>
    cd <project-folder>
```
- Install PHP dependencies:
```bash
    composer install
```
- Create the environment file:
    
```bash
    cp .env.example .env
``` 
- Generate the application key:
```bash
    php artisan key:generate
```
- Configure your database in the `.env` file.
- Run the database migrations:
```bash
    php artisan migrate
```
- Seed the database:
```bash
    php artisan db:seed
```    
- Start the development server:
```bash
    php artisan serve
```
## GitHub Repository

Repository Link:
https://github.com/SalmaMahmoud90/PlayGround.git
