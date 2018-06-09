BileMo API
========

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/6f2aece2052a454d8fb9fcb75734065e)](https://www.codacy.com/app/Emma1987/OC_P7?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Emma1987/OC_P7&amp;utm_campaign=Badge_Grade)


Web service exposing an API 

## Getting Started
You can download the project, or clone it with Git by using the green button "Clone or download". You can run it on your local machine for development and testing purposes.

## Prerequisites
PHP 7.2  
MySql 5.6.35  
Apache  

## Installing
For installing the project, you have to clone or download it. For running it on your local machine, you can install MAMP (or WAMP for Windows), and put it in the htdocs (or www) file.

Execute the command `composer update` to update the dependancies.  
Execute `php bin/console doctrine:database:create` and `php bin/console doctrine:schema:update --force` to create database and all the entities.  
Run `php bin/console doctrine:fixtures:load` to load fixtures.
Now, you can go on http://localhost/ and use the application !

## Built With
[Symfony 4.0](https://symfony.com/doc/current/index.html) - PHP framework  
[FOSRestBundle](https://github.com/FriendsOfSymfony/FOSRestBundle) - This Bundle provides various tools to rapidly develop RESTful API's with Symfony  
[JMSSerializerBundle](https://github.com/schmittjoh/JMSSerializerBundle) - Easily serialize, and deserialize data of any complexity (supports XML, JSON, YAML)  
[Firebase PHP JWT](https://github.com/firebase/php-jwt) - PEAR package for JWT  
[Hateoas](https://github.com/willdurand/Hateoas) - A PHP library to support implementing representations for HATEOAS REST web services  
[NelmioAPIDocBundle](https://github.com/nelmio/NelmioApiDocBundle) - Generates documentation for your REST API from annotations  

## Add-ons
[PHP Code Sniffer](https://github.com/squizlabs/PHP_CodeSniffer) to respect PSR 1 & 2  
