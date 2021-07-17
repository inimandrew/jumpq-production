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
                                <th>Config Type</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <?php $i = 1; ?>
                        <tbody style="text-align:left;color:black;">
                            @if(Auth::guard('staff')->user()->branch->config->count())
                            @foreach (Auth::guard('staff')->user()->branch->config as $configuration)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$configuration->type}}</td>
                                <td>{{returnValue($configuration->value)}}</td>
                            </tr>
                                @endforeach
                                @endif

                        </tbody>

                    </table>
                    <button type="button" style="margin-top:20px;margin-bottom:20px;" class="btn btn-info"
                        data-toggle="modal" data-target="#exampleModal">Update Config</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php
    function returnValue($value){
        if(empty($value)){
            $result = 'Not Set';
        }else{
            $result = $value;
        }
        return $result;
    }
?>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel1">Edit Configurations</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('config_update')}}" id="config_update" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="text" name="paystack" class="form-control" placeholder="Enter Paystack Production Secret Token" required> </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" form="config_update" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>
