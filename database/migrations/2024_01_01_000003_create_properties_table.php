<?php
// database/migrations/2024_01_01_000003_create_properties_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('survey_number')->unique();
            $table->string('plot_number')->nullable();
            $table->string('khasra_number')->nullable();
            $table->enum('land_type', [
                'agricultural', 'residential', 'commercial',
                'industrial', 'forest', 'government', 'other'
            ]);
            $table->enum('land_use', ['vacant', 'built_up', 'semi_built']);

            // Location
            $table->string('village')->nullable();
            $table->string('taluka');
            $table->string('district');
            $table->string('state');
            $table->string('pincode', 10);
            $table->text('address_description')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            // Dimensions
            $table->decimal('area_sqft', 12, 2);
            $table->decimal('area_sqm', 12, 2)->storedAs('area_sqft * 0.092903');
            $table->decimal('area_acres', 10, 4)->nullable();
            $table->decimal('length_ft', 10, 2)->nullable();
            $table->decimal('width_ft', 10, 2)->nullable();

            // Valuation
            $table->decimal('market_value', 15, 2)->default(0);
            $table->decimal('government_value', 15, 2)->default(0);
            $table->year('valuation_year')->nullable();

            // Status & Ownership
            $table->foreignId('current_owner_id')->nullable()->constrained('owners');
            $table->enum('status', ['available', 'registered', 'disputed', 'mortgaged', 'government_acquired'])
                  ->default('available');
            $table->boolean('has_disputes')->default(false);
            $table->text('dispute_notes')->nullable();

            // Documents
            $table->string('site_plan')->nullable();
            $table->string('survey_document')->nullable();

            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['district', 'taluka']);
            $table->index('land_type');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
