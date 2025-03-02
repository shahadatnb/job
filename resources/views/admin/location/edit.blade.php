@extends('admin.layouts.layout')
@section('title',"Location Edit")
@section('content')
<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Location Edit</h3>
        <div class="card-tools">
            <a href="{{route('location.index')}}" class="btn btn-success">Back</a>
        </div>
    </div>
    <div class="card-body">
        @if(request()->routeIs('location.edit'))
            {!! Form::model($location, array('route'=>['location.update',$location],'method'=>'PUT')) !!}
        @else
            {!! Form::open(array('route'=>['location.store'])) !!}
        @endif
        @include('admin.layouts._message')
        <div class="form-group">
            {!! Form::label('name', __('Name'),['class'=>'']) !!}
            {!! Form::text('name',null,['class'=>'form-control','placeholder'=> __('Name')]) !!}
        </div>
        <div class="form-group">
            {!! Form::label('name_bn', __('Name Bangla'),['class'=>'']) !!}
            {!! Form::text('name_bn',null,['class'=>'form-control','placeholder'=> __('Name Bangla')]) !!}
        </div>
        <div class="form-group">
            {!! Form::label('parent_id', __('Parant Location'),['class'=>'']) !!}
            {!! Form::select('parent_id',$plocations,null,['class'=>'form-control select2','placeholder'=> __('Parant Location')]) !!}
          </div>
        {{ Form::submit('Save',array('class'=>'btn btn-primary')) }}
      {!! Form::close() !!}
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        
    </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->
@endsection