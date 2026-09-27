# E-Commerce Inventory API

## Demonstration Video

[Watch Demonstration Video](https://youtu.be/c-B5bxCkW6A)

## How to Run

1. `git clone https://github.com/louxer-crakers/ecommerce-inventory-api`
2. `cd ecommerce-inventory-api`
3. `cp .env.example .env`
4. Configure the `.env` file to match your database settings:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_username
   DB_PASSWORD=your_database_password
   ```

5. `composer install`
6. `docker compose up -d`
7. `php artisan key:generate`
8. `php artisan migrate --seed`
9. `php artisan jwt:secret`
10. `php artisan serve`

## How to Test

1. Open Postman.
2. Import the `api-ecommerce-inventory.postman_collection.json` file.
3. Send a `POST` request to `http://127.0.0.1:8000/api/login` with the following JSON body:

   ```json
   {
       "email": "admin@ecommerce.com",
       "password": "admin123"
   }
   ```

4. Copy the `access_token` from the response.
5. For protected routes, navigate to the **Authorization** tab in Postman, select **Bearer Token**, and paste the token.
