<?php

use Illuminate\Database\Seeder;
use App\Models\Configurations;
class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = [
            'paystack_public_key' => 'pk_live_2402c6ed7f24d120375a0e5a34a6a9b313656a0b',
            'paystack_secret_key' => 'sk_live_0d86e6e7afed4942e6d07cfb17a1788b1882b9b7',
            'paystack_charge' => '1.5',
            'service_charge' => '1.1',
        ];
        foreach($array as $key => $value){
            Configurations::create([
                'type' => $key,
                'value' => $value
            ]);
        }
    }
}
