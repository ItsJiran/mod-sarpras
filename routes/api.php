<?php

use Illuminate\Support\Facades\Route;
use Module\Infrastructure\Http\Controllers\DashboardController;


Route::get('dashboard', [DashboardController::class, 'index']);