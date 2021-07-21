<?php

namespace App\Http\Controllers\Single;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Batch;
use App\Rules\TagsValidation;
use App\Rules\TagNotExist;
use App\Models\Tags;
use App\Rules\AllocatedTags;
use App\Repositories\Others\OtherRepository;
use App\Repositories\StoreBranch\StoreBranchRepository;
use App\Repositories\Products\ProductRepository;

class TagsController extends Controller
{
    private $other, $branch, $product;

    public function __construct(OtherRepository $other, StoreBranchRepository $branch, ProductRepository $product)
    {
        $this->other = $other;
        $this->branch = $branch;
        $this->product = $product;
    }

    public function populateTags(Request $request)
    {
        $data = $request->all();
        $rules = [
            'branch' => 'required|exists:stores_branches,unique_id',
            'tag' => 'required'
        ];
        $messages = [
            'branch.exists' => 'Invalid Branch Id',
            'branch.required' => 'No Branch Supplied',
        ];

        $branch = $this->branch->getBranchByUniqueId($data['branch']);
        $rules2 = [
            'tag' => ['required', new TagsValidation($branch->id)]
        ];

        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        } else {
            $validation1 = Validator::make($data, $rules2);
            if ($validation1->fails()) {
                return response()->json(['errors' => $validation1->errors()]);
            } else {
                $success_count = 0;
                $branch = $this->branch->getBranchByUniqueId($data['branch']);
                $batch = Batch::create([
                    'store_branch_id' => $branch->id,
                    'activity_type' => 'Tags Upload'
                ]);

                if ($batch) {
                    $batch->tag()->create(['rfid' => $data['tag']]);

                    return response()->json(['message' => 'Success']);
                } else {
                    return response()->json(['errors' => ['An Error Occured']]);
                }
            }
        }
    }

    public function checkStatus(Request $request, $branch, $rfid)
    {
        $data['code'] = $rfid;
        $data['branch'] = $branch;
        $rules = [
            'branch' => ['required', 'exists:stores_branches,unique_id'],
            'code' => ['required', 'exists:tags,rfid']
        ];

        $validation = Validator::make($data, $rules);
        if ($validation->fails()) {
            return response()->json(['status' => '4', 'product_name' => '']);
        } else {
            $branch = $this->branch->getBranchByUniqueId($data['branch']);
            $rule2 = [
                'code' => [new TagsValidation($branch->id)]
            ];
            $validation1 = Validator::make($data, $rule2);
            if ($validation1->fails()) {
                return response()->json(['status' => '3', 'product_name' => '']);
            } else {
                $rules3 = [
                    'code' => [new AllocatedTags($branch->id)]
                ];
                $validation2 = Validator::make($data, $rules3);
                if ($validation2->fails()) {
                    return response()->json(['status' => '2', 'product_name' => '']);
                } else {
                    $status = $this->other->checkTagStatus($data['code'], $branch->id);
                    $product = $this->product->getProductByRfid($data['code'], $branch->id);
                    $returnResult = [
                        'status' => $status,
                        'product_name' => $product->name
                    ];

                    return response()->json($returnResult, 200);
                }
            }
        }
    }

    public function checkStatus2(Request $request, $branch, $rfid){
        $data['code'] = $rfid;
        $data['branch'] = $branch;
        $rules = [
            'branch' => ['required', 'exists:stores_branches,unique_id'],
            'code' => ['required']
        ];

        // $validation = Validator::make($data, $rules);
        // if ($validation->fails()) {
        //     return response()->json(['status' => '5', 'product_name' => '']);
        // } else {
            $branch = $this->branch->getBranchByUniqueId($data['branch']);
            $tag = Tags::where('rfid', $data['code'])->whereHas('batch', function ($query) use ($branch) {
                $query->where('store_branch_id', $branch->id);
            })->first();

                if($tag){
                    if($tag->product_tag()->count()){
                        $product = $this->product->getProductByRfid($data['code'], $branch->id);
                        if($tag->product_tag->carted()->count()){

                            $returnResult = [
                                'product_name' => $product->name,
                                'status' => $tag->product_tag->carted->status
                            ];

                            return response()->json($returnResult, 200);
                        }else{
                            return response()->json(['status' => '0','product_name' => $product->name]);
                        }
                    }else{
                        return response()->json(['status' => '2', 'product_name' => '']);
                    }
                }else{
                    return response()->json(['status' => '3', 'product_name' => '']);
                }

    }
}
