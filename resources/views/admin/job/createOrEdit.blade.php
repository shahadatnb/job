@extends('admin.layouts.layout')
@section('title',"Circular Add/Edit")
@section('css')
<link href="//cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<style src="{{ asset('assets/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}"></style>
@endsection
@section('content')
<!-- Default box -->
<div class="card card-outline card-info">
    <div class="card-header">
        <h3 class="card-title">{{__('Circular')}}</h3>
        <div class="card-tools">
          <a href="{{route('job.index')}}" class="btn btn-sm btn-info"><i class="fas fa-arrow-alt-circle-left"></i> Back</a>
        </div>
    </div>
    <div class="card-body">
      @include('admin.layouts._message')
      @if (request()->routeIs('job.edit'))
        {!! Form::model($job, array('route'=>['job.update',$job],'method'=>'PUT','files' => true)) !!}
      @else
        {!! Form::open(array('route'=>['job.store'],'files' => true)) !!}
      @endif
        <div class="row">
          <div class="col-9">
            <div class="form-group">
              {!! Form::label('title', __('Job Title'),['class'=>'']) !!}
              {!! Form::text('title',null,['class'=>'form-control','placeholder'=> __('Job Title')]) !!}
            </div>
            <div class="form-group">
              {!! Form::label('designation_id', __('Designation'),['class'=>'']) !!}
              {!! Form::select('designation_id',$designations,null,['class'=>'form-control','placeholder'=> __('Designation')]) !!}
            </div>
            <div class="form-group">
              {!! Form::label('requirements', __('Requirements'),['class'=>'']) !!}
              {!! Form::textarea('requirements',null,['class'=>'form-control textarea','placeholder'=> __('Requirements')]) !!}
            </div>
            <div class="form-group">
              {!! Form::label('responsibility', __('Responsibilities & Context'),['class'=>'']) !!}
              {!! Form::textarea('responsibility',null,['class'=>'form-control textarea','placeholder'=> __('Responsibility')]) !!}
            </div>
            <div class="form-group">
              {!! Form::label('compensation_other_benefits', __('Compensation & Other Benefits'),['class'=>'']) !!}
              {!! Form::textarea('compensation_other_benefits',null,['class'=>'form-control textarea','placeholder'=> __('Compensation & Other Benefits')]) !!}
            </div>
          </div>
          <div class="col-3">
            @if (request()->routeIs('designation.edit'))
            <div class="form-group">
              {!! Form::label('status', __('Status'),['class'=>'']) !!}
              {{ Form::checkbox('status',1,null) }}
            </div>
            @endif
            <div class="form-group">
              {!! Form::label('vacancy', __('Vacancy'),['class'=>'']) !!}
              {!! Form::text('vacancy',null,['class'=>'form-control','placeholder'=> __('Vacancy')]) !!}
            </div>
            <div class="form-group">
              {!! Form::label('job_nature', __('Job Nature'),['class'=>'']) !!}
              {!! Form::text('job_nature',null,['class'=>'form-control','placeholder'=> __('Job Nature')]) !!}
            </div>
            <div class="form-group">
              {!! Form::label('last_date', __('Last Apply Date').' *',['class'=>'']) !!}
              {!! Form::text('last_date',null,['class'=>'form-control datetimepicker-input', 'data-toggle'=>"datetimepicker", 'data-target'=>"#datetimepicker5", 'placeholder'=> __('Last Date')]) !!}
            </div>
            <div class="form-group">
              {!! Form::label('age_min', __('Age Min').' *',['class'=>'']) !!}
              {!! Form::number('age_min',null,['class'=>'form-control','placeholder'=> __('Age Min')]) !!}
            </div>
            <div class="form-group">
              {!! Form::label('age_max', __('Age Max').' *',['class'=>'']) !!}
              {!! Form::number('age_max',null,['class'=>'form-control','placeholder'=> __('Age Max')]) !!}
            </div>
            <div class="form-group">
              {!! Form::label('gender', __('Gender').' *',['class'=>'']) !!}
              {!! Form::select('gender', ['Any'=>'Any','Male'=>'Male','Female'=>'Female'],null,['class'=>'form-control','placeholder'=> __('Select Gender')]) !!}
            </div>
            <div class="form-group">
              {!! Form::label('edu_level_id', __('Edu Level').' *',['class'=>'']) !!}
              {!! Form::select('edu_level_id',$exams,null,['class'=>'form-control','placeholder'=> __('Edu Level')]) !!}
              {!! Form::label('edu_group_any', __('Any Education Group'),['class'=>'']) !!}
              {{ Form::checkbox('edu_group_any',1,null) }}
            </div>
            <div class="form-group">
              {!! Form::label('edu_group_ids', __('Education Group'),['class'=>'']) !!}
              {!! Form::select('edu_group_ids[]',$eduGroups,null,['class'=>'form-control select2','multiple'=>true]) !!}
            </div>
            <div class="form-group">
              {!! Form::label('salary', __('Salary'),['class'=>'']) !!}
              {!! Form::text('salary',null,['class'=>'form-control','placeholder'=> __('Salary')]) !!}
              {!! Form::label('nagotiable', __('Nagotiable'),['class'=>'']) !!}
              {{ Form::checkbox('nagotiable',1,null) }}
            </div>
            <div class="form-group">
              {!! Form::label('status', __('Publish Status'),['class'=>'']) !!}
              {{ Form::checkbox('status',1,null) }}
            </div>
            {{ Form::submit('Save',array('class'=>'btn btn-primary')) }}
          </div>
        </div>
      </div>
      {!! Form::close() !!}
    <!-- /.card-body -->
    <!-- /.card-footer-->
</div>
<!-- /.card -->
@endsection
@section('js')
{{-- <script src="{{ asset('assets/admin/plugins/summernote/summernote-bs4.min.js') }}"> </script> --}}
<script src="//cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="{{ asset('assets/admin/plugins/moment/moment.min.js') }}"> </script>
<!-- Tempusdominus -->
<script src="{{ asset('assets/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"> </script>
    <script>
        $(document).ready(function(){
          $('.textarea').summernote();

          $('#last_date').datetimepicker({
              //format: 'DD/MM/YYYY'
              format: 'YYYY-MM-DD'
          });

          $('#edu_level_id').change(function() {
            var edu_level_id = $(this).val();
            $.ajax({
                url: "{{route('student.education.group')}}?edu_level_id=" + edu_level_id,
                method: 'GET',
                success: function(data) {
                    console.log(data);                    
                    if(data.status == true){
                        $('#edu_group_ids').empty();
                        //$('#edu_group_id').append('<option value="">Any Group</option>');
                        $.each(data.groups, function(index, value) {
                            $('#edu_group_ids').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                }
            });
          });
        });
    </script>
@endsection