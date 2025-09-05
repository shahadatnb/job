@extends('admin.layouts.layout')
@section('title',"Exam/Degree Title")
@section('content')
<!-- Default box -->
<div class="card card-outline card-info">
    <div class="card-header">
        <h3 class="card-title">{{__('Exam/Degree Title')}}</h3>
        <div class="card-tools">
          <a href="{{route('eduLevelGroup.index')}}" class="btn btn-sm btn-info"><i class="fas fa-arrow-alt-circle-left"></i> Back</a>
        </div>
    </div>
    <div class="card-body">
      @include('admin.layouts._message')
      @if (request()->routeIs('eduLevelGroup.edit'))
        {!! Form::model($eduLevelGroup, array('route'=>['eduLevelGroup.update',$eduLevelGroup],'method'=>'PUT','files' => true)) !!}
      @else
        {!! Form::open(array('route'=>['eduLevelGroup.store'],'files' => true)) !!}
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
              {!! Form::label('edu_level_id', __('Edu Level'),['class'=>'']) !!}
              {!! Form::select('edu_level_id',$exams,null,['class'=>'form-control','placeholder'=> __('Edu Level')]) !!}
            </div>
          </div>         
          <div class="col-3">
            <div class="form-group">
              {!! Form::label('sl', __('Serial'),['class'=>'']) !!}
              {!! Form::number('sl',null,['class'=>'form-control','placeholder'=> __('Serial')]) !!}
            </div>
          </div>
          <div class="col-3">
            @if (request()->routeIs('eduBoard.edit'))
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
