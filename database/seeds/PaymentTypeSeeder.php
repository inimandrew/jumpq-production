<?php

use Illuminate\Database\Seeder;
use App\Models\PaymentType;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ['cash', 'pos', 'paystack', 'flutter'];

        foreach ($types as $type) {
            PaymentType::create([
                'name' => $type,
            ]);
        }
    }
}
