@extends('frontend.layouts.master')
@section('content')
<!-- Start Schedule Area -->


<!-- Start Fun-facts -->
<div id="fun-facts" class="fun-facts section overlay">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Fun -->
                <div class="single-fun">
                    <i class="icofont icofont-home"></i>
                    <div class="content">
                        <span class="counter">3468</span>
                        <p>Hospital Rooms</p>
                    </div>
                </div>
                <!-- End Single Fun -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Fun -->
                <div class="single-fun">
                    <i class="icofont icofont-user-alt-3"></i>
                    <div class="content">
                        <span class="counter">557</span>
                        <p>Specialist Doctors</p>
                    </div>
                </div>
                <!-- End Single Fun -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Fun -->
                <div class="single-fun">
                    <i class="icofont-simple-smile"></i>
                    <div class="content">
                        <span class="counter">4379</span>
                        <p>Happy Patients</p>
                    </div>
                </div>
                <!-- End Single Fun -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Fun -->
                <div class="single-fun">
                    <i class="icofont icofont-table"></i>
                    <div class="content">
                        <span class="counter">32</span>
                        <p>Years of Experience</p>
                    </div>
                </div>
                <!-- End Single Fun -->
            </div>
        </div>
    </div>
</div>
<!--/ End Fun-facts -->

<!-- Start Call to action -->
<section class="call-action overlay" data-stellar-background-ratio="0.5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="content">
                    <h2>Do you need Emergency Medical Care? Call @ 1234 56789</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque porttitor dictum turpis nec gravida.</p>
                    <div class="button">
                        <a href="#" class="btn">Contact Now</a>
                        <a href="#" class="btn second">Learn More<i class="fa fa-long-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/ End Call to action -->


<!-- Start clients -->
<div class="clients overlay">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="owl-carousel clients-slider">
                    <div class="single-clients">
                        <img src="{{asset('/assets/frontend')}}/img/client1.png" alt="#">
                    </div>
                    <div class="single-clients">
                        <img src="{{asset('/assets/frontend')}}/img/client2.png" alt="#">
                    </div>
                    <div class="single-clients">
                        <img src="{{asset('/assets/frontend')}}/img/client3.png" alt="#">
                    </div>
                    <div class="single-clients">
                        <img src="{{asset('/assets/frontend')}}/img/client4.png" alt="#">
                    </div>
                    <div class="single-clients">
                        <img src="{{asset('/assets/frontend')}}/img/client5.png" alt="#">
                    </div>
                    <div class="single-clients">
                        <img src="{{asset('/assets/frontend')}}/img/client1.png" alt="#">
                    </div>
                    <div class="single-clients">
                        <img src="{{asset('/assets/frontend')}}/img/client2.png" alt="#">
                    </div>
                    <div class="single-clients">
                        <img src="{{asset('/assets/frontend')}}/img/client3.png" alt="#">
                    </div>
                    <div class="single-clients">
                        <img src="{{asset('/assets/frontend')}}/img/client4.png" alt="#">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/Ens clients -->

@endsection


@section('js')

@endsection
