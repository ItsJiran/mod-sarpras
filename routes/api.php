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
Route::get('unit/{unit}/asset/{asset}/maintenance',[InfrastructureMaintenanceController::class, 'indexFromUnitAsset']);
Route::get('unit/{unit}/document/{document}/maintenance',[InfrastructureMaintenanceController::class, 'indexFromUnitDocument']);
Route::get('unit/{unit}/asset/{asset}/document/{document}/maintenance',[InfrastructureMaintenanceController::class, 'indexFromUnitAssetDocument']);

Route::post('asset/{asset}/maintenance',[InfrastructureMaintenanceController::class, 'storeFromAsset']);
Route::post('document/{document}/maintenance',[InfrastructureMaintenanceController::class, 'storeFromDocument']);
Route::post('unit/{unit}/asset/{asset}/maintenance',[InfrastructureMaintenanceController::class, 'storeFromUnitAsset']);
Route::post('unit/{unit}/document/{document}/maintenance',[InfrastructureMaintenanceController::class, 'storeFromUnitDocument']);
Route::post('unit/{unit}/asset/{asset}/document/{document}/maintenance',[InfrastructureMaintenanceController::class, 'storeFromUnitAssetDocument']);

Route::get('asset/{asset}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'showFromAsset']);
Route::get('document/{document}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'showFromDocument']);
Route::get('unit/{unit}/asset/{asset}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'showFromUnitAsset']);
Route::get('unit/{unit}/document/{document}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'showFromUnitDocument']);
Route::get('unit/{unit}/asset/{asset}/document/{document}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'showFromUnitAssetDocument']);

Route::put('asset/{asset}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'updateFromAsset']);
Route::put('document/{document}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'updateFromDocument']);
Route::put('unit/{unit}/asset/{asset}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'updateFromUnitAsset']);
Route::put('unit/{unit}/document/{document}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'updateFromUnitDocument']);
Route::put('unit/{unit}/asset/{asset}/document/{document}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'updateFromUnitAssetDocument']);

Route::delete('asset/{asset}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'destroyFromAsset']);
Route::delete('document/{document}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'destroyFromDocument']);
Route::delete('unit/{unit}/asset/{asset}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'destroyFromUnitAsset']);
Route::delete('unit/{unit}/document/{document}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'destroyFromUnitDocument']);
Route::delete('unit/{unit}/asset/{asset}/document/{document}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'destroyFromUnitAssetDocument']);

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
Route::get('unit/{unit}/asset/{asset}',[InfrastructureAssetController::class, 'showFromUnit']);
Route::post('unit/{unit}/asset',[InfrastructureAssetController::class, 'storeFromUnit']);
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
Route::get('unit/{unit}/asset/{asset}/document/{document}',[InfrastructureDocumentController::class, 'showFromUnitAsset']);
Route::get('unit/{unit}/asset/{asset}/document',[InfrastructureDocumentController::class, 'indexFromUnitAsset']);

Route::get('asset/{asset}/document/{document}',[InfrastructureDocumentController::class, 'showFromAsset']);
Route::get('asset/{asset}/document',[InfrastructureDocumentController::class, 'indexFromAsset']);

Route::get('unit/{unit}/document/{document}',[InfrastructureDocumentController::class, 'showFromUnit']);
Route::get('unit/{unit}/document',[InfrastructureDocumentController::class, 'indexFromUnit']);

Route::post('asset/{asset}/document',[InfrastructureDocumentController::class, 'storeFromAsset']);
Route::post('unit/{unit}/asset/{asset}/document',[InfrastructureDocumentController::class, 'storeFromUnit']);
Route::post('unit/{unit}/document',[InfrastructureDocumentController::class, 'storeFromUnit']);

Route::put('asset/{asset}/document/{document}',[InfrastructureDocumentController::class, 'updateFromAsset']);
Route::put('unit/{unit}/asset/{asset}/document/{document}',[InfrastructureDocumentController::class, 'updateFromUnit']);