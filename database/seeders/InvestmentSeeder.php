<?php

namespace Database\Seeders;

use App\Models\Animal;
use App\Models\Investment;
use App\Models\Transaction;
use App\Models\User;
// use Illuminate\Container\Attributes\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvestmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $investors = User::role('investor')->get();
        $animals = Animal::with('shares')->get();

        foreach ($investors as $investor) {
            // Each investor makes 2-5 investments
            $investmentCount = fake()->numberBetween(2, 5);
            $selectedAnimals = $animals->random($investmentCount);

            foreach ($selectedAnimals as $animal) {
                if (!$animal->shares || $animal->shares->available_shares <= 0) {
                    continue;
                }

                // Calculate investment amount
                $maxShares = min(30, $animal->shares->available_shares);
                $sharesToBuy = fake()->numberBetween(5, $maxShares);
                $pricePerShare = $animal->shares->price_per_share;
                $totalAmount = $sharesToBuy * $pricePerShare;

                // Check if investor has enough balance
                if ($investor->wallet->balance < $totalAmount) {
                    continue;
                }

                DB::transaction(function () use ($investor, $animal, $sharesToBuy, $pricePerShare, $totalAmount) {
                    // Create investment
                    $investment = Investment::create([
                        'user_id' => $investor->id,
                        'animal_id' => $animal->id,
                        'shares_owned' => $sharesToBuy,
                        'purchase_price_per_share' => $pricePerShare,
                        'total_amount' => $totalAmount,
                        'current_value' => $totalAmount * fake()->randomFloat(2, 1.02, 1.15), // Small appreciation
                        'total_dividends_earned' => 0,
                        'purchase_date' => fake()->dateTimeBetween('-60 days', 'now'),
                        'status' => 'active',
                    ]);

                    // Create transaction record
                    Transaction::create([
                        'user_id' => $investor->id,
                        'animal_id' => $animal->id,
                        'reference' => 'INV-' . strtoupper(uniqid()),
                        'type' => 'investment',
                        'method' => fake()->randomElement(['mpesa', 'bank']),
                        'amount' => $totalAmount,
                        'shares' => $sharesToBuy,
                        'status' => 'completed',
                        'processed_at' => fake()->dateTimeBetween('-60 days', 'now'),
                    ]);

                    // Update animal shares
                    $animal->shares->update([
                        'available_shares' => $animal->shares->available_shares - $sharesToBuy
                    ]);

                    // Update investor wallet
                    $investor->wallet->update([
                        'balance' => $investor->wallet->balance - $totalAmount,
                        'total_invested' => $investor->wallet->total_invested + $totalAmount,
                    ]);
                });
            }
        }

        // Create some deposit transactions for investors
        foreach ($investors as $investor) {
            $depositCount = fake()->numberBetween(1, 3);
            
            for ($i = 0; $i < $depositCount; $i++) {
                $depositAmount = fake()->randomFloat(2, 5000, 25000);
                
                Transaction::create([
                    'user_id' => $investor->id,
                    'reference' => 'DEP-' . strtoupper(uniqid()),
                    'type' => 'deposit',
                    'method' => fake()->randomElement(['mpesa', 'bank']),
                    'amount' => $depositAmount,
                    'status' => 'completed',
                    'external_reference' => 'MPESA-' . fake()->randomNumber(8, true),
                    'processed_at' => fake()->dateTimeBetween('-90 days', 'now'),
                ]);
            }
        }
    }
}
