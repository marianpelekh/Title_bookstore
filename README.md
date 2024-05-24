Bookstore Website

This is a PHP-based website for an online bookstore. It allows users to browse books, add them to a shopping cart, and make purchases. The website uses phpMyAdmin for database management and requires XAMPP for local development.

Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Troubleshooting](#troubleshooting)
- [Contributing](#contributing)

## Features

- Browse books by categories
- Search for books
- View book details
- Add books to a shopping cart
- User registration and login
- User profile management
- Admin panel for managing books and users

## Requirements

- [XAMPP](https://www.apachefriends.org/index.html) (Apache, MySQL, PHP)
- Web browser (Chrome, Firefox, etc.)
- phpMyAdmin (included with XAMPP)

## Installation

1. Download and Install XAMPP:
   - Download XAMPP from [here](https://www.apachefriends.org/index.html).
   - Install XAMPP by following the instructions on the website.

2. Clone the Repository:
   - Clone this repository to your local machine using:
     ```
     git clone https://github.com/yourusername/bookstore.git
     ```
   - Move the cloned repository to the `htdocs` directory of your XAMPP installation:
     ```
     mv bookstore /path/to/xampp/htdocs/
     ```

3. Start XAMPP:
   - Open XAMPP Control Panel.
   - Start the Apache and MySQL modules.

4. Setup the Database:
   - Open phpMyAdmin by going to `http://localhost/phpmyadmin`.
   - Create a new database named `bookstore`.
   - Import the provided SQL file to set up the necessary tables:
     ```sql
     bookstore/database/bookstore.sql
     ```

5. Configure the Application:
   - Open the `connect_db.php` file in the project directory.
   - Update the database connection settings:
     ```php
     $servername = "localhost";
     $username = "your_db_username";
     $password = "your_db_password";
     $dbname = "bookstore";
     ```

## Configuration

1. Database Configuration:
   - Ensure the database details in `connect_db.php` are correct.
   - Make sure the MySQL server is running.

2. Apache Configuration (optional):
   - If you need to access the website from other devices, configure your firewall to allow connections on port 80 (HTTP) or 443 (HTTPS).
   - Ensure your local network allows communication on these ports.

## Usage

1. Access the Website:
   - Open your web browser.
   - Navigate to `http://localhost/bookstore`.

2. Admin Panel:
   - Access the admin panel to manage books and users by logging in as an admin.
   - The default admin credentials can be set in the database or via registration.

## Troubleshooting

- Can't Connect to Database:
  - Ensure MySQL is running.
  - Verify database credentials in `connect_db.php`.
  - Check if the `bookstore` database exists in phpMyAdmin.

- Website Not Loading:
  - Make sure Apache is running.
  - Check for any syntax errors in the PHP files.
  - Ensure the project directory is in the `htdocs` folder.

## Contributing

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Make your changes.
4. Commit your changes (`git commit -m 'Add some feature'`).
5. Push to the branch (`git push origin feature-branch`).
6. Open a pull request.

