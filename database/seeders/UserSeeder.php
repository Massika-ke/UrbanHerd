<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserWallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'System Administrator',
            'email' => 'admin@urbanherd.com',
            'phone' => '+254748114693',
            'password' => Hash::make('password'),
            'kyc_status' => 'approved',
            'risk_profile' => 'moderate',
            'is_active' => true,
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
        ]);

        $admin->assignRole('admin');

        UserProfile::create([
            'user_id' => $admin->id,
            'national_id' => '12345678',
            'address' => 'Nairobi, Kenya',
            'occupation' => 'System Administrator',
            'monthly_income' => 100000,
            'investment_experience' => 'expert',
            'date_of_birth' => '1990-01-01',
            'gender' => 'male',
        ]);

        UserWallet::create([
            'user_id' => $admin->id,
            'balance' => 5000000.00,
        ]);

        // Creating farm owner
        $farmOwner = User::create([
            'name' => 'Moses Wafula',
            'email' => 'wafula@urbanherd.co.ke',
            'phone' => '+254722000001',
            'password' => Hash::make('password'),
            'kyc_status' => 'approved',
            'risk_profile' => 'conservative',
            'is_active' => true,
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
        ]);

        $farmOwner->assignRole('farm_owner');

        UserProfile::create([
            'user_id' => $farmOwner->id,
            'national_id' => '23456789',
            'address' => 'Kitale, Kenya',
            'occupation' => 'Farm Owner',
            'monthly_income' => 150000,
            'investment_experience' => 'expert',
            'date_of_birth' => '1975-05-15',
            'gender' => 'male',
        ]);

        UserWallet::create([
            'user_id' => $farmOwner->id,
            'balance' => 250000.00,
        ]);

         // Create Sample Investors
        $investors = [
            [
                'name' => 'Mary Wanjiku',
                'email' => 'mary@email.com',
                'phone' => '+254733000001',
                'occupation' => 'Teacher',
                'monthly_income' => 45000,
                'balance' => 15000,
            ],
            [
                'name' => 'Peter Ochieng',
                'email' => 'peter@email.com',
                'phone' => '+254744000001',
                'occupation' => 'Accountant',
                'monthly_income' => 65000,
                'balance' => 25000,
            ],
            [
                'name' => 'Grace Mutiso',
                'email' => 'grace@email.com',
                'phone' => '+254755000001',
                'occupation' => 'Nurse',
                'monthly_income' => 55000,
                'balance' => 20000,
            ],
            [
                'name' => 'David Kiprop',
                'email' => 'david@email.com',
                'phone' => '+254766000001',
                'occupation' => 'Engineer',
                'monthly_income' => 85000,
                'balance' => 35000,
            ],
        ];

        foreach ($investors as $index => $investorData) {
            $investor = User::create([
                'name' => $investorData['name'],
                'email' => $investorData['email'],
                'phone' => $investorData['phone'],
                'password' => Hash::make('password'),
                'kyc_status' => 'approved',
                'risk_profile' => ['conservative', 'moderate', 'aggressive'][array_rand(['conservative', 'moderate', 'aggressive'])],
                'is_active' => true,
                'email_verified_at' => now(),
                'phone_verified_at' => now(),
            ]);
            $investor->assignRole('investor');

            UserProfile::create([
                'user_id' => $investor->id,
                'national_id' => (34567890 + $index),
                'address' => 'Nairobi, Kenya',
                'occupation' => $investorData['occupation'],
                'monthly_income' => $investorData['monthly_income'],
                'investment_experience' => ['beginner', 'intermediate'][array_rand(['beginner', 'intermediate'])],
                'date_of_birth' => fake()->dateTimeBetween('1980-01-01', '1995-12-31')->format('Y-m-d'),
                'gender' => ['male', 'female'][array_rand(['male', 'female'])],
            ]);

            UserWallet::create([
                'user_id' => $investor->id,
                'balance' => $investorData['balance'],
            ]);
        }
    }
}
