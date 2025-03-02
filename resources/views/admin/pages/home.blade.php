@extends('admin.layouts.layout')
@section('title',"Select Branch")
@section('content')
  <!-- Default box -->
<div class="card">
  <div class="card-header">
      <h3 class="card-title">Select Branch</h3>
      <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
          <i class="fas fa-minus"></i></button>
      <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
          <i class="fas fa-times"></i></button>
      </div>
  </div>
  <div class="card-body">
      {!! Form::open(['route' => 'branchSelect']) !!}      
      <div class="form-group">
          {!! Form::label('branch', 'Branch') !!}
          <div class="input-group">
          {!! Form::select('branch_id', $branches, null, ['class' => 'form-control']) !!}
          <div class="input-group-append"></div>
              <button type="submit" class="btn btn-primary">Select</button>
          </div>
        </div>
      </div>
      {!! Form::close() !!}
  </div>
  <!-- /.card-body -->
  <div class="card-footer">
      
  </div>
  <!-- /.card-footer-->
</div>
<!-- /.card -->
@endsection
