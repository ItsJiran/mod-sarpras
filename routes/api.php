<?php

use Illuminate\Support\Facades\Route;
use Module\Infrastructure\Http\Controllers\DashboardController;
use Module\Infrastructure\Http\Controllers\InfrastructureAssetController;
use Module\Infrastructure\Http\Controllers\InfrastructureTaxController;
use Module\Infrastructure\Http\Controllers\InfrastructureMaintenanceController;
use Module\Infrastructure\Http\Controllers\InfrastructureUnitController;
use Module\Infrastructure\Http\Controllers\InfrastructureDocumentController;

// +-- dashboard resource
Route::get('dashboard', [DashboardController::class, 'index']);

// +-----------------------------------
// +-- from resource module unit
Route::resource('unit', InfrastructureUnitController::class)->parameters([
    'unit'=>'infrastructureUnit'
]);

Route::get('ref-unit/combos',[InfrastructureUnitController::class, 'refCombos']);


// +-----------------------------------
// +-- from resource module tax
Route::resource('maintenance',InfrastructureMaintenanceController::class)->parameters([
    'maintenance' => 'infrastructureMaintenance'
]);

Route::get('asset/{asset}/maintenance',[InfrastructureMaintenanceController::class,'indexFromAsset']);
Route::get('document/{document}/maintenance',[InfrastructureMaintenanceController::class,'indexFromDocument']);

Route::post('unit/{unit}/asset/{asset}/maintenance',[InfrastructureMaintenanceController::class, 'storeFromUnitAsset']);
Route::get('unit/{unit}/asset/{asset}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'showFromUnitAsset']);

Route::post('asset/{asset}/maintenance',[InfrastructureMaintenanceController::class, 'storeFromAsset']);
Route::get('asset/{asset}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'showFromAsset']);
Route::put('asset/{asset}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'updateFromAsset']);
Route::delete('asset/{asset}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'destroyFromAsset']);

Route::post('unit/{unit}/document/{document}/maintenance',[InfrastructureMaintenanceController::class, 'storeFromUnitDocument']);
Route::get('unit/{unit}/document/{document}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'showFromUnitDocument']);

Route::post('document/{document}/maintenance',[InfrastructureMaintenanceController::class, 'storeFromDocument']);
Route::get('document/{document}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'showFromDocument']);
Route::put('document/{document}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'updateFromDocument']);
Route::delete('document/{document}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'destroyFromDocument']);

// +-----------------------------------
// +-- from resource module maintenance
Route::resource('tax',InfrastructureTaxController::class)->parameters([
    'tax' => 'infrastructureTax'
]);

// +-----------------------------------
// +-- from resource module asset
Route::resource('asset',InfrastructureAssetController::class)->parameters([
    'asset' => 'infrastructureAsset'
]);

// +-- manually from unit/asset
Route::get('ref-asset/{unit}/asset',[InfrastructureAssetController::class, 'refAsset']);
Route::get('ref-asset/{unit}/{asset_type}/asset',[InfrastructureAssetController::class, 'refAssetType']);
Route::get('ref-asset/type',[InfrastructureAssetController::class, 'refType']);

Route::get('unit/{unit}/asset',[InfrastructureAssetController::class, 'indexFromUnit']);
Route::post('unit/{unit}/asset',[InfrastructureAssetController::class, 'storeFromUnit']);

Route::get('unit/{unit}/asset/{asset}',[InfrastructureAssetController::class, 'showFromUnit']);
Route::put('unit/{unit}/asset/{asset}',[InfrastructureAssetController::class, 'updateFromUnit']);
Route::delete('unit/{unit}/asset/{asset}',[InfrastructureAssetController::class, 'destroyFromUnit']);

// +-----------------------------------
// +-- from resource module asset
Route::resource('document',InfrastructureDocumentController::class)->parameters([
    'document' => 'infrastructureDocument'
]);
Route::get('ref-document/combos/unit/{unit}',[InfrastructureDocumentController::class,'mapCombosOnlyUnit']);
Route::get('ref-document/combos/unit/{unit}/asset/{asset}',[InfrastructureDocumentController::class,'mapCombosOnlyAsset']);

// +-- manually from asset/document
Route::get('unit/{unit}/asset/{asset}/document/{document}',[InfrastructureDocumentController::class, 'showFromUnit']);
Route::get('unit/{unit}/asset/{asset}/document',[InfrastructureDocumentController::class, 'indexFromUnit']);

Route::get('asset/{asset}/document/{document}',[InfrastructureDocumentController::class, 'showFromAsset']);
Route::get('asset/{asset}/document',[InfrastructureDocumentController::class, 'indexFromAsset']);

Route::get('unit/{unit}/document/{document}',[InfrastructureDocumentController::class, 'showFromUnit']);
Route::get('unit/{unit}/document',[InfrastructureDocumentController::class, 'indexFromUnit']);

Route::post('asset/{asset}/document',[InfrastructureDocumentController::class, 'storeFromAsset']);
Route::post('unit/{unit}/asset/{asset}/document',[InfrastructureDocumentController::class, 'storeFromUnit']);
Route::post('unit/{unit}/document',[InfrastructureDocumentController::class, 'storeFromUnit']);

Route::put('asset/{asset}/document/{document}',[InfrastructureDocumentController::class, 'updateFromAsset']);
Route::put('unit/{unit}/asset/{asset}/document/{document}',[InfrastructureDocumentController::class, 'updateFromUnit']);