<?php

use App\Models\AssetType;
use Illuminate\Database\Seeder;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $assets = [
            ['type' => 'photo'],
            ['type' => 'video'],
        ];

        foreach ($assets as $asset) {
            AssetType::create($asset);
        }
    }
}
