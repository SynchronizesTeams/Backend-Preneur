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

        //$users = null;

         $users = DB::transaction(function () use ($request, &$users) {
            $siswa_id = uniqid("siswa_");
            $users = StudentProfile::create([
                'siswa_id' => $siswa_id,
                'nama' => $request->nama,
                'nis' => $request->nis,
            ]);

            // $token = $users->createToken('auth_token')->plainTextToken;
        });

        return response()->json(
            [
                "message" => "succes register",
                "status" => true,
                "siswa" => [
                    "siswa_id" => $users->siswa_id,
                    "nama" => $users->nama,
                    "nis" => $users->nis,
                ]
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
        $validator = Validator::make($request->all(), [
            'name_company' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'required|string|min:8',
        ]);

        //$companies = null;

        $companies = DB::transaction(function () use ($request, &$companies) {
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
                "message" => "succes register company",
                "status" => true,
                "company" => [
                    "company_id" => $companies->company_id,
                    "name_company" => $companies->nama,
                    "logo" => $companies->logo,
                    "password" => $companies->password,
                ]
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
        $validator = Validator::make(Auth::user()->nama$request->all(), [
            'name_company' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid fields',
                'errors' => $validator->errors(),
            ], 422);
        }

        $companies = CompanyProfile::where('name_company', '=', $request->name_company)->where('password', '=', $request->password)->first();

        if ($companies) {
            $token = $companies->createToken("token")->plainTextToken;
        }

        return response()->json(
            [
                "message" => "succes login",
                "status" => true,
                "token" => $token,
                "siswa" => [
                    "id" => $companies->id,
                    "nama_company" => $companies->nama,
                    "password" => $companies->password,
                    "created_at" => $companies->created_at,
                ]
            ]
        );

        
        
    }
    public function siswaProfile($siswa_id) {

        $siswa = StudentProfile::where("siswa_id", '=', $siswa_id)->first();
        return $siswa;
    }

    public function companyProfile($company_id) {
        $company = CompanyProfile::where("company_id", '=', $company_id)->first();
        return $company;
    }

}
