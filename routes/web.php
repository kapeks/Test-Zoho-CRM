<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ZohoController;


Route::get('/', [ZohoController::class, 'index']);
Route::post('/zoho/store', [ZohoController::class, 'store'])->name('zoho.store');
