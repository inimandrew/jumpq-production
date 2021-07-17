@extends('main_site.includes.master')

@section('content')
<meta name="product" content="{{$product_id}}">
@include('main_site.includes.breadcrumb')

<section class="single_product_details_area section_padding_100">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="single_product_thumb">
                    <div id="product_details_slider" class="carousel slide" data-ride="carousel">

                        <div class="carousel-inner">

                        </div>

                        <!-- Carosel Indicators -->
                        <ol class="carousel-indicators">
                        </ol>
                    </div>
                </div>
            </div>

            <!-- Single Product Description -->
            <div class="col-12 col-lg-6">
                <div class="single_product_desc">
                    <h4 class="title mb-2"></h4>

                    <h4 class="price mb-4"></h4>

                    <!-- Overview -->
                    <div class="short_overview mb-4">
                        <h6>Overview</h6>
                        <p id="overview"></p>

                    </div>


                </div>
            </div>
        </div>
    </div>
</section>


@endsection
@section('other_scripts')
<script src="{{url('assets/main/js/product.js')}}"></script>
@endsection
