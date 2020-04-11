<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/signup','UserController@addUser');
Route::post('/login','UserController@login');
Route::post('/logout','UserController@logout');
Route::get('/currencies','CurrencyController@getAllCurrencies');
Route::get('/currencies/{id}','CurrencyController@getCurrencyWithID');

Route::group(['middleware'=>['jwt.verify']],function (){
    Route::post('/categories','CategoryController@addCategory');
    Route::put('/categories','CategoryController@updateCategory');
    Route::delete('/categories','CategoryController@deleteCategory');
    Route::get('/users/{id}/income/categories','CategoryController@getUserIncomeCategories');
    Route::get('/users/{id}/expense/categories','CategoryController@getUserExpenseCategories');
    Route::get('/users/{id}/categories/{category_id}','CategoryController@getUserCategoryWithID');
    Route::post('/transactions','TransactionController@addTransaction');
    Route::put('/transactions','TransactionController@updateTransaction');
    Route::delete('/transactions','TransactionController@deleteTransaction');
    Route::get('/users/{id}/transactions','TransactionController@getUserTransactionsWithID');
});