@extends('main_site.includes.master')

@section('content')


@include('main_site.includes.breadcrumb')

<section class="about_us_area section_padding_100">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-lg-6">
                <div class="about_us_content pb-5 pb-lg-0">
                    <div class="row">
                        <div class="col-6">
                            <img src="img/gallery/1.png" alt="">
                        </div>
                        <div class="col-6">
                            <img src="img/gallery/2.png" alt="">
                        </div>
                        <div class="col-6">
                            <img src="img/gallery/3.png" alt="">
                        </div>
                        <div class="col-6">
                            <img src="img/gallery/4.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="about_us_content pl-0 pl-lg-5">
                    <h5>{{config('app.name')}} is a company built to bring security to retail shop outlets</h5>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione quibusdam saepe alias dignissimos consequatur ullam expedita voluptas commodi veritatis repellendus nostrum, tempore, ducimus architecto iure.</p>
                    <a href="#" class="btn btn-primary mt-30">Learn More</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- About Us Area -->

<!-- Features Area -->
    <!--==========================
      About Us Section
    ============================-->
    <section id="about">
        <div class="container">

          <header class="section-header">
            <h3>About Us</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
          </header>

          <div class="row about-cols" style="margin-top:50px;">

            <div class="col-md-6 wow fadeInUp">
              <div class="about-col">
                <div class="img">
                  <img src="img/about-mission.jpg" alt="" class="img-fluid">
                  <div class="icon"><i class="icofont-ebook"></i></div>
                </div>
                <h2 class="title"><a href="#">Our Mission</a></h2>
                <p>
                  Lorem ipsum dolor sit amet, consectetur elit, sed do eiusmod tempor ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </p>
              </div>
            </div>


            <div class="col-md-6 wow fadeInUp" data-wow-delay="0.2s">
              <div class="about-col">
                <div class="img">
                  <img src="img/about-vision.jpg" alt="" class="img-fluid">
                  <div class="icon"><i class="icofont-list"></i></div>
                </div>
                <h2 class="title"><a href="#">Our Vision</a></h2>
                <p>
                    To Make Shopping, Retailing and Warehouse Management as easy and secure as possible.
                </p>
              </div>
            </div>

          </div>

        </div>
      </section><!-- #about -->
      <section id="team">
        <div class="container">
          <div class="section-header wow fadeInUp">
            <h3>Team</h3>
            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque</p>
          </div>

          <div class="row">

            <div class="col-lg-3 col-md-6 wow fadeInUp">
              <div class="member">
                <img src="{{url('general_assets/team-1.jpg')}}" class="img-fluid" alt="">
                <div class="member-info">
                  <div class="member-info-content">
                    <h4>Walter White</h4>
                    <span>Chief Executive Officer</span>
                    <div class="social">
                      <a href=""><i class="fa fa-twitter"></i></a>
                      <a href=""><i class="fa fa-facebook"></i></a>
                      <a href=""><i class="fa fa-google-plus"></i></a>
                      <a href=""><i class="fa fa-linkedin"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
              <div class="member">
                <img src="{{url('general_assets/team-1.jpg')}}" class="img-fluid" alt="">
                <div class="member-info">
                  <div class="member-info-content">
                    <h4>Sarah Jhonson</h4>
                    <span>Product Manager</span>
                    <div class="social">
                      <a href=""><i class="fa fa-twitter"></i></a>
                      <a href=""><i class="fa fa-facebook"></i></a>
                      <a href=""><i class="fa fa-google-plus"></i></a>
                      <a href=""><i class="fa fa-linkedin"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
              <div class="member">
                <img src="{{url('general_assets/team-1.jpg')}}" class="img-fluid" alt="">
                <div class="member-info">
                  <div class="member-info-content">
                    <h4>William Anderson</h4>
                    <span>CTO</span>
                    <div class="social">
                      <a href=""><i class="fa fa-twitter"></i></a>
                      <a href=""><i class="fa fa-facebook"></i></a>
                      <a href=""><i class="fa fa-google-plus"></i></a>
                      <a href=""><i class="fa fa-linkedin"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
              <div class="member">
                <img src="{{url('general_assets/team-1.jpg')}}" class="img-fluid" alt="">
                <div class="member-info">
                  <div class="member-info-content">
                    <h4>Amanda Jepson</h4>
                    <span>Accountant</span>
                    <div class="social">
                      <a href=""><i class="fa fa-twitter"></i></a>
                      <a href=""><i class="fa fa-facebook"></i></a>
                      <a href=""><i class="fa fa-google-plus"></i></a>
                      <a href=""><i class="fa fa-linkedin"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>

        </div>
      </section>
<!-- Cool Facts Area -->
<section class="about_us_one cool_facts_area section_padding_100_70 bg-overlay jarallax" style="background-image: url(img/bg-img/deals.jpg);">
    <div class="container">
        <div class="row">
            <!-- Single Cool Facts -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="cool_fact_text text-center wow fadeInUp" data-wow-delay="0.2s">
                    <h2><span class="counter">2</span>+</h2>
                    <h5>Years of experience</h5>
                </div>
            </div>
            <!-- Single Cool Facts -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="cool_fact_text text-center wow fadeInUp" data-wow-delay="0.4s">
                    <h2><span class="counter">3350</span>+</h2>
                    <h5>Happy Customer</h5>
                </div>
            </div>
            <!-- Single Cool Facts -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="cool_fact_text text-center wow fadeInUp" data-wow-delay="0.6s">
                    <h2><span class="counter">7815</span>+</h2>
                    <h5>Team Advisor</h5>
                </div>
            </div>
            <!-- Single Cool Facts -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="cool_fact_text text-center wow fadeInUp" data-wow-delay="0.8s">
                    <h2><span class="counter">70</span>%</h2>
                    <h5>Return Customer</h5>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Cool Facts Area End -->

<!-- Testimonial Area -->
<section class="testimonials_area bg-gray section_padding_100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-6">
                <div class="popular_section_heading mb-50 text-center">
                    <h5 class="mb-3">Few Words from Clients</h5>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur saepe labore adipisci assumenda molestiae, omnis, quod ipsa facere praesentium.</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="testimonials_slides owl-carousel">
                    <div class="single_tes_slide text-center">
                        <img src="img/partner-img/tes-1.png" alt="">
                        <h6>Bigshop is smart &amp; elegant e-commerce HTML5 Template. <br> It's suitable for all e-commerce business platform.</h6>
                        <p>Emm Sarah</p>
                        <span>Support Manager</span>
                    </div>

                    <div class="single_tes_slide text-center">
                        <img src="img/partner-img/tes-2.png" alt="">
                        <h6>Bigshop is smart &amp; elegant e-commerce HTML5 Template. <br> It's suitable for all e-commerce business platform.</h6>
                        <p>Nazrul Islam</p>
                        <span>Support Manager</span>
                    </div>

                    <div class="single_tes_slide text-center">
                        <img src="img/partner-img/tes-3.png" alt="">
                        <h6>Bigshop is smart &amp; elegant e-commerce HTML5 Template. <br> It's suitable for all e-commerce business platform.</h6>
                        <p>Justin Align</p>
                        <span>Support Manager</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Testimonial Area End -->


<!-- Message Now Area -->
@endsection
