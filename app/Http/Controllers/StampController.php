<?php

namespace App\Http\Controllers;

use App\Models\CompanyProfile;
use App\Models\Stamp;
use App\Models\StudentProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StampController extends Controller
{
    public function seeStamp($siswa_id) {


        return response();
    }

    public function sendStamp($siswa_id) {
        $company = auth()->user();
        $company_id = $company->company_id;
        $siswa = StudentProfile::where("siswa_id", '=', $siswa_id)->first();
        $result = null;
        DB::transaction(function() use($siswa_id, $company_id,  $company, &$result) {
            $stamp_id = uniqid("stamp_");
            $result = Stamp::create([
                "stamp_id" => $stamp_id,
                "siswa_id" => $siswa_id,
                "company_id" => $company_id,
                "company_stamp" => $company->logo
            ]);

        });

        return response()->json([
            'message' => 'Stamp berhasil dikirim ke ' . $siswa->nama,
            'data' => $result
        ]);
    }
}
