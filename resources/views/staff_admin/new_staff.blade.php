<link href="{{url('assets/administrator/plugins/bower_components/bootstrap-select/bootstrap-select.min.css')}}" rel="stylesheet" />
<link href="{{url('assets/administrator/plugins/bower_components/custom-select/custom-select.css')}}" rel="stylesheet" type="text/css" />

<div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                <h3 class="box-title m-b-0">Create New Staff Account</h3>
<hr>
                <form class="form-horizontal" autocomplete="off" id="create-branch">
                    {{ csrf_field() }}
                    <div class="form-group col-lg-12">
                        <label>Store Branches </label>
                        <div class="col-md-12">
                            <select name="branch" class="form-control select2-container select2" required>
                                <option value="">Select a Branch</option>
                                @foreach ($data['branches'] as $branch)
                                    <option value="{{$branch->id}}">{{$branch->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <fieldset class="col-md-12">
                        <legend style="color:black;font-weight:500;padding-bottom:10px;text-transform:uppercase;">Staff Account Information</legend>

                        <div class="form-group col-lg-6 ">
                            <label>First Name </label>
                            <div class="col-md-12">
                                <input type="text" required name="admin_firstname" maxlength="25" class="form-control" placeholder="Admin First-Name"> </div>
                    </div>

                    <div class="form-group col-lg-6">
                        <label>Last Name </label>
                        <div class="col-md-12">
                            <input type="text" required name="admin_lastname" maxlength="25" class="form-control" placeholder="Admin Last-Name"> </div>
                </div>

                <div class="form-group col-lg-6">
                    <label>Email </label>
                    <div class="col-md-12">
                        <input type="email" required name="admin_email" class="form-control" placeholder="Admin Email"> </div>
            </div>

                <div class="form-group col-lg-6">
                    <label>Username </label>
                    <div class="col-md-12">
                        <input type="text" required name="admin_username" maxlength="25" class="form-control" placeholder="Admin Username"> </div>
            </div>

                <div class="form-group col-lg-6">
                    <label>Phone </label>
                    <div class="col-md-12">
                        <input type="text" required name="admin_phone" maxlength="25" class="form-control" placeholder="Admin Phone Number"> </div>
                </div>

                <div class="form-group col-lg-6">
                    <label>Staff Role </label>
                    <div class="col-md-12">
                        <select name="role" required class="form-control">
                            <option value="">Select a Role</option>
                            @foreach ($data['roles'] as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                        </select> </div>
                </div>

                <div class="form-group col-lg-6">
                    <label>Password </label>
                    <div class="col-md-12">
                        <input type="password" required name="password"  class="form-control" placeholder="Password"> </div>
                </div>

                <div class="form-group col-lg-6">
                        <label>Confirm Password </label>
                        <div class="col-md-12">
                            <input type="password" required name="password_confirmation"  class="form-control" placeholder="Confirm Password"> </div>
                    </div>

                    </fieldset>



                        <button class="btn btn-success btn-md" type="submit" id="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>


@section('other_scripts')
<script src="{{url('assets/administrator/js/new_staff.js')}}"></script>
<script src="{{url('assets/administrator/plugins/bower_components/bootstrap-select/bootstrap-select.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/administrator/plugins/bower_components/custom-select/custom-select.min.js')}}"></script>
<script>
    jQuery(document).ready(function () {
        $(".select2").select2();
        $('.selectpicker').selectpicker();

    });
</script>
@endsection
