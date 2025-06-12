<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAyasmanCardTable extends Migration
{
    public function up()
    {
        Schema::create('ayasman_card', function (Blueprint $table) {
            $table->id();
            $table->string('ref_person_name')->nullable();
            $table->string('ref_person_number')->nullable();
            $table->string('ref_person_address')->nullable();
            $table->string('referral_system')->nullable();
            $table->string('patient_name');
            $table->string('title')->nullable();
            $table->string('guardian_name')->nullable();
            $table->date('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('mobile')->nullable();
            $table->string('problam')->nullable();
            $table->json('doctor_names')->nullable();
            $table->json('hospital_names')->nullable();
            $table->json('department_names')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('village')->nullable();
            $table->string('block')->nullable();
            $table->string('pin_code')->nullable();
            $table->string('aadhaar_number')->nullable();
            $table->string('ayushman_number')->nullable();
            $table->json('other_documents')->nullable();
            $table->string('ayushman_upload')->nullable();
            $table->decimal('amount', 10, 2)->default(0);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->string('payment_id')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ayasman_card');
    }
}
