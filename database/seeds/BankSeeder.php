<?php

use Illuminate\Database\Seeder;
use App\Models\Banks;
use Illuminate\Support\Facades\Storage;
class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $flutter_banks = Storage::get("public/flutter.json");
        $paystack_banks = Storage::get("public/banks.json");
        $flutter_banks_decoded = json_decode($flutter_banks);
        $paystack_banks_decoded = json_decode($paystack_banks);
        $flutter = $flutter_banks_decoded->data;
        $paystack = $paystack_banks_decoded->data;
        foreach ($flutter as $bank) {
            Banks::create([
                'name' => $bank->name,
                'code' => $bank->code,
                'payment_type_id' => '4'
            ]);
        }

        foreach ($paystack as $bank) {
            Banks::create([
                'name' => $bank->name,
                'code' => $bank->code,
                'payment_type_id' => '3'
            ]);
        }
    }
}
