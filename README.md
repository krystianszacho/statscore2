# Gilded Rose Refactoring

## Description

This project is a refactoring of the classic **Gilded Rose**, applying **Domain-Driven Design (DDD)** and **Test-Driven Development (TDD)** principles. The code eliminates redundant `if` statements, using elegant solutions like `array_map` and `array_walk`.

## Requirements

- PHP 8.1+
- Composer

## Installation

1. Clone the repository:
   ```sh
   git clone https://github.com/krystianszacho/statscore2.git
   cd statscore2
   ```
2. Install dependencies:
   ```sh
   composer install
   ```

## Directory Structure

```
.
├── src/                # Application source
│   ├── Models/         # Domain models
│   │   ├── Item.php        # Base item class
│   ├── Services/       # Business logic services
│   │   ├── GildedRose.php  # Main class for updating items
│   │   ├── ItemBase.php    # Abstract base class
│   │   ├── NormalItem.php  # Standard item class
│   │   ├── AgedBrie.php    # Aged Brie item class
│   │   ├── BackstagePass.php # Backstage pass item class
│   │   ├── Sulfuras.php    # Legendary item class
├── tests/              # Unit tests
│   ├── GildedRoseTest.php
├── composer.json       # Composer configuration
├── README.md           # Project documentation
```

## Running Tests

Tests are written using PHPUnit and utilize the **Faker** library for generating random test data.

```sh
./vendor/bin/phpunit
```

## Key Refactoring Changes

- **PSR-4** autoloading implementation.
- **Single Responsibility Principle (SRP)** applied by separating item types into dedicated classes.
- Replacing `if` statements with **match expressions**, `array_map`, and `array_walk`.
- Test cases using **Faker** for generating dynamic test data.

## Author

Krystian Szachogłuchowicz / contact@krystian.site

