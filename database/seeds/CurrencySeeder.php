<?php

use Illuminate\Database\Seeder;
use App\Models\Currency;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = [
            'Naira' => '₦'
        ];

        foreach ($currencies as $currency => $value) {
            Currency::create([
                'name' => $currency,
                'symbol' => $value
            ]);
         }
    }
}
