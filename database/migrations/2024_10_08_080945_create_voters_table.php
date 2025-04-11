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
            $table->string('fname', 500);
            $table->string('mname', 500)->nullable();
            $table->string('lname', 500)->nullable();
            $table->string('suffix', 100)->nullable();
            $table->foreignId('municipality_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('barangay_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('precinct_no', 500)->nullable();
            $table->string('gender', 500)->nullable();
            $table->string('dob', 500)->nullable();
            $table->string('status', 500)->default('Active');
            $table->string('remarks', 500)->nullable()->default('');
            $table->text('image_path')->nullable();
            $table->string('is_guiconsulta')->nullable()->default(NULL);
            $table->integer('is_checked')->nullable()->default(0);
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
