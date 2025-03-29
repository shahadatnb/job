@extends('frontend.layouts.master')
@section('title','Ex Student Form')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endsection
@section('content')
<!-- Start Schedule Area -->
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Ex Student Entry Form</h4>
        </div>
        <div class="card-body">
        {!! Form::open(['route' => 'ex-student.store', 'method' => 'post', 'files' => true]) !!}
        @include('admin.layouts._message')
            <div class="form-group">
                {!! Form::label('name', __('Name'),['class'=>'']) !!}
                {!! Form::text('name', null, ['class' => 'form-control','placeholder'=> __('Name')]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('email', __('Email'),['class'=>'']) !!}
                {!! Form::email('email', null, ['class' => 'form-control','placeholder'=> __('Email')]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('mobile', __('Mobile'),['class'=>'']) !!}
                {!! Form::text('mobile', null, ['class' => 'form-control','placeholder'=> __('Mobile')]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('department_id', __('Department'),['class'=>'']) !!}
                {!! Form::select('department_id', $eduGroups, null, ['class' => 'form-control select2','placeholder'=> __('Department')]) !!}
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        {!! Form::label('roll_number', __('Roll Number'),['class'=>'']) !!}
                        {!! Form::text('roll_number', null, ['class' => 'form-control','placeholder'=> __('Roll Number')]) !!}
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        {!! Form::label('registration_number', __('Registration Number'),['class'=>'']) !!}
                        {!! Form::text('registration_number', null, ['class' => 'form-control','placeholder'=> __('Registration Number')]) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        {!! Form::label('session', __('Session'),['class'=>'']) !!}
                        {!! Form::text('session', null, ['class' => 'form-control','placeholder'=> __('Session')]) !!}
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        {!! Form::label('passing_year', __('Passing Year'),['class'=>'']) !!}
                        {!! Form::text('passing_year', null, ['class' => 'form-control','placeholder'=> __('Passing Year')]) !!}
                    </div>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('job_information', __('Job Information'),['class'=>'']) !!}
                {!! Form::text('job_information', null, ['class' => 'form-control','placeholder'=> __('Job Information')]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('photo', __('Select Photo'),['class'=>'']) !!}
                {!! Form::file('photo',null,['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::submit(__('Submit'),['class'=>'btn btn-block mt-2 btn-primary']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
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

        $('#parmanent_district_id').change(function(){
          $.get('{{ route('childLocation') }}', {
                option: $(this).val()
            },
            function(data) {
                var subcat = $('#parmanent_upazila_id');
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
