<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use App\Models\Owner;
use App\Models\Property;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Users ──────────────────────────────────────────────────────────────
        $admin = User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@landregistry.gov',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'phone'    => '9876543210',
        ]);

        User::create([
            'name'     => 'Registrar Kumar',
            'email'    => 'registrar@landregistry.gov',
            'password' => Hash::make('password'),
            'role'     => 'registrar',
            'phone'    => '9876543211',
        ]);

        User::create([
            'name'     => 'Viewer Staff',
            'email'    => 'viewer@landregistry.gov',
            'password' => Hash::make('password'),
            'role'     => 'viewer',
            'phone'    => '9876543212',
        ]);

        // ── Sample Owners ─────────────────────────────────────────────────────
        $owners = [
            [
                'full_name'  => 'Ramesh Kumar Sharma',
                'owner_type' => 'individual',
                'id_type'    => 'national_id',
                'id_number'  => 'AADHAAR123456',
                'phone'      => '9800000001',
                'email'      => 'ramesh@example.com',
                'address'    => '12, Main Street',
                'city'       => 'Chandigarh',
                'state'      => 'Punjab',
                'pincode'    => '160001',
            ],
            [
                'full_name'  => 'Sunita Devi',
                'owner_type' => 'individual',
                'id_type'    => 'national_id',
                'id_number'  => 'AADHAAR789012',
                'phone'      => '9800000002',
                'email'      => 'sunita@example.com',
                'address'    => '34, Sector 22',
                'city'       => 'Chandigarh',
                'state'      => 'Punjab',
                'pincode'    => '160022',
            ],
            [
                'full_name'  => 'ABC Builders Pvt Ltd',
                'owner_type' => 'company',
                'id_type'    => 'company_reg',
                'id_number'  => 'CIN-U45200PB2010PTC034567',
                'phone'      => '9800000003',
                'email'      => 'abc@builders.com',
                'address'    => 'Plot 7, Industrial Area Phase 1',
                'city'       => 'Mohali',
                'state'      => 'Punjab',
                'pincode'    => '160055',
            ],
        ];

        $createdOwners = collect($owners)->map(fn ($data) =>
            Owner::create(array_merge($data, ['created_by' => $admin->id]))
        );

        // ── Sample Properties ─────────────────────────────────────────────────
        $properties = [
            [
                'land_type'        => 'residential',
                'land_use'         => 'vacant',
                'village'          => 'Sector 15',
                'taluka'           => 'Chandigarh',
                'district'         => 'Chandigarh',
                'state'            => 'Punjab',
                'pincode'          => '160015',
                'area_sqft'        => 2400,
                'market_value'     => 8500000,
                'government_value' => 6000000,
                'valuation_year'   => 2024,
                'current_owner_id' => $createdOwners[0]->id,
                'status'           => 'registered',
            ],
            [
                'land_type'        => 'agricultural',
                'land_use'         => 'vacant',
                'village'          => 'Raipur',
                'taluka'           => 'Kharar',
                'district'         => 'Mohali',
                'state'            => 'Punjab',
                'pincode'          => '140301',
                'area_sqft'        => 43560,
                'area_acres'       => 1.0,
                'market_value'     => 3200000,
                'government_value' => 2400000,
                'valuation_year'   => 2024,
                'current_owner_id' => $createdOwners[1]->id,
                'status'           => 'registered',
            ],
            [
                'land_type'        => 'commercial',
                'land_use'         => 'built_up',
                'village'          => 'Phase 7',
                'taluka'           => 'Mohali',
                'district'         => 'Mohali',
                'state'            => 'Punjab',
                'pincode'          => '160059',
                'area_sqft'        => 5000,
                'market_value'     => 15000000,
                'government_value' => 12000000,
                'valuation_year'   => 2024,
                'current_owner_id' => $createdOwners[2]->id,
                'status'           => 'registered',
            ],
            [
                'land_type'   => 'residential',
                'land_use'    => 'vacant',
                'village'     => 'Sector 25',
                'taluka'      => 'Chandigarh',
                'district'    => 'Chandigarh',
                'state'       => 'Punjab',
                'pincode'     => '160025',
                'area_sqft'   => 1800,
                'market_value'=> 5000000,
                'government_value' => 3800000,
                'valuation_year' => 2024,
                'status'      => 'available',
            ],
        ];

        $createdProperties = collect($properties)->map(fn ($data) =>
            Property::create(array_merge($data, ['created_by' => $admin->id]))
        );

        // ── Sample Registration ───────────────────────────────────────────────
        Registration::create([
            'property_id'          => $createdProperties[0]->id,
            'owner_id'             => $createdOwners[0]->id,
            'registration_type'    => 'first_registration',
            'registration_date'    => now()->subDays(30),
            'sub_registrar_office' => 'Sub-Registrar Office, Sector 17, Chandigarh',
            'transaction_value'    => 8500000,
            'stamp_duty'           => 340000,
            'registration_fee'     => 85000,
            'status'               => 'approved',
            'created_by'           => $admin->id,
            'approved_by'          => $admin->id,
            'approved_at'          => now()->subDays(28),
            'witness1_name'        => 'Ravi Verma',
            'witness1_id'          => 'AADHAAR111111',
        ]);

        Registration::create([
            'property_id'          => $createdProperties[3]->id,
            'owner_id'             => $createdOwners[1]->id,
            'registration_type'    => 'sale_deed',
            'registration_date'    => now()->subDays(5),
            'sub_registrar_office' => 'Sub-Registrar Office, Sector 17, Chandigarh',
            'transaction_value'    => 5000000,
            'stamp_duty'           => 200000,
            'registration_fee'     => 50000,
            'status'               => 'pending',
            'created_by'           => $admin->id,
        ]);

        $this->command->info('✅ Database seeded successfully!');
        $this->command->table(
            ['Role', 'Email', 'Password'],
            [
                ['Admin',     'admin@landregistry.gov',     'password'],
                ['Registrar', 'registrar@landregistry.gov', 'password'],
                ['Viewer',    'viewer@landregistry.gov',    'password'],
            ]
        );
    }
}
