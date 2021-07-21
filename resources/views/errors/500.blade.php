@extends('main_site.includes.master')

@section('content')
<section class="error_page text-center section_padding_100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-6">
                <div class="not-found-text">
                    <h2>500</h2>
                    <h5 class="mb-3">Internal Server Error</h5>
                    <a href="{{url('/')}}" class="btn btn-primary mt-3"><i class="fa fa-home" aria-hidden="true"></i> GO HOME</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection




