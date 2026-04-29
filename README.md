# DestinationApi Project Documentation

## 1. Quick Start Commands
- **Start Project:** `docker-compose up -d`
- **Stop Project:** `docker-compose down`
- **Enter Container:** `docker exec -it symfony_app bash`

## 2. Database & Entity Management
- **Create DB:** `docker exec symfony_app php bin/console doctrine:database:create`
- **Run Migrations:** `docker exec symfony_app php bin/console doctrine:migrations:migrate`
- **Create/Update Entity:** `docker exec symfony_app php bin/console make:entity DestinationApi`
  `docker exec symfony_app php bin/console make:migration`
  `docker exec symfony_app php bin/console doctrine:migrations:migrate`

## 3. Configuration
- **.env DB Path:** `DATABASE_URL="mysql://root:root@db:3306/destination_db?serverVersion=8.0.32&charset=utf8mb4"`
- **Required Packages:** `composer require symfony/validator symfony/serializer symfony/maker-bundle`

## 4. Entity Structure (DestinationApi)
- **name:** String (255), required.
- **activities:** JSON, required.
- **average_cost:** Float, required, must be Positive.
- **best_travel_months:** JSON, required.

## 5. API Endpoints
- **POST /destinations:** Create destination
- **GET /destinations:** List (supports ?page=1&limit=10)
- **GET /destinations/{id}:** Get single entry
- **PUT/PATCH /destinations/{id}:** Update entry
- **DELETE /destinations/{id}:** Remove entry
- **GET /destinations/search:** Filtered search 
  - Params: `page`, `limit`, `maxBudget`, `activities`, `travelMonth`
  - Example: `/destinations/search?maxBudget=200&activities=sport&travelMonth=march`

## 6. Sample Request Body (JSON)
{
  "name": "Köln",
  "activities": ["Cricket", "Football", "Basketball"],
  "average_cost": 2000,
  "best_travel_months": ["May", "June", "July", "August", "September"]
}
