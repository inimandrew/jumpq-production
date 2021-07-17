@extends('main_site.includes.master')

@section('content')

<div class="shortcodes_area section_padding_100" style="margin-bottom:20px;">
    <div class="container">
        <!-- Shortcodes Content -->
        <div class="row">
            <div class="col-12">
                <!-- Shortcodes Title -->
                <div class="shortcodes_title mb-30">
                    <h5 style="color: black;font-weight:bold;">OUR STORES</h5>
                </div>

                <!-- +++++++++++++++++++++++
                Bigshop Accordian With Icon
                +++++++++++++++++++++++ -->
                <div class="shortcodes_content mb-100">
                    <div class="accordion bigshop-accordian-with-icon" id="bigshopAccordianIcon">
                        @foreach ($stores as $store)
                        <div class="card">
                            <div class="card-header" id="bigshopWithIconAccordian{{$store->id}}">
                                <button class="btn collapsed" type="button" data-toggle="collapse"
                                    data-target="#bswicollapseThree" aria-expanded="false"
                                    aria-controls="bswicollapseThree">
                                    <i class="icofont-rounded-up"></i><i class="icofont-rounded-down"></i>
                                    {{$store->name}}
                                </button>
                            </div>
                            <div id="bswicollapseThree" class="collapse"
                                aria-labelledby="bigshopWithIconAccordian{{$store->id}}"
                                data-parent="#bigshopAccordianIcon">
                                @foreach ($store->branches as $branch)

                                <div class="card-body">
                                    <p class="mb-4">
                                        <div class="col-lg-12 pull-left text-uppercase">
                                            BRANCH NAME: <span style="font-weight: bold">{{$branch->name}}</span>
                                        </div>
                                        <div class="col-lg-6 pull-left">
                                            ADDRESS: {{$branch->address}} {{$branch->state}}, {{$branch->country}}.
                                        </div>
                                        <div class="col-lg-6 pull-right">
                                            <a href="{{route('branch_product_main',encrypt($branch->id))}}"
                                                class="btn btn-dark mb-1 ">View Products</a>
                                        </div>

                                    </p>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-lg-4 col-lg-offset-4">
                    {{$stores->links()}}
                </div>





            </div>
        </div>
    </div>
</div>
@endsection
