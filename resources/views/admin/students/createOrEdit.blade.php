@extends('admin.layouts.layout')
@section('title',__("Student"))
@section('css')
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<style type="text/css">
  .card-body {
    padding: .75rem;
  }
</style>
@endsection
@section('content')
@if ($mode == 'edit')
  {!! Form::model($student, array('route'=>['student.student.update',$student],'method'=>'PUT','files' => true)) !!}
@else
  {!! Form::open(array('route'=>['student.student.store'],'files' => true)) !!}
@endif
<!-- Default box -->
<div class="card card-outline card-info">
    <div class="card-header">
        <h3 class="card-title">{{__('Student')}}</h3>
        <div class="card-tools">
          <a href="{{route('student.student.index')}}" class="btn btn-sm btn-info"><i class="far fa-arrow-alt-circle-left"></i> Back</a>
          {!! Form::submit(__('Submit'),['class'=>'btn btn-sm btn-danger']) !!}
          @if ($mode == 'edit')
          <a href="{{route('student.student.show',$student->id)}}" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> View</a>
          @endif
        </div>
    </div>
    <div class="card-body">
      @include('admin.layouts._message')
    </div>
</div>
<!-- /.card -->
<div class="row">
  <div class="col-6">
    <div class="card card-outline card-info">
      <div class="card-header">
          <h3 class="card-title">{{__('Basic Info')}}</h3>
      </div>
      <div class="card-body">
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
              {!! Form::label('reg_no', __('Reg. No'),['class'=>'mb-1']) !!}
              {!! Form::text('reg_no',null,['class'=>'form-control form-control-sm','placeholder'=> __('Reg. No')]) !!}
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group mb-1">
              {!! Form::label('class_roll', __('Class Roll'),['class'=>'mb-1']) !!}
              {!! Form::text('class_roll',null,['class'=>'form-control form-control-sm','required'=>false,'placeholder'=> __('Class Roll')]) !!}
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group mb-1">
            {!! Form::label('section_id', __('Section'),['class'=>'mb-1']) !!}
            {!! Form::select('section_id',$sections,null,['class'=>'form-control form-control-sm select2','required'=>'required','placeholder'=> __('Section')]) !!}
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group mb-1">
            {!! Form::label('group_id', __('Group'),['class'=>'mb-1']) !!}
            {!! Form::select('group_id',$groups,null,['class'=>'form-control form-control-sm select2','required'=>'required','placeholder'=> __('Group')]) !!}
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group mb-1">
              {!! Form::label('category_id', __('Category'),['class'=>'mb-1']) !!}
              {!! Form::select('category_id',$catetories,null,['class'=>'form-control form-control-sm select2','placeholder'=> __('Category')]) !!}
            </div>
          </div>
          <div class="col-6">
            <div class="form-group mb-1">
              {!! Form::label('mobile', __('Mobile Number'),['class'=>'mb-1']) !!}
              {!! Form::text('mobile',null,['class'=>'form-control form-control-sm','placeholder'=> __('Mobile Number')]) !!}
            </div>
          </div>
        </div>
        <div class="row">
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
          <div class="col-6">
            <div class="form-group mb-1">
              {!! Form::label('photo', __('Select Photo'),['class'=>'mb-1']) !!}
              {!! Form::file('photo',null,['class'=>'form-control form-control-sm']) !!}
            </div>
          </div>
        </div>
        <div class="row">          
          <div class="col-12">
            <div class="form-group mb-1">
              {!! Form::label('Comment', __('Comment'),['class'=>'mb-1']) !!}
              {!! Form::textarea('Comment',null,['class'=>'form-control form-control-sm', 'rows'=>'3','placeholder'=> __('Comment')]) !!}
            </div>
          </div>
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
              {!! Form::text('presentVillage',null,['class'=>'form-control form-control-sm','placeholder'=> __('Village')]) !!}
            </div>
          </div>
          <div class="col-6">
            <div class="form-group mb-1">
            {!! Form::label('presentPost', __('Post'),['class'=>'mb-0']) !!}
            {!! Form::text('presentPost',null,['class'=>'form-control form-control-sm','placeholder'=> __('Post')]) !!}
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <div class="form-group mb-1">
            {!! Form::label('presentZila', __('Zila'),['class'=>'mb-0']) !!}
            {!! Form::select('presentZila',$locations,null,['class'=>'form-control form-control-sm select2','data-url'=> route('childLocation'),'placeholder'=> __('Zila')]) !!}
            </div>
          </div>
          <div class="col-6">
            <div class="form-group mb-1">
              {!! Form::label('presentUpazila', __('Upazila'),['class'=>'mb-0']) !!}
              {!! Form::select('presentUpazila',$presentUpazila,null,['class'=>'form-control form-control-sm select2','placeholder'=> __('Upazila')]) !!}
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
              {!! Form::text('permanentVillage',null,['class'=>'form-control form-control-sm','placeholder'=> __('Villege')]) !!}
            </div>
          </div>
          <div class="col-6">
            <div class="form-group mb-1">
            {!! Form::label('permanentPost', __('Post'),['class'=>'mb-0']) !!}
            {!! Form::text('permanentPost',null,['class'=>'form-control form-control-sm','placeholder'=> __('Post')]) !!}
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <div class="form-group mb-1">
            {!! Form::label('permanentZila', __('Zila'),['class'=>'mb-0']) !!}
            {!! Form::select('permanentZila',$locations,null,['class'=>'form-control form-control-sm select2','data-url'=> route('childLocation'),'placeholder'=> __('Zila')]) !!}
            </div>
          </div>
          <div class="col-6">
            <div class="form-group mb-1">
              {!! Form::label('permanentUpazila', __('Upazila'),['class'=>'mb-0']) !!}
              {!! Form::select('permanentUpazila',$permanentUpazila,null,['class'=>'form-control form-control-sm select2','placeholder'=> __('Upazila')]) !!}
            </div>
          </div>
        </div>        
      </div>
    </div>
  </div>
  <div class="col-6">
    <div class="card card-outline card-info">
      <div class="card-header">
          <h3 class="card-title">{{__('Guardian Info')}}</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-6">
            <div class="form-group mb-1">
              {!! Form::label('fathersName', __('Father`s Name'),['class'=>'mb-0']) !!}
              {!! Form::text('fathersName',null,['class'=>'form-control form-control-sm','placeholder'=> __('Father`s Name')]) !!}
            </div>
          </div>
          <div class="col-6">
            <div class="form-group mb-1">
            {!! Form::label('mothersName', __('Mother`s Name'),['class'=>'mb-0']) !!}
            {!! Form::text('mothersName',null,['class'=>'form-control form-control-sm','placeholder'=> __('Mother`s Name')]) !!}
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
              {!! Form::text('guardianName',null,['class'=>'form-control form-control-sm','placeholder'=> __('Guardian Name')]) !!}
            </div>
          </div>
          <div class="col-6">
            <div class="form-group mb-1">
            {!! Form::label('mobileGuardian', __('Mobile Guardian'),['class'=>'mb-0']) !!}
            {!! Form::text('mobileGuardian',null,['class'=>'form-control form-control-sm','placeholder'=> __('Mobile Guardian')]) !!}
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
            {!! Form::text('guardianRelation',null,['class'=>'form-control form-control-sm','placeholder'=> __('Guardian Relation')]) !!}
            </div>
          </div>
        </div>
      </div>
    </div>
    {{-- <div class="card card-outline card-info">
      <div class="card-header">
          <h3 class="card-title">{{__('MIS Info')}}</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-6">
            <div class="form-group mb-1">
              {!! Form::label('MISStudentID', __('MIS Student ID'),['class'=>'mb-0']) !!}
              {!! Form::text('MISStudentID',null,['class'=>'form-control form-control-sm','placeholder'=> __('MIS Student ID')]) !!}
            </div>
          </div>
          <div class="col-6">
            <div class="form-group mb-1">
            {!! Form::label('Bank_Mobile', __('Bank Mobile'),['class'=>'mb-0']) !!}
            {!! Form::text('Bank_Mobile',null,['class'=>'form-control form-control-sm','placeholder'=> __('Bank Mobile')]) !!}
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <div class="form-group mb-1">
              {!! Form::label('accountName', __('Account Name'),['class'=>'mb-0']) !!}
              {!! Form::text('accountName',null,['class'=>'form-control form-control-sm','placeholder'=> __('Account Name')]) !!}
            </div>
          </div>
          <div class="col-6">
            <div class="form-group mb-1">
            {!! Form::label('accountNumber', __('Account Number'),['class'=>'mb-0']) !!}
            {!! Form::text('accountNumber',null,['class'=>'form-control form-control-sm','placeholder'=> __('Account Number')]) !!}
            </div>
          </div>
        </div>
      </div>
    </div> --}}


    <div class="card card-outline card-info">
      <div class="card-header">
          <h3 class="card-title">{{__('JSC Info')}}</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-6">
            <div class="form-group mb-1">
              {!! Form::label('jscBoard', __('JSC Board'),['class'=>'mb-0']) !!}
              {!! Form::text('jscBoard',null,['class'=>'form-control form-control-sm','placeholder'=> __('JSC Board')]) !!}
            </div>
          </div>
          <div class="col-6">
            <div class="form-group mb-1">
            {!! Form::label('jscResistration', __('JSC Resistration'),['class'=>'mb-0']) !!}
            {!! Form::text('jscResistration',null,['class'=>'form-control form-control-sm','placeholder'=> __('JSC Resistration')]) !!}
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-4">
            <div class="form-group mb-1">
              {!! Form::label('jscBoardRoll', __('JSC Board Roll'),['class'=>'mb-0']) !!}
              {!! Form::text('jscBoardRoll',null,['class'=>'form-control form-control-sm','placeholder'=> __('JSC Board Roll')]) !!}
            </div>
          </div>
          <div class="col-4">
            <div class="form-group mb-1">
            {!! Form::label('jscExamYear', __('JSC Exam Year'),['class'=>'mb-0']) !!}
            {!! Form::text('jscExamYear',null,['class'=>'form-control form-control-sm','placeholder'=> __('JSC Exam Year')]) !!}
            </div>
          </div>
          <div class="col-4">
            <div class="form-group mb-1">
            {!! Form::label('jscCgpa', __('JSC Cgpa'),['class'=>'mb-0']) !!}
            {!! Form::text('jscCgpa',null,['class'=>'form-control form-control-sm','placeholder'=> __('JSC Cgpa')]) !!}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


{!! Form::close() !!}
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

        $('#presentZila').change(function(){
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

        $('#permanentZila').change(function(){
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
                $("#permanentZila").empty();
                $("#permanentZila").append(`<option value='${$("#presentZila").val()}'>${$("#presentZila").find(':selected').text()}</option>`);
                $("#permanentZila").val($("#presentZila").val());
                $("#permanentUpazila").append(`<option value='${$("#presentUpazila").val()}'>${$("#presentUpazila").find(':selected').text()}</option>`);
                $("#permanentUpazila").val($("#presentUpazila").val());
            }
        });

    } );
    })(jQuery);
</script>
@endsection