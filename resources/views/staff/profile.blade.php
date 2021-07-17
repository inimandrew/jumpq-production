<link rel="stylesheet" href="{{url('assets/main/dist/css/dropify.min.css')}}">

<div class="row">
    <div class="col-md-4 col-xs-12">
        <div class="white-box">
            <div class="user-bg">
                <div class="overlay-box">
                    <div class="user-content">

                        <a href="javascript:void(0)"><img
                                src="{{route('profile_pic',Auth::guard('staff')->user()->profile_image_location)}}"
                                class="thumb-lg img-circle" alt="img"></a>


                        <h4 class="text-white">User Name</h4>
                        <h5 class="text-white">{{Auth::guard('staff')->user()->username}}</h5>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="col-md-8 col-xs-12">

        <div class="white-box">
            <ul class="nav nav-tabs tabs customtab">

                <li class="tab active">
                    <a href="#profile" data-toggle="tab"> <span class="visible-xs"><i class="fa fa-user"></i></span>
                        <span class="hidden-xs">Profile</span> </a>
                </li>

                <li class="tab">
                    <a href="#settings" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i
                                class="fa fa-cog"></i></span> <span class="hidden-xs">Settings</span> </a>
                </li>
            </ul>
            <div class="tab-content">

                <div class="tab-pane active" id="profile">
                    <div class="row">
                        <div class="col-md-3 col-xs-6 b-r"> <strong>Full Name</strong>
                            <br>
                            <p class="text-muted">{{Auth::guard('staff')->user()->firstname}}
                                {{Auth::guard('staff')->user()->lastname}}</p>
                        </div>
                        <div class="col-md-3 col-xs-6 b-r"> <strong>Mobile</strong>
                            <br>
                            <p class="text-muted">{{Auth::guard('staff')->user()->phone}}</p>
                        </div>
                        <div class="col-md-3 col-xs-6 b-r"> <strong>Email</strong>
                            <br>
                            <p class="text-muted">{{Auth::guard('staff')->user()->email}}</p>
                        </div>
                        <div class="col-md-3 col-xs-6"> <strong>Username</strong>
                            <br>
                            <p class="text-muted">{{Auth::guard('staff')->user()->username}}</p>
                        </div>
                    </div>
                    <hr>

                </div>

                <div class="tab-pane" id="settings">
                    <form class="form-horizontal form-material" autocomplete="off" id="update-profile" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>First-Name</label>
                            <div class="col-md-12">
                                <input type="text" name="firstname" value="{{Auth::guard('staff')->user()->firstname}}"
                                    class="form-control form-control-line"> </div>
                        </div>
                        <div class="form-group">
                            <label>Last-Name</label>
                            <div class="col-md-12">
                                <input type="text" name="lastname" value="{{Auth::guard('staff')->user()->lastname}}"
                                    class="form-control form-control-line"> </div>
                        </div>
                        <div class="form-group">
                            <label for="example-email" class="col-md-12">Username</label>
                            <div class="col-md-12">
                                <input type="text" disabled="disabled" name="username"
                                    value="{{Auth::guard('staff')->user()->username}}"
                                    class="form-control form-control-line" disabled> </div>
                        </div>

                        <div class="form-group">
                            <label for="example-email" class="col-md-12">Email</label>
                            <div class="col-md-12">
                                <input type="email" value="{{Auth::guard('staff')->user()->email}}"
                                    class="form-control form-control-line" disabled="disabled"> </div>
                        </div>
                        <div class="form-group">
                            <label for="example-email" class="col-md-12">Api Token</label>
                            <div class="col-md-12">
                                <input type="email" value="{{Auth::guard('staff')->user()->api_token}}"
                                    class="form-control form-control-line"> </div>
                        </div>

                        <div class="form-group">
                            <label>Phone No</label>
                            <div class="col-md-12">
                                <input type="text" name="phone" value="{{Auth::guard('staff')->user()->phone}}"
                                    class="form-control form-control-line"> </div>
                        </div>

                        <div class="form-group">
                            <label>New Password</label>
                            <div class="col-md-12">
                                <input type="password" name="password" class="form-control form-control-line"> </div>
                        </div>

                        <div class="form-group">
                            <label>Profile Image</label>
                            <div class="col-md-12">
                                <input type="file" id="photo" name="photo" data-allowed-file-extensions="jpg png jpeg"
                                    data-max-file-size="2M" class="form-control dropify form-control-line"> </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <button type="submit" id="update" class="btn btn-success">Update Profile</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('other_scripts')
<script src="{{url('assets/administrator/js/staff/profile.js')}}"></script>

<script src="{{url('assets/main/dist/js/dropify.min.js')}}"></script>
<script>
    $(document).ready(function(){
                // Basic
                $('.dropify').dropify();

                // Translated
                $('.dropify-fr').dropify({
                    messages: {
                        default: 'Glissez-déposez un fichier ici ou cliquez',
                        replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                        remove:  'Supprimer',
                        error:   'Désolé, le fichier trop volumineux'
                    }
                });

                // Used events
                var drEvent = $('#input-file-events').dropify();

                drEvent.on('dropify.beforeClear', function(event, element){
                    return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
                });

                drEvent.on('dropify.afterClear', function(event, element){
                    alert('File deleted');
                });

                drEvent.on('dropify.errors', function(event, element){
                    console.log('Has Errors');
                });

                var drDestroy = $('#input-file-to-destroy').dropify();
                drDestroy = drDestroy.data('dropify')
                $('#toggleDropify').on('click', function(e){
                    e.preventDefault();
                    if (drDestroy.isDropified()) {
                        drDestroy.destroy();
                    } else {
                        drDestroy.init();
                    }
                })
            });
</script>
@endsection
