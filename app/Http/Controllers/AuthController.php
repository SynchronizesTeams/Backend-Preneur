<?php

namespace App\Http\Controllers;

use App\Models\StudentProfile;
use App\Models\CompanyProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function RegisterStudent(Request $request)
    {
        // Fungsi ini menangani permintaan registrasi kayak buat validasi dah keknua.
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'nis' => 'required|integer',
        ]);

        $users = null;
        $token = null;
        DB::transaction(function () use ($request, &$users, &$token) {
            $siswa_id = uniqid("siswa_");
            $users = StudentProfile::create([
                'siswa_id' => $siswa_id,
                'nama' => $request->nama,
                'nis' => $request->nis,
            ]);

            $token = $users->createToken('auth_token')->plainTextToken;
        });

        return response()->json(
            [
                "message" => "succes register",
                "status" => true,
                "siswa" => $users,
                "token" => $token
            ]
        );


        //jika proses validasinya gagall maka akan mengambalikan jeson dengn massage errror 422
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid fields',
                'errors' => $validator->errors(),
            ], 422);
        }

    }





    public function LoginStudent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nis' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid fields',
                'errors' => $validator->errors(),
            ], 422);
        }

        $siswa = StudentProfile::where('nis', '=', $request->nis)->first();

        if ($siswa) {
            $token = $siswa->createToken("token")->plainTextToken;

            return response()->json(
                [
                    "status" => true,
                    "message" => "Hello " . $siswa->nama,
                    "token" => $token,
                    "data" => $siswa
                ]
            );


        } else {
            return response()->json([
                "message" => "Username or password incorrect"
            ], 401);
        }
    }


    public function RegisterCompany(Request $request)
    {
        Validator::make($request->all(), [
            'name_company' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'required|string|min:8',
        ]);

        $companies = null;

        DB::transaction(function () use ($request, &$companies) {
            $company_id = uniqid("company_");

            $logo = $request->file('logo')->store('logo', 'public');
            $companies = CompanyProfile::create([
                'company_id' => $company_id,
                'name_company' => $request->name_company,
                'logo' => $logo,
                'password' => $request->password,
            ]);
        });

        return response()->json(
            [
                "message" => "success register company",
                "status" => true,
                "company" => $companies->select('company_id', 'name_company', 'logo', 'password')
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid fields',
                'errors' => $validator->errors(),
            ], 422);
        }
    }


    public function CompanyLogin(Request $request) {
        $validator = Validator::make($request->all(), [
            'name_company' => 'required|string|max:255',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid fields',
                'errors' => $validator->errors(),
            ], 422);
        }

        $companies = CompanyProfile::where('name_company', '=', $request->name_company)->where('password', '=', $request->password)->where("status", "=", true)->first();
        if (!$companies) {
            return response()->json([
                "message" => "Your account is not active yet"
            ], 401);
        } else {

            $token = $companies->createToken("token")->plainTextToken;
        }

        return response()->json(
            [
                "message" => "succes login",
                "status" => true,
                "token" => $token,
                "company" => $companies->only('company_id', 'name_company', 'logo', 'password')
            ]
        );



    }
    public function siswaProfile($siswa_id) {

        $siswa = StudentProfile::where("siswa_id", '=', $siswa_id)->first();
        if(!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa not found',
            ], 404);
        } else {
            return response()->json([
                'success' => true,
                'data' => $siswa,
            ]);
        }
    }

    public function companyProfile($company_id) {
        $company = CompanyProfile::where("company_id", '=', $company_id)->first();
        if(!$company) {
            return response()->json([
                'success' => false,
                'message' => 'Company not found',
            ], 404);
        } else {
            return response()->json([
                'success' => true,
                'data' => $company,
            ]);
        }
    }

}
