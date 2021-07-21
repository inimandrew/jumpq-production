@extends('main_site.includes.master')

@section('content')
<meta name="branch" content="{{$branch_id}}">
@include('main_site.includes.breadcrumb')

<section class="shop_list_area section_padding_100">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-4 col-xl-3">
                    <div class="shop_sidebar_area">
                        <!-- Single Widget -->
                        <div class="widget catagory mb-30">
                            <h6 class="widget-title">Product Categories</h6>
                            <div class="widget-desc">
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-12 col-md-8 col-xl-9">

                    <div class="shop_grid_product_area">
                        <div class="row justify-content-center" id="product_content">

                        </div>
                    </div>

                    <!-- Shop Pagination Area -->
                    <div class="shop_pagination_area mt-30">
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-sm justify-content-center" id="pagination">

                            </ul>
                        </nav>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

@section('other_scripts')
<script src="{{url('assets/main/js/products.js')}}"></script>

@endsection
