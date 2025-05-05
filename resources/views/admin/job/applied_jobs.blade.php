@extends('admin.layouts.layout')
@section('title',"Job")
@section('css')
{{-- <link rel="stylesheet" href="{{asset('/assets/admin')}}/plugins/datatables/datatables.min.css"> --}}
@endsection
@section('content')
<!-- Default box -->
<div class="card">
    <div class="card-header">
      {!! Form::model($data,['route' => 'job.application','method'=>'get','class'=>'d-print-none row']) !!}
      <div class="col-6 col-md-3">
        {!! Form::select('job_id',$jobs,null,['class'=>'form-control form-control-sm select2','placeholder'=> __('Job Title')]) !!}
      </div>
      {{-- <div class="col-3 col-md-2">
        {!! Form::text('email',null,['class'=>'form-control form-control-sm','placeholder'=> __('Email')]) !!}
      </div>
      <div class="col-3 col-md-2">
        {!! Form::text('phone',null,['class'=>'form-control form-control-sm','placeholder'=> __('Phone')]) !!}
      </div> --}}
      <div class="col-6 col-md-2">
        <div class="btn btn-group">
          <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-search"></i> Filter</button>
          {{-- <a class="btn btn-primary btn-sm" href="{{ route('student.create')}}"><i class="fas fa-plus"></i> New</a> --}}
        </div>              
      </div>
    {!! Form::close() !!}
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table id="example1" class="table table-sm table-bordered table-striped">
            <thead>
            <tr>
              <th>ID</th>
              <th>Designation</th>
              <th>Sallary</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($applied_jobs as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->job->title }}</td>
                    <td>{{$item->expected_salary}}</td>
                    <td>
                      <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Action
                        </button>
                        <div class="dropdown-menu">
                          <a href="{{route('student.show',$item->student_id)}}" class="dropdown-item"><i class="fas fa-eye"></i> View CV</a>
                          {{-- @if (Auth::user()->hasAnyRole(['Manager','Admin'])) --}}
                          <div class="dropdown-divider"></div>
                            {{-- <a href="{{route('job.edit',$item->id)}}" class="dropdown-item"><i class="fas fa-edit"></i> Edit</a> --}}
                            <div class="dropdown-divider"></div>
                            
                            {{-- <a onclick="return confirm('Are you sure remove?');" href="{{route('insuranceRemove',$item->id)}}" class="dropdown-item"><i class="fas fa-trash text-danger"></i> Remove</a> --}}
                          {{-- @endif --}}
                        </div>
                      </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
      </div>
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
    
</script>
@endsection
