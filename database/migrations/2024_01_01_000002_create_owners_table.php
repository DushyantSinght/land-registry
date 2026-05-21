<?php
// database/migrations/2024_01_01_000002_create_owners_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('owners', function (Blueprint $table) {
            $table->id();
            $table->string('owner_number')->unique();   // e.g. OWN-2024-00001
            $table->string('full_name');
            $table->enum('owner_type', ['individual', 'company', 'government']);
            $table->string('id_type')->default('national_id'); // national_id, passport, company_reg
            $table->string('id_number')->unique();
            $table->date('date_of_birth')->nullable();
            $table->string('nationality')->default('Indian');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->string('pincode', 10);
            $table->string('photo')->nullable();
            $table->string('id_document')->nullable();  // uploaded file path
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('owners');
    }
};
