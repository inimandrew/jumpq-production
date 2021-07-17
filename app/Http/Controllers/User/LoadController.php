<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Validator;
use Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\FileController;
use Auth;
use App\Models\Configurations;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Repositories\User\UserRepository;
use App\Repositories\Products\ProductRepository;
use App\Repositories\Others\OtherRepository;
use App\Repositories\StoreBranch\StoreBranchRepository;
use Illuminate\Support\Str;
use App\Rules\Code;
use App\Models\User;
use App\Mail\ResetPassword;
use App\Models\Stores_Branch;

class LoadController extends Controller
{
    private $user, $file, $product, $other, $branch;

    public function __construct(UserRepository $user, FileController $file, ProductRepository $product, OtherRepository $other, StoreBranchRepository $branch)
    {
        $this->user = $user;
        $this->file = $file;
        $this->product = $product;
        $this->other = $other;
        $this->branch = $branch;
    }

    public function register(Request $request)
    {
        try {
            $data = $request->except('_token');
            $rules = [
                'firstname' => 'required|alpha|max:25',
                'lastname' => 'required|alpha|max:25',
                'email' => 'required|email|unique:users,email',
                'username' => 'required|alpha_dash|max:25|unique:users,username',
                'password' => 'required|min:4|confirmed|string',
                'password_confirmation' => 'required',
                'phone' => 'required|numeric|unique:users,phone|min:11'
            ];
            $validation = Validator::make($data, $rules);
            if ($validation->fails()) {
                return response()->json(['errors' => $validation->errors()], 300);
            } else {
                $data['firstname'] = ucfirst($data['firstname']);
                $data['lastname'] = ucfirst($data['lastname']);
                $data['password'] = Hash::make($data['password']);
                unset($data['password_confirmation']);
                $success = $this->user->create($data);
                if ($success) {
                    return response()->json(['message' => ['Your Account has been created Successfully.']], 200);
                }
            }
        } catch (Exception $e) {
            return response()->json(['errors' => ['Oops, An Error Occurred. Please Reload and Try Again.']], 300);
        }
    }

