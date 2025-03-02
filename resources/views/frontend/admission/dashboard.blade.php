@extends('frontend.layouts.master')
@section('title','Admission Dashboard')
@section('css')

@endsection
@section('content')
<div class="container-xxl py-5">
    <div class="container">

<section class="_inner_page_banner" {{--style="background-image: url()"--}}>
  <div class="container">
      <div class="_in_title_text">
          <h3>Welcome to {{ auth('admission')->user()->name }}</h3>
      </div>
  </div>
</section>

<!--    Our Product -->
<section class="_store_by_team">
  <div class="container-fluid">
      <div class="row justify-content-center">
          <div class="col-sm-12 col-lg-9">
                <ol class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-start list-group-item-primary">
                        <div class="ms-2 me-auto">
                            Form Filup
                        </div>
                        <span class="badge bg-primary rounded-pill">{{auth('admission')->user()->form_filup ==1 ? 'Submitted':'Pending'}}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start list-group-item-success">
                        <div class="ms-2 me-auto">
                            Payment
                        </div>
                        <span class="badge bg-primary rounded-pill">{{auth('admission')->user()->paymentStatus ==1 ? 'Paid':'Pending'}}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start list-group-item-danger">
                        <div class="ms-2 me-auto">
                            Result
                        </div>
                        <span class="badge bg-primary rounded-pill">{{auth('admission')->user()->result?auth('admission')->user()->result->position:'Pending'}}</span>
                    </li>
                </ol>
          </div>
      </div>
  </div>
</section>
<!--    Our Product -->
    </div>
</div>
@endsection
