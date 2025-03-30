@extends('frontend.layouts.master')
@section('title','Profile')
@section('content')
<!-- Start Schedule Area -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
          <div class="card mt-3">
            <div class="card-header">
              <h3 class="card-title">Basic</h3>
              <div class="card-tools">
                <a href="{{ route('citizen.editProfile') }}" class="btn btn-sm btn-primary">Edit</a>
              </div>
            </div>  
            <div class="card-body">
            <table class="table table-sm">
                <tr>
                    <th>Email</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>{{ $user->phone }}</td>
                </tr>
                <tr>
                    <th>NID</th>
                    <td>{{ $user->nid }}</td>
                </tr>
                <tr>
                    <th>Date of Birth</th>
                    <td>{{ date('d-m-Y', strtotime($user->date_of_birth)) }}</td>
                </tr>
                <tr>
                    <th>Gender</th>
                    <td>{{ $user->gender }}</td>
                </tr>
                <tr>
                    <th>Religion</th>
                    <td>{{ $user->religion }}</td>
                </tr>
                <tr>
                    <th>Blood Group</th>
                    <td>{{ $user->blood_group }}</td>
                </tr>
            </table>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card mt-3">
            <div class="card-header">
              <h3 class="card-title">Profile</h3>
              <div class="card-tools">
                <a href="{{ route('citizen.editProfile') }}" class="btn btn-sm btn-primary">Edit</a>
              </div>
            </div>  
            <div class="card-body">
            <table class="table table-sm">
                <tr>
                    <th></th>
                    <th>English</th>
                    <td>Bangla</td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->name_bn }}</td>
                </tr>
                <tr>
                    <th>Father Name</th>
                    <td>{{ $user->father_name }}</td>
                    <td>{{ $user->father_name_bn }}</td>
                </tr>
                <tr>
                    <th>Mother Name</th>
                    <td>{{ $user->mother_name }}</td>
                    <td>{{ $user->mother_name_bn }}</td>
                </tr>
            </table>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card mt-3">
            <div class="card-header">
              <h3 class="card-title">Present Address</h3>
            </div>  
            <div class="card-body">
            <table class="table">
                <tr>
                    <th></th>
                    <th>English</th>
                    <td>Bangla</td>
                </tr>
                <tr>
                    <th>Holding</th>
                    <td>{{ $user->holding }}</td>
                    <td>{{ $user->holding_bn }}</td>
                </tr>
                <tr>
                    <th>Road</th>
                    <td>{{ $user->road }}</td>
                    <td>{{ $user->road_bn }}</td>
                </tr>
                <tr>
                    <th>Village</th>
                    <td>{{ $user->village }}</td>
                    <td>{{ $user->village_bn }}</td>
                </tr>
                <tr>
                    <th>Ward</th>
                    <td>{{ $user->ward }}</td>
                    <td>{{ $user->ward_bn }}</td>
                </tr>
                <tr>
                    <th>Post Office</th>
                    <td>{{ $user->post_office }}</td>
                    <td>{{ $user->post_office_bn }}</td>
                </tr>
                <tr>
                    <th>Post Code</th>
                    <td>{{ $user->post_code }}</td>
                    <td>{{ $user->post_code_bn }}</td>
                </tr>
                <tr>
                    <th>Upazilla</th>
                    <td>{{ $user->upazila ? $user->upazila->name : '' }}</td>
                    <td>{{ $user->upazila ? $user->upazila->name_bn : '' }}</td>
                </tr>
                <tr>
                    <th>District</th>
                    <td>{{ $user->district ? $user->district->name : '' }}</td>
                    <td>{{ $user->district ? $user->district->name_bn : '' }}</td>
                </tr>
            </table>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card mt-3">
            <div class="card-header">
              <h3 class="card-title">Permanent Address</h3>
            </div>
            <div class="card-body">
            <table class="table">
                <tr>
                    <th></th>
                    <th>English</th>
                    <td>Bangla</td>
                </tr>
                <tr>
                  <th>Holding</th>
                  <td>{{ $user->permanent_holding }}</td>
                  <td>{{ $user->permanent_holding_bn }}</td>
                </tr>
                <tr>
                    <th>Road</th>
                    <td>{{ $user->permanent_road }}</td>
                    <td>{{ $user->permanent_road_bn }}</td>
                </tr>
                <tr>
                    <th>Village</th>
                    <td>{{ $user->permanent_village }}</td>
                    <td>{{ $user->permanent_village_bn }}</td>
                </tr>
                <tr>
                    <th>Ward</th>
                    <td>{{ $user->permanent_ward }}</td>
                    <td>{{ $user->permanent_ward_bn }}</td>
                </tr>
                <tr>
                    <th>Post Office</th>
                    <td>{{ $user->permanent_post_office }}</td>
                    <td>{{ $user->permanent_post_office_bn }}</td>
                </tr>
                <tr>
                    <th>Post Code</th>
                    <td>{{ $user->permanent_post_code }}</td>
                    <td>{{ $user->permanent_post_code_bn }}</td>
                </tr>
                <tr>
                    <th>Upazilla</th>
                    <td>{{ $user->upazilaPermanent ? $user->upazilaPermanent->name : '' }}</td>
                    <td>{{ $user->upazilaPermanent ? $user->upazilaPermanent->name_bn : '' }}</td>
                </tr>
                <tr>
                    <th>District</th>
                    <td>{{ $user->districtPermanent ? $user->districtPermanent->name : '' }}</td>
                    <td>{{ $user->districtPaermanent ? $user->districtPermanent->name_bn : '' }}</td>
                </tr>
            </table>
            </div>
          </div>
        </div>
    </div>
</div>


@endsection


@section('js')

@endsection
