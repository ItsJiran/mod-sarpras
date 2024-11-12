<?php

use Illuminate\Support\Facades\Route;
use Module\Infrastructure\Http\Controllers\DashboardController;
use Module\Infrastructure\Http\Controllers\InfrastructureAssetController;
use Module\Infrastructure\Http\Controllers\InfrastructureRecordController;
use Module\Infrastructure\Http\Controllers\InfrastructureRecordNoteController;
use Module\Infrastructure\Http\Controllers\InfrastructureRecordNoteUsedController;


use Module\Infrastructure\Http\Controllers\InfrastructureTaxController;
use Module\Infrastructure\Http\Controllers\InfrastructureTaxRecordController;
use Module\Infrastructure\Http\Controllers\InfrastructureTaxRecordUsedController;
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

Route::controller(InfrastructureRecordController::class)->group(function () {

    Route::get('deadline','indexDeadline');

    Route::group(['as' => 'maintenance::'], function(){

        Route::resource('maintenance',InfrastructureRecordController::class)->parameters([
            'maintenance' => 'infrastructureRecord'
        ]);

        Route::get('asset/{asset}/maintenance','indexFromAsset');
        Route::get('asset/{asset}/document/{document}/maintenance','indexFromAssetDocument');
        Route::get('document/{document}/maintenance','indexFromDocument');
        Route::get('unit/{unit}/asset/{asset}/maintenance', 'indexFromUnitAsset');
        Route::get('unit/{unit}/document/{document}/maintenance', 'indexFromUnitDocument');
        Route::get('unit/{unit}/asset/{asset}/document/{document}/maintenance', 'indexFromUnitAssetDocument');
        
        Route::post('asset/{asset}/maintenance', 'storeFromAsset');
        Route::post('asset/{asset}/document/{document}/maintenance', 'storeFromAssetDocument');
        Route::post('document/{document}/maintenance', 'storeFromDocument');
        Route::post('unit/{unit}/asset/{asset}/maintenance', 'storeFromUnitAsset');
        Route::post('unit/{unit}/document/{document}/maintenance', 'storeFromUnitDocument');
        Route::post('unit/{unit}/asset/{asset}/document/{document}/maintenance', 'storeFromUnitAssetDocument');
        
        Route::get('asset/{asset}/maintenance/{maintenance}', 'showFromAsset');
        Route::get('asset/{asset}/document/{document}/maintenance/{maintenance}', 'showFromAssetDocument');
        Route::get('document/{document}/maintenance/{maintenance}', 'showFromDocument');
        Route::get('unit/{unit}/asset/{asset}/maintenance/{maintenance}', 'showFromUnitAsset');
        Route::get('unit/{unit}/document/{document}/maintenance/{maintenance}', 'showFromUnitDocument');
        Route::get('unit/{unit}/asset/{asset}/document/{document}/maintenance/{maintenance}', 'showFromUnitAssetDocument');
        
        Route::put('asset/{asset}/maintenance/{maintenance}', 'updateFromAsset');
        Route::put('asset/{asset}/document/{document}/maintenance/{maintenance}', 'updateFromAssetDocument');
        Route::put('document/{document}/maintenance/{maintenance}', 'updateFromDocument');
        Route::put('unit/{unit}/asset/{asset}/maintenance/{maintenance}', 'updateFromUnitAsset');
        Route::put('unit/{unit}/document/{document}/maintenance/{maintenance}', 'updateFromUnitDocument');
        Route::put('unit/{unit}/asset/{asset}/document/{document}/maintenance/{maintenance}', 'updateFromUnitAssetDocument');
        
        Route::delete('asset/{asset}/maintenance/{maintenance}', 'destroyFromAsset');
        Route::delete('asset/{asset}/document/{document}/maintenance/{maintenance}', 'destroyFromAssetDocument');
        Route::delete('document/{document}/maintenance/{maintenance}', 'destroyFromDocument');
        Route::delete('unit/{unit}/asset/{asset}/maintenance/{maintenance}', 'destroyFromUnitAsset');
        Route::delete('unit/{unit}/document/{document}/maintenance/{maintenance}', 'destroyFromUnitDocument');
        Route::delete('unit/{unit}/asset/{asset}/document/{document}/maintenance/{maintenance}', 'destroyFromUnitAssetDocument');
    });

    Route::group(['as' => 'tax::'], function(){
        Route::resource('tax',InfrastructureRecordController::class)->parameters([
            'tax' => 'infrastructureRecord'
        ]);

        Route::get('asset/{asset}/tax','indexFromAsset');
        Route::get('asset/{asset}/document/{document}/tax','indexFromAssetDocument');
        Route::get('document/{document}/tax','indexFromDocument');
        Route::get('unit/{unit}/asset/{asset}/tax','indexFromUnitAsset');
        Route::get('unit/{unit}/document/{document}/tax','indexFromUnitDocument');
        Route::get('unit/{unit}/asset/{asset}/document/{document}/tax','indexFromUnitAssetDocument');
    
        Route::post('asset/{asset}/tax','storeFromAsset');
        Route::post('asset/{asset}/document/{document}/tax','storeFromAssetDocument');
        Route::post('document/{document}/tax','storeFromDocument');
        Route::post('unit/{unit}/asset/{asset}/tax','storeFromUnitAsset');
        Route::post('unit/{unit}/document/{document}/tax','storeFromUnitDocument');
        Route::post('unit/{unit}/asset/{asset}/document/{document}/tax','storeFromUnitAssetDocument');
        
        Route::get('asset/{asset}/tax/{record}','showFromAsset');
        Route::get('asset/{asset}/document/{document}/tax/{tax}','showFromAssetDocument');
        Route::get('document/{document}/tax/{tax}','showFromDocument');
        Route::get('unit/{unit}/asset/{asset}/tax/{record}','showFromUnitAsset');
        Route::get('unit/{unit}/document/{document}/tax/{record}','showFromUnitDocument');
        Route::get('unit/{unit}/asset/{asset}/document/{document}/tax/{record}','showFromUnitAssetDocument');
        
        Route::put('asset/{asset}/tax/{record}','updateFromAsset');
        Route::put('asset/{asset}/document/{document}/tax/{record}','updateFromAssetDocument');
        Route::put('document/{document}/tax/{record}','updateFromDocument');
        Route::put('unit/{unit}/asset/{asset}/tax/{record}','updateFromUnitAsset');
        Route::put('unit/{unit}/document/{document}/tax/{record}','updateFromUnitDocument');
        Route::put('unit/{unit}/asset/{asset}/document/{document}/tax/{record}','updateFromUnitAssetDocument');
        
        Route::delete('asset/{asset}/tax/{record}','destroyFromAsset');
        Route::delete('asset/{asset}/document/{document}/tax/{record}','destroyFromAssetDocument');
        Route::delete('document/{document}/tax/{record}','destroyFromDocument');
        Route::delete('unit/{unit}/asset/{asset}/tax/{record}','destroyFromUnitAsset');
        Route::delete('unit/{unit}/document/{document}/tax/{record}','destroyFromUnitDocument');
        Route::delete('unit/{unit}/asset/{asset}/document/{document}/tax/{record}','destroyFromUnitAssetDocument');

    });
});

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

