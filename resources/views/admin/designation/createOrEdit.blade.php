@extends('admin.layouts.layout')
@section('title',"Designation")
@section('content')
<!-- Default box -->
<div class="card card-outline card-info">
    <div class="card-header">
        <h3 class="card-title">{{__('Designation')}}</h3>
        <div class="card-tools">
          <a href="{{route('designation.index')}}" class="btn btn-sm btn-info"><i class="fas fa-arrow-alt-circle-left"></i> Back</a>
        </div>
    </div>
    <div class="card-body">
      @include('admin.layouts._message')
      @if (request()->routeIs('designation.edit'))
        {!! Form::model($designation, array('route'=>['designation.update',$designation],'method'=>'PUT','files' => true)) !!}
      @else
        {!! Form::open(array('route'=>['designation.store'],'files' => true)) !!}
      @endif
        <div class="row">
          <div class="col-6">
            <div class="form-group">
              {!! Form::label('name', __('Name'),['class'=>'']) !!}
              {!! Form::text('name',null,['class'=>'form-control','placeholder'=> __('Name')]) !!}
            </div>
          </div>
          <div class="col-3">
            <div class="form-group">
              {!! Form::label('serial', __('Serial'),['class'=>'']) !!}
              {!! Form::number('serial',null,['class'=>'form-control','placeholder'=> __('Serial')]) !!}
            </div>
          </div>         
          <div class="col-3">
            @if (request()->routeIs('designation.edit'))
            <div class="form-group">
              {!! Form::label('status', __('Status'),['class'=>'']) !!}
              {{ Form::checkbox('status',1,null) }}
            </div>
            @endif
          </div>
        </div>
      </div>
      {{ Form::submit('Save',array('class'=>'btn btn-primary')) }}
      {!! Form::close() !!}
    <!-- /.card-body -->
    <!-- /.card-footer-->
</div>
<!-- /.card -->
@endsection
