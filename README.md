# E-Commerce Website

Welcome to the E-Commerce Website repository! This project is a Laravel-based web application designed to provide a robust e-commerce platform. It integrates Stripe for payment processing, includes comprehensive testing, and features an admin dashboard for managing the store.

## Table of Contents

- [Introduction](#introduction)
- [Features](#features)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Testing](#testing)
- [Contributing](#contributing)
- [License](#license)

## Introduction

This E-Commerce Website is built with Laravel and offers a complete online shopping experience. It includes product management, user authentication, payment processing with Stripe, and an admin dashboard for managing orders and products. The project follows best practices in testing to ensure reliability and robustness.

## Features

- **Product Management:** Browse and search products, view product details, and add products to the cart.
- **Shopping Cart:** Add products to the cart, view cart details, and proceed to checkout.
- **Payment Processing:** Integrated with Stripe for secure payment transactions.
- **User Authentication:** Sign up, log in, and manage user accounts.
- **Admin Dashboard:** Manage products, view orders, and handle administrative tasks.
- **Order Management:** View and manage customer orders.

## Installation

You can set up the project either using traditional methods or Laravel Sail.

### Traditional Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/yourusername/e-commerce-website.git
   cd e-commerce-website
   ```

2. **Install dependencies:**
   ```bash
   composer install
   npm install
   npm run dev
   ```

3. **Copy the `.env.example` file to `.env` and configure your environment variables:**
   ```bash
   cp .env.example .env
   ```

4. **Generate an application key:**
   ```bash
   php artisan key:generate
   ```

5. **Run the migrations:**
   ```bash
   php artisan migrate
   ```

6. **Seed the database (optional):**
   ```bash
   php artisan db:seed
   ```

7. **Start the development server:**
   ```bash
   php artisan serve
   ```

### Installation Using Laravel Sail

1. **Clone the repository:**
   ```bash
   git clone https://github.com/yourusername/e-commerce-website.git
   cd e-commerce-website
   ```

2. **Install Sail and Docker dependencies:**
   ```bash
   composer require laravel/sail --dev
   php artisan sail:install
   ```

3. **Build the Sail Docker containers:**
   ```bash
   ./vendor/bin/sail build
   ```

4. **Start the Sail Docker containers:**
   ```bash
   ./vendor/bin/sail up
   ```

5. **Run the migrations:**
   ```bash
   ./vendor/bin/sail php artisan migrate
   ```

6. **Seed the database (optional):**
   ```bash
   ./vendor/bin/sail php artisan db:seed
   ```

7. **Access the application in your browser:**
   The application will be available at `http://localhost`.

## Configuration

To configure the application, you need to set up your `.env` file. The most important variables are:

- **Database Configuration:**
  - `DB_CONNECTION`: Database connection type (e.g., mysql).
  - `DB_HOST`: Database host.
  - `DB_PORT`: Database port.
  - `DB_DATABASE`: Database name.
  - `DB_USERNAME`: Database username.
  - `DB_PASSWORD`: Database password.

- **Stripe Configuration:**
  - `STRIPE_KEY`: Your Stripe public key.
  - `STRIPE_SECRET`: Your Stripe secret key.

Ensure that these environment variables are correctly set in your `.env` file.

## Usage

Once the application is up and running, you can access it in your web browser at `http://localhost`. Users can browse products, add items to their cart, and complete purchases. Admins can log in to the dashboard to manage products and view orders.

## Testing

The project includes a suite of tests to ensure the functionality and reliability of the application. To run the tests:

1. **Install PHPUnit if not already installed:**
   ```bash
   composer require --dev phpunit/phpunit
   ```

2. **Run the tests:**
   ```bash
   ./vendor/bin/phpunit
   ```

   Or, if using Laravel Sail:
   ```bash
   ./vendor/bin/sail phpunit
   ```

Tests are organized in the `tests` directory and cover various aspects of the application, including unit tests, feature tests, and browser tests.

## Contributing

Contributions are welcome! If you'd like to contribute to this project, please follow these steps:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Make your changes.
4. Commit your changes (`git commit -am 'Add new feature'`).
5. Push to the branch (`git push origin feature-branch`).
6. Create a new Pull Request.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for more details.
