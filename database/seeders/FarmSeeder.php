<?php

namespace Database\Seeders;

use App\Models\Farm;
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
                'name' => 'Massika Dairy Farm',
                'description' => 'A modern dairy farm specializing in high-yield Friesian cattle with state-of-the-art milking facilities.',
                'location' => [
                    'address' => 'Bungoma County, Kenya',
                    'latitude' => -0.3031,
                    'longitude' => 36.0800
                ],
                'license_number' => 'KDF-2023-001',
                'certifications' => ['Organic Certification', 'Animal Welfare Certified', 'ISO 22000'],
                'facilities' => ['Automated Milking System', 'Feed Storage Silos', 'Veterinary Clinic', 'Cooling Tanks'],
            ],
            [
                'name' => 'Highland Goat Ranch',
                'description' => 'Specialized goat breeding farm focusing on Boer and Galla goats for meat production.',
                'location' => [
                    'address' => 'Meru County, Kenya',
                    'latitude' => 0.0500,
                    'longitude' => 37.6500
                ],
                'license_number' => 'HGR-2023-002',
                'certifications' => ['Halal Certified', 'Animal Welfare Certified'],
                'facilities' => ['Breeding Pens', 'Feed Storage', 'Veterinary Facilities', 'Quarantine Area'],
            ]
        ];

        foreach ($farms as $farmData) {
            Farm::create([
                'name' => $farmData['name'],
                'description' => $farmData['description'],
                'location' => $farmData['location'],
                'license_number' => $farmData['license_number'],
                'owner_id' => $farmOwner->id,
                'verification_status' => 'verified',
                'rating' => fake()->randomFloat(1, 4.0, 5.0),
                'total_animals' => 0, // Will be updated when animals are created
                'certifications' => $farmData['certifications'],
                'facilities' => $farmData['facilities'],
                'is_active' => true,
            ]);
        }
    }
}
