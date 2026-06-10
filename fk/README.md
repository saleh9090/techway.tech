# Fateer Wa Khameer Accounting System

Internal accounting and operations system for Fateer Wa Khameer.

## Current Build

The first working module is a static browser-based expenses module.

Open `index.html` to use the system.

## Navigation

- Dashboard
- Expenses
  - Expenses
  - Expenses Categories

## Expenses

Fields:

- ID: auto-generated
- Date
- Expense
- Amount: decimal value displayed as `0.00`
- Details

After adding or editing an expense, the app redirects back to `expenses/index.html`.

## Expenses Categories

Fields:

- ID: auto-generated
- Name

After adding or editing a category, the app redirects back to `expense-categories/index.html`.

## Storage

Data is stored in the browser using `localStorage`. This is suitable for the first static prototype. A database-backed version should replace this before production accounting use.
