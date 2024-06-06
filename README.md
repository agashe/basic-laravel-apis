# Basic Laravel APIs

This is a very basic Laravel APIs , including authentication and CRUD operations.

To start using :

```
composer install
```

Create new MySQL database and copy the .env.example and update 
your database credentials :

```
cp .env.example .env
```

And import `database.sql` into the newly created database.

Finally then import `collection.json` into Postman to start 
interacting with the APIs.

Testing credentials :

```
{
  "email": "test@example.com",
  "password": "12345678"
}
```
