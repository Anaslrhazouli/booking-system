# Event Booking System

## Project Overview
The Event Booking System is a web-based platform designed to manage event reservations efficiently. It integrates key features such as email notifications, QR code generation, and client-server communication.

## Features
- **Event Reservations:** Book and manage event schedules.
- **QR Code Generation:** Generate QR codes for event tickets.
- **Email Notifications:** Automated email confirmations using PHPMailer.
- **Responsive Design:** Optimized for various devices.

## Installation

### Prerequisites
Ensure you have the following installed:
- PHP 7.4 or higher
- Composer
- A web server (e.g., Apache or NGINX)
- Database server (e.g., MySQL)

### Steps
1. Clone the repository or download the project files.

   ```bash
   git clone <repository_url>
   cd booking-system
   ```

2. Install dependencies via Composer:

   ```bash
   composer install
   ```

3. Set up environment variables by creating a `.env` file based on the provided `.env.example`.

4. Configure database settings in the `.env` file.

5. Run database migrations if applicable.

6. Start the development server:

   ```bash
   php -S localhost:8000 -t public
   ```

7. Access the application at `http://localhost:8000`.

## Dependencies
The project uses the following packages:
- **PHPMailer:** For sending emails
- **Endroid/QR-Code:** QR code generation
- **Chillerlan/QR-Code:** Advanced QR code functionalities
- **Symfony/HttpClient:** HTTP client for server requests
- **Nyholm/PSR7:** HTTP message implementations
- **Mailersend/Mailersend:** Email sending service

## Usage
1. Navigate to the application homepage.
2. Register or log in as a user.
3. Create, view, or cancel event bookings.
4. Receive QR code tickets and email confirmations for bookings.

## Contributing
Contributions are welcome! Please fork the repository and submit a pull request.

## License
This project is licensed under the [MIT License](LICENSE).

## Acknowledgments
- Thanks to the developers of the open-source libraries used in this project.

