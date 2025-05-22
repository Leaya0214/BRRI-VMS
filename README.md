# BRRI Vehicle Management System (BRRI-VMS)

BRRI-VMS is a web-based vehicle management system designed to streamline vehicle allocation, requisition, and tracking processes at BRRI.

## Features

- Vehicle requisition and approval workflow
- Vehicle assignment and scheduling
- User roles and permissions
- Real-time status updates

## Installation

1. Clone the repository:  
   `git clone https://github.com/Leaya0214/BRRI-VMS.git`

2. Install dependencies:  
   `composer install` (for Laravel PHP dependencies)  
   `npm install` (if you use Node.js packages)

3. Configure environment variables:  
   Copy `.env.example` to `.env` and set database and other configs.

4. Run migrations:  
   `php artisan migrate`

5. Start the server:  
   `php artisan serve`

## Usage

Access the app via the browser at `http://localhost:8000`

## Contributing

Feel free to fork the project and submit pull requests.

## License

This project is licensed under the MIT License.
