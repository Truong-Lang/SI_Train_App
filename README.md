## About Environment

- Programming Language: PHP (Laravel Framework v9.22.XX).
- Runs on the Docker environment.
- Database MYSQL (Php 8.1.X).


- Docker command :
  - docker-compose build --no-cache
  - docker-compose up -d
  - docker-compose down
  - docker exec -it app bash (Command to CONTAINER folder /var/www/html to run commands like: composer install, php artisan migrate .....)
- Web command:
    - composer install
    - php artisan migrate
    - php artisan db:seed
    - php artisan make New model -m (create migration and option -m to create a migration for the New model)
    - Next we create NewController by: php artisan make controller NewController --resource
- clear cache command:
    - php artisan cache:clear
    - php artisan config:clear
    - composer dump-autoload
