<div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                <h3 class="box-title m-b-0">Create Administrator Account</h3>
<hr>
                <form class="form-horizontal" autocomplete="off" id="register-admin">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>First-Name </label>
                        <div class="col-md-12">
                            <input type="text" required name="firstname" maxlength="25" class="form-control" placeholder="Your First Name"> </div>
                    </div>

                    <div class="form-group">
                            <label>Last-Name </label>
                            <div class="col-md-12">
                                <input type="text" required name="lastname" maxlength="25" class="form-control" placeholder="Your Last Name"> </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12" for="example-email">Username </label>
                        <div class="col-md-12">
                            <input type="text" required name="username" maxlength="25" class="form-control" placeholder="Your Username"> </div>
                    </div>

                    <div class="form-group">
                            <label class="col-md-12" for="example-email">Email</label>
                            <div class="col-md-12">
                                <input type="email" required name="email" class="form-control" placeholder="Your Email Address"> </div>
                    </div>

                    <div class="form-group">
                            <label class="col-md-12" for="example-email">Phone </label>
                            <div class="col-md-12">
                                <input type="text" required name="phone" maxlength="25" class="form-control" placeholder="Your Phone Number"> </div>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <div class="col-md-12">
                            <input type="password" required class="form-control" name="password"> </div>
                    </div>


                        <button class="btn btn-success btn-md" type="submit" id="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>

@section('other_scripts')
<script src="{{url('assets/administrator/js/register.js')}}"></script>

@endsection
