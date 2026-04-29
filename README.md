Project Summary

Key Commands Start: docker-compose up -d
Stop: docker-compose down

Create DB: docker exec symfony_app php bin/console doctrine:database:create

Migrate: docker exec symfony_app php bin/console doctrine:migrations:migrate

docker exec -it symfony_app php bin/console make:entity DestinationApi docker exec symfony_app php bin/console make:migration docker exec symfony_app php bin/console doctrine:migrations:migrate

Enter App: docker exec -it symfony_app bash

the .ENV database Path: DATABASE_URL="mysql://root:root@db:3306/destination_db?serverVersion=8.0.32&charset=utf8mb4" Entity: DestinationApi: name: String (255 chars), required. activities: JSON array, required. average_cost: Float, required, must be Positive. best_travel_months: JSON array, required.

• POST /destinations – Create a new destination it take to valu for Pagination it is optional page, limit • GET /destinations – List all destinations localhost:8000/destinations?page=1&limit=10 • GET /destinations/{id} – Get a single destination localhost:8000/destinations/3 • PUT, PATCH /destinations/{id} – Update a destination localhost:8000/destinations/3 • DELETE /destinations/{id} – Delete a destination localhost:8000/destinations/3 GET /destinations/search for searching and it support Pagination is will take value and it is optional page, limit, maxBudget, activities, travelMonth
localhost:8000/destinations?maxBudget=200&activities=sport&travelMonth=march&page=1&limit=10

for more information checkout the docker-compose.yml and DockerFile

for sending data to to the POST END POINT { "name": "Köln", "activities": [ "Cricket", "Football", "Basketball" ], "average_cost": 2000, "best_travel_months": [ "May", "June", "July", "August", "September" ] } COMPOSER PACKEG symfony/validator symfony/serializer maker