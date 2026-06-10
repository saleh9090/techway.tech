<?php

use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpenseItemController;
use App\Http\Controllers\IncomeCategoryController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\IncomeItemController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::resource('expenses', ExpenseController::class)->except(['show']);
Route::resource('expense-categories', ExpenseCategoryController::class)->except(['show']);
Route::resource('expense-items', ExpenseItemController::class)->except(['show']);
Route::resource('income', IncomeController::class)->except(['show']);
Route::resource('income-categories', IncomeCategoryController::class)->except(['show']);
Route::resource('income-items', IncomeItemController::class)->except(['show']);
