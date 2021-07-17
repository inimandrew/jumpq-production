@extends('main_site.includes.master')
@section('other_styles')
<link href="{{url('assets/administrator/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css')}}"
    rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{url('assets/main/dist/css/dropify.min.css')}}">
@endsection
@section('content')
@include('main_site.includes.breadcrumb')

<section class="my-account-area section_padding_100_50">
    <style>
        .form-control {
            width: 100%;
            padding: 2px 10px;
            border: 1px solid #d6e6fb;
        }

        .form-control:focus {
            outline: none;
            border-color: black;
        }

        .list {
            width: 100%;
        }

        .list li {
            width: 100%;
        }

        label {
            font-weight: 500;
            color: black;
        }
    </style>
    <div class="container">
        <div class="row">
            @include('main_site.includes.sidenav')


            <div class="col-12 col-lg-9">
                <div class="mb-50">
                    <h5 class="mb-3">Create Campaign</h5>

                    <form enctype="multipart/form-data" autocomplete="off" method="POST" autocomplete="off"
                        action="{{route('create-ads-campaign-action')}}">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="firstName">Campaign Name </label>
                                    <input type="text" class="form-control" name="title" value="{{old('title')}}"
                                        required>
                                </div>

                            </div>
                            {{ csrf_field() }}
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="lastName">Select a Plan </label>
                                    <select class="form-control text-capitalize" name="plan_id" required>
                                        <option value="">Select a Plan</option>
                                        @foreach ($plans as $plan)
                                        <option data-price="{{$plan->price}}" value="{{$plan->id}}">{{$plan->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="lastName">Description</label>
                                    <textarea class="form-control" rows="5" name="description" placeholder="Type a Description"
                                         required>{{old('description')}}</textarea>
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="lastName">Start Date</label>
                                    <input type="date" min="{{date('Y/m/d',time())}}" class="form-control" name="start_date"
                                        value="{{old('start_date')}}" required>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="lastName">End Date</label>
                                    <input min="{{date('Y/m/d',time())}}" type="date" class="form-control" name="end_date" required
                                        value="{{old('end_date')}}">
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="lastName">Asset Type for Campaign </label>
                                    <select class="form-control text-capitalize" name="asset_type_id" required>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="lastName">Payment Service</label>
                                    <select class="form-control text-capitalize" name="payment_type_id" required>
                                        @foreach ($payment_types as $payment)
                                        <option value="{{$payment->id}}">{{$payment->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="firstName">Asset Selection </label>
                                    <input accept="image/*"  type="file" name="asset" required
                                        class="form-control dropify form-control-line" data-allowed-size="5M">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="firstName">WebPage Redirect Link </label>
                                    <input type="url" class="form-control" name="url_link" value="{{old('url_link')}}"
                                        required>
                                </div>

                            </div>
                            <input type="hidden" name="amount">
                            <div class="col-12 col-lg-5 offset-lg-7">
                                <div class="cart-total-area mb-30">
                                    <h5 class="mb-3">Cart Total</h5>
                                    <div class="table-responsive">
                                        <table class="table mb-3">
                                            <tbody>
                                                <tr>
                                                    <td>Total Amount (₦)</td>
                                                    <td id="total"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button id="submit" type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</section>
@endsection

@section('other_scripts')
<script src="{{url('assets/ads/js/campaign.js')}}"></script>
<script src="{{url('assets/administrator/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js')}}">
</script>
<script src="{{url('assets/main/dist/js/dropify.min.js')}}"></script>
<script>
    // jQuery('.mydatepicker, #datepicker').datepicker({ format: 'yyyy/mm/dd' });

    //     jQuery('#datepicker-autoclose').datepicker({
    //         autoclose: true
    //         , todayHighlight: true
    //     });

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
