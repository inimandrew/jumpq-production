<?php

use App\Models\AssetType;
use App\Models\Plans;
use Illuminate\Database\Seeder;

class PlanAssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = [
            "regular" => [
                'photo'
            ],
            "classic" => [
                'photo','video'
            ],
            "premium" => [
                'photo','video'
            ]
        ];

        foreach ($plans as $key => $types) {
            $plan = Plans::where('name',$key)->first();
                foreach ($types as $key => $value) {
                    $asset_id = $this->getAssetId($value);
                    $plan->assets_allowed()->attach($asset_id);
                }
        }
    }

    public function getAssetId($name){
        $asset = AssetType::where('type',$name)->first();
        return $asset->id;
    }
}
