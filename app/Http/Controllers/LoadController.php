<?php

namespace App\Http\Controllers;

use App\Http\Resources\Campaign;
use App\Models\Accounts;
use App\Models\CampaignCount;
use App\Models\Campaigns;
use App\Models\Plans;
use App\Repositories\Others\OtherRepository;
use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Session;
use Validator;
use Storage;


class LoadController extends Controller
{
    private $other;
    public function __construct(OtherRepository $other)
    {
        $this->other = $other;
    }
    public function verifyPaystack(Request $request)
    {
        $input = @file_get_contents("php://input");
        $event = json_decode($input);
        Storage::put("public/response2.txt", $input);
        $reference = $event->data->metadata->custom_fields[0]->value;
        $this->other->verifyTransaction($reference);
        $reference = $event->data->metadata->custom_field[0]->value;
        $this->other->verifyTransaction($reference);
        $reference = $event->data->metadata->transaction_id;
        $this->other->verifyTransaction($reference);
        http_response_code(200);
    }

    public function verifyFlutterWave(Request $request)
    {
        $input = @file_get_contents("php://input");
        $event = json_decode($input, true);
        Storage::put("public/response.txt", $input);
        $reference = $event['data']['tx_ref'];
        $this->other->verifyTransaction($reference);
        http_response_code(200);
    }

    public function changePassword(Request $request, $id)
    {
        try {
            $decrypted = decrypt($id);
            $title = 'Update Password';
            $user = User::find($decrypted);
            if ($user) {
                $title = 'Password Change';
                return view('landing.auth.change-password', ['user_id' => $user->id, 'title' => $title]);
            } else {
                return redirect()->route('landing_page');
            }
        } catch (DecryptException $e) {
            return redirect()->route('landing_page');
        }
    }

    public function createAccount(Request $request)
    {
        $data = $request->all();
        $rules = [
            'company_name' => ['required', 'unique:accounts'],
            'cac_number' => ['required', 'unique:accounts'],
            'email' => ['required', 'email', 'unique:accounts'],
            'phone' => ['required', 'numeric'],
            'address' => ['required', 'string'],
            'password' => ['required', 'alpha_dash'],
            'website_url' => ['nullable', 'string'],
        ];

        $validation = Validator::make($data, $rules);
        if ($validation->fails()) {
            Session::put('red', 1);
            return redirect()->back()->withErrors($validation->errors())->withInput();
        } else {
            Accounts::create($data);
            Session::put('green', 1);
            return redirect()->back()->withErrors(['message' => 'Ad Account Created']);
        }
    }

