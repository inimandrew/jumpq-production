<link href="{{url('assets/administrator/plugins/bower_components/bootstrap-select/bootstrap-select.min.css')}}"
    rel="stylesheet" />
<link href="{{url('assets/administrator/plugins/bower_components/custom-select/custom-select.css')}}" rel="stylesheet"
    type="text/css" />

<div class="row">
    <div class="col-sm-12">
        <div class="white-box">

            <h3 class="box-title m-b-0">Create New Branch</h3>
            <hr>
            <form class="form-horizontal" autocomplete="off" id="create-branch">
                {{ csrf_field() }}
                <div class="form-group col-lg-12">
                    <label class="col-md-12">Parent Organisation </label>
                    <div class="col-md-12">
                        <select name="parent" class="form-control select2-container select2" required>
                            <option value="">Select an Organisation</option>
                            @foreach ($data['stores'] as $store)
                            <option value="{{$store->id}}">{{$store->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>



                <fieldset class="col-md-12">
                    <legend style="color:black;font-weight:500;padding-bottom:10px;text-transform:uppercase;">Branch
                        Information</legend>

                    <div class="form-group col-lg-6">
                        <label class="col-md-12">Type of Store</label>
                        <div class="col-md-12">
                            <select name="store_type" class="form-control">
                                @foreach ($data['store_types'] as $store_type)
                                <option value="{{$store_type->id}}">{{$store_type->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-lg-6">
                        <label class="col-md-12">Branch Name </label>
                        <div class="col-md-12">
                            <input type="text" required name="branch_name" class="form-control"
                                placeholder="Branch Name"> </div>
                    </div>


                    <div class="form-group col-lg-6">
                        <label class="col-md-12">Branch Phone </label>
                        <div class="col-md-12">
                            <input type="text" required name="branch_phone" maxlength="20" class="form-control"
                                placeholder="Branch Phone Number"> </div>
                    </div>

                    <div class="form-group col-lg-6">
                        <label class="col-md-12">Branch Address </label>
                        <div class="col-md-12">
                            <input type="text" required name="branch_address" class="form-control"
                                placeholder="Branch Address"> </div>
                    </div>
                    <div class="form-group col-lg-6">
                        <label>Country </label>
                        <div class="col-md-12">
                            <input type="text" required name="country" class="form-control" placeholder="Country">
                        </div>
                    </div>

                    <div class="form-group col-lg-6">
                        <label>State </label>
                        <div class="col-md-12">
                            <input type="text" required name="state" class="form-control" placeholder="State"> </div>
                    </div>
                </fieldset>


                <fieldset class="col-md-12">
                    <legend style="color:black;font-weight:500;padding-bottom:10px;text-transform:uppercase;">
                        Administrator Account Information</legend>

                    <div class="form-group col-lg-6 ">
                        <label class="col-md-12">First Name </label>
                        <div class="col-md-12">
                            <input type="text" required name="admin_firstname" maxlength="25" class="form-control"
                                placeholder="Admin First-Name"> </div>
                    </div>

                    <div class="form-group col-lg-6">
                        <label class="col-md-12">Last Name </label>
                        <div class="col-md-12">
                            <input type="text" required name="admin_lastname" maxlength="25" class="form-control"
                                placeholder="Admin Last-Name"> </div>
                    </div>

                    <div class="form-group col-lg-6">
                        <label class="col-md-12">Email </label>
                        <div class="col-md-12">
                            <input type="email" required name="admin_email" class="form-control"
                                placeholder="Admin Email"> </div>
                    </div>

                    <div class="form-group col-lg-6">
                        <label class="col-md-12">Username </label>
                        <div class="col-md-12">
                            <input type="text" required name="admin_username" maxlength="25" class="form-control"
                                placeholder="Admin Username"> </div>
                    </div>

                    <div class="form-group col-lg-6">
                        <label class="col-md-12">Phone </label>
                        <div class="col-md-12">
                            <input type="text" required name="admin_phone" maxlength="25" class="form-control"
                                placeholder="Admin Phone Number"> </div>
                    </div>

                    <div class="form-group col-lg-6">
                        <label>Currency </label>
                        <div class="col-md-12">
                            <select required name="currency" id="currency" class="form-control">

                            </select> </div>
                    </div>

                    <div class="form-group col-lg-6">
                        <label class="col-md-12">Password </label>
                        <div class="col-md-12">
                            <input type="password" required name="password" class="form-control" placeholder="Password">
                        </div>
                    </div>

                    <div class="form-group col-lg-6">
                        <label class="col-md-12">Confirm Password </label>
                        <div class="col-md-12">
                            <input type="password" required name="password_confirmation" class="form-control"
                                placeholder="Confirm Password"> </div>
                    </div>

                </fieldset>



                <button class="btn btn-success btn-md" type="submit" id="submit">Submit</button>
            </form>
        </div>
    </div>
</div>

@section('other_scripts')
<script src="{{url('assets/administrator/js/new_branch.js')}}"></script>
<script src="{{url('assets/administrator/plugins/bower_components/bootstrap-select/bootstrap-select.min.js')}}"
    type="text/javascript"></script>
<script src="{{url('assets/administrator/plugins/bower_components/custom-select/custom-select.min.js')}}"></script>
<script>
    jQuery(document).ready(function () {
        $(".select2").select2();
        $('.selectpicker').selectpicker();

    });
</script>
@endsection
