# Fateer Wa Khameer Accounting System

Laravel accounting system for Fateer Wa Khameer.

## Current Module

The first implemented module is Expenses.

Navigation:

- Dashboard
- Income
  - Income
  - Sub Income
  - Income Categories
- Expenses
  - Expenses
  - Expenses Categories
  - Sub Expenses

## Income

Fields:

- ID: auto-generated
- Date
- Income Category: parent category selected from Income Categories
- Sub Income: category-owned item selected after choosing the income category
- Amount: decimal value stored and displayed as `0.00`
- Note

After adding or editing an income record, Laravel redirects back to the income index route.

## Income Categories

Fields:

- ID: auto-generated
- Name
- Sub: number of child Sub Income records

After adding or editing an income category, Laravel redirects back to the income categories index route.

## Sub Income

Fields:

- ID: auto-generated
- Income Category: parent category
- Name

After adding or editing a sub income record, Laravel redirects back to the sub income index route.

## Expenses

Fields:

- ID: auto-generated
- Date
- Expense Category: parent category selected from Expenses Categories
- Sub Expense: category-owned item selected after choosing the expense category
- Amount: decimal value stored and displayed as `0.00`
- Note

After adding or editing an expense, Laravel redirects back to the expenses index route.

## Expenses Categories

Fields:

- ID: auto-generated
- Name

After adding or editing a category, Laravel redirects back to the expense categories index route.

## Sub Expenses

Fields:

- ID: auto-generated
- Expense Category: parent category
- Name

After adding or editing a sub expense, Laravel redirects back to the sub expenses index route.

Default sub expenses are seeded under the main expense categories, including food ingredients, beverages, packaging, salaries, rent, utilities, equipment, cleaning, transportation, marketing, office expenses, government fees, professional services, staff welfare, and miscellaneous expenses.

## Local Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
mysql -u root -e "CREATE DATABASE fk_accounting CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
php artisan migrate
php artisan db:seed --class=ExpenseCategorySeeder
php artisan serve
```

Open the app at the URL printed by `php artisan serve`.

## Deployment

The web server document root should point to:

```text
fk/public
```

Run migrations on the server after deployment:

```bash
php artisan migrate --force
php artisan db:seed --class=ExpenseCategorySeeder --force
```

## Database

The application is configured for MySQL by default.

Required `.env` values:

```text
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fk_accounting
DB_USERNAME=root
DB_PASSWORD=
```

## Static Prototype

The previous static prototype is preserved in:

```text
docs/static-prototype
```
