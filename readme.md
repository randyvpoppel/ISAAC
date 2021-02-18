# ISAAC
## Assignment for Junior PHP Developer position

### How to run
- Clone project
- Copy `.env.example` to `.env` and configure the database variables (`username`/`password`/`database_name`)
- Run command: `composer install`
- Run command: `php bin/console doctrine:database:create`
- Run command: `php bin/console doctrine:migrations:migrate`
- Run command: `php bin/console doctrine:fixtures:load`
- Host the Symfony project

### Testing
- Run command: `php bin/console app:calculate-price {scheduled_maintenance_job_id}`
- Run command: `php bin/console app:calculate-api-price {scheduled_maintenance_job_id}`

Mock data:
- `{scheduled_maintenance_job_id} = 1` - ScheduledMaintenanceJob on a weekday
- `{scheduled_maintenance_job_id} = 2` - ScheduledMaintenanceJob on a weekend

### Assumptions that I have made
- Time slots are 15 minutes each
- Time slots are always in 1 day
- Every mechanic has a separate wage cost per time slot
- Wages are increased by 30% in the weekend
- The VAT percentage is 21%
- All prices are in euros

### External API
To mock an external API I created a REST endpoint in `Controller\SparePart` and called it in `Command\CalculateScheduledMaintenancePriceUsingAPI`