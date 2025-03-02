@extends('frontend.layouts.master')
@section('content')
<div class="container-xxl py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 wow fadeInUp" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;">
                <h1 class="mb-4">ভর্তি ফলাফল</h1>
                {{-- <p class="mb-4">এডমিশন ফরম পূরণে যেকোনো সহায়তার জন্য যোগাযোগ করুন এই নাম্বারে</p> --}}
                {{-- <p class="mb-4">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit. Aliqu diam amet diam et eos. Clita erat ipsum et lorem et sit, sed stet lorem sit clita duo justo magna dolore erat amet</p> --}}
                <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">নাম</th>
                        <th scope="col">ডাউনলোড</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($datas as $item)
                          <tr>
                            <td>{{ $item->title }}</td>
                            <td><a href="{{ asset('storage/'.$item->image) }}" class="btn btn-primary">Download</a></td>
                          </tr>
                      @endforeach
                    </tbody>
                  </table>
            </div>
            <div class="col-lg-3">
                
            </div>
        </div>
    </div>
</div>
@endsection