// tax - record
Route::controller(InfrastructureRecordNoteController::class)->group(function () {
    // change statuses 
    Route::post('record/{record}/note/{note}/draft','changeToDraft');
    Route::post('record/{record}/note/{note}/pending','changeToPending');
    Route::post('record/{record}/note/{note}/verified','changeToVerified');
    Route::post('record/{record}/note/{note}/unverified','changeToUnverified');
    Route::post('record/{record}/note/{note}/cancelled','changeToCancelled');

    Route::get('deadline/{record}/note','index');
    Route::post('deadline/{record}/note','store');
    Route::get('deadline/{record}/note/{note}','show');
    Route::put('deadline/{record}/note/{note}','update');
    Route::delete('deadline/{record}/note/{note}','destroy');

    Route::group(['as' => 'tax::'], function(){
        Route::get('tax/{record}/note','index');
        Route::post('tax/{record}/note','store');
        Route::get('tax/{record}/note/{note}','show');
        Route::put('tax/{record}/note/{note}','update');
        Route::delete('tax/{record}/note/{note}','destroy');
    });

    Route::group(['as' => 'maintenance::'], function(){
        Route::get('maintenance/{record}/note','index');
        Route::post('maintenance/{record}/note','store');
        Route::get('maintenance/{record}/note/{note}','show');
        Route::put('maintenance/{record}/note/{note}','update');
        Route::delete('maintenance/{record}/note/{note}','destroy');
    });
});

// +-----------------------------------------------
// +-- from resource module tax record used

// tax - record - used - asset
Route::controller(InfrastructureRecordNoteUsedController::class)->group(function () {
    Route::get( 'deadline/{record}/note/{note}/used', 'index' );
    Route::post( 'deadline/{record}/note/{note}/used', 'store' );
    Route::get( 'deadline/{record}/note/{note}/used/{used}', 'show' );
    Route::put( 'deadline/{record}/note/{note}/used/{used}', 'update' );
    Route::delete( 'deadline/{record}/note/{note}/used/{used}', 'destroy' );

    Route::group(['as' => 'tax::'], function(){
        Route::get( 'tax/{record}/note/{note}/used', 'index' );
        Route::post( 'tax/{record}/note/{note}/used', 'store' );
        Route::get( 'tax/{record}/note/{note}/used/{used}', 'show' );
        Route::put( 'tax/{record}/note/{note}/used/{used}', 'update' );
        Route::delete( 'tax/{record}/note/{note}/used/{used}', 'destroy' );
    });
    
    Route::group(['as' => 'maintenance::'], function(){
        Route::get( 'maintenance/{record}/note/{note}/used', 'index' );
        Route::post( 'maintenance/{record}/note/{note}/used', 'store' );
        Route::get( 'maintenance/{record}/note/{note}/used/{used}', 'show' );
        Route::put( 'maintenance/{record}/note/{note}/used/{used}', 'update' );
        Route::delete( 'maintenance/{record}/note/{note}/used/{used}', 'destroy' );
    });
});
