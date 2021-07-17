<?php

use Illuminate\Database\Seeder;
use App\Models\Api_Tokens as Api;
use Illuminate\Support\Str;

class Api_Tokens extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $devices = ['web','desktop','android','ios'];

        foreach($devices as $device){
            Api::create([
                'device_type' => $device,
                'api_token' => Str::random(60)
            ]);
        }
    }
}
