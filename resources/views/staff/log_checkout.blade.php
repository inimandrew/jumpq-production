<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <div class="scrollable">
                <div class="table-responsive">
                    <table id="demo-foo-addrow"
                        class="table m-t-30 table-hover contact-list color-table dark-table table-bordered"
                        data-page-size="10">
                        <thead>
                            <tr style="color:black;text-transform:uppercase;font-weight:bold;">
                                <th>#</th>
                                <th>CHECK-IN DATE</th>
                                <th>CHECK-OUT DATE</th>
                                <th>RFID CODE</th>
                                <th>PRODUCT NAME</th>
                            </tr>
                        </thead>
                        <?php $i = 1; ?>
                        <tbody style="text-align:left;color:black;">
                            @foreach ($data['tags'] as $tag)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$tag->batch->created_at}}</td>
                                <td>{{$tag->product_tag->carted->cart->sales->payment->created_at}}</td>
                                <td>{{$tag->rfid}}</td>
                                <td>{{$tag->product_tag->product->name}}</td>
                            @endforeach

                        </tbody>

                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
