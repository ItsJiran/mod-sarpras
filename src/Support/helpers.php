<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

if (!functions_exists('isRequestModelStatusDraft')) {
    function isRequestModelStatusDraft(Request $request, $model = null) : JsonResponse | null 
    {
        $isUserAdmin = $request->user()->hasLicenseAs('infrastructure-administrator');
        $isUserSuperAdmin = $request->user()->hasLicenseAs('infrastructure-superadmin');

        if ( $model->status != 'draft' && !$isUserAdmin && !$isUserSuperAdmin ) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak berwenang!'
            ], 500);
        }

        return null;
    }
}

if (!functions_exists('isRequestModelStatusPending')) {
    function isRequestModelStatusPending(Request $request, $model = null) : JsonResponse | null 
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

if (!function_exists('isRequestUserOperator')) {
    function isRequestUserOperator(Request $request) : JsonResponse | null
    {
        // apabila user bukan admin dan note status sudah bukan draft maka jangan tambah
        $isUserAdmin = $request->user()->hasLicenseAs('infrastructure-administrator');
        $isUserSuperAdmin = $request->user()->hasLicenseAs('infrastructure-superadmin');

        // kalau user bukan operator
        $isUserOperator = $request->user()->hasLicenseAs('infrastructure-operator');
        if (!$isUserOperator && !$isUserAdmin && !$isUserSuperAdmin) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa mengubah karena anda bukan operator.'
            ], 500);
        }

        return null;
    }
}

if (!function_exists('isRequestUserOwnerModel')) {
    function isRequestUserOwnerModel(Request $request, $model) : JsonResponse | null
    {
        // apabila user bukan admin dan note status sudah bukan draft maka jangan tambah
        $isUserAdmin = $request->user()->hasLicenseAs('infrastructure-administrator');
        $isUserSuperAdmin = $request->user()->hasLicenseAs('infrastructure-superadmin');

        // kalau user bukan operator
        $isUserOwner = $model->user_id == $request->user()->id;
        if (!$isUserOwner && !$isUserAdmin && !$isUserSuperAdmin) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa mengubah karena anda bukan pemilik.'
            ], 500);
        }

        return null;
    }
}

if (!function_exists('isRequestUserVerificator')) {
    function isRequestUserVerificator(Request $request) : JsonResponse | null
    {
        // apabila user bukan admin dan note status sudah bukan draft maka jangan tambah
        $isUserAdmin = $request->user()->hasLicenseAs('infrastructure-administrator');
        $isUserSuperAdmin = $request->user()->hasLicenseAs('infrastructure-superadmin');

        // kalau user bukan verificator
        $isUserVerificator = $request->user()->hasLicenseAs('infrastructure-superadmin');
        if (!$isUserVerificator && !$isUserAdmin && !$isUserSuperAdmin){
            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa karena anda bukan verificator..'
            ], 500);
        }

        return null;
    }
}