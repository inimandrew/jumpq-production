<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Models\Configurations;
use Illuminate\Support\Str;
use PDF;
use Illuminate\Validation\Rule;
use App\Http\Controllers\FileController;
use Hash;
use Session;
use App\Rules\ProductBranch;
use App\Rules\Code;
use App\Rules\Transaction;
use App\Rules\BarcodeValidation;
use App\Repositories\Staffs\StaffRepository;
use App\Repositories\StoreBranch\StoreBranchRepository;
use App\Repositories\Products\ProductRepository;
use App\Repositories\Others\OtherRepository;
use App\Models\Banks;

class LoadController extends Controller
{
    private $staff, $file, $category, $product, $other;

    public function __construct(StaffRepository $staff, FileController $file, OtherRepository $category, ProductRepository $product, OtherRepository $other, StoreBranchRepository $branch)
    {
        $this->staff = $staff;
        $this->file = $file;
        $this->category = $category;
        $this->product = $product;
        $this->other = $other;
        $this->branch = $branch;
    }


    public function authenticate(Request $request, StaffRepository $staff)
    {
        $data = $request->except('_token');
        $rules = [
            'username' => 'required|exists:staffs,username|string',
            'password' => 'required',
        ];

        $validation = Validator::make($data, $rules);
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        } else {
            if (Auth::guard('staff')->attempt(['username' => $request['username'], 'password' => $request['password'], 'status' => '2'], 1)) {
                $this->logout($request);
                return response()->json(['errors' => ['status' => ['Your Account has been Suspended and placed Under Review. Please Contact Support']]], 422);
            } elseif (Auth::guard('staff')->attempt(['username' => $request['username'], 'password' => $request['password'], 'status' => '0'], 1)) {
                $this->logout($request);
                return response()->json(['errors' => ["status" => ['Your Account has not been activated. Please Check your Email to Activate']]], 422);
            } elseif (Auth::guard('staff')->attempt(['username' => $request['username'], 'password' => $request['password']], 1)) {
                $staff = $this->staff->setApiKey($request['username']);
                $user = [
                    'name' => $staff->firstname . ' ' . $staff->lastname,
                    'email' => $staff->email,
                    'username' => $staff->username,
                    'phone' => $staff->phone,
                    'store_branch' => $staff->branch->name,
                    'api_token' => $staff->api_token
                ];

                return response()->json(['message' => ['Login Successful'], 'user' => $user], 200);
            } else {
                return response()->json(['errors' => ['password' => ['Password is Incorrect']]], 422);
            }
        }
    }

    public function logout(Request $request)
    {
        $api_token = $request->header('api_token');
        $this->staff->logout($api_token);
        Auth::guard('staff')->logout();
        return response()->json(['message' => ['Logout Successful']]);
    }

    public function updateProfile(Request $request)
    {
        $data = $request->except('_token');

        $rules = [
            'firstname' => 'required|alpha|max:25',
            'lastname' => 'required|alpha|max:25',
            'username' => 'required|alpha_dash|max:25|exists:staffs,username',
            'password' => 'nullable|alpha_dash|min:10',
            'phone' => 'required|digits:11',
            'photo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ];

        $validation = Validator::make($data, $rules);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        } else {

            $data['firstname'] = ucfirst(strtolower($data['firstname']));
            $data['lastname'] = ucfirst(strtolower($data['lastname']));
            if (empty($data['password'])) {
                unset($data['password']);
            } else {
                $data['password'] = Hash::make($data['password']);
            }
            if (empty($data['photo'])) {
                unset($data['photo']);
            } else {
                $path = $this->file->uploadProfileImage($request->file('photo'));
                $file_name = explode('/', $path);
                unset($data['photo']);
                $data['profile_image_location'] = $file_name[1];
            }
            $where['username'] = $data['username'];
            $update_count = $this->staff->update($data, $where);

            if ($update_count == 1) {
                return response()->json(['message' => ['Profile Updated Successfully']]);
            }
        }
    }

    public function new_category(Request $request)
    {
        $data = $request->except('_token');
        $rules = [
            'name' => 'required|string|unique:categories,name'
        ];
        $messages = [
            'name.required' => 'Category Name is required'
        ];

        $validation = Validator::make($data, $rules, $messages);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        } else {
            $data['name'] = ucwords($data['name']);
            $success = $this->category->create($data);
            if ($success) {
                return response()->json(['message' => ['Category Created Successfully']]);
            }
        }
    }

    public function getCategories(Request $request)
    {
        $categories = $this->category->getAll();
        return response()->json($categories);
    }

    public function deleteCategory(Request $request, $id)
    {
        $data['id'] = $id;
        $rules = [
            'id' => 'required|exists:categories,id'
        ];

        $messages = [
            'id.required' => 'Category is Required',
            'id.exists' => 'Invalid Category'
        ];
        $validation = Validator::make($data, $rules, $messages);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        } else {
            if ($this->category->relatedProducts($data['id']) == 0) {
                $delete_success = $this->category->deleteCategory($data['id']);
                if ($delete_success) {
                    return response()->json(['message' => ['Category Deleted Successfully']]);
                }
            } else {
                return response()->json(['errors' => ['This category cannot be deleted because it has been linked to a product']]);
            }
        }
    }

    public function deleteProducts(Request $request, $id)
    {
        $delete_success = $this->product->deleteProduct($id);
        if ($delete_success) {
            return response()->json(['message' => ['Product Deleted Successfully']]);
        } else {
            return response()->json(['errors' => ['This Product cannot be deleted because it has been assigned to a tag']]);
        }
    }

    public function getProduct(Request $request, $id)
    {
        $product = $this->product->getOne($id);
        return response()->json($product);
    }

    public function updateCategory(Request $request)
    {

        $data = $request->all();
        $rules = [
            'id' => 'required|exists:categories,id',
            'name' => 'required|unique:categories,name'
        ];

        $messages = [
            'id.required' => 'Category is Required',
            'id.exists' => 'Invalid Category Id',
            'name.required' => 'Category Name is required',
            'name.unique' => 'No changes made to Category Name'
        ];
        $validation = Validator::make($data, $rules, $messages);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        } else {
            $where = [
                'id' => $data['id']
            ];
            unset($data['id']);
            $update_success = $this->category->updateCategory($where, $data);
            if ($update_success) {
                return response()->json(['message' => ['Category Updated Successfully']]);
            }
        }
    }

    public function newProducts(Request $request)
    {
        $data = $request->only(['products']);
        $branch = $this->staff->getBranchId($request->header('api_token'));
        $created = 0;
        $updated = 0;
        $rules = [
            'products' => ['required', 'array'],
            'products.*.name' => ['required', 'string'],
            'products.*.price' => 'required|numeric',
            'products.*.cost_price' => ['required', 'numeric'],
            'products.*.category_id' => 'nullable|exists:categories,id',
            'products.*.barcode' => ['required', 'string'],
            'products.*.description' => 'nullable',
            'products.*.quantity' => 'required|numeric',
            'products.*.storeProductId' => 'required|string',
            'products.*.thumbnail' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:502', Rule::dimensions()->maxWidth(100)->ratio(1 / 1)->minWidth(100)],
            'products.*.medium' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:1024', Rule::dimensions()->maxWidth(300)->ratio(2 / 3)->minWidth(300)],
            'products.*.images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048', Rule::dimensions()->maxWidth(800)->minWidth(800)->ratio(1)],
        ];

        $validation = Validator::make($data, $rules);
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        } else {

            foreach ($data['products'] as $product) {
                $barcode_check = $this->product->getProductByUniqueId($product['storeProductId'], $branch);
                if (!$barcode_check) {
                    $single = array(
                        'name' => ucfirst($product['name']),
                        'product_type' => '1',
                        'category_id' => !empty($product['category_id']) ? $product['category_id'] : NULL,
                        'unit_price' => $product['price'],
                        'cost_price' => $product['cost_price'],
                        'quantity' => $product['quantity'],
                        'store_branch_id' => $branch,
                        'description' => !empty($product['description']) ? $product['description'] : '',
                        'uniqueId' => $product['storeProductId'],
                    );


                    $product_success = $this->product->create($single);
                    if ($product_success) {
                        $created = $created + 1;
                        if (!empty($product['barcode'])) {
                            $this->product->saveBarcode($product_success->id, $product['barcode']);
                        }
                    }
                } else {
                    $main_product = $barcode_check;
                    $where = ['id' => $main_product->id];
                    $update_data = [
                        'name' => ucfirst($product['name']),
                        'category_id' => !empty($product['category_id']) ? $product['category_id'] : NULL,
                        'unit_price' => $product['price'],
                        'cost_price' => $product['cost_price'],
                        'quantity' => $product['quantity'],
                        'description' => !empty($product['description']) ? $product['description'] : NULL,
                        'uniqueId' => !empty($product['storeProductId']) ? $product['storeProductId'] : NULL

                    ];

                    $this->product->updateProduct($where, $update_data);
                    $updated = $updated + 1;
                }
            }
            return response()->json(['message' => [$created . ' new products has been created successfully, ' . $updated . ' product updated']]);
        }
    }

    public function checkIfBarcodeExist(Request $request, $barcode)
    {
        $branch = $this->staff->getBranchId($request->header('api_token'));
        $products = $this->product->getProductCountByBarcode($barcode, $branch);

        if ($products === 0) {
            return response()->json(["message" => "Barcode doesn't exist"]);
        } else {
            return response()->json(["errors" => ["Barcode Already Belongs to a Product"]], 400);
        }
    }

    public function newProduct(Request $request)
    {
        $data = $request->except('_token');
        $branch = $this->staff->getBranchId($request->header('api_token'));
        $rules = [
            'name' => ['required', 'string', new ProductBranch($this->staff, $request)],
            'price' => 'required|min:1|numeric',
            'cost_price' => ['required', 'numeric', 'min:1'],
            'product_type' => 'required|numeric|min:0|max:1',
            'category_id' => 'required|exists:categories,id',
            'barcode' => ['required', 'string'],
            'description' => 'nullable',
            'thumbnail' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:502', Rule::dimensions()->maxWidth(100)->ratio(1 / 1)->minWidth(100)],
            'medium' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:1024', Rule::dimensions()->maxWidth(300)->ratio(2 / 3)->minWidth(300)],
            'images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048', Rule::dimensions()->maxWidth(800)->minWidth(800)->ratio(1)],
        ];

        $messages = [
            'images.*.required' => 'At Least 1 Product Image should be selected',
            'images.*.max' => 'An Image should not be more than 2MB',
            'thumbnail.dimensions' => 'Thumbnail should have a dimension of 100 x 100',
            'medium.dimensions' => 'Medium Size Images should have a dimension of 300 x 450',
            'cost_price.required' => 'Cost Price is required for Preparing Reports',
            'price.required' => 'Selling Price is required'
        ];


        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        } else {
            $product = array(
                'name' => ucfirst($data['name']),
                'product_type' => $data['product_type'],
                'category_id' => $data['category_id'],
                'unit_price' => $data['price'],
                'cost_price' => $data['cost_price'],
                'store_branch_id' => $branch,
                'description' => $data['description']
            );


            $product_success = $this->product->create($product);
            if ($product_success) {
                if (!empty($data['barcode'])) {
                    $this->product->saveBarcode($product_success->id, $data['barcode']);
                }

                $thumbnail_path = $this->file->uploadProductImage($data['thumbnail'], 'thumbnail');
                $thumbnail = array(
                    'product_id' => $product_success->id,
                    'image_type' => 'thumbnail',
                    'location' => $thumbnail_path
                );
                $thumbnail_success = $this->product->createImage($thumbnail);

                $medium_path = $this->file->uploadProductImage($data['medium'], 'medium');
                $medium = array(
                    'product_id' => $product_success->id,
                    'image_type' => 'medium',
                    'location' => $medium_path
                );
                $final_success = 0;
                $medium_success = $this->product->createImage($medium);

                foreach ($data['images'] as $product_image) {
                    $large_path = $this->file->uploadProductImage($product_image, 'large');
                    $large = array(
                        'product_id' => $product_success->id,
                        'image_type' => 'large',
                        'location' => $large_path
                    );

                    $large_success = $this->product->createImage($large);
                    if ($large_success) {
                        $final_success = $final_success + 1;
                    }
                }

                if ($thumbnail_success && $medium_success && ($final_success == count($data['images']))) {
                    return response()->json(['message' => ['Product Created Successfully']]);
                }
            }
        }
    }

    public function getPaymentType(Request $request)
    {
        $payments_types = $this->category->showPaymentTypes();
        return response()->json($payments_types);
    }

    public function getProducts(Request $request, $start, $end)
    {

        if ($start == 'null' && $end == 'null') {
            $products = $this->product->getProducts($this->staff->getBranchId($request->header('api_token')));
        } else {
            $products = $this->product->getProducts($this->staff->getBranchId($request->header('api_token')), $start, $end);
        }

        return response()->json($products);
    }

    public function getProductByBranch(Request $request, $branch_id)
    {
        $branch = \decrypt($branch_id);
        $products = $this->product->getProducts($branch);
        return response()->json($products);
    }

    public function getAllProducts(Request $request)
    {
        $products = $this->product->getAllProducts($this->staff->getBranchId($request->header('api_token')));
        return response()->json($products);
    }

    public function getTaggableProducts(Request $request)
    {
        $products = $this->product->getTaggableProduct($this->staff->getBranchId($request->header('api_token')));
        return response()->json($products);
    }

    public function countAvailableTags(Request $request)
    {
        $available_count = $this->other->countAvailableTags($this->staff->getBranchId($request->header('api_token')));
        if ($available_count > 0) {
            return response()->json(['available_tags' => $available_count]);
        } else {
            return response()->json(['errors' => ['No Tag Available for Allocation']]);
        }
    }

    public function updateProduct2(Request $request)
    {
        $data = $request->all();
        $rules = [
            'products.*.price' => 'required|min:1|numeric',
            'products.*.cost_price' => 'required|numeric|min:0',
            'products.*.quantity' => 'required|numeric',
            'products.*.id' => 'required|exists:products,id',
            'products.*.reorder' => 'required'
        ];

        $validation = Validator::make($data, $rules);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        } else {
            foreach ($data['products'] as $key => $value) {
                $where = ['id' => $value['id']];
                $update_data = [
                    'unit_price' => $value['price'],
                    'cost_price' => $value['cost_price'],
                    'quantity' => $value['quantity'],
                    'reorder_level' => $value['reorder']

                ];
            }

            $update_success = $this->product->updateProduct($where, $update_data);
            if ($update_success) {
                return response()->json(['message' => ['Product Updated Successfully']]);
            }
        }
    }

    public function updateProduct(Request $request)
    {
        $data = $request->except('_token');
        if (empty($data['product'])) {
            return response()->json(['errors' => ['product' => 'Product is Required']], 422);
        }
        if (empty($data['category_id'])) {
            $data['category_id'] = '';
        }
        $rules = [
            'product' => 'required|exists:products,id|numeric',
            'name' => ['nullable', 'string'],
            'price' => 'nullable|min:1|numeric',
            'cost_price' => 'nullable|min:1|numeric',
            'category_id' => 'nullable|exists:categories,id',
            'product_type' => 'nullable|numeric|min:0|max:1',
        ];

        $validation = Validator::make($data, $rules);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        } else {

            $where = ['id' => $data['product']];
            $update_data = [
                'name' => !empty($data['name']) ? $data['name'] : '',
                'unit_price' => !empty($data['price']) ? $data['price'] : '',
                'cost_price' => !empty($data['cost_price']) ? $data['cost_price'] : '',
                'category_id' => !empty($data['category_id']) ? $data['category_id'] : '',
                'description' => !empty($data['description']) ? $data['description'] : '',
                'product_type' => $data['product_type'],

            ];


            $update_success = $this->product->updateProduct($where, $update_data);

            if ($update_success) {
                return response()->json(['message' => ['Product Updated Successfully']]);
            }
        }
    }

    public function allocateTags(Request $request)
    {
        $data = $request->all();
        $rules = [
            'product' => 'required|numeric|exists:products,id',
            'tags.*' => 'required|string'
        ];
        $messages = [
            'product.numeric' => 'Invalid Product Selected',
            'product.exists' => 'Invalid Product Selected',
            'product.required' => 'Select a Product',
        ];
        $validation = Validator::make($data, $rules, $messages);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        } else {

            foreach ($data['tags'] as $tag) {
                $this->product->allocateTag($data['product'], $tag);
            }
            return response()->json(['message' => ['Tags has been allocated to products successfully']]);
        }
    }

    public function getCategoriesByBranch(Request $request, $branch_id)
    {
        $decrypt_branch_id = \decrypt($branch_id);
        $categories = $this->product->getCategories($decrypt_branch_id);
        return response()->json($categories);
    }


    public function product(Request $request, $product_id)
    {
        $product = $this->product->getProduct($product_id);
        return response()->json($product);
    }

    public function stockAvailabilityReport(Request $request)
    {
        $branch = $this->staff->getBranchId(Auth::guard('staff')->user()->api_token);
        $products = $this->product->getAllProducts($branch);

        if ($products->count() > 0) {
            $pdf = PDF::loadView('reports.stock', ['products' => $products]);
            return $pdf->download('Stock_Availability_Report.pdf');
        } else {
            Session::put('red', 1);
            return redirect()->back()->withErrors(['message' => 'No Inventory Recorded for that time frame']);
        }
    }

    public function getSalesRecord(Request $request, $start, $end)
    {
        $branch = $this->staff->getBranchId($request->header('api_token'));

        if ($start == 'null' && $end == 'null') {
            $sales = $this->other->getAllSales($branch);
        } else {
            $sales = $this->other->getAllSales($branch, $start, $end);
        }

        return response()->json($sales);
    }

    public function salesReport(Request $request)
    {
        $data = $request->except('_token');
        $rules = [
            'start' => ['required', 'date', 'before_or_equal:today'],
            'end' => ['required', 'date', 'after_or_equal:start']
        ];
        $messages = [
            'start.before_or_equal' => 'The Start Date should be today or a any date before',
            'end.after_or_equal' => 'The End Date should be a date after Start Date',
        ];

        $validation = Validator::make($data, $rules);
        if ($validation->fails()) {
            Session::put('red', 1);
            return redirect()->back()->withErrors($validation->errors());
        } else {
            $transactions = $this->other->getSalesRecordsAll(Auth::guard('staff')->user()->store_branch_id, $data['start'], $data['end']);
            if ($transactions->count() > 0) {
                $pdf = PDF::loadView('reports.sales', ['transactions' => $transactions, 'start' => $data['start'], 'end' => $data['end']])->setPaper('a2');;
                return $pdf->download('Sales Report.pdf');
            } else {
                Session::put('red', 1);
                return redirect()->back()->withErrors(['message' => 'No Sales Recorded for that time frame']);
            }
        }
    }

    public function getProductsByBarcode(Request $request, $barcode)
    {
        $branch = $this->staff->getBranchId($request->header('api_token'));

        $data = [
            'barcode' => $barcode
        ];
        $rules = [
            'barcode' => ['required', new Code($branch), 'string']
        ];
        $validation = Validator::make($data, $rules);
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        } else {
            $branch = $this->staff->getBranchId($request->header('api_token'));
            $products =  $this->product->getProductByBarcode($barcode, $branch);
            $isRfid = false;
            foreach ($products as $key => $value) {
                if ($value->product_type == '0') {
                    $isRfid = true;
                }
            }
            if ($isRfid) {
                return response()->json(['errors' => ['One or more items is an RFID Item, Please Check-in using the RFID Code Instead']]);
            } else {
                return response()->json($products, 200);
            }
        }
    }

    public function checkout(Request $request)
    {
        $branch = $this->staff->getBranchId($request->header('api_token'));
        $data = $request->all();
        $rules = [
            'name' => ['required', 'string'],
            'phone' => ['required', 'numeric'],
            'payment' => ['required', 'exists:payment_type,id'],
            'cart.*.quantity' => ['required', 'numeric'],
            'cart.*.product_type' => ['required', 'numeric'],
            'cart.*.codes.*' => ['required', new Code($branch)],
        ];

        $validation = Validator::make($data, $rules);
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        } else {
            $buyer = array(
                'name' => $data['name'],
                'phone' => $data['phone'],
            );
            $total = 0.00;
            $config = Configurations::where('type', 'service_charge')->first();
            $service_charge = (float) ($config->value / 100);
            $staff = $this->staff->getOne($this->staff->getIdByApiToken($request->header('api_token')));

            $cart_items = [];

            foreach ($data['cart'] as $value) {

                $product = $this->product->getProduct($value['product_id']);
                $total += ($product->unit_price * $value['quantity']);
                array_push($cart_items, [
                    'product_id' => $product->id,
                    'product_type' => $value['product_type'],
                    'price' => $product->unit_price,
                    'cost_price' => $product->cost_price,
                    'quantity' => $value['quantity'],
                    'status' => '1',
                    'codes' => $value['codes']
                ]);
            }


            $payment = [
                'transaction_id' => strtoupper(Str::random(8)),
                'payment_type_id' => $data['payment'],
                'staff_id' => $staff->id,
                'store_branch_id' => $staff->store_branch_id,
                'total' => $total,
                'service_charge' => $service_charge * $total,
                'status' => '1'
            ];

            DB::transaction(function () use ($buyer, $cart_items, $payment, $branch) {
                $buyer_success = $this->other->addBuyer($buyer);

                foreach ($cart_items as $cart) {
                    $this->other->addToCart($buyer_success, $cart, $branch);
                }
                $payment_success = $this->other->addPayment($buyer_success, $payment);

                $checkout_cart = $this->other->getCheckOutCart($buyer_success);

                foreach ($checkout_cart as $sales_cart) {
                    $payment_success->sales()->create([
                        'cart_id' => $sales_cart->id
                    ]);
                    $this->product->reduceQuantity($sales_cart->product, $sales_cart->quantity);
                }
            });


            return response()->json(['message' => ['Payment has been Cleared Successfully']]);
        }
    }


    public function getTransaction(Request $request, $transaction_id)
    {

        $data['transaction_id'] = $transaction_id;
        $rules = [
            'transaction_id' => ['required', 'string', 'exists:cart_payments,transaction_id']
        ];
        $validation = Validator::make($data, $rules);
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        } else {
            $rule2 = [
                'transaction_id' => [new Transaction(Auth::guard('staff')->user()->store_branch_id)]
            ];
            $validation1 = Validator::make($data, $rule2);
            if ($validation1->fails()) {
                return response()->json(['errors' => $validation1->errors()]);
            } else {
                $transaction = $this->other->getSale($transaction_id);
                return response()->json($transaction);
            }
        }
    }

    public function clearPayment(Request $request)
    {
        $data = $request->all();
        $rules = [
            'transaction_id' => ['required', 'string', 'exists:cart_payments,transaction_id']
        ];
        $validation = Validator::make($data, $rules);
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        } else {
            $rule2 = [
                'transaction_id' => [new Transaction(Auth::guard('staff')->user()->store_branch_id)]
            ];
            $validation1 = Validator::make($data, $rule2);
            if ($validation1->fails()) {
                return response()->json(['errors' => $validation1->errors()]);
            } else {
                $clear_transaction = $this->other->clearPayment($data['transaction_id'], Auth::guard('staff')->user()->id);
                return response()->json(['message' => ['Transaction has been cleared']]);
            }
        }
    }

    public function getProductByCategories(Request $request, $branch, $category_id)
    {
        $branch_id = decrypt($branch);
        $products = $this->product->getProductByCategory($category_id, $branch_id);
        return response()->json($products, 200);
    }

    public function getUnallocatedTags(Request $request)
    {
        $branch_id = $this->staff->getBranchId($request->header('api_token'));
        $unallocated_tags = $this->other->getAvailableTags($branch_id);
        return response()->json($unallocated_tags, 200);
    }

    public function addPaystackAccount(Request $request, array $data, $bank)
    {
        try {
            $secret = Configurations::where('type', 'paystack_secret_key')->first();
            $client = new \GuzzleHttp\Client([
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $secret->value
                ],
                'timeout' => '10'
            ]);
            $response = $client->post('https://api.paystack.co/subaccount', [
                'form_params' => [
                    'business_name' => Auth::guard('staff')->user()->branch->name,
                    'bank_code' => $bank->code,
                    'percentage_charge' => 2.57,
                    'account_number' => $data['account_number']
                ]
            ]);
            $body = $response->getBody()->getContents();
            $json = json_decode($body);
            $staff = $this->staff->getBranch($request->header('api_token'));
            $staff->branch->sub_account()->create([
                'account_number' => $data['account_number'],
                'currency_id' => $data['currency_id'],
                'bank_id' => $data['bank_id'],
                'sub_account_code' => $json->data->subaccount_code,
                'payment_type_id' => '3'
            ]);
            return response()->json(['message' => ['Paystack Business Account Details Saved']]);
        } catch (GuzzleHttp\Exception\GuzzleException $e) {
            return response()->json(['errors' => ["Cannot Connect to Paystack"]]);
        }
    }

    public function addSubAccount(Request $request)
    {

        $data = $request->all();
        $rules = [
            'account_number' => ['required', 'numeric', 'digits:10'],
            'currency_id' => ['required', 'exists:currencies,id'],
            'bank_id' => ['required', 'exists:banks,id']
        ];
        $validation = Validator::make($data, $rules);
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        } else {
            $bank = Banks::find($data['bank_id']);
            if ($bank->payment_type_id == '3') {
                return $this->addPaystackAccount($request, $data, $bank);
            } else if ($bank->payment_type_id == '4') {
                return $this->addFlutterAccount($request, $data, $bank);
            }
        }
    }

    public function addFlutterAccount(Request $request, array $data, $bank)
    {
        try {
            $secret = Configurations::where('type', 'flutterwave_secret_key')->first();
            $client = new \GuzzleHttp\Client([
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $secret->value
                ],
                'timeout' => '10'
            ]);
            $staff = $this->staff->getBranch($request->header('api_token'));
            $response = $client->post('https://api.flutterwave.com/v3/subaccounts', [
                'form_params' => [
                    'business_name' => $staff->branch->name,
                    'account_bank' => $bank->code,
                    'split_value' => 0.0247,
                    'split_type' => 'percentage',
                    'account_number' => $data['account_number'],
                    'country' => 'NG',
                    'business_mobile' => $staff->branch->phone,
                    'business_email' => $staff->email
                ]
            ]);
            $body = $response->getBody()->getContents();
            $json = json_decode($body);
            $staff->branch->sub_account()->create([
                'account_number' => $data['account_number'],
                'currency_id' => $data['currency_id'],
                'bank_id' => $data['bank_id'],
                'sub_account_code' => $json->data->subaccount_id,
                'payment_type_id' => '4'
            ]);
            return response()->json(['message' => ['FlutterWave Business Account Details Saved']]);
        } catch (GuzzleHttp\Exception\GuzzleException $e) {
            return response()->json(['errors' => ["Cannot Connect to Paystack"]]);
        }
    }

    public function getBanks(Request $request, $payment_gateway_id)
    {
        $banks = Banks::where('payment_type_id', $payment_gateway_id)->get();
        return response()->json(['banks' => $banks], 200);
    }
}
