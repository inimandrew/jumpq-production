<link href="{{url('assets/administrator/plugins/bower_components/bootstrap-select/bootstrap-select.min.css')}}"
    rel="stylesheet" />
<link href="{{url('assets/administrator/plugins/bower_components/custom-select/custom-select.css')}}" rel="stylesheet"
    type="text/css" />
<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <h3 class="box-title">Plans</h3>
            <div class="scrollable">
                <div class="table-responsive">
                    <table style="text-align: center;"
                        class="table m-t-30 table-hover table-bordered contact-list color-table dark-table">
                        <thead>
                            <tr style="color:black;text-transform:uppercase;font-weight:bold;">
                                <th class="text-center">#</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Daily Counts</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Allowed Assets Types</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            @foreach ($data['plans'] as $plan)
                            <tr>
                                <td>{{++$i}}</td>
                                <td class="text-capitalize">{{$plan->name}}</td>
                                <td>{{$plan->price}}</td>
                                <td>{{$plan->daily_counts}}</td>
                                <td>
                                    @if ($plan->status == '0')
                                    <span class=" badge badge-info">Inactive</span>
                                    @else
                                    <span class="badge badge-success">Active</span>
                                    @endif
                                </td>
                                <td>
                                    <?php $assets = '' ?>

                                    @foreach ($plan->assets_allowed as $allowed)
                                    <?php $assets .= $allowed->type.', '?>
                                    @endforeach
                                    {{Str::replaceFirst(',', ' or ',Str::replaceLast(',', '.', $assets))}}
                                </td>
                                <td>
                                    @if ($plan->status == '0')
                                    <a title="Activate Plan" href="{{route('toggle-status',[$plan->id,'1'])}}"
                                        class="btn btn-success btn-outline btn-circle btn-lg m-r-5"><i
                                            class="fa fa-chain-broken"></i></a>
                                    @else
                                    <a title="Deactivate Plan" href="{{route('toggle-status',[$plan->id,'0'])}}"
                                        class="btn btn-warning btn-outline btn-circle btn-lg m-r-5"><i
                                            class="fa fa-power-off"></i></a>
                                    @endif
                                    {{-- <a title="Delete Plan" href="#" class="btn btn-danger btn-outline btn-circle btn-lg m-r-5"><i
                                            class="ti-trash"></i></a> --}}
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="white-box">

            <h3 class="box-title m-b-0">Create Plan</h3>
            <hr>
            <form class="form-horizontal" method="POST" action="{{route('create-plan')}}" autocomplete="off">
                {{ csrf_field() }}
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Plan Name </label>
                        <input type="text" name="name" class="form-control" required value="{{old('name')}}"> </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Daily Count </label>
                        <input type="number" name="daily_counts" class="form-control" required
                            value="{{old('daily_counts')}}"> </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="example-email">Daily Price </label>
                        <input type="number" name="price" class="form-control" required value="{{old('price')}}"> </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="example-email">Allowed Assets</label>
                        <select name="assets[]" class="form-control select2" multiple required
                            value="{{old('assets[]')}}">
                            @foreach ($data['assets'] as $asset)
                            <option value="{{$asset->id}}">{{$asset->type}}</option>
                            @endforeach

                        </select> </div>
                </div>


                <button class="btn btn-success btn-md" type="submit" id="submit">Submit</button>
            </form>
        </div>
    </div>
</div>
@section('other_scripts')
<script src="{{url('assets/administrator/plugins/bower_components/bootstrap-select/bootstrap-select.min.js')}}"
    type="text/javascript"></script>
<script src="{{url('assets/administrator/plugins/bower_components/custom-select/custom-select.min.js')}}"></script>
<script>
    jQuery(document).ready(function () {
        $(".select2").select2({placeholder: 'Select Allowed Assets'});
        $('.selectpicker').selectpicker();

    });
</script>
@endsection
