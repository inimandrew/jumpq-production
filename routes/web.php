<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'PageController@index')->name('landing_page');
Route::get('about-us', 'PageController@aboutUs')->name('about_us');
Route::get('contact-us', 'PageController@contactUs')->name('contact_us');
Route::get('sign_up', 'PageController@register')->name('sign_up');
Route::get('sign_in', 'PageController@login')->name('sign_in');
Route::get('privacy', 'PageController@privacy')->name('privacy');
Route::get('products/{branch_id}', 'PageController@products')->name('branch_product_main');
Route::get('product/{product_id}', 'PageController@product')->name('single_product');
Route::get('payment/{transaction_id}', 'PageController@pay')->name('payments');
Route::post('verify_transaction', 'LoadController@verifyFlutterWave');
Route::post('verify_paystack', 'LoadController@verifyPaystack');
Route::get('payment_successful/{transaction_id}', 'PageController@successPayment')->name('successful_payment');
Route::get('activate', 'PageController@activateUser')->name('users_activation');
Route::get('forgot_password', 'PageController@forgotPassword')->name('forgot_password');
Route::get('change_password/{id}', 'LoadController@changePassword')->name('password_change');
Route::get('advert-placement', 'PageController@advert')->name('advert-placement');
Route::get('ads/pricing', 'PageController@pricing')->name('advert-pricing');
Route::post('register-account', 'LoadController@createAccount')->name('advert-registration');
Route::post('login-account', 'LoadController@authenticate')->name('advert-login');
Route::get('assets_allowed/{plan}', 'LoadController@getAllowed');
Route::get('asset/{campaign_id}','LoadController@getFile')->name('download_asset');

Route::group(['prefix' => 'ads', 'middleware' => 'ads'], function () {
    Route::get('/', 'PageController@adsHome')->name('ads-home');
    Route::get('logout', 'LoadController@logout')->name('ads-logout');
    Route::get('profile', 'PageController@profile')->name('ads-profile');
    Route::post('update-profile', 'LoadController@updateProfile')->name('update-ads-profile');
    Route::get('create-campaign', 'PageController@createCampaign')->name('create-ads-campaign');
    Route::post('create-campaign', 'LoadController@createCampaign')->name('create-ads-campaign-action');
});

Route::group(['prefix' => 'admin', 'namespace' => 'Administrator'], function () {
    Route::get('/', 'PageController@index');
    Route::get('login', 'PageController@login')->name('admin_login');

    Route::group(['middleware' => 'admin_pages'], function () {
        Route::get('dashboard', 'PageController@dashboard')->name('admin_home');
        Route::get('create_admin', 'PageController@createAdminPage')->name('createAdmin');
        Route::get('admins', 'PageController@displayAdmins')->name('returnAdmins');
        Route::get('profile', 'PageController@profilePage')->name('admin_profile');
        Route::get('new_store', 'PageController@newStorePage')->name('new_store_page');
        Route::get('stores', 'PageController@storesPage')->name('view_stores_page');
        Route::get('new_branch', 'PageController@branchPage')->name('new_branch_page');
        Route::get('new_staff', 'PageController@staffPage')->name('new_staff_page');
        Route::get('branches/{store_id}', 'PageController@branchesPage')->name('store_branches');
        Route::get('edit-branch', 'PageController@editBranch')->name('admin_edit_branch');
        Route::post('edit-branch', 'LoadController@editBranch')->name('admin_edit_branch_action');
        Route::get('staffs/{branch_id}', 'PageController@staffsPage')->name('staffs_page');
        Route::get('plans', 'PageController@plansPage')->name('ads-plans');
        Route::get('ads-accounts', 'PageController@adsAccount')->name('ads-accounts');
        Route::get('campaigns', 'PageController@campaigns')->name('campaign-page');
        Route::post('plan-create', 'LoadController@createPlan')->name('create-plan');
        Route::get('toggle-status/{id}/{status}', 'LoadController@toggleStatus')->name('toggle-status');
        Route::get('toggle-account-status/{id}/{status}', 'LoadController@toggleAccountStatus')->name('toggle-account-status');
        Route::get('toggle-approval-status/{id}/{status}', 'LoadController@toggleApprovalStatus')->name('toggle-approval-status');
        Route::get('toggle-active-status/{id}/{status}', 'LoadController@toggleCampaignStatus')->name('toggle-campaign-status');
    });
});

