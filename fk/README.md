# Fateer Wa Khameer Accounting System

Laravel accounting system for Fateer Wa Khameer.

## Current Module

The first implemented module is Expenses.

Navigation:

- Dashboard
- Expenses
  - Expenses
  - Expenses Categories

## Expenses

Fields:

- ID: auto-generated
- Date
- Expense
- Amount: decimal value stored and displayed as `0.00`
- Details

After adding or editing an expense, Laravel redirects back to the expenses index route.

## Expenses Categories

Fields:

- ID: auto-generated
- Name

After adding or editing a category, Laravel redirects back to the expense categories index route.

## Local Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
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
```

## Static Prototype

The previous static prototype is preserved in:

```text
docs/static-prototype
```
