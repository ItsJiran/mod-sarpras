<?php

use Illuminate\Support\Facades\Route;
use Module\Infrastructure\Http\Controllers\DashboardController;
use Module\Infrastructure\Http\Controllers\InfrastructureAssetController;
use Module\Infrastructure\Http\Controllers\InfrastructureUnitController;

// dashboard resource
Route::get('dashboard', [DashboardController::class, 'index']);
Route::resource('asset', InfrastructureAssetController::class)->parameters(['assets'=>'infrastructureAsset']);

// from resource module human unit
Route::resource('unit', InfrastructureUnitController::class)->parameters(['unit'=>'infrastructureUnit']);