Route::get('profile_image/{file_name}', 'FileController@profileImage')->name('profile_pic');
Route::get('product_image/{file_name}', 'FileController@productImage')->name('product_pic');


Route::group(['prefix' => 'staff', 'namespace' => 'Staff'], function () {
    Route::get('/', 'PageController@index');
    Route::get('login', 'PageController@loginPage')->name('staff_login');

    Route::group(['middleware' => 'staff_pages'], function () {
        Route::get('home', 'PageController@home')->name('staff_home');
        Route::get('profile', 'PageController@profile')->name('staff_profile');
        Route::get('new_branch', 'PageController@new_branch')->name('staff_create_branch');
        Route::get('new_staff', 'PageController@new_staff')->name('staff_create_staff');
        Route::get('branches/{store_id}', 'PageController@branches')->name('staff_branches');
        Route::get('staffs/{branch_id}', 'PageController@staffs')->name('branch_staffs');
        Route::get('category', 'PageController@category')->name('category_page');
        Route::get('new_product', 'PageController@product')->name('product_page');
        Route::get('products', 'PageController@products')->name('inventory');
        Route::get('edit_product/{product_id}', 'PageController@editProduct')->name('edit_product_page');
        Route::get('allocate_tags', 'PageController@tagsAllocation')->name('tags_allocation');
        Route::get('stock_availability_report', 'LoadController@stockAvailabilityReport')->name('download_report');
        Route::post('sales_report', 'LoadController@salesReport')->name('sales_report');
        Route::get('barcode_only', 'PageController@checkIn')->name('barcode_only_check_in');
        Route::get('checkout', 'PageController@checkout')->name('products_checkout');
        Route::get('receipt/{transaction_id}', 'PageController@invoice')->name('receipt');
        Route::get('log_checkout', 'PageController@checkoutProducts')->name('log_checkout');
        Route::get('account', 'PageController@addAccount')->name('add_account');
        Route::get('transactions', 'PageController@transactions')->name('transaction');
    });
});

Route::group(['prefix' => 'user', 'namespace' => 'User', 'middleware' => 'user_pages'], function () {
    Route::get('dashboard', 'PageController@home')->name('user_home');
    Route::get('profile', 'PageController@profile')->name('user_profile');
    Route::get('cart', 'PageController@checkOut')->name('cart');
    Route::get('transactions', 'PageController@transactions')->name('transactions');
});

