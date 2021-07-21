<?php

use App\Models\Plans;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = [
            [
                "name" => 'regular',
                "daily_counts" => 50,
                'status' => '1',
                'price' => '100',
            ],
            [
                "name" => 'classic',
                "daily_counts" => 100,
                'status' => '1',
                'price' => '200',
            ],
            [
                "name" => 'premium',
                "daily_counts" => 200,
                'status' => '1',
                'price' => '400',
            ],
        ];

        foreach ($plans as $plan) {
            Plans::create($plan);
        }
    }
}
