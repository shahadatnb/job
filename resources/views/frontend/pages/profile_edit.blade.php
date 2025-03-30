@extends('frontend.layouts.master')
@section('title','Profile')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endsection
@section('content')
<!-- Start Schedule Area -->
<div class="container-fluid">
  {!! Form::model($user, ['route' => 'citizen.updateProfile', 'method' => 'post']) !!}
  @include('admin.layouts._message')
    <div class="row">
        <div class="col-md-6">
          <div class="card mt-3">
            <div class="card-header">
              <h3 class="card-title">Basic</h3>
              <div class="card-tools">
                <input type="submit" class="btn btn-sm btn-primary" value="Save">
              </div>
            </div>  
            <div class="card-body">
            <table class="table table-sm">
                <tr>
                    <th>Email</th>
                    <td>
                      {!! Form::email('email', $user->email, ['class' => 'form-control', 'placeholder' => 'Email', 'required']) !!}
                    </td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>
                      {!! Form::text('phone', $user->phone, ['class' => 'form-control', 'placeholder' => 'Phone', 'required']) !!}
                    </td>
                </tr>
                <tr>
                    <th>NID</th>
                    <td>
                      {!! Form::text('nid', $user->nid, ['class' => 'form-control', 'placeholder' => 'NID', 'required']) !!}
                    </td>
                </tr>
                <tr>
                    <th>Date of Birth</th>
                    <td>
                      <div class="form-group">
                        {!! Form::text('date_of_birth', $user->date_of_birth, ['class' => 'form-control datetimepicker-input','id'=>'date_of_birth', 'data-toggle'=>"datetimepicker", 'data-target'=>"#datetimepicker5", 'placeholder' => 'YYYY-MM-DD', 'required']) !!}
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Gender</th>
                    <td>
                      {!! Form::select('gender', ['male' => 'Male', 'female' => 'Female'], $user->gender, ['class' => 'form-control', 'required']) !!}
                    </td>
                </tr>
                <tr>
                    <th>Religion</th>
                    <td>
                      {!! Form::select('religion',['Muslim' => 'Muslim', 'Hindu' => 'Hindu', 'Christian' => 'Christian', 'Buddhist' => 'Buddhist', 'Others' => 'Others'], $user->religion, ['class' => 'form-control', 'placeholder' => 'Religion', 'required']) !!}
                    </td>
                </tr>
                <tr>
                    <th>Blood Group</th>
                    <td>
                      {!! Form::select('blood_group', ['A+' => 'A+', 'A-' => 'A-', 'B+' => 'B+', 'B-' => 'B-', 'O+' => 'O+', 'O-' => 'O-', 'AB+' => 'AB+', 'AB-' => 'AB-','Unknown' => 'Unknown'], $user->blood_group, ['class' => 'form-control', 'placeholder' => 'Blood Group', 'required']) !!}
                    </td>
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
                <input type="submit" class="btn btn-sm btn-primary" value="Save">
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
                    <td>
                      {!! Form::text('name', $user->name, ['class' => 'form-control', 'placeholder' => 'Name', 'required']) !!}
                    </td>
                    <td>
                      {!! Form::text('name_bn', $user->name_bn, ['class' => 'form-control', 'placeholder' => 'Name', 'required']) !!}
                    </td>
                </tr>
                <tr>
                    <th>Father Name</th>
                    <td>
                      {!! Form::text('father_name', $user->father_name, ['class' => 'form-control', 'placeholder' => 'Father Name', 'required']) !!}
                    </td>
                    <td>
                      {!! Form::text('father_name_bn', $user->father_name_bn, ['class' => 'form-control', 'placeholder' => 'Father Name', 'required']) !!}
                    </td>
                </tr>
                <tr>
                    <th>Mother Name</th>
                    <td>
                      {!! Form::text('mother_name', $user->mother_name, ['class' => 'form-control', 'placeholder' => 'Mother Name', 'required']) !!}
                    </td>
                    <td>
                      {!! Form::text('mother_name_bn', $user->mother_name_bn, ['class' => 'form-control', 'placeholder' => 'Mother Name', 'required']) !!}
                    </td>
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
                  <td>
                    {!! Form::text('holding', $user->holding, ['class' => 'form-control', 'placeholder' => 'Holding']) !!}
                  </td>
                  <td>
                    {!! Form::text('holding_bn', $user->holding_bn, ['class' => 'form-control', 'placeholder' => 'Holding']) !!}
                  </td>
              </tr>
              <tr>
                  <th>Road</th>
                  <td>
                    {!! Form::text('road', $user->road, ['class' => 'form-control', 'placeholder' => 'Road']) !!}
                  </td>
                  <td>
                    {!! Form::text('road_bn', $user->road_bn, ['class' => 'form-control', 'placeholder' => 'Road']) !!}
                  </td>
              </tr>
              <tr>
                  <th>Village</th>
                  <td>
                    {!! Form::text('village', $user->village, ['class' => 'form-control', 'placeholder' => 'Village']) !!}
                  </td>
                  <td>
                    {!! Form::text('village_bn', $user->village_bn, ['class' => 'form-control', 'placeholder' => 'Village']) !!}
                  </td>
              </tr>
              <tr>
                  <th>Ward</th>
                  <td>
                    {!! Form::text('ward', $user->ward, ['class' => 'form-control', 'placeholder' => 'Ward']) !!}
                  </td>
                  <td></td>
              </tr>
              <tr>
                  <th>Post Office</th>
                  <td>
                    {!! Form::text('post_office', $user->post_office, ['class' => 'form-control', 'placeholder' => 'Post Office']) !!}
                  </td>
                  <td>
                    {!! Form::text('post_office_bn', $user->post_office_bn, ['class' => 'form-control', 'placeholder' => 'Post Office']) !!}
                  </td>
              </tr>
              <tr>
                  <th>Post Code</th>
                  <td>
                    {!! Form::text('post_code', $user->post_code, ['class' => 'form-control', 'placeholder' => 'Post Code']) !!}
                  </td>
                  <td></td>
              </tr>
              <tr>
                  <th>District</th>
                  <td>
                    <div class="form-group">
                    {!! Form::select('district_id', $districts, null,['class' => 'form-control select2', 'id' => 'district_id', 'placeholder' => 'District']) !!}
                    </div>
                  </td>
                  <td></td>
              </tr>
              <tr>
                  <th>Upazilla</th>
                  <td>
                    {!! Form::select('upazila_id', $upazilas, $user->upazila_id, ['class' => 'form-control select2','id'=>'upazila_id', 'placeholder' => 'Upazila']) !!}
                  </td>
                  <td></td>
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
                  <td>
                    {!! Form::text('permanent_holding', $user->permanent_holding, ['class' => 'form-control', 'placeholder' => 'Holding']) !!}
                  </td>
                  <td>
                    {!! Form::text('permanent_holding_bn', $user->permanent_holding_bn, ['class' => 'form-control', 'placeholder' => 'Holding']) !!}
                  </td>
                </tr>
                <tr>
                    <th>Road</th>
                    <td>
                      {!! Form::text('permanent_road', $user->permanent_road, ['class' => 'form-control', 'placeholder' => 'Road']) !!}
                    </td>
                    <td>
                      {!! Form::text('permanent_road_bn', $user->permanent_road_bn, ['class' => 'form-control', 'placeholder' => 'Road']) !!}
                    </td>
                </tr>
                <tr>
                    <th>Village</th>
                    <td>
                      {!! Form::text('permanent_village', $user->permanent_village, ['class' => 'form-control', 'placeholder' => 'Village']) !!}
                    </td>
                    <td>
                      {!! Form::text('permanent_village_bn', $user->permanent_village_bn, ['class' => 'form-control', 'placeholder' => 'Village']) !!}
                    </td>
                </tr>
                <tr>
                    <th>Ward</th>
                    <td>
                      {!! Form::text('permanent_ward', $user->permanent_ward, ['class' => 'form-control', 'placeholder' => 'Ward']) !!}
                    </td>
                    <td>
                      {!! Form::text('permanent_ward_bn', $user->permanent_ward_bn, ['class' => 'form-control', 'placeholder' => 'Ward']) !!}
                    </td>
                </tr>
                <tr>
                    <th>Post Office</th>
                    <td>
                      {!! Form::text('permanent_post_office', $user->permanent_post_office, ['class' => 'form-control', 'placeholder' => 'Post Office']) !!}
                    </td>
                    <td>
                      {!! Form::text('permanent_post_office_bn', $user->permanent_post_office_bn, ['class' => 'form-control', 'placeholder' => 'Post Office']) !!}
                    </td>
                </tr>
                <tr>
                    <th>Post Code</th>
                    <td>
                      {!! Form::text('permanent_post_code', $user->permanent_post_code, ['class' => 'form-control', 'placeholder' => 'Post Code']) !!}
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <th>District</th>
                    <td>
                      {!! Form::select('permanent_district_id', $districts, $user->permanent_district_id, ['class' => 'form-control select2','id'=>'permanent_district_id', 'placeholder' => 'District']) !!}
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <th>Upazilla</th>
                    <td>
                      {!! Form::select('permanent_upazila_id', $upazilas, $user->permanent_upazila_id, ['class' => 'form-control select2','id'=>'permanent_upazila_id', 'placeholder' => 'Upazila']) !!}
                    </td>
                    <td></td>
                </tr>
                <tr>
                  <th>Union</th>
                    <td>
                      {{-- {!! Form::select('union_id', $unions, $user->union_id, ['class' => 'form-control select2','id'=>'union_id', 'placeholder' => 'Union']) !!} --}}
                    </td>
                    <td></td>
                </tr>
            </table>
            </div>
          </div>
        </div>
    </div>
  {!! Form::close() !!}
