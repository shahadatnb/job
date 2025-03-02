@extends('admin.layouts.layout')
@section('title',"Service")
@section('content')
<!-- Default box -->
<div class="card card-outline card-info">
    <div class="card-header">
        <h3 class="card-title">Patient</h3>
        <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
        <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
        </div>
    </div>
    <div class="card-body">
      @include('admin.layouts._message')
        {!! Form::model($language,array('route'=>['language.update',$language],'method'=>'put')) !!}
          <div class="form-group">
              {!! Form::label('code', __('Code'),['class'=>'']) !!}
              {!! Form::text('code',null,['class'=>'form-control','autocomplete'=>'off','placeholder'=> __('Code')]) !!}
          </div>
          <div class="form-group">
              {!! Form::label('en', __('English'),['class'=>'']) !!}
              {!! Form::text('en',null,['class'=>'form-control','autocomplete'=>'off','placeholder'=> __('English')]) !!}
          </div>
          <div class="form-group">
              {!! Form::label('bn', __('Bangla'),['class'=>'']) !!}
              {!! Form::text('bn',null,['class'=>'form-control','autocomplete'=>'off','placeholder'=> __('Bangla')]) !!}
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
      </div>

      {!! Form::close() !!}
    <!-- /.card-body -->
    <div class="card-footer">
        Footer
    </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->
@endsection
