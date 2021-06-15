# Blog

## Software requirements
1) Docker
2) Docker-compose

## Deploy
    > docker-compose up -d --build
    > docker-compose exec application npm i
    > docker-compose exec application composer i
    > docker-compose exec application php artisan migrate
    > docker-compose exec application php artisan db:seed
    > docker-compose exec application php artisan storage:link