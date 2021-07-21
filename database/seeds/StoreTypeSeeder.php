<?php

use Illuminate\Database\Seeder;
use App\Models\Store_Type;
class StoreTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ['Retail Outlet'];

        foreach($types as $type){
            Store_Type::create([
                'name' => $type
                ]);
        }
    }
}
