<?php

use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpenseItemController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::resource('expenses', ExpenseController::class)->except(['show']);
Route::resource('expense-categories', ExpenseCategoryController::class)->except(['show']);
Route::resource('expense-items', ExpenseItemController::class)->except(['show']);
