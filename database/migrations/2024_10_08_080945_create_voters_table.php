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
        Schema::create('voters', function (Blueprint $table) {
            $table->id();
            $table->string('fname', 100);
            $table->string('mname', 100)->nullable();
            $table->string('lname', 100)->nullable();
            $table->string('suffix', 100)->nullable();
            $table->foreignId('municipality_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('barangay_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('precinct_no', 100)->nullable();
            $table->string('gender', 100)->nullable();
            $table->string('dob', 100)->nullable();
            $table->string('status', 100)->default('Active');
            $table->string('remarks', 100)->nullable()->default('');
            $table->text('image_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voters');
    }
};
