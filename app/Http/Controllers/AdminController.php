<?php

namespace App\Http\Controllers;

use App\Models\CompanyProfile;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function setStatus($company_id, $status) {
        $company = CompanyProfile::where("company_id", '=', $company_id)->first();
        if (!$company) {
            return response()->json([
                'message' => 'Company not found',
            ], 404);
        }
        $company->status = $status;
        $company->save();
        return response()->json([
            'message' => 'Status company berhasil diubah',
            'status' => $company->status,
        ], 200);
    }

    public function seeAllCompany() {
        $companies = CompanyProfile::select('company_id', 'name_company')->get();
        return response()->json([
            'success' => true,
            'data' => $companies,
        ]);
    }


}
