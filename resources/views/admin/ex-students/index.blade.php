@extends('admin.layouts.layout')
@section('title',__("Students List"))
@section('css')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.24/b-1.7.0/b-colvis-1.7.0/b-html5-1.7.0/b-print-1.7.0/datatables.min.css"/>
@endsection
@section('content')
<!-- Default box -->
<div class="card">
    <div class="card-header d-print-none">
          {!! Form::model($data,['route' => 'exStudent.index','method'=>'get','class'=>'d-print-none row']) !!}
            <div class="col-6 col-md-2">
              {!! Form::select('department_id',$eduGroups,null,['class'=>'form-control form-control-sm','placeholder'=> __('Department')]) !!}
            </div>
            <div class="col-3 col-md-2">
              {!! Form::text('email',null,['class'=>'form-control form-control-sm','placeholder'=> __('Email')]) !!}
            </div>
            <div class="col-3 col-md-2">
              {!! Form::text('phone',null,['class'=>'form-control form-control-sm','placeholder'=> __('Phone')]) !!}
            </div>
            <div class="col-6 col-md-2">
              <div class="btn btn-group">
                <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-search"></i> Filter</button>
                {{-- <a class="btn btn-primary btn-sm" href="{{ route('student.create')}}"><i class="fas fa-plus"></i> New</a> --}}
              </div>              
            </div>
          {!! Form::close() !!}
      <div id="report-header" class="d-none d-print-block">
        <h2 class="text-center">{{__('Students List')}}</h2>
      </div>
    </div>
    <div class="card-body">
      @include('admin.layouts._message')        
      <div class="table-responsive">
        <table id="student" class="table table-sm table-bordered table-striped">
            <thead>
            <tr>
              {{-- <th>ID</th> --}}
              <th class="not-exported d-print-none">Action</th>
              <th class="not-exported">{{__('Photo')}}</th>
              <th>{{__('Name')}}</th>
              <th>{{__('Department')}}</th>
              <th>{{__('Mobile')}}</th>
              <th>{{__('Email')}}</th>
              <th>{{__('Roll No')}}</th>
              <th>{{__('Reg No')}}</th>
              <th>{{__('Session')}}</th>
              <th>{{__('Pas Year')}}</th>
              <th>{{__('Job Info')}}</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($exStudents as $item)
                <tr>
                    {{-- <td>{{$item->id}}</td> --}}
                    <td class="d-print-none not-exported">
                      <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         <i class="fas fa-bars"></i>
                        </button>
                        <div class="dropdown-menu">
                          {{-- @if (Auth::user()->hasAnyRole(['Manager','Admin'])) --}}
                          <div class="dropdown-divider"></div>
                            <a href="{{route('exStudent.edit',$item->id)}}" class="dropdown-item"><i class="fas fa-edit"></i> Edit</a>
                            {{-- <a href="{{route('student.show',$item->id)}}" class="dropdown-item"><i class="fas fa-eye"></i> Show</a> --}}
                            <div class="dropdown-divider"></div>
                            <form class="delete" action="{{ route('exStudent.destroy',$item->id) }}" method="post">
                              {{ csrf_field() }}
                              {{ method_field('DELETE') }}
                              <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Are You Sure To Delete This Item?')"><i class="fas fa-trash"></i> Delete</button>
                            </form>
                            {{-- <a onclick="return confirm('Are you sure remove?');" href="{{route('insuranceRemove',$item->id)}}" class="dropdown-item"><i class="fas fa-trash text-danger"></i> Remove</a> --}}
                          {{-- @endif --}}
                        </div>
                      </div>
                    </td>
                    <td class="not-exported"><img width="80" src="{{asset('/storage/'.$item->photo)}}" alt=""></td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->department ? $item->department->name : ''}}</td>
                    <td>{{$item->phone}}</td>
                    <td>{{$item->email}}</td>
                    <td>{{$item->roll_number}}</td>
                    <td>{{$item->registration_number}}</td>                   
                    <td>{{$item->session}}</td>                   
                    <td>{{$item->passing_year}}</td>                   
                    <td>{{$item->job_information}}</td>                   
                </tr>
                @endforeach
            </tbody>
        </table>
      </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <div class="text-center">{{ $exStudents->appends($_GET)->links() }}</div>
    </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->
@endsection
@section('js')
{{-- <script src="{{asset('/assets/admin')}}/plugins/datatables/datatables.min.js"></script> --}}
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.24/b-1.7.0/b-colvis-1.7.0/b-html5-1.7.0/b-print-1.7.0/datatables.min.js"></script>
<script>
    $(function () {
      // $("#example1").DataTable({
      //   "responsive": true,
      //   "autoWidth": false,
      // });

      var header = $('#report-header').html();
		
        $('#student').DataTable( {
            dom: '<"row d-print-none"<"col"B><"col"f><"col text-right"l>>tip',
            buttons: [
				'copy',
				{
                extend: 'excel',
					text: '<i title="Excel" class="far fa-file-excel"></i>',
                	messageTop: header,
                  exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                  },
            	},
                {
					extend: 'pdfHtml5',	//pdf
					text: '<i title="PDF" class="far fa-file-pdf"></i>',
					messageTop: header,
					exportOptions: {
						columns: ':visible:Not(.not-exported)',
						rows: ':visible'
					},
				},
				{
					extend: 'print',
					text: '<i title="Print" class="fas fa-print"></i>',
					messageTop: header,
					title: '',
					exportOptions: {
						columns: ':visible:Not(.not-exported)',
						rows: ':visible'
					},
					messageBottom: null
				},
				{
                  extend: 'colvis',
                  text: '<i title="column visibility" class="fa fa-eye"></i>',
                  columns: ':gt(0)'
              },
            ],
            "paging":   false,
            //"ordering": false,
        } );
    });
  </script>
@endsection
