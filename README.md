# justfly
PHP coding assignment part of interview process


With this app, you can:

- search trips (one-way, round-trip, open-jaw, multi-city)
- search flights
- create trips (one-way, round-trip, open-jaw, multi-city)

# Setup

### Database

Install MYSQL. Setup database with your database info (datbase name, your username and your password).

### Migrations

Use the following command to create the tables that will be used.

```
php artisan migrate
```
### Database Seeder

Use the following command to add data into the tables.

*note: for trips, only one-way trips are seeded. you can add other types of trips by using the application.*

```
php artisan db:seed
```

### Run Application

Use the following command to run the application.

```
php artisan serve
```
