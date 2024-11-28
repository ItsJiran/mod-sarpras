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
// +-- from resource module asset
Route::resource('asset',InfrastructureAssetController::class)->parameters([
    'asset' => 'infrastructureAsset'
]);

Route::put('asset/{asset}/restore',[InfrastructureAssetController::class, 'restore']);
Route::delete('asset/{asset}/force',[InfrastructureAssetController::class, 'forceDelete']);

// +-----------------------------------
// +-- manually from unit/asset
Route::get('ref-asset/{unit}/asset',[InfrastructureAssetController::class, 'refAsset']);
Route::get('ref-asset/{unit}/{asset_type}/asset',[InfrastructureAssetController::class, 'refAssetType']);
Route::get('ref-asset/type',[InfrastructureAssetController::class, 'refType']);

Route::get('unit/{unit}/asset',[InfrastructureAssetController::class, 'indexFromUnit']);
Route::get('unit/{unit}/asset/{asset}',[InfrastructureAssetController::class, 'showFromUnit']);
Route::post('unit/{unit}/asset',[InfrastructureAssetController::class, 'storeFromUnit']);
Route::put('unit/{unit}/asset/{asset}',[InfrastructureAssetController::class, 'updateFromUnit']);
Route::delete('unit/{unit}/asset/{asset}',[InfrastructureAssetController::class, 'destroyFromUnit']);
Route::put('unit/{unit}/asset/{asset}/restore',[InfrastructureAssetController::class, 'restoreFromUnit']);
Route::delete('unit/{unit}/asset/{asset}/force',[InfrastructureAssetController::class, 'forceDeleteFromUnit']);

// +-----------------------------------
// +-- from resource module asset
Route::resource('document',InfrastructureDocumentController::class)->parameters([
    'document' => 'infrastructureDocument'
]);
Route::delete('document/{document}/force',[InfrastructureDocumentController::class, 'forceDelete']);
Route::put('document/{document}/restore',[InfrastructureDocumentController::class, 'restore']);
Route::delete('document/{document}',[InfrastructureDocumentController::class, 'destroy']);

Route::get('ref-document/combos/unit/{unit}',[InfrastructureDocumentController::class,'mapCombosOnlyUnit']);
Route::get('ref-document/combos/unit/{unit}/asset/{asset}',[InfrastructureDocumentController::class,'mapCombosOnlyAsset']);

Route::get('unit/{unit}/asset/{asset}/document/{document}',[InfrastructureDocumentController::class, 'showFromUnitAsset']);
Route::get('unit/{unit}/asset/{asset}/document',[InfrastructureDocumentController::class, 'indexFromUnitAsset']);

Route::get('asset/{asset}/document/{document}',[InfrastructureDocumentController::class, 'showFromAsset']);
Route::get('asset/{asset}/document',[InfrastructureDocumentController::class, 'indexFromAsset']);

Route::get('unit/{unit}/document/{document}',[InfrastructureDocumentController::class, 'showFromUnit']);
Route::get('unit/{unit}/document',[InfrastructureDocumentController::class, 'indexFromUnit']);

Route::post('asset/{asset}/document',[InfrastructureDocumentController::class, 'storeFromAsset']);
Route::post('unit/{unit}/asset/{asset}/document',[InfrastructureDocumentController::class, 'storeFromUnitAsset']);
Route::post('unit/{unit}/document',[InfrastructureDocumentController::class, 'storeFromUnit']);

Route::put('asset/{asset}/document/{document}',[InfrastructureDocumentController::class, 'updateFromAsset']);
Route::put('unit/{unit}/asset/{asset}/document/{document}',[InfrastructureDocumentController::class, 'updateFromUnitAsset']);
Route::put('unit/{unit}/document/{document}',[InfrastructureDocumentController::class, 'updateFromUnit']);

Route::put('asset/{asset}/document/{document}/restore',[InfrastructureDocumentController::class, 'restoreFromAsset']);
Route::put('unit/{unit}/asset/{asset}/document/{document}/restore',[InfrastructureDocumentController::class, 'restoreFromUnitAsset']);
Route::put('unit/{unit}/document/{document}/restore',[InfrastructureDocumentController::class, 'restoreFromUnit']);

