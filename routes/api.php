<?php

use Illuminate\Support\Facades\Route;
use Module\Infrastructure\Http\Controllers\DashboardController;
use Module\Infrastructure\Http\Controllers\InfrastructureAssetController;
use Module\Infrastructure\Http\Controllers\InfrastructureUnitController;

// dashboard resource
Route::get('dashboard', [DashboardController::class, 'index']);

// from resource module human unit
Route::resource('unit', InfrastructureUnitController::class)->parameters([
    'unit'=>'infrastructureUnit'
]);

// manually from unit/asset
Route::get('unit/{unit}/asset',[InfrastructureAssetController::class, 'indexFromUnit']);
Route::post('unit/{unit}/asset',[InfrastructureAssetController::class, 'storeFromUnit']);
Route::put('unit/{unit}/asset',[InfrastructureAssetController::class, 'updateFromUnit']);
Route::delete('unit/{unit}/asset',[InfrastructureAssetController::class, 'destroyFromUnit']);

// from resource module asset
Route::resource('asset',InfrastructureAssetController::class)->parameters([
    'asset' => 'infrastructureAsset'
]);

// Route::resource('unit.employee', EmployeeController::class)
// ->parameters(['unit' => 'hRDUnit', 'employee' => 'hRDEmployee']);