@extends('frontend.layouts.master')
@section('title','Admission Find')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endsection
@section('content')
<div class="container-xxl py-5">
    <div class="container">

<section class="_inner_page_banner" {{--style="background-image: url()"--}}>
  <div class="container">
      <div class="_in_title_text">
          <h3 class="text-center">Application Find</h3>
      </div>
  </div>
</section>

<!--    Our Product -->
<section class="_store_by_team">
  <div class="container-fluid">
      <div class="row justify-content-center">
          <div class="col-sm-12 col-lg-9">
            @include('admin.layouts._message')
            {!! Form::open( array('route'=>['admission.find_admission_submit'],'method'=>'POST')) !!}              
              <div class="row">
                <div class="col-5">
                  <div class="form-group mb-1">
                    {!! Form::label('student_id', __('Student ID *'),['class'=>'mb-0']) !!}
                    {!! Form::text('student_id',null,['class'=>'form-control form-control-sm','required'=>true,'placeholder'=> __('Student ID')]) !!}
                  </div>
                </div>
                <div class="col-5">
                  <div class="form-group mb-1">
                    {!! Form::label('dateOfBirth', __('Date of Birth *'),['class'=>'mb-1']) !!}
                    <div class="input-group" id="dateOfBirth2" data-target-input="nearest">
                      {!! Form::text('dateOfBirth',null,['class'=>'form-control form-control-sm datetimepicker-input','placeholder'=>__('Ex: 1999-01-30'),
                      'data-target'=>'#dateOfBirth2', 'data-inputmask-alias'=>'datetime','data-inputmask-inputformat'=>'yyyy/mm/dd','data-mask'=>'data-mask']) !!}
                      <div class="input-group-append" data-target="#dateOfBirth2" data-toggle="datetimepicker">
                          <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-2">
                    {!! Form::submit(__('Submit'),['class'=>'btn btn-block mt-2 btn-danger']) !!}
                </div>
              </div>              
              </div>
          {!! Form::close() !!}
          </div>
      </div>
  </div>
</section>
<!--    Our Product -->
    </div>
</div>
@endsection
@section('js')
<script src="{{ asset('assets/admin/plugins/moment/moment.min.js') }}"> </script>
<!-- Tempusdominus -->
<script src="{{ asset('assets/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"> </script>
<script>
  (function ($) {
    $(document).ready(function() {
        $('#dateOfBirth2').datetimepicker({
            //format: 'DD/MM/YYYY'
            format: 'YYYY-MM-DD'
        });


        $('.select2').select2();
        $('.select2-multi').select2();        

    } );
    })(jQuery);
</script>
@endsection