# Laravel Task Management API - Setup Guide

## Prerequisites
Ensure you have the following installed on your system before proceeding:
- **Docker** (For running containers)
- **Docker Compose** (For managing multiple containers)

## Setup Instructions

### Step 1: Clone the Repository
```sh
git clone https://github.com/haisamhameed/task-management-squadio
cd task-management
```

### Step 2: Build and Start the Containers
```sh
docker compose build --no-cache
docker compose up -d
```
This will build and start the following services:
- PHP-FPM container for Laravel
- Nginx webserver
- MySQL database
- Redis for caching
- MailHog for testing emails
- Laravel queue worker

### Step 3: Install Dependencies
Once the containers are running, execute the following command inside the `app` container to install Laravel dependencies:
```sh
docker exec -it laravel_app composer install --no-dev --optimize-autoloader
```

### Step 4: Configure Environment Variables
Copy the example environment file and update any necessary configurations:
```sh
cp .env.example .env
```
Update the `.env` file, ensuring the database and other configurations match the Docker services.

### Step 5: Run Migrations
```sh
docker exec -it laravel_app php artisan migrate
```
This will create the necessary tables.

### Step 6: Generate Application Key
```sh
docker exec -it laravel_app php artisan key:generate
```

### Step 7: Access the Application
Your Laravel application should now be running at:
```
http://localhost
```

### Step 8: Queue Worker (Optional)
To start the Laravel queue worker, use:
```sh
docker exec -it laravel_queue php artisan queue:work redis --sleep=3 --tries=3
```

### Step 9: MailHog for Email Testing
To test email functionality, open:
```
http://localhost:8025
```
### 10. API Testing
A Postman collection named **Task Management.postman_collection** is included for API testing. Import it into Postman to test the endpoints.
## Useful Docker Commands
- Restart all containers: `docker compose restart`
- Stop all containers: `docker compose down`
- View running containers: `docker ps`
- View logs for a container: `docker logs -f <container_name>