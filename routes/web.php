<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/income', function () {
    return view('IncomeAndExpense/income');
});
Route::get('/incomeCreate', function () {
    return view('IncomeAndExpense/createIncome');
});
Route::get('/incomeUpdate', function () {
    return view('IncomeAndExpense/updateIncome');
});

Route::get('/investment', function () {
    return view('Investment/Investment');
});
Route::get('/investmentCreate', function () {
    return view('Investment/createInvestment');
});
Route::get('/investmentUpdate', function () {
    return view('Investment/updateInvestment');
});


Route::get('/portfolio', function () {
    return view('portfolio/portfolio');
});
Route::get('/portfolioCreate', function () {
    return view('portfolio/createportfolio');
});
Route::get('/portfolioUpdate', function () {
    return view('portfolio/updateportfolio');
});



