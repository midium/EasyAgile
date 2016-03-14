# EasyAgile #
Easy Agile is a small and easy to use agile ticketing system based on Laravel and MySql.

## Server Requirements ##
- Composer installed on your remote system
- PHP >= 5.5.9
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- MySql Server >= 5.5

## Installation ##
1. First download the package from [here](https://github.com/midium/EasyAgile/archive/master.zip "Easy Agile") and decompress it into your remote folder
2. Navigate into the remote folder and run following command: `composer install` 
3. Allow proper write access to the folders. Please refer to [this](https://laravel.com/docs/5.2#configuration) link for further details.
4. Copy the .env.example file into .env one: `cp .env.example .env`
5. Use the `database_structure.sql` file to create the required tables on your MySql server.
6. Create a user entry on the database on user table leaving the password empty. You will create the password later using the recover password feature. 
7. Edit the .env file adding database credentials and other application details. For email service please refer to laravel [mail](https://laravel.com/docs/5.2/mail) documentation for further details.
8. If you want you can populate the application key manually inside the .env file or automatically generate a new one running the following command: `php artisan key:generate`
9. Install a virtual host on your apache or ningx server pointing to the application folder.
