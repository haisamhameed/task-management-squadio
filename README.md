# Project Setup Guide

## Prerequisites
Ensure you have the following installed on your system before proceeding:

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)
- [Composer](https://getcomposer.org/download/)
- [Node.js](https://nodejs.org/) & npm (if applicable)

## Installation Steps

### 1. Clone the Repository
```sh
git clone <repository-url>
cd <project-folder>
```

### 2. Copy Environment File
```sh
cp .env.example .env
```
Update the `.env` file with appropriate configurations.

### 3. Start Docker Containers
```sh
docker-compose up -d
```

### 4. Install PHP Dependencies
```sh
docker exec -it app-container-name composer install
```

### 5. Run Migrations and Seed Database
```sh
docker exec -it app-container-name php artisan migrate --seed
```

### 6. Generate Application Key
```sh
docker exec -it app-container-name php artisan key:generate
```

### 7. Set Permissions (if needed)
```sh
chmod -R 777 storage bootstrap/cache
```

### 8. (Optional) Install Frontend Dependencies
```sh
docker exec -it app-container-name npm install && npm run build
```

## Running the Application
To start the application, ensure the containers are running:
```sh
docker-compose up -d
```
Access the application at: `http://localhost:8000`

## Troubleshooting
- Check container logs: `docker logs app-container-name`
- Restart containers: `docker-compose restart`
- Rebuild containers (if necessary): `docker-compose up --build -d`

For further issues, check Laravel logs:
```sh
docker exec -it app-container-name tail -f storage/logs/laravel.log
