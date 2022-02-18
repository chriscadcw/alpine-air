/**
This script sets up our database, the database user and creates the tables required for this project
*/

/*
Create the database if it doesn't exists
*/
create database if not exists alpineair;
/*
Create the database user if it does not already exist
*/
CREATE USER IF NOT EXISTS 'alpineair'@'%' IDENTIFIED BY 'secret';
/*
Grant the database user full access to the database we just created
*/
grant all on alpineair.* to 'alpineair'@'%';
/*
Set up to use the new database for our next set of transactions
*/
use alpineair;

/*
Here we'll drop the users table if it already exists and create it again
*/
DROP TABLE IF EXISTS users;
CREATE TABLE users (id INT NOT NULL AUTO_INCREMENT, 
        first_name VARCHAR(50), 
        last_name VARCHAR(50), 
        email_address VARCHAR(50), 
        password VARCHAR(100),
        role_id INT,
        PRIMARY KEY (id));

/*
Here we'll drop the roles table if it already exists and create it again
*/
DROP TABLE IF EXISTS roles;
CREATE TABLE roles (id INT NOT NULL AUTO_INCREMENT,
        role_name VARCHAR(25),
        PRIMARY KEY (id)
        );

/**
Inserting starting data, including roles and "super" admin user
*/
INSERT INTO roles (role_name) VALUES ('Super Admin'), ('Admin'), ('User');
/* The password inserted here is the hashed string for "secret" */
INSERT INTO users (first_name, last_name, email_address, password, role_id) VALUES 
                ('Super', 'Admin', 'admin@alpineair.com', '$2y$10$pGNLK1kPo3GVPnImlSijEemf2.R1lq1ToZJtchmp9y2U.VJwvWhKy', (SELECT id FROM roles WHERE role_name = 'Super Admin'));

