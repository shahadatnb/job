@extends('admin.layouts.layout')
@section('title',"Student Statitics")
@section('content')
<style type="text/css">

 </style>
<!-- Default box -->
<div class="card">
    <div class="card-header">
        {!! Form::model($data,['route' => 'student_statitics','method'=>'get','class'=>'d-print-none ']) !!}
        <div class="row">
            <div class="col">
              {{-- {!! Form::select('session_id',$academicYear,null,['class'=>'form-control select2','placeholder'=> __('Academic Year')]) !!} --}}
              {!! Form::text('session',null,['class'=>'form-control','placeholder'=> __('Session')]) !!}
            </div>
            <div class="col">
              {!! Form::select('shift',['1st'=>'1st Shift','2nd'=>'2nd Shift'],null,['class'=>'form-control','placeholder'=> __('Shift')]) !!}
            </div>
            <div class="col">
              {!! Form::select('student_group',['A'=>'A','B'=>'B'],null,['class'=>'form-control','placeholder'=> __('Group')]) !!}
            </div>
            <div class="col-3">
              <div class="btn btn-group">
                <button type="submit" class="btn btn-success"><i class="fas fa-search"></i> Filter</button>
                <button type="button" class="btn btn-info" onclick="window.print();">Print</button>
              </div>
            </div>
          </div>
          {!! Form::close() !!}
    </div>
    <div class="card-body">      
      <table id="example1" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th rowspan="2" class="text-center align-middle">Class</th>
          <th colspan="2" class="text-center">Gender</th>
          <th colspan="4" class="text-center">Relegion</th>
          <th rowspan="2" class="text-center align-middle">Ethnic</th>
          <th rowspan="2" class="text-center align-middle">Autistic</th>
          <th rowspan="2" class="text-center align-middle">Total</th>
        </tr>
        <tr>
          <th>Male</th>
          <th>Female</th>
          <th>Islam</th>
          <th>Hindu</th>
          <th>Christian</th>
          <th>Buddhist</th>
        </tr>
        </thead>
        <tbody>
        @foreach($students->groupBy('semester_id') as $class)
          <tr>
            <td>{{$class->first()->semester ? $class->first()->semester->title : ''}}</td>
            <td>{{$class->where('sex','Male')->count()}}</td>
            <td>{{$class->where('sex','Female')->count()}}</td>
            <td>{{$class->where('religion','Islam')->count()}}</td>
            <td>{{$class->where('religion','Hindu')->count()}}</td>
            <td>{{$class->where('religion','Christian')->count()}}</td>
            <td>{{$class->where('religion','Buddhist')->count()}}</td>
            <td></td>
            <td></td>
            <td>{{$class->count()}}</td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
        <!-- /.card-footer-->
  </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->
@endsection