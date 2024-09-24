<?php

use Illuminate\Support\Facades\Route;
use Module\Infrastructure\Http\Controllers\DashboardController;
use Module\Infrastructure\Http\Controllers\InfrastructureAssetController;

Route::get('dashboard', [DashboardController::class, 'index']);
Route::get('assets', [InfrastructureAssetController::class, 'index']);