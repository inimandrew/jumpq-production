<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="white-box printableArea">
            <h3><b>RECEIPT</b> <span class="pull-right">#{{$data['cart_payment']->transaction_id}}</span></h3>
            <hr>
            <div class="row">
                <div class="col-md-12">

                    <div class="pull-right text-right">
                        <address>
                            <h3>To,</h3>
                            <h4 class="font-bold">{{$data['cart_payment']->payer->name}}</h4>
                            <p class="text-muted m-l-30">Phone: {{$data['cart_payment']->payer->phone}} </p>
                            <p class="text-muted m-l-30">Purchased With: {{$data['cart_payment']->payment_type->name}} </p>
                            <p class="m-t-30"><b>Purchase Date :</b> {{str_replace(' ','@',$data['cart_payment']->created_at)}}</p>
                        </address>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="table-responsive m-t-40" style="clear: both;">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Product Name</th>
                                    <th class="text-right">Quantity</th>
                                    <th class="text-right">Unit Cost({{Auth::guard('staff')->user()->branch->currency->symbol}})</th>
                                    <th class="text-right">Total({{Auth::guard('staff')->user()->branch->currency->symbol}})</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($data['cart_payment']->sales as $item)
                                <tr>
                                    <td class="text-center">{{$i++}}</td>
                                    <td>{{$item->cart->product->name}}</td>
                                    <td class="text-right">{{$item->cart->quantity}} </td>
                                    <td class="text-right"> {{formatNumber($item->cart->price)}} </td>
                                    <td class="text-right"> {{formatNumber(($item->cart->quantity * $item->cart->price))}} </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="pull-right m-t-30 text-right">
                        <p>Sub - Total amount: {{Auth::guard('staff')->user()->branch->currency->symbol}} {{formatNumber($data['cart_payment']->total)}}</p>
                        <p>Service-Charge: {{Auth::guard('staff')->user()->branch->currency->symbol}} {{formatNumber($data['cart_payment']->service_charge)}} </p>
                        <hr>
                        <h3><b>Total :</b> {{Auth::guard('staff')->user()->branch->currency->symbol}} {{ formatNumber(($data['cart_payment']->service_charge + $data['cart_payment']->total)) }}</h3>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <div class="text-right">
                        <button id="print" class="btn btn-default btn-outline" type="button"> <span><i
                                    class="fa fa-print"></i> Print</span> </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    function formatNumber($number){
        return number_format($number,2,'.',',');
    }
?>

@section('other_scripts')

@endsection
