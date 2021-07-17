<?php

namespace App\Repositories\Products;

use App\Models\Products;
use App\Models\Tags;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\Product;
use App\Models\Product_Images;
use App\Models\Barcode;

class ProductRepository implements ProductInterface
{

    public function create(array $data)
    {
        return Products::create($data);
    }

    public function createImage(array $data)
    {
        return Product_Images::create($data);
    }

    public function insertPayment($product_id, $payment_id)
    {
        $product = Products::find($product_id);
        if ($product->payments->contains($payment_id)) {
            $query_result = true;
        } else {
            $query_result = $product->payments()->attach($payment_id);
        }
        return $query_result;
    }

    public function getProducts($store_branch_id, $start = NULL, $end = NULL)
    {
        if ($start == NULL | $end == NULL) {
            $products = Products::where('store_branch_id', $store_branch_id)->paginate(10);
        } else {
            if ($start == $end) {
                $products = Products::where('store_branch_id', $store_branch_id)->whereDate('created_at', '=', $start)->paginate(10);
            } else {
                $products = Products::where('store_branch_id', $store_branch_id)->whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end)->paginate(10);
            }
        }

        return new ProductCollection($products);
    }

    public function getAllProducts($store_branch_id)
    {
        $products = Products::where('store_branch_id', $store_branch_id)->get();
        return Product::collection($products);
    }


    public function getTaggableProduct($store_branch_id)
    {
        $products = Products::where('store_branch_id', $store_branch_id)->where('product_type', '0')->get();
        return Product::collection($products);
    }

    public function deleteProduct($product_id)
    {
        $product = Products::find($product_id);
        if ($product->tags->count() > 0) {
            $result = false;
        } else {
            $result = $product->delete();
        }
        return $result;
    }

    public function getOne($product)
    {
        return new Product(Products::find($product));
    }


    public function updateProduct(array $where, array $data)
    {
        return Products::where($where)->update($data);
    }

    public function deleteProductPayment($product_id, $payment_id)
    {
        $product = Products::find($product_id);

        if ($product->payments->contains($payment_id)) {
            $query_result = $product->payments()->detach($payment_id);
        } else {
            $query_result = true;
        }
    }

    public function allocateTag($product_id, $tag_id)
    {
        $product = Products::find($product_id);

        $query_result = $product->tags()->create([
            'tag_id' => $tag_id
        ]);

        Tags::where('id', $tag_id)->update(['status' => '1']);

        return $query_result;
    }

    public function productCount($branch_id, $category_id)
    {
        return Products::where('store_branch_id', $branch_id)->where('category_id', $category_id)->count();
    }

    public function getCategories($branch_id)
    {
        $product = Products::where('store_branch_id', $branch_id)->get();
        $categories = $product->unique('category_name');
        $final_result = [];
        $i = 1;
        foreach ($categories as $category) {
            $final_result[$i] = [
                'id' => $category->category_id,
                'name' => $category->category_name,
                'product_count' => $this->productCount($branch_id, $category->category_id)
            ];
            $i = $i + 1;
        }

        return $final_result;
    }

    public function getProduct($product_id)
    {
        $product = Products::find($product_id);
        return new Product($product);
    }

    public function countProducts($store_branch_id)
    {
        return Products::where('store_branch_id', $store_branch_id)->count();
    }

    public function checkStock($product_id)
    {
        $product = Products::find($product_id);
        if ($product->product_type == '0') {
            $quantity = $product->tags()->doesntHave('carted')->count();
        } elseif ($product->product_type == '1') {
            $quantity = $product->quantity;
        }

        return $quantity;
    }

    public function saveBarcode($product_id, $barcode)
    {
        $product = Products::find($product_id);
        if ($product->barcode()->count()) {

            $barcode_saved = $product->barcode()->update([
                'barcode' => $barcode
            ]);
        } else {
            $barcode_saved = $product->barcode()->create([
                'barcode' => $barcode
            ]);
        }
        return $barcode_saved;
    }

    public function getProductByBarcode($barcode, $branch)
    {
        $products = Products::where('store_branch_id', $branch)->whereHas('barcode', function ($query) use ($barcode) {
            $query->where('barcode', $barcode);
        })->get();

        return $products;
    }

    public function getProductCountByBarcode($barcode, $branch)
    {
        $product = Products::where('store_branch_id', $branch)->whereHas('barcode', function ($query) use ($barcode) {
            $query->where('barcode', $barcode);
        })->count();

        return $product;
    }

    public function getProductModelByBarcode($barcode, $branch)
    {
        $product = Products::where('store_branch_id', $branch)->whereHas('barcode', function ($query) use ($barcode) {
            $query->where('barcode', $barcode);
        })->first();

        return $product;
    }

    public function reduceQuantity($product, $quantity)
    {
        if (($product->quantity > 0) && ($product->quantity >= $quantity)) {
            $product->quantity = $product->quantity - $quantity;
            $product->save();
        }
        return true;
    }

    public function getProductByCode($code, $branch)
    {
        $tag = Tags::where('rfid', $code)->whereHas('batch', function ($query) use ($branch) {
            $query->where('store_branch_id', $branch);
        })->count();
        $product = null;
        if ($tag) {
            $product = $this->getProductByRfid($code, $branch);
        } else {
            $barcode = Barcode::where('barcode', $code)->whereHas('product', function ($query) use ($branch) {
                $query->where('store_branch_id', $branch);
            })->count();
            if ($barcode) {
                $product = $this->getProductByBarcode($code, $branch);
                foreach ($product as $key => $value) {
                    if ($value->product_type == '0') {
                        return false;
                    }
                }
            }
        }
        return $product;
    }


    public function getProductByRfid($rfid, $branch)
    {
        $product = Products::where('store_branch_id', $branch)->whereHas('tags', function ($query) use ($rfid) {
            $query->whereHas('tag', function ($query1) use ($rfid) {
                $query1->where('rfid', $rfid)->where('status', '1');
            });
        })->get();

        return $product;
    }

    public function getBranchId($product_id){
        $product = Products::find($product_id);
        return $product->store_branch_id;
    }

    public function getProductByCategory($category_id,$branch){
        $products = Products::where('store_branch_id',$branch)->where('category_id',$category_id)->paginate(10);
        return new ProductCollection($products);
    }
}
