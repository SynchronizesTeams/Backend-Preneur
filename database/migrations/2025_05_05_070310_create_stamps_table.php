<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stamps', function (Blueprint $table) {
            $table->id();
            $table->string("stamp_id");
            $table->string("siswa_id");
            $table->string("company_id");
            $table->string("company_stamp");
            $table->timestamps();

            //FK
            $table->index("siswa_id");
            $table->index("company_id");
            $table->foreign("siswa_id")->references('siswa_id')->on("student_profiles");
            $table->foreign("company_id")->references('company_id')->on("company_profiles");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stamps');
    }
};
