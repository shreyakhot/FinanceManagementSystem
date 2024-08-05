<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\IncomeController;
use App\Http\Controllers\api\InvestmentController;
use App\Http\Controllers\Api\PortfolioController;


   // Register a new user
Route::post('register', [RegisterController::class, 'registerUser']);

// Authenticate a user and issue a token
Route::post('login', [LoginController::class, 'login']);


//Income and Expense tracker
Route::get('getIncome', [IncomeController::class, 'index']);
Route::post('storeIncome', [IncomeController::class, 'store']);
Route::get('findIncome/{id}', [IncomeController::class, 'findIncome']);
Route::post('updateIncome/{id}', [IncomeController::class, 'update']);
Route::post('deleteIncome/{id}', [IncomeController::class, 'destroy']);

//Integrate with a third-party API to fetch real-time prices and stock market data. 
Route::get('fetchPrice', [InvestmentController::class, 'fetchPrice']);


//Investment
Route::get('getInvestment', [InvestmentController::class, 'index']);
Route::post('storeInvestment', [InvestmentController::class, 'store']);
Route::get('findInvestment/{id}', [InvestmentController::class, 'findInvestment']);
Route::post('updateInvestment/{id}', [InvestmentController::class, 'update']);
Route::post('deleteInvestment/{id}', [InvestmentController::class, 'destroy']);

//Portfolio
Route::get('getPortfolio', [PortfolioController::class, 'index']);
Route::post('storePortfolio', [PortfolioController::class, 'store']);
Route::get('findPortfolio/{id}', [PortfolioController::class, 'findPortfolio']);
Route::post('updatePortfolio/{id}', [PortfolioController::class, 'update']);
Route::post('deletePortfolio/{id}', [PortfolioController::class, 'destroy']);

