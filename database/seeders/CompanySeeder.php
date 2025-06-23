<?php

namespace Database\Seeders;

use App\Models\CompanyProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CompanyProfile::create([
             'company_id' => uniqid("company_"),
            'name_company' => 'Saisek Corp',
            'logo' => 'public/images/company/saisek.jpg',
            'password' => 'saisek',
        ]);
    }
}
