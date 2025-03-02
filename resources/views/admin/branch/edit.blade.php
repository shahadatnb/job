@extends('admin.layouts.layout')
@section('title',"Branch Edit")
@section('css')
@endsection
@section('content')
<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Branch Edit</h3>
        <div class="card-tools">
          <a href="{{ route('branch.index')}}"><i class="fas fa-arrow-alt-circle-left"></i> Back</a>
        </div>
    </div>
    <div class="card-body">
      @if (request()->routeIs('branch.edit'))
        {!! Form::model($branch, array('route'=>['branch.update',$branch],'method'=>'PUT','files' => true)) !!}
      @else
        {!! Form::open(array('route'=>['branch.store'],'files' => true)) !!}          
      @endif
        @include('admin.layouts._message')
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
          <div class="col-12 col-md-6">
            <div class="form-group">
                {!! Form::label('zila_id', __('Zila'),['class'=>'']) !!}
                {!! Form::select('zila_id',$zilas,null,['class'=>'form-control select2','requerd'=>'requerd','data-url'=> route('childLocation'),'placeholder'=> __('Select Zila')]) !!}
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="form-group">
                {!! Form::label('upazila_id', __('Upazila'),['class'=>'']) !!}
                {!! Form::select('upazila_id',$upaZilas,null,['class'=>'form-control select2','requerd'=>'requerd','placeholder'=> __('Select Upazila')]) !!}
            </div>
          </div>
        </div>
        @if (request()->routeIs('branch.create'))
        <div class="row">
          <div class="col-12 col-md-6">
            <div class="form-group">
                {!! Form::label('login_email', __('Login Email'),['class'=>'']) !!}
                {!! Form::email('login_email',null,['class'=>'form-control','requerd'=>'requerd','placeholder'=> __('Login Email')]) !!}
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="form-group">
                {!! Form::label('password', __('Password'),['class'=>'']) !!}
                {!! Form::password('password',['class'=>'form-control','requerd'=>'requerd','placeholder'=> __('Password')]) !!}
            </div>  
          </div>
        </div>
        @endif
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
                {!! Form::text('chairman_name',null,['class'=>'form-control','requerd'=>false,'placeholder'=> __('Chairman Name')]) !!}
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
          @if (request()->routeIs('branch.edit'))
            <div class="col-3">
                <div class="form-group">
                    {!! Form::label('status', __('Status'),['class'=>'']) !!}
                    {!! Form::checkbox('status',1,null,['class'=>'']) !!}
                </div>
            </div>            
            <div class="col-3">
              @if($branch->chairman_sign != '')
                <img src="{{asset('upload/site_file/'.$branch->chairman_sign)}}" alt="" width="100">
              @endif
              <div class="form-group">
                  {!! Form::label('chairman_sign', __('Chairman Signature'),['class'=>'']) !!}
                  {!! Form::file('chairman_sign') !!}
              </div>
            </div>           
          @endif
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
@section('js')
<script src="{{asset('/assets/admin')}}/js/main.js"></script>
<script>
    $(function () {
      $('#zila_id').change(function(){
          $.get($(this).data('url'), {
                option: $(this).val()
            },
            function(data) {
                var upazila_id = $('#upazila_id');
                upazila_id.empty();
                upazila_id.append("<option value=''>-----</option>");
                $.each(data, function(index, element) {
                  upazila_id.append("<option value='"+ element.id +"'>" + element.name + "</option>");
                });
            });
        });

    })
</script>
@endsection