# Travel Blog Application using Symfony framework 
  - This app is about to post travel stories and perform CRUD operations on it
# Concepts used
  - Annotations
  - Doctrine
  - Form Builder
# Steps to run
  - Clone the project
  - Run composer install to install all the dependencies
  - Setup and update database details in .env file
  - Run the below command to create database in phpmyadmin 
    ```sh
    $ cd php bin/console doctrine:database:create
  - Run the below command to migrate all the tables data
    ```sh 
    $ php bin/console doctrine:migrations:migrate
  - Finally run the below command to run the project
     ```sh 
    $ php bin/console server:run
