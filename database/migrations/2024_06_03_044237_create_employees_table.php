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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->date('dob')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('phoneno')->nullable();
            $table->string('gender')->nullable();
            $table->integer('salary')->nullable();
            $table->date('joiningdate')->nullable();
            $table->integer('total_leave')->default(22);
            $table->string('aadhar_number')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