    public function authenticate(Request $request)
    {
        $data = $request->only(['email_login', 'password_login']);
        $rules = [
            'email_login' => ['required', 'exists:accounts,email'],
            'password_login' => ['required']
        ];
        $messages = [
            'email_login.exists' => 'Invalid Email Address'
        ];

        $validation = Validator::make($data, $rules, $messages);

        if ($validation->fails()) {
            Session::put('red', 1);
            return redirect()->back()->withErrors($validation->errors())->withInput();
        } else {
            if (Auth::guard('ads')->attempt(['email' => $data['email_login'], 'password' => $data['password_login']], 1)) {
                return redirect()->route('ads-home')->withErrors(['message' => 'Welcome. You have been Logged in']);
            } else {
                Session::put('red', 1);
                return redirect()->back()->withErrors(['password' => 'Password is Incorrect'])->withInput();
            }
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('ads')->logout();
        Session::put('green', 1);
        return redirect()->route('advert-login')->withErrors(['password' => 'Logged Out']);
    }

    public function updateProfile(Request $request)
    {
        $data = $request->except('_token');
        if ($data['company_name'] == Auth::guard('ads')->user()->company_name) {
            unset($data['company_name']);
        }
        if ($data['phone'] == Auth::guard('ads')->user()->phone) {
            unset($data['phone']);
        }
        if ($data['cac_number'] == Auth::guard('ads')->user()->cac_number) {
            unset($data['cac_number']);
        }
        if ($data['website_url'] == Auth::guard('ads')->user()->website_url) {
            unset($data['website_url']);
        }
        if (empty($data['password']) && empty($data['password_confirmation'])) {
            unset($data['password']);
            unset($data['password_confirmation']);
        }

        if (empty($data)) {
            Session::put('green', 1);
            return redirect()->back()->withErrors(['message' => 'Profile Updated Successfully']);
        } else {
            $rules = [
                'company_name' => ['nullable', 'string', 'unique:accounts'],
                'phone' => ['nullable', 'numeric'],
                'website_url' => ['nullable', 'string'],
                'cac_number' => ['nullable', 'unique:accounts', 'numeric'],
                'address' => ['nullable', 'string'],
                'password' => ['nullable', 'alpha_dash', 'confirmed'],
                'password_confirmation' => ['nullable'],
            ];

            $validation = Validator::make($data, $rules);

            if ($validation->fails()) {
                Session::put('red', 1);
                return redirect()->back()->withErrors($validation->errors())->withInput();
            } else {
                unset($data['password_confirmation']);
                Auth::guard('ads')->user()->update($data);
                Session::put('green', 1);
                return redirect()->back()->withErrors(['message' => 'Profile Updated Successfully']);
            }
        }
    }

    public function getAllowed(Request $request, $plan)
    {
        $plan = Plans::find($plan);
        return response()->json(['allowed' => $plan->assets_allowed], 200);
    }

    public function createCampaign(Request $request)
    {
        if (Auth::guard('ads')->user()->status == 0) {
            Session::put('red', 1);
            return redirect()->back()->withErrors(['error' => 'You cannot create a campaign until your account has been Verified']);
        };

        $data = $request->except('_token');

        $rules = [
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'plan_id' => ['required', 'exists:plans,id'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'asset_type_id' => ['required', 'exists:asset_types,id'],
            'payment_type_id' => ['required', 'exists:payment_type,id'],
            'amount' => ['required', 'numeric'],
            'asset' => ['required', 'file'],
            'url_link' => ['required', 'url']
        ];

        $validation = Validator::make($data, $rules);

        if ($validation->fails()) {
            Session::put('red', 1);
            return redirect()->back()->withErrors($validation->errors())->withInput();
        } else {
            $rule2 = [
                'asset' => ['image', 'mimes:jpg,jpeg,png', 'max:10240']
            ];
            $rule3 = [
                'asset' => ['mimes:mp4,webm,mpeg,avi,mov,flv']
            ];
            if ($data['asset_type_id'] == 1) {
                $validation = Validator::make($data, $rule2);
            } else {
                $validation = Validator::make($data, $rule3);
            }

            if ($validation->fails()) {
                Session::put('red', 1);
                return redirect()->back()->withErrors($validation->errors())->withInput();
            } else {
                $path = $request->file('asset')->store('public/ads-assets');
                $exploded_path = explode('/', $path);
                $main_path = $exploded_path[count($exploded_path) - 1];
                $data['asset_url'] = $main_path;
                unset($data['asset']);
                Auth::guard('ads')->user()->campaign()->create($data);
                Session::put('green', 1);
                return redirect()->back()->withErrors(['message' => 'Campaign Created Successfully. You will be notified when your Campaign has been approved and you can therefore proceed to payment']);
            }
        }
    }

    public function getNextAd(Request $request)
    {
        $campaign = CampaignCount::whereDate('date', '=', Carbon::today()->toDateString())->orderBy('count')->whereHas('campaign', function ($query) {
            $query->where('status', '1');
        })->first();

        if ($campaign) {
            $ad = [
                'plan' => $campaign->campaign->plan->name,
                'owner' => $campaign->campaign->account->company_name,
                'title' => $campaign->campaign->title,
                'description' => $campaign->campaign->description,
                'url_redirect' => $campaign->campaign->url_link,
                'asset_type' => $campaign->campaign->asset->type,
                'asset_url' => url('/') . '/public/storage/ads-assets/' . $campaign->campaign->asset_url,
            ];
            $campaign->increment('count');
            if ($campaign->campaign->plan->daily_counts == $campaign->count) {
                Campaigns::where('id', $campaign->campaign->id)->update(['status' => '0']);
            }
            return response()->json(compact('ad'), 200);
        } else {
            return response()->json(['message' => 'No Advert to Display at this time'], 204);
        }
    }

    public function getFile(Request $request, $image)
    {
        $campaign = Campaigns::where('asset_url', $image)->first();
        return storage_path('app/public/ads-assets/' . $campaign->asset_url);
    }
}
