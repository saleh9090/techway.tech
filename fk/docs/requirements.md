# Requirements

## Business

Fateer Wa Khameer needs a small accounting system for daily restaurant/shop operations.

## Module 1: Income and Expenses

### Navigation

The system must have an Income tab with three pages under it:

- Income
- Income Categories
- Sub Income

The system must have an Expenses tab with three pages under it:

- Expenses
- Expenses Categories
- Sub Expenses

### Income Page

The income page must support listing, adding, editing, and deleting income records.

Fields:

- ID: auto-generated
- Date
- Income Category: required parent category
- Sub Income: required item filtered by the selected category
- Amount: decimal with `0.00` formatting
- Note

After add or edit, the user must redirect back to the income index page.

### Income Categories Page

The income categories page must support listing, adding, editing, and deleting categories.

Fields:

- ID: auto-generated
- Name
- Sub: count of child Sub Income records

After add or edit, the user must redirect back to the income categories index page.

### Sub Income Page

The sub income page must support listing, adding, editing, and deleting category-owned income items.

Fields:

- ID: auto-generated
- Income Category: parent category selected from Income Categories
- Name

When adding or editing income, the user must first select an Income Category, then only see Sub Income that belongs to that category.

After add or edit, the user must redirect back to the sub income index page.

The system seeds default income categories and sub income:

- Sales: POS, Transfer, Talabat, Cash
- Other

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

The system seeds default sub expenses under the main expense categories:

- Food Ingredients: Meat, Chicken, Cheese, Vegetables, Spices & Seasonings, Flour & Dough Ingredients, Oil & Ghee, Dairy Products, Eggs
- Beverages: Tea & Karak Ingredients, Water, Soft Drinks, Juices
- Packaging Materials: Boxes, Bags, Stickers & Labels, Napkins & Tissues
- Salaries & Wages: Employee Salaries, Overtime, Staff Benefits
- Rent & Accommodation: Shop Rent, Staff Accommodation
- Utilities: Electricity, Water Utility, Internet, Telephone
- Equipment & Maintenance: Kitchen Equipment, Oven Maintenance, Air Conditioning, General Maintenance
- Cleaning Supplies: Cleaning Chemicals, Cleaning Tools
- Transportation & Delivery: Fuel, Delivery Expenses, Vehicle Maintenance
- Marketing & Advertising: Social Media Ads, Printing Materials, Signboards & Branding
- Office Expenses: Stationery, Software & Subscriptions
- Government Fees: Licenses & Permits, Municipality Fees
- Professional Services: Accounting Services, Legal Services, Consultancy Services
- Staff Welfare: Meals & Refreshments, Uniforms
- Miscellaneous Expenses: Other Expenses

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
