# justfly
PHP coding assignment part of interview process


With this app, you can:

- search trips (one-way, round-trip, open-jaw, multi-city)
- search flights
- create trips (one-way, round-trip, open-jaw, multi-city)

# Setup

### Source Code

Use the following command to clone the repository.

```
git clone https://github.com/moumaa/justfly.git
```

Then do the following.

```
composer install
```

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
### Screenshots
- **One-way trip search.**
![Screenshot 2024-05-16 032216](https://github.com/moumaa/justfly/assets/31826851/e86fbbe5-c5a9-43dd-83f6-1c6a25c05de8)

- **Build Trip page (create trip at the top and search flights at the bottom. Helps the user figure out which flights to choose.**
![Screenshot 2024-05-16 032313](https://github.com/moumaa/justfly/assets/31826851/acb3e04f-cdc4-4fa1-baad-8257414376a4)

- **Flight search.**
![Screenshot 2024-05-16 032427](https://github.com/moumaa/justfly/assets/31826851/6b96185a-89dc-4c91-b40a-09df1ff22e91)

- **This is how you create a trip (one-way, round-trip, open-jaw, multi-cty). As long as it passes all validations.**
![Screenshot 2024-05-16 032549](https://github.com/moumaa/justfly/assets/31826851/4400fd0e-07a0-432d-83b9-390a7a9b479b)

- **Trip Build confirmation page. This lets the user see what their trip looks like. Also helps to see if the trip follows the rules the selected trip type to be created.**
![Screenshot 2024-05-16 032613](https://github.com/moumaa/justfly/assets/31826851/7a454ab1-b31d-4359-aac8-0a317435d0fd)

- **After trip creation, the user is redirected to the trip search page witha message. The message will either be a green successful message if validations passed or a red error message if validations failed.**
![Screenshot 2024-05-16 032633](https://github.com/moumaa/justfly/assets/31826851/0bb1bac6-00db-4770-b63f-49630b5d443c)

- **Round-trip trip search of the previously created round-trip trip.**
![Screenshot 2024-05-16 032708](https://github.com/moumaa/justfly/assets/31826851/f8223b73-9b66-4549-b1e7-7b33296a9bff)
