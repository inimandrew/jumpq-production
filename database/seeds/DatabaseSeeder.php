<?php

use App\Models\AssetType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(Api_Tokens::class);
        $this->call(RoleSeeder::class);
        $this->call(StoreTypeSeeder::class);
        $this->call(PaymentTypeSeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(ConfigurationSeeder::class);
        $this->call(BankSeeder::class);
        $this->call(PlanSeeder::class);
        $this->call(AssetSeeder::class);
        $this->call(PlanAssetSeeder::class);
    }
}
