<html>
<head>
    <style>
        table{
            border-collapse: collapse;
            width: 100%;
            border-color: black;
            text-align: center;
        }
        th{
            padding: 10px 0;
            color: white;
        }
        td{
            padding: 10px 0;
        }
        .head{
            color: #2f5195;
            font-size: 1.5em;
            font-weight: bold;
        }

        p{
            font-weight: bold;
            text-transform: uppercase;
        }
        thead{
            border-color: white;
            color: white;
            background: #2f5195;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }
    </style>
</head>
<body>
    <div>
        <p class="head">Stock Availabilty Report  </p>
        <p>STORE NAME: {{Auth::guard('staff')->user()->branch->store->name}}</p>
        <p>BRANCH NAME: {{Auth::guard('staff')->user()->branch->name}}</p>
        <p>STAFF: {{Auth::guard('staff')->user()->firstname}} {{Auth::guard('staff')->user()->lastname}}</p>
        <p>DATE OF DOWNLOAD: {{ Carbon\Carbon::now() }} </p>

    </div>
    <table border="1">
        <thead>
            <tr>
                <th>ITEM CODE</th>
                <th>ITEM NAME</th>
                <th>AVAILABLE STOCK</th>
                <th>CATEGORY</th>
                <th>SELLING PRICE</th>
                <th>COST PRICE</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{$product->id}}</td>
                <td>{{$product->name}}</td>
                <td>@if($product->product_type == '1')
                    {{$product->quantity}}
                    @else
                    {{$product->tags()->wherePivot('status', '0')->count()}}
                    @endif
                </td>
                <td>{{$product->category->name}}</td>
                <td>{{$product->branch->currency->symbol}}{{number_format($product->unit_price, 2, '.', ',')}}</td>
                <td>{{$product->branch->currency->symbol}}{{number_format($product->cost_price, 2, '.', ',')}}</td>
            </tr>

            @endforeach
        </tbody>
    </table>
</body>

</html>
