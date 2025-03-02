@extends('frontend.layouts.master')
@section('title','Admission Form')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
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
            @include('admin.layouts._message')
            {!! Form::model($student, array('route'=>['admission.formsave',$student],'method'=>'POST','files' => true)) !!}
            <div class="form-group mb-1">
                {!! Form::label('name', __('Name Of Student'),['class'=>'mb-1']) !!}
                {!! Form::text('name',null,['class'=>'form-control form-control-sm','required'=>'required','placeholder'=> __('Name Of Student')]) !!}
              </div>
              <div class="row">
                <div class="col-6">
                  <div class="form-group mb-1">
                    {!! Form::label('sex', __('Sex'),['class'=>'mb-1']) !!}
                    {!! Form::select('sex',['Male'=>'Male','Female'=>'Female','Others'=>'Others'],null,['class'=>'form-control form-control-sm','required'=>'required','placeholder'=> __('Sex')]) !!}
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group mb-1">
                    {!! Form::label('religion', __('Religion'),['class'=>'mb-1']) !!}
                    {!! Form::select('religion',['Islam'=>'Islam','Hindu'=>'Hindu','Christian'=>'Christian','Others'=>'Others'],null,['class'=>'form-control form-control-sm','required'=>'required','placeholder'=> __('Religion')]) !!}
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group mb-1">
                  {!! Form::label('class_id', __('Class'),['class'=>'mb-1']) !!}
                  {!! Form::select('class_id',$admission_class,null,['class'=>'form-control form-control-sm select2','required'=>true,'placeholder'=> __('Class')]) !!}
                  </div>                  
                  <div class="form-group mb-1" id="admission_trades">
                    @if($student_class)
                      @if($admission_trades)
                        {!! Form::label('trade_id', __('Trade Name'),['class'=>'']) !!}
                        {!! Form::select('trade_id',$admission_trades,null,['class'=>'form-control form-control-sm','required'=>true,'placeholder'=> __('Trade Name')]) !!}
                      @endif
                    @endif
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group mb-1">
                    {!! Form::label('shift', __('Shift'),['class'=>'mb-1']) !!}
                    {!! Form::select('shift',['1st Shift'=>'1st Shift','2nd Shift'=>'2nd Shift'],null,['class'=>'form-control form-control-sm','required'=>true,'placeholder'=> __('Shift')]) !!}
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <div class="form-group mb-1">
                    {!! Form::label('mobile', __('Student Mobile'),['class'=>'mb-1']) !!}
                    {!! Form::text('mobile',null,['class'=>'form-control form-control-sm','required'=>true,'placeholder'=> __('Student Mobile')]) !!}
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group mb-1">
                    {!! Form::label('dateOfBirth', __('Date of Birth'),['class'=>'mb-1']) !!}
                    <div class="input-group" id="dateOfBirth2" data-target-input="nearest">
                      {!! Form::text('dateOfBirth',null,['class'=>'form-control form-control-sm datetimepicker-input','placeholder'=>__('Date of Birth'),
                      'data-target'=>'#dateOfBirth2', 'data-inputmask-alias'=>'datetime','data-inputmask-inputformat'=>'yyyy/mm/dd','data-mask'=>'data-mask']) !!}
                      <div class="input-group-append" data-target="#dateOfBirth2" data-toggle="datetimepicker">
                          <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <div class="form-group mb-1">
                    {!! Form::label('fathersName', __('Father`s Name'),['class'=>'mb-0']) !!}
                    {!! Form::text('fathersName',null,['class'=>'form-control form-control-sm','required'=>true,'placeholder'=> __('Father`s Name')]) !!}
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group mb-1">
                  {!! Form::label('mothersName', __('Mother`s Name'),['class'=>'mb-0']) !!}
                  {!! Form::text('mothersName',null,['class'=>'form-control form-control-sm','required'=>true,'placeholder'=> __('Mother`s Name')]) !!}
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <div class="form-group mb-1">
                    {!! Form::label('mobileFather', __('Mobile Father'),['class'=>'mb-0']) !!}
                    {!! Form::text('mobileFather',null,['class'=>'form-control form-control-sm','placeholder'=> __('Mobile Father')]) !!}
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group mb-1">
                  {!! Form::label('mobileMother', __('Mobile Mother'),['class'=>'mb-0']) !!}
                  {!! Form::text('mobileMother',null,['class'=>'form-control form-control-sm','placeholder'=> __('Mobile Mother')]) !!}
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <div class="form-group mb-1">
                    {!! Form::label('guardianName', __('Guardian Name'),['class'=>'mb-0']) !!}
                    {!! Form::text('guardianName',null,['class'=>'form-control form-control-sm','required'=>true,'placeholder'=> __('Guardian Name')]) !!}
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group mb-1">
                  {!! Form::label('mobileGuardian', __('Mobile Guardian'),['class'=>'mb-0']) !!}
                  {!! Form::text('mobileGuardian',null,['class'=>'form-control form-control-sm','required'=>true,'placeholder'=> __('Mobile Guardian')]) !!}
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <div class="form-group mb-1">
                    {!! Form::label('lastQualification', __('Last Qualification'),['class'=>'mb-0']) !!}
                    {!! Form::text('lastQualification',null,['class'=>'form-control form-control-sm','required'=>true,'placeholder'=> __('Last Qualification')]) !!}
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group mb-1">
                  {!! Form::label('NameOfOrg', __('Name Of Org'),['class'=>'mb-0']) !!}
                  {!! Form::text('NameOfOrg',null,['class'=>'form-control form-control-sm','required'=>true,'placeholder'=> __('Name Of Org')]) !!}
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <div class="form-group mb-1">
                    {!! Form::label('guardianNID', __('Guardian NID'),['class'=>'mb-0']) !!}
                    {!! Form::text('guardianNID',null,['class'=>'form-control form-control-sm','placeholder'=> __('Guardian NID')]) !!}
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group mb-1">
                  {!! Form::label('guardianRelation', __('Guardian Relation'),['class'=>'mb-0']) !!}
                  {!! Form::text('guardianRelation',null,['class'=>'form-control form-control-sm','required'=>true,'placeholder'=> __('Guardian Relation')]) !!}
                  </div>
                </div>
              </div>
              <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">{{__('Present Address')}}</h3>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group mb-1">
                        {!! Form::label('presentVillage', __('Village'),['class'=>'mb-0']) !!}
                        {!! Form::text('presentVillage',null,['class'=>'form-control form-control-sm','required'=>true,'placeholder'=> __('Village')]) !!}
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group mb-1">
                      {!! Form::label('presentPost', __('Post'),['class'=>'mb-0']) !!}
                      {!! Form::text('presentPost',null,['class'=>'form-control form-control-sm','required'=>true,'placeholder'=> __('Post')]) !!}
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group mb-1">
                      {!! Form::label('presentDistrict', __('District'),['class'=>'mb-0']) !!}
                      {!! Form::select('presentDistrict',$locations,null,['class'=>'form-control form-control-sm select2','required'=>true,'data-url'=> route('childLocation'),'placeholder'=> __('District')]) !!}
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group mb-1">
                        {!! Form::label('presentUpazila', __('Upazila'),['class'=>'mb-0']) !!}
                        {!! Form::select('presentUpazila',$presentUpazila,null,['class'=>'form-control form-control-sm select2','required'=>true,'placeholder'=> __('Upazila')]) !!}
                      </div>
                    </div>
                  </div>        
                </div>
              </div>
              <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">{{__('Permanent Address')}}</h3>
                    <div class="card-tools">
                      <div class="custom-control custom-checkbox">
                        {{ Form::checkbox('sameAsPresent', 1, null, ['class' => 'custom-control-input', 'id' => 'sameAsPresent']) }}
                        {!! Form::label('sameAsPresent', __('Same As Present'),['class'=>'custom-control-label']) !!}
                      </div>
                    </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group mb-1">
                        {!! Form::label('permanentVillage', __('Villege'),['class'=>'mb-0']) !!}
                        {!! Form::text('permanentVillage',null,['class'=>'form-control form-control-sm','required'=>true,'placeholder'=> __('Villege')]) !!}
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group mb-1">
                      {!! Form::label('permanentPost', __('Post'),['class'=>'mb-0']) !!}
                      {!! Form::text('permanentPost',null,['class'=>'form-control form-control-sm','required'=>true,'placeholder'=> __('Post')]) !!}
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group mb-1">
                      {!! Form::label('permanentDistrict', __('District'),['class'=>'mb-0']) !!}
                      {!! Form::select('permanentDistrict',$locations,null,['class'=>'form-control form-control-sm select2','required'=>true,'data-url'=> route('childLocation'),'placeholder'=> __('District')]) !!}
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group mb-1">
                        {!! Form::label('permanentUpazila', __('Upazila'),['class'=>'mb-0']) !!}
                        {!! Form::select('permanentUpazila',$permanentUpazila,null,['class'=>'form-control form-control-sm select2','required'=>true,'placeholder'=> __('Upazila')]) !!}
                      </div>
                    </div>
                  </div>        
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <img width="100" class="img-thumbnail" src="{{asset('/storage/'.$student->photo)}}" alt="">
                  <div class="form-group mb-1">
                    {!! Form::label('photo', __('Select Photo'),['class'=>'mb-1']) !!}
                    {!! Form::file('photo',null,['class'=>'form-control form-control-sm']) !!}
                  </div>
                </div>
                <div class="col-6">
                    {!! Form::submit(__('Submit'),['class'=>'btn btn-block mt-2 btn-danger']) !!}
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
<script src="{{ asset('assets/admin/plugins/select2/js/select2.min.js') }}"></script>
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

        $('#presentDistrict').change(function(){
          $.get($(this).data('url'), {
                option: $(this).val()
            },
            function(data) {
                var subcat = $('#presentUpazila');
                subcat.empty();
                subcat.append("<option value=''>-----</option>");
                $.each(data, function(index, element) {
                    subcat.append("<option value='"+ element.id +"'>" + element.name + "</option>");
                });
            });
        });

        $('#permanentDistrict').change(function(){
          $.get($(this).data('url'), {
                option: $(this).val()
            },
            function(data) {
                var subcat = $('#permanentUpazila');
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

        $("#class_id").change(function(){
          $("#admission_trades").empty();
          let url = "{{route('admission_trades')}}?class_id="+$(this).val();
          $.get(url, {
              
            },
            function(data) {
              console.log(data);
              if(data.status == true){
                $("#admission_trades").append(`
                  <label for="trade_id" class="">Trade Name</label>
                  <select class="form-control form-control-sm" required="" id="trade_id" name="trade_id"><option selected="selected" value="">Select Trade</option></select>
                `);
                  data.trades.forEach(function(element){
                    $("#trade_id").append("<option value='"+ element.id +"'>" + element.name + "</option>");
                  });
              }
            });
          
        });

    } );
    })(jQuery);
</script>
@endsection