    public function login(Request $request)
    {
        $data = $request->except('_token');
        $rules = [
            'username' => 'required|exists:users,username',
            'password' => 'required'
        ];
        $validation = Validator::make($data, $rules);
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 300);
        } else {
            if (Auth::guard('user')->attempt(['username' => $request['username'], 'password' => $request['password'], 'status' => '2'], 1)) {
                return response()->json(['errors' => ['status' => ['Your Account has been Suspended and placed Under Review. Please Contact Support']]], 300);
            } elseif (Auth::guard('user')->attempt(['username' => $request['username'], 'password' => $request['password']], 1)) {
                $token = $this->user->setApiKey($request['username']);
                return response()->json([
                    'message' => ['Login Successful'],
                    'user' => [
                        'firstname' => Auth::guard('user')->user()->firstname,
                        'lastname' => Auth::guard('user')->user()->lastname,
                        'email' => Auth::guard('user')->user()->email,
                        'username' => Auth::guard('user')->user()->username,
                        'phone' => Auth::guard('user')->user()->phone,
                        'api_token' => $token,
                    ]
                ], 200);
            } else {
                return response()->json(['errors' => ['password' => ['Password is Incorrect']]], 300);
            }
        }
    }

    public function logout(Request $request)
    {
        $api_token = $request->header('api_token');
        $this->user->logout($api_token);
        Auth::guard('user')->logout();
        return response()->json(['message' => ['Logout Successful']], 200);
    }

    public function updateProfile(Request $request)
    {

        $data = $request->except('_token');

        $rules = [
            'firstname' => 'required|alpha|max:25',
            'lastname' => 'required|alpha|max:25',
            'username' => 'required|alpha_dash|max:25|exists:users,username',
            'password' => 'nullable|alpha_dash|min:10|confirmed',
            'password_confirmation' => 'nullable',
            'phone' => 'required|digits:11',
            'birthday' => 'nullable|date_format:Y-m-d',
            'photo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ];

        $validation = Validator::make($data, $rules);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 300);
        } else {

            $data['firstname'] = ucfirst(strtolower($data['firstname']));
            $data['lastname'] = ucfirst(strtolower($data['lastname']));
            if (empty($data['password'])) {
                unset($data['password']);
                unset($data['password_confirmation']);
            } else {
                $data['password'] = Hash::make($data['password']);
                unset($data['password_confirmation']);
            }

            if (empty($data['birthday'])) {
                unset($data['birthday']);
            } else {
                $data['birthday'] = $request['birthday'];
            }

            if (empty($data['photo'])) {
                unset($data['photo']);
            } else {
                $path = $this->file->uploadProfileImage($request->file('photo'));

                unset($data['photo']);
                $data['profile_image_location'] = $path;
            }
            $where['username'] = $data['username'];
            $update_count = $this->user->update($data, $where);

            if ($update_count == 1) {
                return response()->json(['message' => ['Profile Updated Successfully']], 200);
            }
        }
    }

    public function addToCart(Request $request)
    {
        $data = $request->all();

        $rules = [
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['nullable', 'numeric', 'required_if:product_type,1'],
            'product_type' => ['required', 'numeric'],
            'code' => ['nullable', 'required_if:product_type,0'],
        ];

        $messages = [
            'code.required_if' => 'RFID Tag is required'
        ];

        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 300);
        } else {
            $branch = $this->product->getBranchId($data['product_id']);

            $stock_remaining = $this->product->checkStock($data['product_id']);
            if ($stock_remaining == '0') {
                return response()->json(['message' => ['Out of Stock']], 200);
            } else {
                $rule2 = [
                    'code' => [new Code($branch)]
                ];
                $validation2 = Validator::make($data, $rule2);
                if ($validation2->fails()) {
                    return response()->json(['errors' => $validation2->errors()], 300);
                } else {
                    $user = $this->user->getUser($request->header('api_token'));
                    $product = $this->product->getOne($data['product_id']);
                    $data['price'] = $product->unit_price;
                    $data['cost_price'] = $product->cost_price;

                    $add_to_cart_success = $this->other->addNormalUserToCart($user, $data, $branch);
                    if ($add_to_cart_success) {
                        return response()->json(['message' => [$product->name . ' has been added to cart']], 200);
                    } else {
                        return response()->json(['message' => ['Scanned RFID tag has already been added to cart']], 200);
                    }
                }
            }
        }
    }


    public function getProduct(Request $request, $barcode, $branch_id)
    {
        $data['barcode'] = $barcode;
        $data['branch'] = $branch_id;
        $rules = [
            'barcode' => ['required'],
            'branch' => ['required', 'exists:stores_branches,unique_id'],
        ];
        $messages = [
            'branch.required' => 'Branch Id is required',
            'barcode.required' => 'Barcode is required',
            'branch.exists' => 'Branch Id is Invalid',
        ];

        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 300);
        } else {

            $branch = $this->branch->getBranchByUniqueId($data['branch']);
            $product = $this->product->getProductByCode($data['barcode'], $branch->id);
                if(!empty($product)){
                    return response()->json($product, 200);
                }else{
                    return response()->json(['errors' => ['Invalid Barcode for this Branch']], 404);
                }
        }
    }

    public function deleteCart(Request $request, $cart_id)
    {
        $success = $this->other->deleteCart($cart_id);
        return response()->json(['message' => ['Product has been removed from cart']], 200);
    }

    public function getCart(Request $request)
    {
        $user = $this->user->getUser($request->header('api_token'));
        $carts = $this->other->getCart($user);
        return response()->json($carts, 200);
    }

    public function calculatePaystackCharge($payment, $total_amount)
    {
        $config = Configurations::where('type', 'service_charge')->first();
        $service_charge = (float) ($config->value / 100);
        $final = 0.00;
        if ($payment == '3') {
            $paystack = Configurations::where('type', 'paystack_charge')->first();
            $paystack_charge = (float) ($paystack->value / 100);
            if ($total_amount < 2500) {
                $result = $total_amount / (1 - $service_charge - $paystack_charge);
            } else {
                $result = ($total_amount / (1 - $service_charge - $paystack_charge)) + 100;
            }
            $final = $result - $total_amount;
        } else {
            $result = $service_charge * $total_amount;
            $final = $result;
        }

        return round($final, 2);
    }

    public function calculateFlutterCharge($payment, $total_amount)
    {
        $config = Configurations::where('type', 'service_charge')->first();
        $service_charge = (float) ($config->value / 100);
        $final = 0.00;
        if ($payment == '4') {
            $flutter_wave = Configurations::where('type', 'flutterwave_charge')->first();
            $flutter_wave_charge = (float) ($flutter_wave->value / 100);
            $result = $total_amount / (1 - $service_charge - $flutter_wave_charge);

            $final = $result - $total_amount;
        } else {
            $result = $service_charge * $total_amount;
            $final = $result;
        }

        return round($final, 2);
    }

    public function checkoutCash(Request $request)
    {
        $data = $request->all();
        $rules = [
            'branch' => ['required', 'exists:stores_branches,unique_id'],
            'payment' => ['required', 'numeric']
        ];
        $validation = Validator::make($data, $rules);
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 300);
        } else {
            $total = 0.00;
            $user = $this->user->getUser($request->header('api_token'));
            $carts = $this->other->getCart($user);
            $payment = $data['payment'];
            $branch = $this->branch->getBranchByUniqueId($data['branch']);

            if (!($carts->isEmpty())) {
                // DB::transaction(function () use ($user, $carts, $branch, $total,$payment) {
                foreach ($carts as $cart) {
                    $this->other->checkOutCart($cart);
                    $total = $total + ($cart->price * $cart->quantity);
                }

                if ($payment == '3') {
                    $service_charge = round($this->calculatePaystackCharge($payment, $total), 2);
                } else if ($payment == '4') {
                    $service_charge = round($this->calculateFlutterCharge($payment, $total), 2);
                }

                $payment = [
                    'transaction_id' => strtoupper(Str::random(8)),
                    'payment_type_id' => $payment,
                    'store_branch_id' => $branch->id,
                    'total' => $total,
                    'service_charge' => $service_charge,
                    'status' => '0'
                ];
                $payment_success = $this->other->addPayment($user, $payment);


                $checkout_cart = $this->other->getCheckOutCart($user);

                foreach ($checkout_cart as $sales_cart) {
                    $payment_success->sales()->create([
                        'cart_id' => $sales_cart->id
                    ]);
                    $this->product->reduceQuantity($sales_cart->product, $sales_cart->quantity);
                }
                return response()->json(['reference' => $payment_success->transaction_id]);
                // });
            } else {
                return response()->json(['errors' => ['No Product in User Cart']], 300);
            }
        }
    }

    public function getTransactionAmount(Request $request)
    {
        $data = $request->all();
        $rules = [
            'payment' => ['required', 'numeric', 'exists:payment_type,id']
        ];
        $validation = Validator::make($data, $rules);
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 300);
        } else {
            $total = 0.00;
            $user = $this->user->getUser($request->header('api_token'));
            $carts = $this->other->getCart($user);
            $payment = $data['payment'];

            if (!($carts->isEmpty())) {
                foreach ($carts as $cart) {
                    $total = $total + ($cart->price * $cart->quantity);
                    $currency = $cart->product->branch->currency->symbol;
                }

                if ($payment == '3') {
                    $service_charge = round($this->calculatePaystackCharge($payment, $total), 2);
                } else if ($payment == '4') {
                    $service_charge = round($this->calculateFlutterCharge($payment, $total), 2);
                }


                $payment = [
                    'total_amount' => $currency . $total,
                    'service_charge' => $currency . $service_charge,
                ];
                return response()->json($payment, 200);
            } else {
                return response()->json(['errors' => ['No Product in User Cart']], 300);
            }
        }
    }

    public function getTransactions(Request $request)
    {
        $user = $this->user->getUser($request->header('api_token'));
        $transactions = $this->other->getTransactions($user);
        return response()->json($transactions, 200);
    }

    public function resetPassword(Request $request)
    {
        $data = $request->all();
        $rules = [
            'email' => ['required', 'email', 'exists:users,email']
        ];
        $validation = Validator::make($data, $rules);
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 300);
        } else {
            $user = User::where('email', $data['email'])->first();
            Mail::to($data['email'])->send(new ResetPassword($user->id));
            return response()->json(['user_id' => encrypt($user->id), 'message' => ['Your Password Reset Link has been sent to your email']]);
        }
    }

    public function changePassword(Request $request)
    {
        $data = $request->all();
        $rules = [
            'user_id' => ['required', 'numeric', 'exists:users,id'],
            'password' => 'required|min:10|confirmed|alpha_dash',
            'password_confirmation' => 'required',
        ];
        $validation = Validator::make($data, $rules);
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 300);
        } else {
            $where['id'] = $data['user_id'];
            $update['password'] = Hash::make($data['password']);
            $user = $this->user->update($update, $where);
            return response()->json(['message' => ['Your Password has been updated. Please Login to Continue']]);
        }
    }

    public function checkBranch(Request $request, $branch_id)
    {
        try {
            $branch = Stores_Branch::where('unique_id',$branch_id)->firstOrFail();
            return response()->json(['data' => compact('branch'),'message' => 'Branch Exist'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json(['errors' => ['Invalid Branch Id']], 404);
        }
    }

    public function editCart(Request $request){
        $data = $request->all();

        $rules = [
            'cart_id' => ['required', 'exists:carts,id'],
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'numeric'],
        ];

        $messages = [
            'code.required_if' => 'RFID Tag is required'
        ];

        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 300);
        } else {
            $branch = $this->product->getBranchId($data['product_id']);
            $stock_remaining = $this->product->checkStock($data['product_id']);
            if ($stock_remaining < $data['quantity']) {
                return response()->json(['errors' => ['Quanity not available in stock']], 300);
            } else {

                $rule2 = [
                    'code' => [new Code($branch)]
                ];
                $validation2 = Validator::make($data, $rule2);
                if ($validation2->fails()) {
                    return response()->json(['errors' => $validation2->errors()], 300);
                } else {
                    $user = $this->user->getUser($request->header('api_token'));
                    $product = $this->product->getOne($data['product_id']);
                    $data['price'] = $product->unit_price;
                    $data['cost_price'] = $product->cost_price;

                    $add_to_cart_success = $this->other->updateCart($user,$data);
                    if ($add_to_cart_success) {
                        return response()->json(['message' => ['Cart updated']], 200);
                    } else {
                        return response()->json(['message' => ['Invalid Cart Id']], 200);
                    }
                }
            }
        }
    }
}
