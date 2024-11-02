# Basic Laravel APIs

This is a very basic Laravel APIs project , including authentication and CRUD operations.

## Installation

Start by installing the dependencies using the following command:

```
composer install
```

## Database

Create new MySQL database , and copy the `.env.example` to `.env`:

```
cp .env.example .env
```

After that open the `.env` file update your database credentials as following :

```

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your-database-name
DB_USERNAME=root
DB_PASSWORD=root
```

Finally import `database.sql` into the newly created database.

## Security Keys

As usual with any new Laravel project a new secret keys must be generated for Laravel Framework and Passport Package , we can perform such task by running the following commands in the terminal :

```
php artisan key:generate

php artisan passport:keys
```

## Running the app

To start the Laravel development server , we use the following command :

```
php artisan serve
```

To start interacting with the APIs we should import either `collection-postman.json` into Postman . Or import `collection-thunder-client.json` in case you prefer 
Thunder Client Extension.

Testing credentials :

```
{
  "email": "test@example.com",
  "password": "12345678"
}
```

And here are some of the APIs we can check :

```
http://localhost:8000/api/auth/login
http://localhost:8000/api/users
http://localhost:8000/api/users/1/time-sheets
http://localhost:8000/api/projects
```
