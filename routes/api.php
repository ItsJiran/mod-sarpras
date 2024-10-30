<?php

use Illuminate\Support\Facades\Route;
use Module\Infrastructure\Http\Controllers\DashboardController;
use Module\Infrastructure\Http\Controllers\InfrastructureAssetController;
use Module\Infrastructure\Http\Controllers\InfrastructureTaxController;
use Module\Infrastructure\Http\Controllers\InfrastructureTaxRecordController;
use Module\Infrastructure\Http\Controllers\InfrastructureMaintenanceController;
use Module\Infrastructure\Http\Controllers\InfrastructureMaintenanceRecordController;
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
Route::get('asset/{asset}/document/{document}/maintenance',[InfrastructureMaintenanceController::class,'indexFromAssetDocument']);
Route::get('document/{document}/maintenance',[InfrastructureMaintenanceController::class,'indexFromDocument']);
Route::get('unit/{unit}/asset/{asset}/maintenance',[InfrastructureMaintenanceController::class, 'indexFromUnitAsset']);
Route::get('unit/{unit}/document/{document}/maintenance',[InfrastructureMaintenanceController::class, 'indexFromUnitDocument']);
Route::get('unit/{unit}/asset/{asset}/document/{document}/maintenance',[InfrastructureMaintenanceController::class, 'indexFromUnitAssetDocument']);

Route::post('asset/{asset}/maintenance',[InfrastructureMaintenanceController::class, 'storeFromAsset']);
Route::post('asset/{asset}/document/{document}/maintenance',[InfrastructureMaintenanceController::class, 'storeFromAssetDocument']);
Route::post('document/{document}/maintenance',[InfrastructureMaintenanceController::class, 'storeFromDocument']);
Route::post('unit/{unit}/asset/{asset}/maintenance',[InfrastructureMaintenanceController::class, 'storeFromUnitAsset']);
Route::post('unit/{unit}/document/{document}/maintenance',[InfrastructureMaintenanceController::class, 'storeFromUnitDocument']);
Route::post('unit/{unit}/asset/{asset}/document/{document}/maintenance',[InfrastructureMaintenanceController::class, 'storeFromUnitAssetDocument']);

