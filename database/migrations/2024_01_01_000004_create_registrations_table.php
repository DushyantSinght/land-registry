<?php
// database/migrations/2024_01_01_000004_create_registrations_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number')->unique();   // REG-2024-00001
            $table->foreignId('property_id')->constrained('properties');
            $table->foreignId('owner_id')->constrained('owners');
            $table->enum('registration_type', [
                'first_registration', 'sale_deed', 'gift_deed',
                'will_deed', 'partition_deed', 'lease_deed', 'mortgage_deed'
            ]);
            $table->date('registration_date');
            $table->date('execution_date')->nullable();
            $table->string('sub_registrar_office');
            $table->string('document_number')->nullable();
            $table->decimal('transaction_value', 15, 2)->default(0);
            $table->decimal('stamp_duty', 12, 2)->default(0);
            $table->decimal('registration_fee', 12, 2)->default(0);
            $table->decimal('total_fee', 12, 2)->virtualAs('stamp_duty + registration_fee');

            $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled'])->default('pending');
            $table->text('remarks')->nullable();
            $table->text('rejection_reason')->nullable();

            // Witness info
            $table->string('witness1_name')->nullable();
            $table->string('witness1_id')->nullable();
            $table->string('witness2_name')->nullable();
            $table->string('witness2_id')->nullable();

            // Documents
            $table->string('deed_document')->nullable();
            $table->string('supporting_doc1')->nullable();
            $table->string('supporting_doc2')->nullable();

            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->string('transfer_number')->unique();    // TRF-2024-00001
            $table->foreignId('property_id')->constrained('properties');
            $table->foreignId('from_owner_id')->constrained('owners');
            $table->foreignId('to_owner_id')->constrained('owners');
            $table->foreignId('registration_id')->nullable()->constrained('registrations');
            $table->date('transfer_date');
            $table->decimal('transfer_value', 15, 2)->default(0);
            $table->string('transfer_mode');   // sale, gift, inheritance, court_order
            $table->text('reason')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('remarks')->nullable();
            $table->string('transfer_deed')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });

        // Property ownership history
        Schema::create('property_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('properties');
            $table->foreignId('owner_id')->constrained('owners');
            $table->date('from_date');
            $table->date('to_date')->nullable();
            $table->string('event_type');   // registered, transferred, mortgaged, etc.
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_histories');
        Schema::dropIfExists('transfers');
        Schema::dropIfExists('registrations');
    }
};
