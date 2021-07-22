<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientEncounterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_encounter', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->string('time');
            $table->enum('visit_type', ['first_time','repeat'])->default('first_time');
            $table->foreignId('healthworker')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('shared_access')->nullable()->constrained('users')->nullOnDelete();
            $table->string('height');
            $table->string('weight');
            $table->string('bmi');
            $table->string('bp');
            $table->string('temp');
            $table->string('respiratory_rate');
            $table->string('complaints');
            $table->string('diagnosis');
            $table->string('treatment_plan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_encounter');
    }
}