Route::group(['prefix' => 'api'], function () {
    Route::get('next-ad', 'LoadController@getNextAd');
    Route::get('categories', 'Staff\LoadController@getCategories');
    Route::get('products/{branch}/{category}', 'Staff\LoadController@getProductByCategories');
    Route::get('payment_types', 'Staff\LoadController@getPaymentType');
    Route::post('tags_populate', 'Single\TagsController@populateTags');
    Route::get('all_branches', 'Single\StoreBranchController@showAll');
    Route::get('categories/{branch_id}', 'Staff\LoadController@getCategoriesByBranch');
    Route::get('products/{branch_id}', 'Staff\LoadController@getProductByBranch');
    Route::get('products/{branch_id}/{category_id}', 'Staff\LoadController@getCategoriesByBranch');
    Route::get('product/{product_id}', 'Staff\LoadController@product')->name('single_product');
    Route::get('tag_status/{branch}/{rfid}', 'Single\TagsController@checkStatus2');


    Route::group(['namespace' => 'Administrator', 'prefix' => 'admin'], function () {
        Route::post('register', 'LoadController@register');
        Route::post('login', 'LoadController@authenticate');

        Route::group(['middleware' => 'admin_api'], function () {
            Route::post('update_profile', 'LoadController@updateProfile');
            Route::get('logout', 'LoadController@logout');
            Route::get('admins', "LoadController@getAdmins");
            Route::post('change_status', 'LoadController@changeStatus');
            Route::post('store/register', 'LoadController@createStore');
            Route::get('stores', 'LoadController@getStores');
            Route::post('update_commission_rate', 'LoadController@updateCommission');
        });
    });



    Route::group(['middleware' => 'admin_staff', 'namespace' => 'Single'], function () {
        Route::post('store/new_branch', 'StoreController@newBranch');
        Route::post('store/new_staff', 'StoreController@newStaff');
        Route::get('branches/{store_id}', 'StoreController@getBranches');
        Route::post('branch/change_status', 'StoreController@changeStatus');
        Route::post('branch/delete', 'StoreController@deleteBranch');
        Route::get('staffs/{branch_id}', 'StoreController@getStaffs');
        Route::post('staff/change_status', 'StoreController@changeStaffStatus');
        Route::post('staff/delete', 'StoreController@deleteStaff');
        Route::get('currencies', 'StoreBranchController@getCurrencies');
    });

    Route::group(['prefix' => 'staff', 'namespace' => 'Staff'], function () {
        Route::post('login', 'LoadController@authenticate');

        Route::group(['middleware' => 'staff_api'], function () {
            Route::get('logout', 'LoadController@logout');
            Route::post('update_profile', 'LoadController@updateProfile');
            Route::post('create_category', 'LoadController@new_category');
            Route::post('add_product', 'LoadController@newProduct');
            Route::post('add_products', 'LoadController@newProducts');
            Route::get('deletecategory/{id}', 'LoadController@deleteCategory');
            Route::post('editCategory', 'LoadController@updateCategory');
            Route::get('products/{start}/{end}', 'LoadController@getProducts');
            Route::get('all_products', 'LoadController@getAllProducts');
            Route::get('all_taggable_products', 'LoadController@getTaggableProducts');
            Route::get('deleteProduct/{id}', 'LoadController@deleteProducts');
            Route::get('product/{id}', 'LoadController@getProduct');
            Route::post('update_product', 'LoadController@updateProduct');
            Route::post('simple_update_product', 'LoadController@updateProduct2');
            Route::get('available_tags', 'LoadController@countAvailableTags');
            Route::post('allocate_tags', 'LoadController@allocateTags');
            Route::post('populate_tags', 'LoadController@populateTags');
            Route::get('sales_records/{start}/{end}', 'LoadController@getSalesRecord');
            Route::get('get_products/{barcode}', 'LoadController@getProductsByBarcode');
            Route::post('checkout', 'LoadController@checkout');
            Route::get('transaction/{transaction_id}', 'LoadController@getTransaction');
            Route::post('clear_payment', 'LoadController@clearPayment');
            Route::post('add_subaccount', 'LoadController@addSubAccount');
            Route::get('unallocated_tags', 'LoadController@getUnallocatedTags');
            Route::get('banks/{payment_gateway_id}', 'LoadController@getBanks');
            Route::get('product/barcode/{barcode}', 'LoadController@checkIfBarcodeExist');
        });
    });

    Route::group(['prefix' => 'user', 'namespace' => 'User'], function () {
        Route::post('register', 'LoadController@register');
        Route::post('login', 'LoadController@login');
        Route::post('reset_password', 'LoadController@resetPassword');
        Route::post('change_password', 'LoadController@changePassword');

        Route::group(['middleware' => 'user_api'], function () {
            Route::get('logout', 'LoadController@logout');
            Route::post('update_profile', 'LoadController@updateProfile');
            Route::get('product/{barcode}/{branch_id}', 'LoadController@getProduct');
            Route::post('add_cart', 'LoadController@addToCart');
            Route::post('edit_cart', 'LoadController@editCart');
            Route::get('cart', 'LoadController@getCart');
            Route::get('remove_from_cart/{cart_id}', 'LoadController@deleteCart');
            Route::post('checkout_by_cash', 'LoadController@checkoutCash');
            Route::get('transactions', 'LoadController@getTransactions');
            Route::post('load_cart_amount', 'LoadController@getTransactionAmount');
            Route::get('branch/{branch_id}', 'LoadController@checkBranch');
        });
    });
});
