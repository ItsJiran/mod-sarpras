<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

if (!function_exists('isRequestUser')) {
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