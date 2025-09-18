<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FarmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $farmOwner = User::role('farm_owner')->first();

        $farms = [
            [
                'name' => 'Kamau Dairy Farm',
                'description' => 'A modern dairy farm specializing in high-yield Friesian cattle with state-of-the-art milking facilities.',
                'location' => [
                    'address' => 'Nakuru County, Kenya',
                    'latitude' => -0.3031,
                    'longitude' => 36.0800
                ],
                'license_number' => 'KDF-2023-001',
                'certifications' => ['Organic Certification', 'Animal Welfare Certified', 'ISO 22000'],
                'facilities' => ['Automated Milking System', 'Feed Storage Silos', 'Veterinary Clinic', 'Cooling Tanks'],
            ],
        ]
    }
}
