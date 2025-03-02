@extends('admin.layouts.layout')
@section('title',"Permission Edit")
@section('content')
<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Permission Edit</h3>
        <div class="card-tools">
            <a href="{{route('permissions.index')}}" class="btn btn-primary btn-sm float-md-right"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
    </div>
    <div class="card-body">
        {!! Form::model($permission, array('route'=>['permissions.update',$permission],'method'=>'PUT','files' => true)) !!}
        @include('admin.layouts._message')
        <div class="form-group">
            {!! Form::label('name', __('Name'),['class'=>'']) !!}
            {!! Form::text('name',null,['class'=>'form-control','placeholder'=> __('Name')]) !!}
        </div>
        <div class="form-group">
            {!! Form::label('slug', __('Slug'),['class'=>'']) !!}
            {!! Form::text('slug',null,['class'=>'form-control','placeholder'=> __('Slug')]) !!}
        </div>
        {{ Form::submit('Save',array('class'=>'btn btn-primary')) }}
      {!! Form::close() !!}
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        Footer
    </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->
@endsection