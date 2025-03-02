@extends('admin.layouts.layout')
@section('page_title',"Settings")
@section('content')
<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Settings</h3>
        <div class="card-tools">
          <a href="{{route('siteCache')}}" class="btn btn-primary btn-sm"> <i class="fas fa-sync"></i> Applay</a>
        </div>
    </div>
    <div class="card-body">
      @include('admin.layouts._message')
      {!! Form::model($settings,['route'=>['saveSetting'],'method'=>'PUT','class'=>'form-horizontal','enctype'=>'multipart/form-data']) !!}
      {!! Form::hidden('id',null) !!}
      <div class="row">
        <div class="col-12 col-md-6">
          <div class="form-group">
              {!! Form::label('name', __('Name'),['class'=>'']) !!}
              {!! Form::text('name',null,['class'=>'form-control','requerd'=>'requerd','placeholder'=> __('Name')]) !!}
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="form-group">
              {!! Form::label('website', __('Website'),['class'=>'']) !!}
              {!! Form::text('website',null,['class'=>'form-control','requerd'=>false,'placeholder'=> __('Website')]) !!}
          </div>  
        </div>
      </div>
      <div class="row">
        <div class="col-12 col-md-12">
          <div class="form-group">
              {!! Form::label('address', __('Address'),['class'=>'']) !!}
              {!! Form::text('address',null,['class'=>'form-control','requerd'=>'requerd','placeholder'=> __('Address')]) !!}
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="form-group">
              {!! Form::label('contact', __('Contact Phone/Mobile'),['class'=>'']) !!}
              {!! Form::text('contact',null,['class'=>'form-control','requerd'=>'requerd','placeholder'=> __('Contact Phone/Mobile')]) !!}
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="form-group">
            {!! Form::label('email', __('Email'),['class'=>'']) !!}
            {!! Form::email('email',null,['class'=>'form-control','requerd'=>false,'placeholder'=> __('Email')]) !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12 col-md-6">
          <div class="form-group">
              {!! Form::label('chairman_name', __('Chairman Name'),['class'=>'']) !!}
              {!! Form::text('chairman_name',null,['class'=>'form-control','requerd'=>false,'placeholder'=> __('Chairman')]) !!}
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="form-group">
            {!! Form::label('chairman_email', __('Chairman Email'),['class'=>'']) !!}
            {!! Form::email('chairman_email',null,['class'=>'form-control','requerd'=>false,'placeholder'=> __('Chairman Email')]) !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12 col-md-6">
          <div class="form-group">
              {!! Form::label('chairman_contact', __('Chairman Contact'),['class'=>'']) !!}
              {!! Form::text('chairman_contact',null,['class'=>'form-control','requerd'=>false,'placeholder'=> __('Chairman Contact')]) !!}
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="form-group">
              {!! Form::label('chairman_designation', __('Chairman Designation'),['class'=>'']) !!}
              {!! Form::text('chairman_designation',null,['class'=>'form-control','requerd'=>false,'placeholder'=> __('Chairman Designation')]) !!}
          </div>
        </div>
      </div>
      <div class="row">
          <div class="col-3">
            @if($settings->logo != '')
              <img src="{{asset('upload/site_file/'.$settings->logo)}}" alt="" width="100">
            @endif
            <div class="form-group">
                {!! Form::label('logo', __('Logo'),['class'=>'']) !!}
                {!! Form::file('logo') !!}
            </div>
          </div>
          <div class="col-3">
            @if($settings->favicon != '')
              <img src="{{asset('upload/site_file/'.$settings->favicon)}}" alt="" width="100">
            @endif
            <div class="form-group">
              {!! Form::label('favicon', __('Favicon'),['class'=>'']) !!}
              {!! Form::file('favicon') !!}
            </div>
          </div>
          <div class="col-3">
            @if($settings->chairman_sign != '')
              <img src="{{asset('upload/site_file/'.$settings->chairman_sign)}}" alt="" width="100">
            @endif
            <div class="form-group">
                {!! Form::label('chairman_sign', __('Chairman Signature'),['class'=>'']) !!}
                {!! Form::file('chairman_sign') !!}
            </div>
          </div>
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