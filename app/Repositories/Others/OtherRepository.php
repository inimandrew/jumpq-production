<?php

namespace App\Repositories\Others;

use App\Models\Categories;
use App\Models\Buyer;
use App\Models\Cart_Payment;
use App\Models\Cart as CartModel;
use App\Models\PaymentType as Payments;
use App\Http\Resources\Category;
use App\Http\Resources\cart;
use App\Http\Resources\TransactionCollection;
use App\Http\Resources\Transaction;
use App\Http\Resources\PaymentType;
use App\Models\Campaigns;
use App\Models\Tags;
use App\Models\Products_Tags;
use Carbon\Carbon;

class OtherRepository implements OtherInterface
{

    public function create(array $data)
    {
        return Categories::create($data);
    }

    public function getAll()
    {
        return Category::collection(Categories::all());
    }

    public function showPaymentTypes()
    {
        $payments_type = Payments::whereIn('name', ['pos','cash'])->get();
        return PaymentType::collection($payments_type);
    }

    public function deleteCategory($id)
    {
        return Categories::where('id', $id)->delete();
    }

    public function updateCategory(array $where, array $data)
    {
        return Categories::where($where)->update($data);
    }

    public function relatedProducts($category_id)
    {
        $category = Categories::find($category_id);
        return $category->products->count();
    }

    public function createTag(array $data)
    {
        return Tags::create($data);
    }

    public function countAvailableTags($store_branch_id)
    {
        $tags = Tags::where('status', '0')->whereHas('batch', function ($query) use ($store_branch_id) {
            $query->where('store_branch_id', $store_branch_id);
        })->count();

        return $tags;
    }

    public function getAvailableTags($store_branch_id)
    {
        $tags = Tags::where('status', '0')->doesntHave('product_tag')->whereHas('batch', function ($query) use ($store_branch_id) {
            $query->where('store_branch_id', $store_branch_id);
        })->get();

        return $tags;
    }


