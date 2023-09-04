Hello!


### Description
This project provides insights for stocks prices in different matter of time based on company_symbol

### Prerequisites

Before setting up and running the Laravel project, ensure you have the following prerequisites installed on your system:

1. PHP (Recommended version: PHP 8.0 or higher)
2. Composer (Dependency manager for PHP)
3. Node.js (Required for Laravel Mix)
4. MySQL (or any other supported database)
5. A web server (e.g., Apache, Nginx)
6. Git (Version control)

### Installation

#### Without Docker

1. Clone the Git repository:

   ```bash
   git clone <repository_url>
   ```

2. Change directory to your project folder:

   ```bash
   cd project-folder
   ```

3. Install PHP dependencies using Composer:

   ```bash
   composer install
   ```

4. Create a `.env` file by duplicating the `.env.example` file:

   ```bash
   cp .env.example .env
   ```

5. Generate an application key:

   ```bash
   php artisan key:generate
   ```

6. Configure your database connection by updating the `.env` file with your database credentials.

7. Run database migrations to create the required tables:

   ```bash
   php artisan migrate
   ```

8. Optionally, seed the database with initial data (if available):

   ```bash
   php artisan db:seed
   ```

9. Install JavaScript dependencies (if needed):

   ```bash
   npm install
   ```

10. Compile assets (JavaScript and CSS) if you use Laravel Mix:

    ```bash
    npm run dev
    ```

11. Start the Laravel development server:

    ```bash
    php artisan serve
    ```

12. Access the application in your web browser at `http://localhost:8000`.

#### With Docker

1. Clone the Git repository:

   ```bash
   git clone <repository_url>
   ```

2. Change directory to your project folder:

   ```bash
   cd project-folder
   ```

3. Create a `.env` file by duplicating the `.env.example` file:

   ```bash
   cp .env.example .env
   ```

4. Build and start Docker containers:

   ```bash
   docker-compose up --build
   ```

5. Install PHP dependencies inside the PHP container:

   ```bash
   docker-compose exec php composer install
   ```

6. Generate an application key:

   ```bash
   docker-compose exec php php artisan key:generate
   ```

7. Configure your database connection by updating the `.env` file inside the PHP container with your database credentials.

8. Run database migrations to create the required tables:

   ```bash
   docker-compose exec php php artisan migrate
   ```

9. Optionally, seed the database with initial data (if available):

   ```bash
   docker-compose exec php php artisan db:seed
   ```

10. Install JavaScript dependencies (if needed) inside the Node.js container:

    ```bash
    docker-compose exec node npm install
    ```

11. Compile assets (JavaScript and CSS) if you use Laravel Mix inside the Node.js container:

    ```bash
    docker-compose exec node npm run dev
    ```

12. Access the application in your web browser at `http://localhost:8000`.

### Running Seeder

To seed your database with data, use the following Artisan command:

```bash
php artisan db:seed
```

This command will execute the seeders defined in your Laravel application, populating your database with initial data.
