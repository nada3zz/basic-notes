# Notes App

Simple notes app performs simple CRUD functionalities, includes user authentication using JWT, and integrates a simple cron job to send email notifications for users based on set reminders.


## Getting Started

### Prerequisites

* PHP
* composer
* XAMPP

### Installation

1. Clone the repository:

   ```bash
      git clone https://github.com/nada3zz/php-task 
      cd notesBackend
   ```

2. Install API dependencies
  ```bash
      composer install
     # create .env with your configuration details
   ```

3. Install Client dependencies
  ```bash
      cd notes-frontend
      npm install
   ```