    public function getSalesRecordsAll($store_branch_id, $start_date, $end_date)
    {
        $transactions = Cart_Payment::has('sales')->where('store_branch_id', $store_branch_id)->whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)->orderBy('created_at', 'desc')->get();
        return $transactions;
    }

    public function getAllSales($store_branch_id, $start_date = null, $end_date = null)
    {
        if (empty($start_date) && empty($end_date)) {
            $transactions = Cart_Payment::has('sales')->where('store_branch_id', $store_branch_id)->orderBy('created_at', 'desc')->paginate(10);
        } else {
            $transactions = Cart_Payment::has('sales')->where('store_branch_id', $store_branch_id)->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)->orderBy('created_at', 'desc')->paginate(10);
        }

        return new TransactionCollection($transactions);
    }

    public function countSales($store_branch_id)
    {
        return Buyer::whereHas('staff', function ($query) use ($store_branch_id) {
            $query->whereHas('branch', function ($query1) use ($store_branch_id) {
                $query1->where('store_branch_id', $store_branch_id);
            });
        })->count();
    }

    public function addToCart($user, $cart, $branch)
    {
        if ($this->checkCart($user, $cart['product_id']) == 0) {
            if ($cart['product_type'] == '0') {
                unset($cart['product_type']);
                $codes = $cart['codes'];
                unset($cart['codes']);
                $success = $user->topurchase()->create($cart);

                foreach ($codes as $rfid) {
                    $product_tag = $this->getProductTagId($rfid, $branch);
                    $product_tag->carted()->create([
                        'cart_id' => $success->id,
                        'status' => '1'
                    ]);
                }
            } else {
                unset($cart['product_type']);
                unset($cart['codes']);
                $success = $user->topurchase()->create($cart);
            }
        } else {
            $success = false;
        }

        return $success;
    }

    public function addNormalUserToCart($user, $cart, $branch)
    {
        $cart_exist = $this->checkCart($user, $cart['product_id']);
        if ($cart_exist) {
            if ($cart['product_type'] == '0') {
                $product_tag = $this->getProductTagId($cart['code'], $branch);
                if (!($product_tag->carted()->count())) {
                    $product_tag->carted()->create([
                        'cart_id' => $cart_exist->id,
                    ]);
                } else {
                    return false;
                }
            } else {
                $user->topurchase()->where('id', $cart_exist->id)->update([
                    'quantity' => $cart_exist->quantity + $cart['quantity']
                ]);
            }
        } else {
            if ($cart['product_type'] == '0') {
                $code = $cart['code'];
                unset($cart['code']);
                $cart_added = $user->topurchase()->create($cart);
                $product_tag = $this->getProductTagId($code, $branch);
                $product_tag->carted()->create([
                    'cart_id' => $cart_added->id,
                ]);
            } else {
                unset($cart['code']);
                $user->topurchase()->create($cart);
            }
        }
        return true;
    }

    public function updateCart($user, $cart)
    {
        unset($cart['cart_id']);
        $cart_exist = $this->checkCart($user, $cart['product_id']);
        if ($cart_exist) {
            $user->topurchase()->where('id', $cart_exist->id)->update($cart);
            return true;
        } else {
            return false;
        }
    }


    public function getProductTagId($tag, $branch)
    {
        $product_tag = Products_Tags::whereHas('tag', function ($query) use ($branch, $tag) {
            $query->where('rfid', $tag)->whereHas('batch', function ($query2) use ($branch) {
                $query2->where('store_branch_id', $branch);
            });
        })->first();

        return $product_tag;
    }


    public function getCart($user)
    {
        return cart::collection($user->topurchase()->doesntHave('sales')->get());
    }

    public function checkOutCart($cart)
    {
        return CartModel::where('id', $cart->id)->update([
            'status' => '1'
        ]);
    }

    public function getCheckOutCart($user)
    {
        return $user->topurchase()->doesntHave('sales')->get();
    }

    public function checkCart($user, $product)
    {
        return $user->topurchase->where('product_id', $product)->where('status', '0')->first();
    }

    public function deleteCart($cart_id)
    {
        return CartModel::where('id', $cart_id)->delete();
    }

    public function addBuyer($buyer)
    {
        return Buyer::create($buyer);
    }

    public function addPayment($payer, array $payment)
    {
        return $payer->paid()->create($payment);
    }
    public function checkOutTags($branch)
    {
        $tags = Tags::whereHas('product_tag', function ($query) {
            $query->has('carted');
        })->whereHas('batch', function ($qu2) use ($branch) {
            $qu2->where('store_branch_id', $branch);
        })->get();

        return $tags;
    }

    public function checkTagStatus($tag, $branch)
    {
        $tag = $tag = Tags::where('rfid', $tag)->whereHas('batch', function ($query) use ($branch) {
            $query->where('store_branch_id', $branch);
        })->first();
        $status = $tag->product_tag->carted->status;
        return $status;
    }

    public function getSale($transaction_id)
    {
        $transaction = Cart_Payment::where('transaction_id', $transaction_id)->first();
        return new Transaction($transaction);
    }
    public function clearPayment($transaction_id, $staff_id)
    {
        $cart_payment = Cart_Payment::where('transaction_id', $transaction_id)->first();
        $cart_payment->status = '1';
        $cart_payment->staff_id = $staff_id;
        $cart_payment->save();
        if ($cart_payment->sales->count()) {
            foreach ($cart_payment->sales as $sale) {
                if ($sale->cart->carted()->count()) {
                    $sale->cart->carted()->update([
                        'status' => '1'
                    ]);
                }
            }
        }

        return true;
    }

    public function verifyTransaction($transaction_id)
    {
        $cart_payment = Cart_Payment::where('transaction_id', $transaction_id)->first();
        $cart_payment->status = '1';
        $cart_payment->payment_type_id = '3';
        $cart_payment->save();
        if ($cart_payment->sales->count()) {
            foreach ($cart_payment->sales as $sale) {
                if ($sale->cart->carted()->count()) {
                    $sale->cart->carted()->update([
                        'status' => '1'
                    ]);
                }
            }
        }

        return true;
    }

    public function getTransactions($user)
    {
        return Transaction::collection($user->paid);
    }

    public function getProductId($tag, $branch)
    {
        $tag = Tags::where('rfid', $tag)->whereHas('batch', function ($query) use ($branch) {
            $query->where('store_branch_id', $branch);
        })->first();
        $product_id = $tag->product_tag->product_id;
        return $product_id;
    }

    public function activateCampaign($campaign_id)
    {
        $campaign = Campaigns::find($campaign_id);
        $start_date = Carbon::createFromFormat('Y-m-d', $campaign->start_date);
        $end_date = Carbon::createFromFormat('Y-m-d', $campaign->end_date);
        $difference = $start_date->diffInDays($end_date);
        for ($i = 0; $i <= $difference; $i++) {
            $new_date = Carbon::createFromFormat('Y-m-d', $campaign->start_date);
            $campaign->campaign_count()->create([
                'count' => '0',
                'date' => $new_date->addDay($i)->toDateString()
            ]);
        }

        $campaign->update(['paid' => '1', 'status' => '1']);

        return true;
    }
}
