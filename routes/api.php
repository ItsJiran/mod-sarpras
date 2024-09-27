<?php

use Illuminate\Support\Facades\Route;
use Module\Infrastructure\Http\Controllers\DashboardController;
use Module\Infrastructure\Http\Controllers\InfrastructureAssetController;

Route::get('dashboard', [DashboardController::class, 'index']);
Route::resource('assets', InfrastructureAssetController::class)->parameters(['assets'=>'infrastructureAsset']);
Route::post('assets', [InfrastructureAssetController::class, 'store']);
