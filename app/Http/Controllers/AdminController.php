<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\CompanyProfile;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function setStatus($company_id, $status) {
        $admin = auth()->user();

        $booleanStatus = filter_var($status, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

         if (!is_bool($booleanStatus)) {
            return response()->json([
                'message' => 'Status must be true or false',
            ], 400);
         }


        $company = CompanyProfile::where("company_id", '=', $company_id)->first();
        if (!$company) {
            return response()->json([
                'message' => 'Company not found',
            ], 404);
        }

        $company->status = $booleanStatus;
        $company->save();
        return response()->json([
            'message' => 'Status company berhasil diubah',
            'status' => $company->status,
        ], 200);
    }

    public function seeAllCompany() {
        $companies = CompanyProfile::select('company_id', 'name_company', 'status')->get();
        return response()->json([
            'success' => true,
            'data' => $companies,
        ]);
    }

    public function login(Request $request) {
        $admin = Admin::where('username', '=', $request->username)->where('password', '=', $request->password)->first();
        if (!$admin) {
            return response()->json([
                'message' => 'Invalid username or password',
            ], 401);
        } else {
            $token = $admin->createToken("token")->plainTextToken;
        }

        return response()->json([
            'message' => 'success login',
            'status' => true,
            'token' => $token
        ]);

    }
}
