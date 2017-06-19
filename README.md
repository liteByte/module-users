# README #


### What is this repository for? ###

* Quick summary
* Version


### How do I get set up? ###

* Summary of set up

* Configuration
  Configure apache server

* Dependencies
    composer, 
    illuminate/database
    

* Database configuration
    in the Config.php config your DATABASE

   script for MYSQL:

    CREATE TABLE `users` (
      `id` int(11) UNSIGNED NOT NULL,
      `username` varchar(100) NOT NULL,
      `email` varchar(200) NOT NULL,
      `password` varchar(200) NOT NULL,
      `active` tinyint(1) NOT NULL DEFAULT '1',
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL,
      `deleted_at` timestamp NULL DEFAULT NULL
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ALTER TABLE `users`
      ADD PRIMARY KEY (`id`);



* How to run tests

* Deployment instructions
   1- CLone Repo.
   2- Execute command => composer install