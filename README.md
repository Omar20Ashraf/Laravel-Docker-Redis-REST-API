# Project Name

This is a Laravel project that demonstrates how to build a RESTful API using Laravel Vapor and implement a queue worker using Redis.

# Project Url:
[Project Url](https://3xrormh7omelyn6c6muz5xwygy0lashl.lambda-url.eu-west-3.on.aws)

## Setup and Deployment

1. Clone the repository:
```
git clone https://github.com/Omar20Ashraf/Laravel-Docker-Redis-REST-API.git
```

2. Navigate to the project directory:
    cd Laravel-Docker-Redis-REST-AP

3. Install the project dependencies as described here [Laravel Documentation](https://laravel.com/docs/9.x/sail#installing-composer-dependencies-for-existing-projects):

```
    docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```

4. Create a copy of the .env.example file and name it .env:
```
cp .env.example .env
```

5. Enter your database credentials in the .env file.

6. Start the Docker containers using Laravel Sail:
```
./vendor/bin/sail up -d
```

7. Generate an application key:
```
./vendor/bin/sail artisan key:generate
```

8. Run the database migrations with seeders:
```
./vendor/bin/sail artisan migrate --seed
```

9. Access the application in your web browser at [Application](http://localhost). 

## Redis Queue Worker

To implement the queue worker using Redis, follow these steps:

Run the queue worker to process background jobs:
```
./vendor/bin/sail artisan queue:work
```

## Vapor Deployment
Vapor is used for seamless deployment. Follow these steps to deploy your application:

1. Add your Vapor credentials using this command:
```
./vendor/bin/sail php vendor/bin/vapor login
```

2. Configure application environments and database names in the vapor.yml file.

3. Deploy each environment using this command:
```
./vendor/bin/sail php vendor/bin/vapor deploy env_name
```

You can find all the instructions about Vapor at [Laravel Vapor Documentation](https://docs.vapor.build/introduction.html). 

## Api Collection

You can find the api collection created with this project in the root folder.
