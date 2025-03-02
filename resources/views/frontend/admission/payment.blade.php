@extends('frontend.layouts.master')
@section('title','Customer Dashboard')
@section('css')
@endsection
@section('content')
<section class="_inner_page_banner" {{--style="background-image: url()"--}}>
  <div class="container">
      <div class="_in_title_text">
          <h1>{{ auth('admission')->user()->name }}</h1>
      </div>
  </div>
</section>

<!--    Our Product -->
<section class="_store_by_team">
  <div class="container-fluid">
      <div class="row justify-content-center">

          <div class="col-md-12 col-lg-9">
              <table id="orders" class="table table-striped">
                  <thead>
                      <tr>
                          <th>Date</th>
                          <th>Amount</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($payments as $item)
                      <tr>
                          <td>{{ prettyDate($item->date) }}</td>
                          <td>{{ $item->amount }}</td>
                      </tr>
                      @endforeach
                  </tbody>
              </table>
          </div>
      </div>
  </div>
</section>
<!--    Our Product -->
@endsection
@section('js')
@endsection
