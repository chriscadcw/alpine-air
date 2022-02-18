# Welcome to this coding project for Alpine Air created by Christopher Carrigan

# Included in this repo
* The project files including models, controllers and views designed for a minimal MVC stack
* A custom docker build environment to test this project in, read the instructions below for alterations that should
be made to the stack before deployment.
* A custom CA cert and server cert to use on a server (already configured into the docker deployment) to allow for ssl
* A database initialization script located in the `docker/mysql/init.sql` file that sets up the initial database
* Some basic unit testing for the models

# How to use this repo
This repo includes a custom docker build that is designed to be launched from Docker Desktop.
If you do not wish to use the docker build, you will need to copy the following files and place them 
into the appropriate locations in your custom stack.
* `/docker/mysql/init.sql` - The database initialization file
* `/docker/nginx/cert/` - This directory includes all cert files for utilizing the ssl
* You will also need to make the appropriate adjustments to the `app/Lib/Database.php` file to allow it to connect to 
  your custom database.

# To use the included docker build
This repo is designed to be a single setup app with the docker build included.  In order to make this work, 
you will need to make a small adjustment to the `.env` file:
* Update the `WEB_APP_PATH=D:` 
  * On Windows - Update this to the drive letter where the files are located
  * On Mac - this should be changed to `./`
* Update the `WEB_APP_PROJECT_PATH=/projects/alpine-air` to match the current working directory where you have the
  project located.  This will allow docker to create the linked volumes it uses to place the files into the containers.
* With these two changes made, you should be able to lauch the project by running `docker compose up --build` from the 
  project directory.
* Once the build is running, you can access the site at `https://alpine.localhost`
* The credentials for the pre-installed admin test user are:
  * user: admin@alpineair.com
  * password: secret
