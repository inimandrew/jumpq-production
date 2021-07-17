<div class="breadcumb_area">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <h5>{{$title}}</h5>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('user_home')}}">Home</a></li>
                    <li class="breadcrumb-item active">{{$title}}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="offset-md-3 col-md-6">
    @include('includes.error')

</div>
<!-- Breadcumb Area -->
