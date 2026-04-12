# StabilityLog

A Laboratory Information Management System (LIMS) for skincare product stability testing.

## Features

- **Sample Registration**: Register products with unique batch codes and automated QR code generation.
- **Automated Scheduling**: Automatically creates stability test schedules for H+1, H+7, and H+30 days.
- **Audit Trail**: Tracks all changes to data for compliance.
- **Anomaly Detection**: Highlights abnormal test results.
- **pH Validation**: Ensures pH values are within 0.0-14.0 range.

## Installation

1. Clone the repository
2. Run `composer install`
3. Copy `.env.example` to `.env` and configure your database
4. Run `php artisan migrate`
5. Run `php artisan serve`

## Usage

- Register a sample: Visit `/register`
- View tests: (Coming soon)

## Tech Stack

- Laravel 11
- SQLite
- Bootstrap
- Simple QR Code
