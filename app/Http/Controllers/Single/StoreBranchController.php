<?php

namespace App\Http\Controllers\Single;
use App\Models\Stores_Branch;
use App\Models\Currency;
use App\Http\Resources\Branch;
use App\Http\Resources\Currency as CurrencyResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StoreBranchController extends Controller
{
    public function showAll(Request $request){
        $branches = Stores_Branch::where('status','1')->has('products')->paginate(15);
        $result = Branch::collection($branches);
        return response()->json(['branches' => $result],200);
    }

    public function getCurrencies(Request $request){
        $currencies = Currency::all();
        $result = CurrencyResource::collection($currencies);
        return response()->json($result,200);

    }
}
