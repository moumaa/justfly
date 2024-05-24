# FlightHub - Trip Builder
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

Copy the .env.example file and create the .env file.

Run the following command to generate the encryption key.

```
php artisan key:generate
```
### Database

Install MYSQL. Setup database with your database info (database name, your username and your password).

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
![Screenshot 2024-05-16 044659](https://github.com/moumaa/justfly/assets/31826851/fdb8c0f9-c9e4-4ae4-86ba-4a8fe90cb769)

- **Build Trip page (create trip at the top and search flights at the bottom. Helps the user figure out which flights to choose.**
![Screenshot 2024-05-16 044741](https://github.com/moumaa/justfly/assets/31826851/e85f8a3e-9b50-46d6-b501-7cb04b4fb4d7)

- **Flight search.**
![Screenshot 2024-05-16 044854](https://github.com/moumaa/justfly/assets/31826851/e8f11c1c-2dc0-4cb8-b2ad-eef4c7e174b8)

- **This is how you create a trip (one-way, round-trip, open-jaw, multi-cty). As long as it passes all validations.**
![Screenshot 2024-05-16 045258](https://github.com/moumaa/justfly/assets/31826851/47d2b8f6-6b55-4d14-9ba0-21f2ab0021d9)

- **Trip Build confirmation page. This lets the user see what their trip looks like. Also helps to see if the trip follows the rules the selected trip type to be created.**
![Screenshot 2024-05-16 045348](https://github.com/moumaa/justfly/assets/31826851/73d3a367-1ae3-422c-9a39-5a7716b8f986)

- **After trip creation, the user is redirected to the trip search page with a message. The message will either be a green successful message if validations passed or a red error message if validations failed.**
![Screenshot 2024-05-16 045418](https://github.com/moumaa/justfly/assets/31826851/e7955ea3-0bcc-4fe2-8e87-1b6b8cb665d7)

- **Round-trip trip search of the previously created round-trip trip.**
![Screenshot 2024-05-16 045506](https://github.com/moumaa/justfly/assets/31826851/2202ebcb-261a-4931-94cc-471ef1b0380e)
