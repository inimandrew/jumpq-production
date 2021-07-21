@extends('main_site.includes.master')
@section('other_styles')
<link href="{{url('assets/administrator/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{url('assets/main/dist/css/dropify.min.css')}}">
@endsection
@section('content')
    @include('main_site.includes.breadcrumb')

        <section class="my-account-area section_padding_100_50">
            <div class="container">
                <div class="row">
                @include('main_site.includes.sidenav')

                    <div class="col-12 col-lg-9">
                        <div class="my-account-content mb-50">
                            <h5 class="mb-3">Account Details</h5>

                            <form autocomplete="off" method="POST" id="update-profile">
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="firstName">First Name </label>
                                            <input type="text" class="form-control" name="firstname" value="{{Auth::user()->firstname}}">
                                        </div>
                                        {{ csrf_field() }}
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="lastName">Last Name </label>
                                            <input type="text" class="form-control" name="lastname" value="{{Auth::user()->lastname}}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="firstName">Email Address </label>
                                            <input type="text" class="form-control" disabled value="{{Auth::user()->email}}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="lastName">Username</label>
                                            <input type="text" disabled class="form-control" name="username" value="{{Auth::user()->username}}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="lastName">Phone *</label>
                                            <input type="text" class="form-control" name="phone" value="{{Auth::user()->phone}}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="lastName">Birthday</label>
                                            <input type="text" class="form-control mydatepicker" name="birthday" value="{{Auth::user()->birthday}}" >
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="newPass">New Password (Leave blank to leave unchanged)</label>
                                            <input type="password" class="form-control" name="password">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="confirmPass">Confirm New Password</label>
                                            <input type="password" class="form-control" name="password_confirmation">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                    <div class="form-group">
                                        <label>Profile Image</label>
                                        <div class="col-md-12">
                                            <input type="file" id="photo"  name="photo" data-allowed-file-extensions="jpg png" data-max-file-size="2M" class="form-control dropify form-control-line"> </div>
                                    </div>
                                    </div>

                                    <div class="col-12">
                                        <button id="update" type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@section('other_scripts')
<script src="{{url('assets/administrator/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
<script src="{{url('assets/main/dist/js/dropify.min.js')}}"></script>
<script src="{{url('assets/users/js/profile.js')}}"></script>
<script>
        jQuery('.mydatepicker, #datepicker').datepicker({ format: 'yyyy-mm-dd' });

        jQuery('#datepicker-autoclose').datepicker({
            autoclose: true
            , todayHighlight: true
        });

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
@endsection