Route::delete('asset/{asset}/document/{document}',[InfrastructureDocumentController::class, 'destroyFromAsset']);
Route::delete('unit/{unit}/asset/{asset}/document/{document}',[InfrastructureDocumentController::class, 'destroyFromUnitAsset']);
Route::delete('unit/{unit}/document/{document}',[InfrastructureDocumentController::class, 'destroyFromUnit']);

Route::delete('asset/{asset}/document/{document}/force',[InfrastructureDocumentController::class, 'forceDeleteFromAsset']);
Route::delete('unit/{unit}/asset/{asset}/document/{document}/force',[InfrastructureDocumentController::class, 'forceDeleteFromUnitAsset']);
Route::delete('unit/{unit}/document/{document}/force',[InfrastructureDocumentController::class, 'forceDeleteFromUnit']);

// +-----------------------------------
// +-- from resource module tax
Route::get('ref-image/{path}',[InfrastructureRecordNoteController::class,'getImage'])->where('path', '.*');;

Route::controller(InfrastructureRecordController::class)->group(function () {

    Route::get('deadline', 'indexDeadline');
    Route::get('deadline/{deadline}', 'showDeadline');

    Route::group(['as' => 'maintenance::'], function(){
        Route::get('maintenance','index');
        Route::post('maintenance','store');
        Route::get('maintenance/{record}','show');
        Route::post('maintenance/{record}/update','update');
        Route::delete('maintenance/{record}','destroy');
        Route::put( 'maintenance/{record}/restore', 'restore' );
        Route::delete( 'maintenance/{record}/force', 'forceDelete' );

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
        
        Route::get('asset/{asset}/maintenance/{record}', 'showFromAsset');
        Route::get('asset/{asset}/document/{document}/maintenance/{record}', 'showFromAssetDocument');
        Route::get('document/{document}/maintenance/{record}', 'showFromDocument');
        Route::get('unit/{unit}/asset/{asset}/maintenance/{record}', 'showFromUnitAsset');
        Route::get('unit/{unit}/document/{document}/maintenance/{record}', 'showFromUnitDocument');
        Route::get('unit/{unit}/asset/{asset}/document/{document}/maintenance/{record}', 'showFromUnitAssetDocument');
        
        Route::put('asset/{asset}/maintenance/{record}', 'updateFromAsset');
        Route::put('asset/{asset}/document/{document}/maintenance/{record}', 'updateFromAssetDocument');
        Route::put('document/{document}/maintenance/{record}', 'updateFromDocument');
        Route::put('unit/{unit}/asset/{asset}/maintenance/{record}', 'updateFromUnitAsset');
        Route::put('unit/{unit}/document/{document}/maintenance/{record}', 'updateFromUnitDocument');
        Route::put('unit/{unit}/asset/{asset}/document/{document}/maintenance/{record}', 'updateFromUnitAssetDocument');
        
        Route::delete('asset/{asset}/maintenance/{record}', 'destroyFromAsset');
        Route::delete('asset/{asset}/document/{document}/maintenance/{record}', 'destroyFromAssetDocument');
        Route::delete('document/{document}/maintenance/{record}', 'destroyFromDocument');
        Route::delete('unit/{unit}/asset/{asset}/maintenance/{record}', 'destroyFromUnitAsset');
        Route::delete('unit/{unit}/document/{document}/maintenance/{record}', 'destroyFromUnitDocument');
        Route::delete('unit/{unit}/asset/{asset}/document/{document}/maintenance/{record}', 'destroyFromUnitAssetDocument');
    });

    Route::group(['as' => 'tax::'], function(){
        Route::get('tax','index');
        Route::post('tax','store');
        Route::get('tax/{record}','show');
        Route::post('tax/{record}/update','update');
        Route::delete('tax/{record}','destroy');
        Route::put( 'tax/{record}/restore', 'restore' );
        Route::delete( 'tax/{record}/force', 'forceDelete' );

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
        Route::get('asset/{asset}/document/{document}/tax/{record}','showFromAssetDocument');
        Route::get('document/{document}/tax/{record}','showFromDocument');
        Route::get('unit/{unit}/asset/{asset}/tax/{record}','showFromUnitAsset');
        Route::get('unit/{unit}/document/{document}/tax/{record}','showFromUnitDocument');
        Route::get('unit/{unit}/asset/{asset}/document/{document}/tax/{record}','showFromUnitAssetDocument');
        
        Route::put('asset/{asset}/tax/{record}','updateFromAsset');
        Route::put('asset/{asset}/document/{document}/tax/{record}','updateFromAssetDocument');
        Route::put('document/{document}/tax/{record}','updateFromDocument');
        Route::put('unit/{unit}/asset/{asset}/tax/{record}','updateFromUnitAsset');
        Route::put('unit/{unit}/document/{document}/tax/{record}','updateFromUnitDocument');
        Route::put('unit/{unit}/asset/{asset}/document/{document}/tax/{record}','updateFromUnitAssetDocument');

        Route::put('asset/{asset}/tax/{record}/restore','restoreFromAsset');
        Route::put('asset/{asset}/document/{document}/tax/{record}/restore','restoreFromAssetDocument');
        Route::put('document/{document}/tax/{record}/restore','restoreFromDocument');
        Route::put('unit/{unit}/asset/{asset}/tax/{record}/restore','restoreFromUnitAsset');
        Route::put('unit/{unit}/document/{document}/tax/{record}/restore','restoreFromUnitDocument');
        Route::put('unit/{unit}/asset/{asset}/document/{document}/tax/{record}/restore','restoreFromUnitAssetDocument');
        
        Route::delete('asset/{asset}/tax/{record}','destroyFromAsset');
        Route::delete('asset/{asset}/document/{document}/tax/{record}','destroyFromAssetDocument');
        Route::delete('document/{document}/tax/{record}','destroyFromDocument');
        Route::delete('unit/{unit}/asset/{asset}/tax/{record}','destroyFromUnitAsset');
        Route::delete('unit/{unit}/document/{document}/tax/{record}','destroyFromUnitDocument');
        Route::delete('unit/{unit}/asset/{asset}/document/{document}/tax/{record}','destroyFromUnitAssetDocument');

        Route::delete('asset/{asset}/tax/{record}/force','forceDeleteFromAsset');
        Route::delete('asset/{asset}/document/{document}/tax/{record}/force','forceDeleteFromAssetDocument');
        Route::delete('document/{document}/tax/{record}/force','forceDeleteFromDocument');
        Route::delete('unit/{unit}/asset/{asset}/tax/{record}/force','forceDeleteFromUnitAsset');
        Route::delete('unit/{unit}/document/{document}/tax/{record}/force','forceDeleteFromUnitDocument');
        Route::delete('unit/{unit}/asset/{asset}/document/{document}/tax/{record}/force','forceDeleteFromUnitAssetDocument');
    });
});

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
    Route::post('deadline/{record}/note/{note}/update','update');
    Route::delete('deadline/{record}/note/{note}','destroy');
    Route::put( 'deadline/{record}/note/{note}/restore', 'restore' );
    Route::delete( 'deadline/{record}/note/{note}/force', 'forceDelete' );

    Route::group(['as' => 'tax::'], function(){
        Route::get('tax/{record}/note','index');
        Route::post('tax/{record}/note','store');
        Route::get('tax/{record}/note/{note}','show');
        Route::post('tax/{record}/note/{note}/update','update');
        Route::delete('tax/{record}/note/{note}','destroy');
        Route::put( 'tax/{record}/note/{note}/restore', 'restore' );
        Route::delete( 'tax/{record}/note/{note}/force', 'forceDelete' );

        /// GET INDEX
        Route::get('asset/{asset}/tax/{record}/note','indexFromAsset');
        Route::get('asset/{asset}/document/{document}/tax/{record}/note','indexFromAssetDocument');
        Route::get('document/{document}/tax/{record}/note','indexFromDocument');
        Route::get('unit/{unit}/asset/{asset}/tax/{record}/note','indexFromUnitAsset');
        Route::get('unit/{unit}/document/{document}/tax/{record}/note','indexFromUnitDocument');
        Route::get('unit/{unit}/asset/{asset}/document/{document}/tax/{record}/note','indexFromUnitAssetDocument');

        // POST STORE
        Route::post('asset/{asset}/tax/{record}/note','storeFromAsset');
        Route::post('asset/{asset}/document/{document}/tax/{record}/note','storeFromAssetDocument');
        Route::post('document/{document}/tax/{record}/note','storeFromDocument');
        Route::post('unit/{unit}/asset/{asset}/tax/{record}/note','storeFromUnitAsset');
        Route::post('unit/{unit}/document/{document}/tax/{record}/note','storeFromUnitDocument');
        Route::post('unit/{unit}/asset/{asset}/document/{document}/tax/{record}/note','storeFromUnitAssetDocument');

        // GET SHOW
        Route::get('asset/{asset}/tax/{record}/note/{note}','showFromAsset');
        Route::get('asset/{asset}/document/{document}/tax/{record}/note/{note}','showFromAssetDocument');
        Route::get('document/{document}/tax/{record}/note/{note}','showFromDocument');
        Route::get('unit/{unit}/asset/{asset}/tax/{record}/note/{note}','showFromUnitAsset');
        Route::get('unit/{unit}/document/{document}/tax/{record}/note/{note}','showFromUnitDocument');
        Route::get('unit/{unit}/asset/{asset}/document/{document}/tax/{record}/note/{note}','showFromUnitAssetDocument');

        // POST UPDATE MULTIPLATFORM
        Route::post('asset/{asset}/tax/{record}/note/{note}/update','updateFromAsset');
        Route::post('asset/{asset}/document/{document}/tax/{record}/note/{note}/update','updateFromAssetDocument');
        Route::post('document/{document}/tax/{record}/note/{note}/update','updateFromDocument');
        Route::post('unit/{unit}/asset/{asset}/tax/{record}/note/{note}/update','updateFromUnitAsset');
        Route::post('unit/{unit}/document/{document}/tax/{record}/note/{note}/update','updateFromUnitDocument');
        Route::post('unit/{unit}/asset/{asset}/document/{document}/tax/{record}/note/{note}/update','updateFromUnitAssetDocument');

        // DELETE
        Route::delete('asset/{asset}/tax/{record}/note/{note}','destroyFromAsset');
        Route::delete('asset/{asset}/document/{document}/tax/{record}/note/{note}','destroyFromAssetDocument');
        Route::delete('document/{document}/tax/{record}/note/{note}','destroyFromDocument');
        Route::delete('unit/{unit}/asset/{asset}/tax/{record}/note/{note}','destroyFromUnitAsset');
        Route::delete('unit/{unit}/document/{document}/tax/{record}/note/{note}','destroyFromUnitDocument');
        Route::delete('unit/{unit}/asset/{asset}/document/{document}/tax/{record}/note/{note}','destroyFromUnitAssetDocument');

        // RESTORE
        Route::put('asset/{asset}/tax/{record}/note/{note}/restore','restoreFromAsset');
        Route::put('asset/{asset}/document/{document}/tax/{record}/note/{note}/restore','restoreFromAssetDocument');
        Route::put('document/{document}/tax/{record}/note/{note}/restore','restoreFromDocument');
        Route::put('unit/{unit}/asset/{asset}/tax/{record}/note/{note}/restore','restoreFromUnitAsset');
        Route::put('unit/{unit}/document/{document}/tax/{record}/note/{note}/restore','restoreFromUnitDocument');
        Route::put('unit/{unit}/asset/{asset}/document/{document}/tax/{record}/note/{note}/restore','restoreFromUnitAssetDocument');

        // RESTORE
        Route::delete('asset/{asset}/tax/{record}/note/{note}/force','forceDeleteFromAsset');
        Route::delete('asset/{asset}/document/{document}/tax/{record}/note/{note}/force','forceDeleteFromAssetDocument');
        Route::delete('document/{document}/tax/{record}/note/{note}/force','forceDeleteFromDocument');
        Route::delete('unit/{unit}/asset/{asset}/tax/{record}/note/{note}/force','forceDeleteFromUnitAsset');
        Route::delete('unit/{unit}/document/{document}/tax/{record}/note/{note}/force','forceDeleteFromUnitDocument');
        Route::delete('unit/{unit}/asset/{asset}/document/{document}/tax/{record}/note/{note}/force','forceDeleteFromUnitAssetDocument');
    
    });

    Route::group(['as' => 'maintenance::'], function(){
        Route::get('maintenance/{record}/note','index');
        Route::post('maintenance/{record}/note','store');
        Route::get('maintenance/{record}/note/{note}','show');
        Route::post('maintenance/{record}/note/{note}/update','update');
        Route::delete('maintenance/{record}/note/{note}','destroy');
        Route::put( 'maintenance/{record}/note/{note}/restore', 'restore' );
        Route::delete( 'maintenance/{record}/note/{note}/force', 'forceDelete' );

        /// GET INDEX
        Route::get('asset/{asset}/maintenance/{record}/note','indexFromAsset');
        Route::get('asset/{asset}/document/{document}/maintenance/{record}/note','indexFromAssetDocument');
        Route::get('document/{document}/maintenance/{record}/note','indexFromDocument');
        Route::get('unit/{unit}/asset/{asset}/maintenance/{record}/note','indexFromUnitAsset');
        Route::get('unit/{unit}/document/{document}/maintenance/{record}/note','indexFromUnitDocument');
        Route::get('unit/{unit}/asset/{asset}/document/{document}/maintenance/{record}/note','indexFromUnitAssetDocument');

        // POST STORE
        Route::post('asset/{asset}/maintenance/{record}/note','storeFromAsset');
        Route::post('asset/{asset}/document/{document}/maintenance/{record}/note','storeFromAssetDocument');
        Route::post('document/{document}/maintenance/{record}/note','storeFromDocument');
        Route::post('unit/{unit}/asset/{asset}/maintenance/{record}/note','storeFromUnitAsset');
        Route::post('unit/{unit}/document/{document}/maintenance/{record}/note','storeFromUnitDocument');
        Route::post('unit/{unit}/asset/{asset}/document/{document}/maintenance/{record}/note','storeFromUnitAssetDocument');

        // GET SHOW
        Route::get('asset/{asset}/maintenance/{record}/note/{note}','showFromAsset');
        Route::get('asset/{asset}/document/{document}/maintenance/{record}/note/{note}','showFromAssetDocument');
        Route::get('document/{document}/maintenance/{record}/note/{note}','showFromDocument');
        Route::get('unit/{unit}/asset/{asset}/maintenance/{record}/note/{note}','showFromUnitAsset');
        Route::get('unit/{unit}/document/{document}/maintenance/{record}/note/{note}','showFromUnitDocument');
        Route::get('unit/{unit}/asset/{asset}/document/{document}/maintenance/{record}/note/{note}','showFromUnitAssetDocument');

        // POST UPDATE MULTIPLATFORM
        Route::post('asset/{asset}/maintenance/{record}/note/{note}/update','updateFromAsset');
        Route::post('asset/{asset}/document/{document}/maintenance/{record}/note/{note}/update','updateFromAssetDocument');
        Route::post('document/{document}/maintenance/{record}/note/{note}/update','updateFromDocument');
        Route::post('unit/{unit}/asset/{asset}/maintenance/{record}/note/{note}/update','updateFromUnitAsset');
        Route::post('unit/{unit}/document/{document}/maintenance/{record}/note/{note}/update','updateFromUnitDocument');
        Route::post('unit/{unit}/asset/{asset}/document/{document}/maintenance/{record}/note/{note}/update','updateFromUnitAssetDocument');

        // DELETE
        Route::delete('asset/{asset}/maintenance/{record}/note/{note}','destroyFromAsset');
        Route::delete('asset/{asset}/document/{document}/maintenance/{record}/note/{note}','destroyFromAssetDocument');
        Route::delete('document/{document}/maintenance/{record}/note/{note}','destroyFromDocument');
        Route::delete('unit/{unit}/asset/{asset}/maintenance/{record}/note/{note}','destroyFromUnitAsset');
        Route::delete('unit/{unit}/document/{document}/maintenance/{record}/note/{note}','destroyFromUnitDocument');
        Route::delete('unit/{unit}/asset/{asset}/document/{document}/maintenance/{record}/note/{note}','destroyFromUnitAssetDocument');

        // RESTORE
        Route::put('asset/{asset}/maintenance/{record}/note/{note}/restore','restoreFromAsset');
        Route::put('asset/{asset}/document/{document}/maintenance/{record}/note/{note}/restore','restoreFromAssetDocument');
        Route::put('document/{document}/maintenance/{record}/note/{note}/restore','restoreFromDocument');
        Route::put('unit/{unit}/asset/{asset}/maintenance/{record}/note/{note}/restore','restoreFromUnitAsset');
        Route::put('unit/{unit}/document/{document}/maintenance/{record}/note/{note}/restore','restoreFromUnitDocument');
        Route::put('unit/{unit}/asset/{asset}/document/{document}/maintenance/{record}/note/{note}/restore','restoreFromUnitAssetDocument');

        // RESTORE
        Route::delete('asset/{asset}/maintenance/{record}/note/{note}/force','forceDeleteFromAsset');
        Route::delete('asset/{asset}/document/{document}/maintenance/{record}/note/{note}/force','forceDeleteFromAssetDocument');
        Route::delete('document/{document}/maintenance/{record}/note/{note}/force','forceDeleteFromDocument');
        Route::delete('unit/{unit}/asset/{asset}/maintenance/{record}/note/{note}/force','forceDeleteFromUnitAsset');
        Route::delete('unit/{unit}/document/{document}/maintenance/{record}/note/{note}/force','forceDeleteFromUnitDocument');
        Route::delete('unit/{unit}/asset/{asset}/document/{document}/maintenance/{record}/note/{note}/force','forceDeleteFromUnitAssetDocument');
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
    Route::put( 'deadline/{record}/note/{note}/used/{used}/restore', 'restore' );
    Route::delete( 'deadline/{record}/note/{note}/used/{used}/force', 'forceDelete' );

    Route::group(['as' => 'tax::'], function(){
        Route::get( 'tax/{record}/note/{note}/used', 'index' );
        Route::post( 'tax/{record}/note/{note}/used', 'store' );
        Route::get( 'tax/{record}/note/{note}/used/{used}', 'show' );
        Route::put( 'tax/{record}/note/{note}/used/{used}', 'update' );
        Route::delete( 'tax/{record}/note/{note}/used/{used}', 'destroy' );
        Route::put( 'tax/{record}/note/{note}/used/{used}/restore', 'restore' );
        Route::delete( 'tax/{record}/note/{note}/used/{used}/force', 'forceDelete' );

        // GET INDEX
        Route::get('asset/{asset}/tax/{record}/note/{note}/used','indexFromAsset');
        Route::get('asset/{asset}/document/{document}/tax/{record}/note/{note}/used','indexFromAssetDocument');
        Route::get('document/{document}/tax/{record}/note/{note}/used','indexFromDocument');
        Route::get('unit/{unit}/asset/{asset}/tax/{record}/note/{note}/used','indexFromUnitAsset');
        Route::get('unit/{unit}/document/{document}/tax/{record}/note/{note}/used','indexFromUnitDocument');
        Route::get('unit/{unit}/asset/{asset}/document/{document}/tax/{record}/note/{note}/used','indexFromUnitAssetDocument');

        // POST STORE
        Route::post('asset/{asset}/tax/{record}/note/{note}/used','storeFromAsset');
        Route::post('asset/{asset}/document/{document}/tax/{record}/note/{note}/used','storeFromAssetDocument');
        Route::post('document/{document}/tax/{record}/note/{note}/used','storeFromDocument');
        Route::post('unit/{unit}/asset/{asset}/tax/{record}/note/{note}/used','storeFromUnitAsset');
        Route::post('unit/{unit}/document/{document}/tax/{record}/note/{note}/used','storeFromUnitDocument');
        Route::post('unit/{unit}/asset/{asset}/document/{document}/tax/{record}/note/{note}/used','storeFromUnitAssetDocument');

        // GET SHOW
        Route::get('asset/{asset}/tax/{record}/note/{note}/used/{used}','showFromAsset');
        Route::get('asset/{asset}/document/{document}/tax/{record}/note/{note}/used/{used}','showFromAssetDocument');
        Route::get('document/{document}/tax/{record}/note/{note}/used/{used}','showFromDocument');
        Route::get('unit/{unit}/asset/{asset}/tax/{record}/note/{note}/used/{used}','showFromUnitAsset');
        Route::get('unit/{unit}/document/{document}/tax/{record}/note/{note}/used/{used}','showFromUnitDocument');
        Route::get('unit/{unit}/asset/{asset}/document/{document}/tax/{record}/note/{note}/used/{used}','showFromUnitAssetDocument');

        // DELETE UPDATE
        Route::delete('asset/{asset}/tax/{record}/note/{note}/used/{used}','destroyFromAsset');
        Route::delete('asset/{asset}/document/{document}/tax/{record}/note/{note}/used/{used}','destroyFromAssetDocument');
        Route::delete('document/{document}/tax/{record}/note/{note}/used/{used}','destroyFromDocument');
        Route::delete('unit/{unit}/asset/{asset}/tax/{record}/note/{note}/used/{used}','destroyFromUnitAsset');
        Route::delete('unit/{unit}/document/{document}/tax/{record}/note/{note}/used/{used}','destroyFromUnitDocument');
        Route::delete('unit/{unit}/asset/{asset}/document/{document}/tax/{record}/note/{note}/used/{used}','destroyFromUnitAssetDocument');

        // PUT RESTORE
        Route::put('asset/{asset}/tax/{record}/note/{note}/used/{used}/restore','restoreFromAsset');
        Route::put('asset/{asset}/document/{document}/tax/{record}/note/{note}/used/{used}/restore','restoreFromAssetDocument');
        Route::put('document/{document}/tax/{record}/note/{note}/used/{used}/restore','restoreFromDocument');
        Route::put('unit/{unit}/asset/{asset}/tax/{record}/note/{note}/used/{used}/restore','restoreFromUnitAsset');
        Route::put('unit/{unit}/document/{document}/tax/{record}/note/{note}/used/{used}/restore','restoreFromUnitDocument');
        Route::put('unit/{unit}/asset/{asset}/document/{document}/tax/{record}/note/{note}/used/{used}/restore','restoreFromUnitAssetDocument');

        // FORCE DELETE
        Route::delete('asset/{asset}/tax/{record}/note/{note}/used/{used}/force','forceDeleteFromAsset');
        Route::delete('asset/{asset}/document/{document}/tax/{record}/note/{note}/used/{used}/force','forceDeleteFromAssetDocument');
        Route::delete('document/{document}/tax/{record}/note/{note}/used/{used}/force','forceDeleteFromDocument');
        Route::delete('unit/{unit}/asset/{asset}/tax/{record}/note/{note}/used/{used}/force','forceDeleteFromUnitAsset');
        Route::delete('unit/{unit}/document/{document}/tax/{record}/note/{note}/used/{used}/force','forceDeleteFromUnitDocument');
        Route::delete('unit/{unit}/asset/{asset}/document/{document}/tax/{record}/note/{note}/used/{used}/force','forceDeleteFromUnitAssetDocument');

    });
    
    Route::group(['as' => 'maintenance::'], function(){
        Route::get( 'maintenance/{record}/note/{note}/used', 'index' );
        Route::post( 'maintenance/{record}/note/{note}/used', 'store' );
        Route::get( 'maintenance/{record}/note/{note}/used/{used}', 'show' );
        Route::put( 'maintenance/{record}/note/{note}/used/{used}', 'update' );
        Route::delete( 'maintenance/{record}/note/{note}/used/{used}', 'destroy' );
        Route::put( 'maintenance/{record}/note/{note}/used/{used}/restore', 'restore' );
        Route::delete( 'maintenance/{record}/note/{note}/used/{used}/force', 'forceDelete' );

        // GET INDEX
        Route::get('asset/{asset}/maintenance/{record}/note/{note}/used','indexFromAsset');
        Route::get('asset/{asset}/document/{document}/maintenance/{record}/note/{note}/used','indexFromAssetDocument');
        Route::get('document/{document}/maintenance/{record}/note/{note}/used','indexFromDocument');
        Route::get('unit/{unit}/asset/{asset}/maintenance/{record}/note/{note}/used','indexFromUnitAsset');
        Route::get('unit/{unit}/document/{document}/maintenance/{record}/note/{note}/used','indexFromUnitDocument');
        Route::get('unit/{unit}/asset/{asset}/document/{document}/maintenance/{record}/note/{note}/used','indexFromUnitAssetDocument');

        // POST STORE
        Route::post('asset/{asset}/maintenance/{record}/note/{note}/used','storeFromAsset');
        Route::post('asset/{asset}/document/{document}/maintenance/{record}/note/{note}/used','storeFromAssetDocument');
        Route::post('document/{document}/maintenance/{record}/note/{note}/used','storeFromDocument');
        Route::post('unit/{unit}/asset/{asset}/maintenance/{record}/note/{note}/used','storeFromUnitAsset');
        Route::post('unit/{unit}/document/{document}/maintenance/{record}/note/{note}/used','storeFromUnitDocument');
        Route::post('unit/{unit}/asset/{asset}/document/{document}/maintenance/{record}/note/{note}/used','storeFromUnitAssetDocument');

        // GET SHOW
        Route::get('asset/{asset}/maintenance/{record}/note/{note}/used/{used}','showFromAsset');
        Route::get('asset/{asset}/document/{document}/maintenance/{record}/note/{note}/used/{used}','showFromAssetDocument');
        Route::get('document/{document}/maintenance/{record}/note/{note}/used/{used}','showFromDocument');
        Route::get('unit/{unit}/asset/{asset}/maintenance/{record}/note/{note}/used/{used}','showFromUnitAsset');
        Route::get('unit/{unit}/document/{document}/maintenance/{record}/note/{note}/used/{used}','showFromUnitDocument');
        Route::get('unit/{unit}/asset/{asset}/document/{document}/maintenance/{record}/note/{note}/used/{used}','showFromUnitAssetDocument');

        // DELETE UPDATE
        Route::delete('asset/{asset}/maintenance/{record}/note/{note}/used/{used}','destroyFromAsset');
        Route::delete('asset/{asset}/document/{document}/maintenance/{record}/note/{note}/used/{used}','destroyFromAssetDocument');
        Route::delete('document/{document}/maintenance/{record}/note/{note}/used/{used}','destroyFromDocument');
        Route::delete('unit/{unit}/asset/{asset}/maintenance/{record}/note/{note}/used/{used}','destroyFromUnitAsset');
        Route::delete('unit/{unit}/document/{document}/maintenance/{record}/note/{note}/used/{used}','destroyFromUnitDocument');
        Route::delete('unit/{unit}/asset/{asset}/document/{document}/maintenance/{record}/note/{note}/used/{used}','destroyFromUnitAssetDocument');

        // PUT RESTORE
        Route::put('asset/{asset}/maintenance/{record}/note/{note}/used/{used}/restore','restoreFromAsset');
        Route::put('asset/{asset}/document/{document}/maintenance/{record}/note/{note}/used/{used}/restore','restoreFromAssetDocument');
        Route::put('document/{document}/maintenance/{record}/note/{note}/used/{used}/restore','restoreFromDocument');
        Route::put('unit/{unit}/asset/{asset}/maintenance/{record}/note/{note}/used/{used}/restore','restoreFromUnitAsset');
        Route::put('unit/{unit}/document/{document}/maintenance/{record}/note/{note}/used/{used}/restore','restoreFromUnitDocument');
        Route::put('unit/{unit}/asset/{asset}/document/{document}/maintenance/{record}/note/{note}/used/{used}/restore','restoreFromUnitAssetDocument');

        // FORCE DELETE
        Route::delete('asset/{asset}/maintenance/{record}/note/{note}/used/{used}/force','forceDeleteFromAsset');
        Route::delete('asset/{asset}/document/{document}/maintenance/{record}/note/{note}/used/{used}/force','forceDeleteFromAssetDocument');
        Route::delete('document/{document}/maintenance/{record}/note/{note}/used/{used}/force','forceDeleteFromDocument');
        Route::delete('unit/{unit}/asset/{asset}/maintenance/{record}/note/{note}/used/{used}/force','forceDeleteFromUnitAsset');
        Route::delete('unit/{unit}/document/{document}/maintenance/{record}/note/{note}/used/{used}/force','forceDeleteFromUnitDocument');
        Route::delete('unit/{unit}/asset/{asset}/document/{document}/maintenance/{record}/note/{note}/used/{used}/force','forceDeleteFromUnitAssetDocument');
    });
});
