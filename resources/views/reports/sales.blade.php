<html>

<head>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            border-color: black;
            text-align: center;
        }

        th {
            padding: 10px 0;
            color: white;

        }

        td {
            padding: 10px 0;
        }

        .head {
            color: #2f5195;
            font-size: 1.5em;
            font-weight: bold;
        }

        p {
            font-weight: bold;
            text-transform: uppercase;
        }

        thead {
            border-color: white;
            color: white;
            background: #2f5195;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }
    </style>
</head>

<body>
    <div>
        <p class="head">SALES REPORT FROM {{date('d-M-Y',strtotime($start))}} to {{date('d-M-Y',strtotime($end))}} </p>
        <p>STORE NAME: {{Auth::guard('staff')->user()->branch->store->name}}</p>
        <p>BRANCH NAME: {{Auth::guard('staff')->user()->branch->name}}</p>
        <p>STAFF: {{Auth::guard('staff')->user()->firstname}} {{Auth::guard('staff')->user()->lastname}}</p>
        <p>CURRENCY: {{Auth::guard('staff')->user()->branch->currency->name}}</p>
        <p>DATE OF DOWNLOAD: {{ Carbon\Carbon::now() }}</p>

    </div>
    <table border="1">
        <thead>

            <tr style="color:black;text-transform:uppercase;font-weight:bold;">
                <th>#</th>
                <th>TRANSACTION DATE</th>
                <th>TRANSACTION ID</th>
                <th>ATTENDING STAFF</th>
                <th>BUYER'S NAME</th>
                <th>Buyer's Phone</th>
                <th>Cart</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php $total_profit = 0.00;$total = 0.00; $i = 1; ?>

            @foreach ($transactions as $transaction)
            <tr>
                <td>{{$i++}}</td>
                <td>{{$transaction->transaction_date}}</td>
                <td>{{$transaction->transaction_id}}</td>
                <td>{{$transaction->staff_name}}</td>
                <td>{{$transaction->payer->name}}</td>
                <td>{{$transaction->payer->phone}}</td>
                <td>
                    @foreach ($transaction->sales as $sale)
                    {{$sale->cart->product->name}}
                    ({{$sale->cart->price}} *
                    {{$sale->cart->quantity}}) =
                    {{$sale->cart->price * $sale->cart->quantity}} <br>
                    @endforeach
                </td>
                <td>{{formatNumber($transaction->total,2,'.',',')}}
                </td>
                <?php $total += $transaction->total;
                 $total_profit += calculateProfit($transaction->sales) ?>

            </tr>
            @endforeach
            <tr>
                <td colspan="6"></td>
                <td style="text-align: center;font-weight:bold;">TOTAL AMOUNT SOLD</td>
                <td>{{formatNumber($total, 2, '.', ',')}}
                </td>
            </tr>
            <tr>
                <td colspan="6"></td>
                <td style="text-align: center;font-weight:bold;">TOTAL PROFIT ACCUMULATED</td>
                <td>{{formatNumber($total_profit, 2, '.', ',')}}
                </td>
            </tr>
        </tbody>
    </table>
</body>
<?php
        function calculateProfit($sales){
            $profit = 0.00;
            foreach ($sales as $sale) {
                $profit += ( ($sale->cart->price - $sale->cart->cost_price) * $sale->cart->quantity );
            }
            return $profit;
        }

        function formatNumber($number){
            return number_format($number,2,'.',',');
}
    ?>

</html>
