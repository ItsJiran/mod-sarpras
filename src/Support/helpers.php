<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Module\Infrastructure\Models\InfrastructureDocument;
use Module\Infrastructure\Models\InfrastructureAsset;
use Module\Infrastructure\Models\InfrastructureUnit;
use Module\Infrastructure\Models\InfrastructureRecord;
use Module\Infrastructure\Models\InfrastructureRecordNote;
use Module\Infrastructure\Models\InfrastructureRecordNoteUsed;

if (!function_exists('ensureRequests')) {
    function ensureRequests(Array $list_array) : JsonResponse | null
    {
        foreach ($list_array as $key => $value) {
            if( !is_null($value) ) return $value;
        }

        return null;
    }
}

if (!function_exists('ensureRequestRelationValid')) {
    function ensureRequestRelationValid(Request $request, Array $list_class) : JsonResponse | null 
    {

        // ASSET ENSURE
        if ( is_null( $list_class['asset'] )  ) {

        }

    }
}

if (!function_exists('ensureRequestModelStatusDraft')) {
    function ensureRequestModelStatusDraft(Request $request, $model = null) : JsonResponse | null 
    {
        $isUserAdmin = $request->user()->hasLicenseAs('infrastructure-administrator');
        $isUserSuperAdmin = $request->user()->hasLicenseAs('infrastructure-superadmin');

        if ( $model->status != 'draft' && !$isUserAdmin && !$isUserSuperAdmin ) {
            return response()->json([
                'success' => false,
                'message' => 'Model tidak sedang dalam draft mode!'
            ], 500);
        }

        return null;
    }
}

if (!function_exists('ensureRequestModelStatusPending')) {
    function ensureRequestModelStatusPending(Request $request, $model = null) : JsonResponse | null 
    {
        $isUserAdmin = $request->user()->hasLicenseAs('infrastructure-administrator');
        $isUserSuperAdmin = $request->user()->hasLicenseAs('infrastructure-superadmin');

        if ( $model->status != 'pending' && !$isUserAdmin && !$isUserSuperAdmin ) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak berwenang!'
            ], 500);
        }

        return null;
    }
}

if (!function_exists('ensureRequestUserOperator')) {
    function ensureRequestUserOperator(Request $request) : JsonResponse | null
    {
        // apabila user bukan admin dan note status sudah bukan draft maka jangan tambah
        $isUserAdmin = $request->user()->hasLicenseAs('infrastructure-administrator');
        $isUserSuperAdmin = $request->user()->hasLicenseAs('infrastructure-superadmin');
        $isUserOperator = $request->user()->hasLicenseAs('infrastructure-operator');

        // kalau user bukan operator
        if (!$isUserOperator && !$isUserAdmin && !$isUserSuperAdmin) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa mengubah karena anda bukan operator.'
            ], 500);
        }

        return null;
    }
}

if (!function_exists('ensureRequestUserOwnerModel')) {
    function ensureRequestUserOwnerModel(Request $request, $model) : JsonResponse | null
    {
        // apabila user bukan admin dan note status sudah bukan draft maka jangan tambah
        $isUserAdmin = $request->user()->hasLicenseAs('infrastructure-administrator');
        $isUserSuperAdmin = $request->user()->hasLicenseAs('infrastructure-superadmin');
        $isUserOwner = $model->user_id == $request->user()->id;

        // kalau user bukan operator
        if (!$isUserOwner && !$isUserAdmin && !$isUserSuperAdmin) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa mengubah karena anda bukan pemilik.'
            ], 500);
        }

        return null;
    }
}

if (!function_exists('ensureRequestUserVerificator')) {
    function ensureRequestUserVerificator(Request $request) : JsonResponse | null
    {
        // apabila user bukan admin dan note status sudah bukan draft maka jangan tambah
        $isUserAdmin = $request->user()->hasLicenseAs('infrastructure-administrator');
        $isUserSuperAdmin = $request->user()->hasLicenseAs('infrastructure-superadmin');
        $isUserVerificator = $request->user()->hasLicenseAs('infrastructure-superadmin');

        // kalau user bukan verificator
        if (!$isUserVerificator && !$isUserAdmin && !$isUserSuperAdmin){
            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa karena anda bukan verificator..'
            ], 500);
        }

        return null;
    }
}