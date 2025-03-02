@extends('admin.layouts.layout')
@section('title',"Template Edit")
@section('css')
@endsection
@section('content')
<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Template Edit</h3>
        <div class="card-tools">
          <a href="{{ route('smsTemplate.index')}}"><i class="fas fa-arrow-alt-circle-left"></i> Back</a>
        </div>
    </div>
    <div class="card-body">
      @if (request()->routeIs('smsTemplate.edit'))
        {!! Form::model($smsTemplate, array('route'=>['smsTemplate.update',$smsTemplate],'method'=>'PUT','files' => true)) !!}
      @else
        {!! Form::open(array('route'=>['smsTemplate.store'],'files' => true)) !!}          
      @endif
        @include('admin.layouts._message')
        <div class="form-group">
            {!! Form::label('title', __('Title'),['class'=>'']) !!}
            {!! Form::text('title',null,['class'=>'form-control','requerd'=>'requerd','placeholder'=> __('Title')]) !!}
        </div>
        <div class="form-group">
            {!! Form::label('content', __('Content'),['class'=>'']) !!}
            {!! Form::textarea('content',null,['class'=>'form-control','requerd'=>'requerd', 'rows' => 2, 'placeholder'=> __('Content')]) !!}
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
@section('js')
<script>
  $(function () {
      
  });
</script>
@endsection