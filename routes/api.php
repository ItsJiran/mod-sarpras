<?php

use Illuminate\Support\Facades\Route;
use Module\Infrastructure\Http\Controllers\DashboardController;
use Module\Infrastructure\Http\Controllers\InfrastructureAssetController;

// dashboard resource
Route::get('dashboard', [DashboardController::class, 'index']);
Route::resource('assets', InfrastructureAssetController::class)->parameters(['assets'=>'infrastructureAsset']);

// from resource module human unit
Route::get('unit', [InfrastructureAssetController::class,'indexUnits']);