Route::get('asset/{asset}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'showFromAsset']);
Route::get('asset/{asset}/document/{document}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'showFromAssetDocument']);
Route::get('document/{document}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'showFromDocument']);
Route::get('unit/{unit}/asset/{asset}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'showFromUnitAsset']);
Route::get('unit/{unit}/document/{document}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'showFromUnitDocument']);
Route::get('unit/{unit}/asset/{asset}/document/{document}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'showFromUnitAssetDocument']);

Route::put('asset/{asset}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'updateFromAsset']);
Route::put('asset/{asset}/document/{document}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'updateFromAssetDocument']);
Route::put('document/{document}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'updateFromDocument']);
Route::put('unit/{unit}/asset/{asset}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'updateFromUnitAsset']);
Route::put('unit/{unit}/document/{document}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'updateFromUnitDocument']);
Route::put('unit/{unit}/asset/{asset}/document/{document}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'updateFromUnitAssetDocument']);

Route::delete('asset/{asset}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'destroyFromAsset']);
Route::delete('asset/{asset}/document/{document}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'destroyFromAssetDocument']);
Route::delete('document/{document}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'destroyFromDocument']);
Route::delete('unit/{unit}/asset/{asset}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'destroyFromUnitAsset']);
Route::delete('unit/{unit}/document/{document}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'destroyFromUnitDocument']);
Route::delete('unit/{unit}/asset/{asset}/document/{document}/maintenance/{maintenance}',[InfrastructureMaintenanceController::class, 'destroyFromUnitAssetDocument']);

// +-----------------------------------
// +-- from resource module maintenance
Route::resource('tax',InfrastructureTaxController::class)->parameters([
    'tax' => 'infrastructureTax'
]);

Route::get('asset/{asset}/tax',[InfrastructureTaxController::class,'indexFromAsset']);
Route::get('asset/{asset}/document/{document}/tax',[InfrastructureTaxController::class,'indexFromAssetDocument']);
Route::get('document/{document}/tax',[InfrastructureTaxController::class,'indexFromDocument']);
Route::get('unit/{unit}/asset/{asset}/tax',[InfrastructureTaxController::class, 'indexFromUnitAsset']);
Route::get('unit/{unit}/document/{document}/tax',[InfrastructureTaxController::class, 'indexFromUnitDocument']);
Route::get('unit/{unit}/asset/{asset}/document/{document}/tax',[InfrastructureTaxController::class, 'indexFromUnitAssetDocument']);

Route::post('asset/{asset}/tax',[InfrastructureTaxController::class, 'storeFromAsset']);
Route::post('asset/{asset}/document/{document}/tax',[InfrastructureTaxController::class, 'storeFromAssetDocument']);
Route::post('document/{document}/tax',[InfrastructureTaxController::class, 'storeFromDocument']);
Route::post('unit/{unit}/asset/{asset}/tax',[InfrastructureTaxController::class, 'storeFromUnitAsset']);
Route::post('unit/{unit}/document/{document}/tax',[InfrastructureTaxController::class, 'storeFromUnitDocument']);
Route::post('unit/{unit}/asset/{asset}/document/{document}/tax',[InfrastructureTaxController::class, 'storeFromUnitAssetDocument']);

Route::get('asset/{asset}/tax/{tax}',[InfrastructureTaxController::class, 'showFromAsset']);
Route::get('asset/{asset}/document/{document}/tax/{tax}',[InfrastructureTaxController::class, 'showFromAssetDocument']);
Route::get('document/{document}/tax/{tax}',[InfrastructureTaxController::class, 'showFromDocument']);
Route::get('unit/{unit}/asset/{asset}/tax/{tax}',[InfrastructureTaxController::class, 'showFromUnitAsset']);
Route::get('unit/{unit}/document/{document}/tax/{tax}',[InfrastructureTaxController::class, 'showFromUnitDocument']);
Route::get('unit/{unit}/asset/{asset}/document/{document}/tax/{tax}',[InfrastructureTaxController::class, 'showFromUnitAssetDocument']);

Route::put('asset/{asset}/tax/{tax}',[InfrastructureTaxController::class, 'updateFromAsset']);
Route::put('asset/{asset}/document/{document}/tax/{tax}',[InfrastructureTaxController::class, 'updateFromAssetDocument']);
Route::put('document/{document}/tax/{tax}',[InfrastructureTaxController::class, 'updateFromDocument']);
Route::put('unit/{unit}/asset/{asset}/tax/{tax}',[InfrastructureTaxController::class, 'updateFromUnitAsset']);
Route::put('unit/{unit}/document/{document}/tax/{tax}',[InfrastructureTaxController::class, 'updateFromUnitDocument']);
Route::put('unit/{unit}/asset/{asset}/document/{document}/tax/{tax}',[InfrastructureTaxController::class, 'updateFromUnitAssetDocument']);

Route::delete('asset/{asset}/tax/{tax}',[InfrastructureTaxController::class, 'destroyFromAsset']);
Route::delete('asset/{asset}/document/{document}/tax/{tax}',[InfrastructureTaxController::class, 'destroyFromAssetDocument']);
Route::delete('document/{document}/tax/{tax}',[InfrastructureTaxController::class, 'destroyFromDocument']);
Route::delete('unit/{unit}/asset/{asset}/tax/{tax}',[InfrastructureTaxController::class, 'destroyFromUnitAsset']);
Route::delete('unit/{unit}/document/{document}/tax/{tax}',[InfrastructureTaxController::class, 'destroyFromUnitDocument']);
Route::delete('unit/{unit}/asset/{asset}/document/{document}/tax/{tax}',[InfrastructureTaxController::class, 'destroyFromUnitAssetDocument']);


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

// +-----------------------------------------------
// +-- from resource module maintenance record

Route::get('tax/{tax}/record',[InfrastructureTaxRecordController::class, 'index']);
Route::get('tax/{tax}/record/{record}',[InfrastructureTaxRecordController::class, 'show']);
Route::post('tax/{tax}/record',[InfrastructureTaxRecordController::class, 'store']);
Route::put('tax/{tax}/record/{record}',[InfrastructureTaxRecordController::class, 'update']);
Route::delete('tax/{tax}/record/{record}',[InfrastructureTaxRecordController::class, 'destroy']);

// +-----------------------------------------------
// +-- from resource module tax record
Route::resource('maintenance/{maintenance}/record',InfrastructureMaintenanceRecordController::class)->parameters([
    'maintenance' => 'infrastructureMaintenance',
    'record' => 'infrastructureMaintenanceRecord',
]);
