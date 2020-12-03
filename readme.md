# HCT
Health Care Travels

## Notes
1. When any values in `.env` files are changed, a restart will be required to reflect the updated values.
2. Commit messages are validated by [this](https://www.conventionalcommits.org/en/v1.0.0/) convention.
3. Seeding step from project setup steps should only be executed if the database is fresh/empty.

### Project setup
1. Install Node dependencies by running `npm i`
2. Install composer dependencies by running `composer install`
3. Create an environment file named `.env` by copying the `.env.example` file and add respective values.
4. Create database and database user as per env file.
5. Seed database with database dump using command `php artisan db:seed --class=InitialDBSeeder`
6. Seed database with all other data seeder file required for project using command `php artisan db:seed`

### Get started

```bash
php artisan serve
```

This project is built using [Laravel](https://laravel.com/).
Laravel generates it's own readme file which can be accessed [here](https://gitlab.com/healthcaretravels/hct/-/blob/master/laravel_readme.md)

### To run redis queue, execute following script 

```bash
sh queue-worker.sh
```

## Database migration notes:

#### For creating database migrations

To create new table, add migration with following command:
```bash
php artisan make:migration create_tablename_table --create=tablename
```

To create new column in existing table, add migration with following command:
```bash
php artisan make:migration add_columnname_to_tablename_table --table=tablename
```

To run migrations use command:

```bash
php artisan migrate
```

## Database seeder notes:

#### For creating database seeder

To create new seeder for a table, use following command:
```bash
php artisan make:seeder <table_name>TableSeeder
```

To run seeders use command:

```bash
php artisan db:seed
```

## Git Workflow
We have multiple environments:
1. Production - *Production Live server*
2. Staging - *Testing server with stable code*
3. Test - *Testing server with all the code to be tested*

#### make use of git feature branch with following steps:
1. Create a branch from develop branch for your ticket/feature.
2. Add all the related commits to that branch.
3. Raise a RP against develop branch and merge it.
4. QA the ticket on testing server when testing server is updated.
5. QA the ticket on staging server when staging server is updated.
6. Failed tickets should be fixed again in the same branch and pushed to develop and if the ticket failed on staging it should also be pushed to staging branch.
7. If any issue or bug arises in the code, we can create hot-fix branch and merge it directly in staging, but also to be merged in develop branch.

#### Commit convention:
1. Follow conventional commits. [More info](https://www.conventionalcommits.org/en/v1.0.0/).
2. Add ticket id to each commit message in scope. (Optional)

##### Commit message examples:
1. feat: added github integration
2. docs(#437861042): added commit message convention and examples
3. fix: login bug when user is not verified
