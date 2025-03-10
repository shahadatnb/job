@extends('admin.layouts.layout')
@section('title',__("Students List"))
@section('css')
<link rel="stylesheet" href="{{asset('/assets/admin')}}/plugins/datatables/datatables.min.css">
@endsection
@section('content')
<!-- Default box -->
<div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col">
          {!! Form::model($data,['route' => 'student.marksheet','method'=>'get','class'=>'d-print-none']) !!}
          <div class="row">
            <div class="col">
              {{-- {!! Form::select('session_id',$academicYear,null,['class'=>'form-control select2','placeholder'=> __('Academic Year')]) !!} --}}
              {!! Form::text('session',null,['class'=>'form-control','placeholder'=> __('Session')]) !!}
            </div>
            <div class="col">
              {!! Form::select('department_id',$departments,null,['class'=>'form-control select2','placeholder'=> __('Department')]) !!}
            </div>
            <div class="col">
              {!! Form::number('class_roll',null,['class'=>'form-control','placeholder'=> __('class_roll No')]) !!}
            </div>
            <div class="col">{{ Form::submit(__('Filter'),array('class'=>'btn btn-success')) }}</div>
          </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>ID</th>
              <th>{{__('Photo')}}</th>
              <th>{{__('Reg No')}}</th>
              <th>{{__('Name')}}</th>
              <th>{{__('Academic Year')}}</th>
              <th>{{__('Department')}}</th>
              <th>{{__('Exam Held')}}</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($students as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td><img width="80" src="{{asset('/storage/'.$item->photo)}}" alt=""></td>
                    <td>{{$item->reg_no}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->session}}</td>
                    {{-- <td>@if($item->academicYear){{$item->academicYear->year}}@endif</td> --}}
                    <td>@if($item->department){{$item->department->title}}@endif</td>
                    <td>{{$item->exam_held}}</td>
                    <td>
                      <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Action
                        </button>
                        <div class="dropdown-menu">
                          {{-- @if (Auth::user()->hasAnyRole(['Manager','Admin'])) --}}
                          <div class="dropdown-divider"></div>
                            <a href="{{route('student.appeared.download',$item->id)}}" class="dropdown-item"><i class="fas fa-file-pdf"></i> Download Appeared</a>
                            <a href="{{route('student.testomonial.download',$item->id)}}" class="dropdown-item"><i class="fas fa-file-pdf"></i> Download Testimonial</a>
                            {{-- <a href="{{route('student.marksheet.download',$item->id)}}" class="dropdown-item"><i class="fas fa-file-pdf"></i> Download Marksheet</a> --}}
                            {{-- <a href="{{route('student.certificate.download',$item->id)}}" class="dropdown-item"><i class="fas fa-file-pdf"></i> Download Certificate</a>                             --}}
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
      @if($students != [])
      <div class="text-center">{{ $students->appends($_GET)->links() }}</div>
      @endif
    </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->
@endsection
@section('js')
<script src="{{asset('/assets/admin')}}/plugins/datatables/datatables.min.js"></script>
<script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true,
        "autoWidth": false,
      });
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>
@endsection
