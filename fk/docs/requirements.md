# Requirements

## Business

Fateer Wa Khameer needs a small accounting system for daily restaurant/shop operations.

## Module 1: Expenses

### Navigation

The system must have an Expenses tab with two pages under it:

- Expenses
- Expenses Categories
- Sub Expenses

### Expenses Page

The expenses page must support listing, adding, editing, and deleting expenses.

Fields:

- ID: auto-generated
- Date
- Expense Category: required parent category
- Sub Expense: required item filtered by the selected category
- Amount: decimal with `0.00` formatting
- Note

After add or edit, the user must redirect back to the expenses index page.

### Expenses Categories Page

The expenses categories page must support listing, adding, editing, and deleting categories.

Fields:

- ID: auto-generated
- Name

After add or edit, the user must redirect back to the categories index page.

### Sub Expenses Page

The sub expenses page must support listing, adding, editing, and deleting category-owned expense items.

Fields:

- ID: auto-generated
- Expense Category: parent category selected from Expenses Categories
- Name

When adding or editing an expense, the user must first select an Expense Category, then only see Sub Expenses that belong to that category.

After add or edit, the user must redirect back to the sub expenses index page.

## Future Core Records

- Customer
- Supplier
- Product
- Ingredient
- Invoice
- Payment
- Account

## Future Reports

- Daily sales
- Monthly sales
- Expenses by category
- Customer balances
- Supplier balances
- Profit summary
- Cash and bank movement

## Implementation

- Framework: Laravel
- Database: MySQL
- Database access: Eloquent models and migrations
- Add/edit behavior: controller redirects to the relevant index route after successful create or update
- Previous static prototype: preserved under `docs/static-prototype`

## Open Decisions

- Arabic, English, or bilingual interface
- Single branch or multiple branches
- Inventory tracking required now or later
- Tax/VAT handling required or not
