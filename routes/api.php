<?php

use Illuminate\Support\Facades\Route;
use Module\Infrastructure\Http\Controllers\DashboardController;
use Module\Infrastructure\Http\Controllers\InfrastructureAssetController;
use Module\Infrastructure\Http\Controllers\InfrastructureUnitController;

// dashboard resource
Route::get('dashboard', [DashboardController::class, 'index']);

// from resource module asset unit
Route::resource('asset', InfrastructureAssetController::class)->parameters(['asset'=>'infrastructureAsset']);

// from resource module human unit
Route::resource('unit', InfrastructureUnitController::class)->parameters(['unit'=>'infrastructureUnit']);
Route::resource('unit.asset', InfrastructureUnitController::class)->parameters(['unit'=>'infrastructureUnit','asset'=>'infrastructureAsset']);
