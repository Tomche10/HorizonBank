<span style="font-size: 40px; font-weight: bold"> <span style="color:turquoise ">Horizon Bank</span> Banking Project</span>

## Table of Contents

-   [About Horizon Bank](#about-horizon-bank)
-   [Installation](#installation)
-   [Features](#features)
    -   [Account Management](#account-management)
    -   [Transaction Management](#transaction-management)

## About Horizon Bank

The **Horizon Bank** project is a Laravel-based web application simulating a banking system. Built on Laravel 11 and MySQL, the project includes user-friendly features for account and transaction management, along with robust administrative tools.

## Installation

To install and set up the Horizon Bank project locally:

1. Clone the repository:

    ```bash
    git clone https://your-repository-link.git

    cd your-project-directory

    git checkout main
    ```

2. Install dependencies:

    ```bash
    composer install

    npm install && npm run dev
    ```

3. Copy the `.env` file and generate the application key:

    ```bash
    cp .env.example .env

    php artisan key:generate
    ```

4. Configure the database in `.env`:

    ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=databaseName
    DB_USERNAME=username
    DB_PASSWORD=password
    ```

5. Run migrations and seeders, and create a symbolic link for storage:

    ```bash
    php artisan migrate --seed
    ```

6. Serve the application:

    ```bash
    php artisan serve
    ```

## Features

### Account Management

-   Create, view, and delete customer accounts.
-   Update customer details.
-   Manage account balances.

### Transaction Management

-   Perform deposits, withdrawals, and transfers.
-   View transaction history for all accounts.

### Fictional ATM's

-   A map for the potential ATM's of the bank.

### Admin Credentials

```bash
email: admin@horizonbank.com
password: password
```
