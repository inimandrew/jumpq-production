<div class="row">
    <div class="col-sm-12">


        @if (!empty($data['paystack']) | !empty($data['flutter']))
        <div class="white-box">
            <div class="row">
                <h3 class="box-title m-b-0">BUSINESS ACCOUNT</h3>
                <div class="table-responsive">
                    <table class="table table-bordered inverse-table">
                        <thead>
                            <tr>
                                <th>Account Number</th>
                                <th>Bank</th>
                                <th>Currency</th>
                                <th>Sub-Account Code</th>
                                <th>Payment Gateway</th>
                            </tr>
                        <tbody>
                            @if (!empty($data['paystack']))
                            <tr>
                                <th>{{$data['paystack']->account_number}}</th>
                                <th>{{$data['paystack']->bank->name}}</th>
                                <th>{{$data['paystack']->currency->name}} -
                                    {{$data['paystack']->currency->symbol}}</th>
                                <th>{{$data['paystack']->sub_account_code}}</th>
                                <th>{{$data['paystack']->payment->name}}</th>
                            </tr>
                            @endif

                            @if (!empty($data['flutter']))
                            <tr>
                                <th>{{$data['flutter']->account_number}}</th>
                                <th>{{$data['flutter']->bank->name}}</th>
                                <th>{{$data['flutter']->currency->name}} -
                                    {{$data['flutter']->currency->symbol}}</th>
                                <th>{{$data['flutter']->sub_account_code}}</th>
                                <th>{{$data['flutter']->payment->name}}</th>
                            </tr>
                            @endif

                        </tbody>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        @endif

        @if (empty($data['paystack']) | empty($data['flutter']))
        <div class="white-box">
            <div class="row">
                <h3 class="box-title m-b-0" style="padding-left: 20px">ADD BUSINESS ACCOUNT</h3>
                <hr>
                <form class="form" autocomplete="off" id="sub_accounts">
                    {{ csrf_field() }}

                    <div class="form-group col-lg-6">
                        <label class="col-md-12">Currency</label>
                        <div class="col-md-12">
                            <select name="currency_id" class="form-control select2">
                                <option>Select a Currency</option>
                                @foreach ($data['currencies'] as $currency)
                                <option value="{{$currency->id}}">{{$currency->name}} - {{$currency->symbol}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-lg-6">
                        <label class="col-md-12">Payment Platform</label>
                        <div class="col-md-12">
                            <select name="payment" id="payment" class="form-control select2"
                                style="text-transform: capitalize">
                                <option>Select a payment platform</option>
                                @foreach ($data['payments'] as $payment)
                                <option value="{{$payment->id}}">{{$payment->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-lg-6">
                        <label class="col-md-12">Banks</label>
                        <div class="col-md-12">
                            <select name="bank_id" id="banks" class="form-control" required>
                                <option value="">Select a Bank</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-lg-6">
                        <label class="col-md-12">Account Number</label>
                        <div class="col-md-12">
                            <input type="number" name="account_number" class="form-control">
                        </div>
                    </div>


                    <div style="margin-left: 30px;">
                        <button class="btn btn-success btn-md " type="button" id="submit">Submit</button>
                    </div>

                </form>
            </div>
        </div>
        @endif
    </div>
</div>
</div>
</div>

@section('other_scripts')
<script src="{{url('assets/administrator/js/staff/subaccount.js')}}"></script>
@endsection
