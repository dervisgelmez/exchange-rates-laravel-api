# Laravel Exchange Rates API Project

This project is a Exchange Rates API developed using Laravel 10 and PHP 8.1.

----
## Documents

### Flowchart

View the project's flowchart [here](resources/document/).

### Postman Collection

Download the Postman collection and env for the API [here](resources/document/postman).

---

## Installation

To get started with the project, follow these steps:

1. Create the `.env` file:
    ```bash
    cp .env.example .env
    ```

2. Install dependencies with Composer:
    ```bash
    composer install
    ```

3. Database migrations
    ```bash
    php artisan migrate
    ```

4. Add an admin user:
    ```bash
    php artisan db:seed
    ```
   `username="admin" & password="Admin123!"`


5. Fetch exchange rates:
    ```bash
    php artisan fetch:exchange-rates
    ```

6. Run tests:
    ```bash
    php artisan migrate --env=test
    ```
    ```bash
    php artisan test --env=test
    ```

---

## Project Features

- You can extend the project by inheriting from the `ExchangeRatesAbstract` class, allowing easy addition of multiple currency exchange APIs. Simply fill in the required fields for a new provider.

- Utilizes a response cache structure with Redis.

- Logs user requests.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