</div>


@endsection
@section('js')
<script src="{{ asset('assets/admin/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/moment/moment.min.js') }}"> </script>
<!-- Tempusdominus -->
<script src="{{ asset('assets/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"> </script>
<script>
  (function ($) {
    $(document).ready(function() {
        $('#date_of_birth').datetimepicker({
            //format: 'DD/MM/YYYY'
            format: 'YYYY-MM-DD'
        });


        $('.select2').select2();
        $('.select2-multi').select2();

        $('#district_id').change(function(){
          $.get('{{ route('childLocation') }}', {
                option: $(this).val()
            },
            function(data) {
                var subcat = $('#upazila_id');
                subcat.empty();
                subcat.append("<option value=''>-----</option>");
                $.each(data, function(index, element) {
                    subcat.append("<option value='"+ element.id +"'>" + element.name + "</option>");
                });
            });
        });

        $('#permanent_district_id').change(function(){
          $.get('{{ route('childLocation') }}', {
                option: $(this).val()
            },
            function(data) {
                var subcat = $('#permanent_upazila_id');
                subcat.empty();
                subcat.append("<option value=''>-----</option>");
                $.each(data, function(index, element) {
                    subcat.append("<option value='"+ element.id +"'>" + element.name + "</option>");
                });
            });
        });

        $("#sameAsPresent").change(function(){
            if($(this).is(":checked")) {
                $("#permanentVillage").val($("#presentVillage").val());
                $("#permanentPost").val($("#presentPost").val());
                $("#permanentDistrict").empty();
                $("#permanentDistrict").append(`<option value='${$("#presentDistrict").val()}'>${$("#presentDistrict").find(':selected').text()}</option>`);
                $("#permanentDistrict").val($("#presentDistrict").val());
                $("#permanentUpazila").append(`<option value='${$("#presentUpazila").val()}'>${$("#presentUpazila").find(':selected').text()}</option>`);
                $("#permanentUpazila").val($("#presentUpazila").val());
            }
        });    

    } );
    })(jQuery);
</script>
@endsection
