@extends('admin.layouts.layout')
@section('title',"Job")
@section('css')
<link href="//cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<style src="{{ asset('assets/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}"></style>
@endsection
@section('content')
<!-- Default box -->
<div class="card card-outline card-info">
    <div class="card-header">
        <h3 class="card-title">{{__('Job')}}</h3>
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
              {!! Form::label('designation_id', __('Designation'),['class'=>'']) !!}
              {!! Form::select('designation_id',$designations,null,['class'=>'form-control','placeholder'=> __('Designation')]) !!}
            </div>
            <div class="form-group">
              {!! Form::label('description', __('Description'),['class'=>'']) !!}
              {!! Form::textarea('description',null,['class'=>'form-control textarea','placeholder'=> __('Description')]) !!}
            </div>
            <div class="form-group">
              {!! Form::label('responsibility', __('Responsibility'),['class'=>'']) !!}
              {!! Form::textarea('responsibility',null,['class'=>'form-control textarea','placeholder'=> __('Responsibility')]) !!}
            </div>
            <div class="form-group">
              {!! Form::label('qualifications', __('Qualification'),['class'=>'']) !!}
              {!! Form::textarea('qualifications',null,['class'=>'form-control textarea','placeholder'=> __('Qualification')]) !!}
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
              {!! Form::label('last_date', __('Last Date'),['class'=>'']) !!}
              {!! Form::text('last_date',null,['class'=>'form-control datetimepicker-input', 'data-toggle'=>"datetimepicker", 'data-target'=>"#datetimepicker5", 'placeholder'=> __('Last Date')]) !!}
            </div>
            <div class="form-group">
              {!! Form::label('age_limit', __('Age Limit'),['class'=>'']) !!}
              {!! Form::number('age_limit',null,['class'=>'form-control','placeholder'=> __('Age Limit')]) !!}
            </div>
            <div class="form-group">
              {!! Form::label('salary', __('Salary'),['class'=>'']) !!}
              {!! Form::text('salary',null,['class'=>'form-control','placeholder'=> __('Salary')]) !!}
              {!! Form::label('nagotiable', __('Nagotiable'),['class'=>'']) !!}
              {{ Form::checkbox('nagotiable',1,null) }}
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
        });
    </script>
@endsection