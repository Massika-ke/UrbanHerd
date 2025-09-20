<?php

namespace Database\Seeders;

use App\Models\Animal;
use App\Models\AnimalShare;
use App\Models\Farm;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnimalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $farms = Farm::all();

        $animalTypes = [
            'cow' => [
                'breeds' => ['Friesian', 'Ayrshire', 'Guernsey', 'Jersey'],
                'price_range' => [80000, 150000],
                'weight_range' => [400, 650],
                'age_range' => [18, 60],
            ],
            'goat' => [
                'breeds' => ['Boer', 'Galla', 'Toggenburg', 'Saanen'],
                'price_range' => [15000, 35000],
                'weight_range' => [30, 80],
                'age_range' => [12, 48],
            ]
        ];

        foreach ($farms as $farm) {
            $animalCount = rand(8, 15);
            
            for ($i = 0; $i < $animalCount; $i++) {
                $animalType = $farm->name === 'Kamau Dairy Farm' ? 'cow' : 'goat';
                $typeData = $animalTypes[$animalType];
                
                $purchasePrice = fake()->randomFloat(2, $typeData['price_range'][0], $typeData['price_range'][1]);
                $currentValue = $purchasePrice * fake()->randomFloat(2, 1.05, 1.25); // 5-25% appreciation
                
                $animal = Animal::create([
                    'farm_id' => $farm->id,
                    'tag_number' => strtoupper(substr($farm->name, 0, 3)) . sprintf('%04d', $i + 1),
                    'animal_type' => $animalType,
                    'breed' => fake()->randomElement($typeData['breeds']),
                    'age_months' => fake()->numberBetween($typeData['age_range'][0], $typeData['age_range'][1]),
                    'gender' => fake()->randomElement(['male', 'female']),
                    'weight_kg' => fake()->randomFloat(1, $typeData['weight_range'][0], $typeData['weight_range'][1]),
                    'health_status' => fake()->randomElement(['excellent', 'good', 'good', 'fair']), // Weighted toward good health
                    'purchase_price' => $purchasePrice,
                    'current_value' => $currentValue,
                    'insurance_value' => $currentValue * 1.1,
                    'is_breeding' => fake()->boolean(70), // 70% breeding animals
                    'last_health_check' => fake()->dateTimeBetween('-30 days', 'now'),
                    'medical_history' => [
                        'vaccinations' => ['FMD', 'Anthrax', 'Blackleg'],
                        'treatments' => fake()->randomElements(['Deworming', 'Vitamin injection', 'Antibiotic treatment'], rand(1, 3)),
                        'last_vaccination' => fake()->dateTimeBetween('-6 months', 'now')->format('Y-m-d')
                    ],
                    'notes' => fake()->optional()->sentence(),
                    'status' => 'active',
                ]);

                // Create shares for each animal
                $totalShares = 100; // Each animal divided into 100 shares
                $pricePerShare = round($currentValue / $totalShares, 2);
                $availableShares = fake()->numberBetween(30, 100); // Some may already have investors

                AnimalShare::create([
                    'animal_id' => $animal->id,
                    'total_shares' => $totalShares,
                    'available_shares' => $availableShares,
                    'price_per_share' => $pricePerShare,
                    'minimum_investment' => $pricePerShare * 5, // Minimum 5 shares
                    'is_available' => true,
                    'listing_date' => fake()->dateTimeBetween('-60 days', 'now'),
                    'last_price_update' => fake()->dateTimeBetween('-7 days', 'now'),
                ]);

                // Create some performance data
                $this->createPerformanceData($animal);
            }

            // Update farm's total animals count
            $farm->update(['total_animals' => $farm->animals()->count()]);
        }
    }

    private function createPerformanceData(Animal $animal)
    {
        $startDate = now()->subMonths(6);
        
        for ($month = 0; $month < 6; $month++) {
            $period = $startDate->copy()->addMonths($month)->format('Y-m');
            
            if ($animal->animal_type === 'cow') {
                $milkProduction = fake()->randomFloat(1, 400, 800); // liters per month
                $milkRevenue = $milkProduction * fake()->randomFloat(2, 50, 65); // KES per liter
                $breedingRevenue = fake()->boolean(20) ? fake()->randomFloat(2, 5000, 15000) : 0;
            } else {
                $milkProduction = fake()->randomFloat(1, 20, 60); // goat milk
                $milkRevenue = $milkProduction * fake()->randomFloat(2, 80, 120);
                $breedingRevenue = fake()->boolean(30) ? fake()->randomFloat(2, 2000, 8000) : 0;
            }

            $healthCosts = fake()->randomFloat(2, 500, 2000);
            $feedCosts = fake()->randomFloat(2, 3000, 8000);
            $otherCosts = fake()->randomFloat(2, 200, 1000);
            $totalRevenue = $milkRevenue + $breedingRevenue;
            $totalCosts = $healthCosts + $feedCosts + $otherCosts;
            
            // AnimalPerformance::create([
            //     'animal_id' => $animal->id,
            //     'period' => $period,
            //     'milk_production_liters' => $milkProduction,
            //     'milk_revenue' => $milkRevenue,
            //     'offspring_count' => $breedingRevenue > 0 ? fake()->numberBetween(1, 3) : 0,
            //     'breeding_revenue' => $breedingRevenue,
            //     'health_costs' => $healthCosts,
            //     'feed_costs' => $feedCosts,
            //     'other_costs' => $otherCosts,
            //     'net_profit' => $totalRevenue - $totalCosts,
            //     'weight_change_kg' => fake()->randomFloat(1, -5, 10),
            //     'health_metrics' => [
            //         'temperature' => fake()->randomFloat(1, 38.0, 39.5),
            //         'activity_level' => fake()->randomElement(['high', 'medium', 'low']),
            //         'feed_consumption' => fake()->randomFloat(1, 15, 25)
            //     ],
            //     'notes' => fake()->optional(30)->sentence(),
            // ]);
        }
    }
}
