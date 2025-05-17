@extends('admin.layouts.layout')
@section('title',"Job")
@section('css')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.24/b-1.7.0/b-colvis-1.7.0/b-html5-1.7.0/b-print-1.7.0/datatables.min.css"/>
@endsection
@section('content')
<!-- Default box -->
<div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-8">
          {!! Form::model($data,['route' => 'job.application','method'=>'get','class'=>'d-print-none row']) !!}
          <div class="col-6 col-md-3">
            {!! Form::select('job_id',$jobs,null,['class'=>'form-control form-control-sm select2','placeholder'=> __('Job Title')]) !!}
          </div>
          <div class="col-6 col-md-3">
            {!! Form::text('email',null,['class'=>'form-control form-control-sm','placeholder'=> __('Email')]) !!}
          </div>
          <div class="col-6 col-md-3">
            {!! Form::text('phone',null,['class'=>'form-control form-control-sm','placeholder'=> __('Phone')]) !!}
          </div>
          <div class="col-6 col-md-3">
            <div class="btn btn-group">
              <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-search"></i> Filter</button>
              <a class="btn btn-danger btn-sm" href="{{ route('job.application')}}"><i class="fas fa-sync"></i> Reset</a>
              {{-- <a class="btn btn-primary btn-sm" href="{{ route('student.create')}}"><i class="fas fa-plus"></i> New</a> --}}
            </div>              
          </div>
          {!! Form::close() !!}
        </div>
        <div class="col-4">
          {!! Form::open(['route' => 'job.application_status','class'=>'d-print-none row','id'=>'application_status']) !!}
          <div class="input-group">
            {!! Form::select('status',$applicationStatus,null,['class'=>'form-control form-control-sm select2','placeholder'=> __('Application Status')]) !!}
            <div class="input-group-append">
              <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> Save</button>
            </div>
          </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
    <div class="card-body">
      <div id="errorMsg"></div>
      <div class="table-responsive">
        <table id="applied_jobs" class="table table-sm table-bordered table-striped">
            <thead>
            <tr>
              <th class="not-exported"><input class="checkbox" id="selectAll" name="selectAll" type="checkbox"> <label for="selectAll">All</label></th>
              <th>SL</th>
              <th>Image</th>
              <th>Name</th>
              <th>Career Summary</th>
              <th>Experience And Application Status</th>
              <th>Applied On</th>
              <th>Remarks</th>
              <th>Action</th>
            </tr>
            </thead>
            @php $sl=1;
              //$date_of_birth = '1990-01-01';
              //$age = \Carbon\Carbon::parse($date_of_birth)->age;
            @endphp
            <tbody>
                @foreach ($applied_jobs as $item)
                <tr>
                  <td class="not-exported"><input class="candidate_list" name="candidate[]" type="checkbox" value="{{$item->id}}"></td>
                    <td>{{$sl++}}</td>
                    <td>
                      {{-- @dd($item->student) --}}
                      {{-- {{$item->student}} --}}
                      <img src="{{asset('/storage/'.$item->student->photo)}}" alt="" style="width: 80px;height: 80px;" class="rounded">
                    </td>
                    <td>
                      {{$item->student->name }} <br>
                      Age: {{$item->age }} <br>
                      @foreach ($item->student->educations as $education)
                        {{$education->exam ? $education->exam->name : '' }}, {{$education->edu_board_id != '' ? $education->board->name : $education->university }} <br>
                      @endforeach
                      Phone: {{$item->student->phone }} <br>
                      Email: {{$item->student->email }} <br>
                      Address: {{$item->student->village }}, {{$item->student->post_office }}, {{$item->student->upazila ? $item->student->upazila->name : '' }}, {{$item->student->district ? $item->student->district->name : '' }}
                    </td>
                    <td>
                      @php $total_experience = 0 @endphp
                      @foreach ($item->student->employments as $employment)
                        @php $length = \Carbon\Carbon::parse($employment->start_date)->diffInDays(\Carbon\Carbon::parse($employment->end_date)) @endphp
                        {{$employment->company_name }}, {{$employment->job_title }}, {{ $experience =  $length>0 ? number_format($length/365,1) : 0}}+ <br>
                        @php $total_experience += $experience @endphp
                      @endforeach
                    </td>
                    <td>
                      {{ $total_experience > 0 ? $total_experience.'+' : 'No experience' }} <br>
                      {{$item->expected_salary}}
                    </td>
                    <td>
                      {{ date('d-m-Y', strtotime($item->created_at)) }}
                    </td>
                    <td>
                      {{$item->remarks}}
                    </td>
                    <td class="not-exported">
                      {{ $item->application_status->name }}
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
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.24/b-1.7.0/b-colvis-1.7.0/b-html5-1.7.0/b-print-1.7.0/datatables.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>

<script>
    $(function () {

      $(':checkbox[name=selectAll]').click (function () {
        //$(':checkbox[name=student_list]').prop('checked', this.checked);
        $('.candidate_list').prop('checked', this.checked);
      });

      $("#application_status").submit(function(e) {
        e.preventDefault();
        $.LoadingOverlay("show");
        $("#errorMsg").html('');
        var url = $(this).attr('action');
        let formData = new FormData(this);
        var checkboxValues = [];
        $('input[name="candidate[]"]:checked').each(function() {
            checkboxValues.push($(this).val());
        });
        formData.append("candidate_ids", checkboxValues);
        console.log(checkboxValues);
        //formData.append("application_ids", $('.candidate_list:checked').serialize());
        //console.log(formData);
        $.ajax({
          url: url,
          type: "POST",
          data: formData,
          contentType: false,
          processData: false,
          success: function (data) {
            console.log(data);
            if (data.status == true) {
              location.reload();
            }
            if(data.status == false){
              if(data.message){
                  $("#errorMsg").append(`<div class="alert alert-danger"><strong>Warning: </strong>${data.message}</div>`);
              }
              if(data.errors){
                  data.errors.forEach(function(element){
                      $("#errorMsg").append(`<div class="alert alert-danger"><strong>Warning: </strong>${element}</div>`);
                  });
              } 
            }
          }
        });
        $.LoadingOverlay("hide");
      });

      var header = $('#report-header').html();
		
        $('#applied_jobs').DataTable( {
            dom: '<"row d-print-none"<"col"B><"col"f><"col text-right"l>>tip',
            buttons: [
				'copy',
				{
                extend: 'excel',
					text: '<i title="Excel" class="far fa-file-excel"></i>',
                	messageTop: header,
                  exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible',
                    // format: {
                    //     body: function(data, row, column, node) {
                    //         if (column === 1) {
                    //             return '<img src="'+data+'" width="80" height="80">';
                    //         } else {
                    //             return data;
                    //         }
                    //     }
                    // }
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
            "paging":   false,columns: [
              { orderable: false }, // first column
              null, // second column
              { orderable: false }, // third column
              null, // fourth column
              null, // fifth column
              null, // sixth column
              null, // seventh column
              null, // eighth column
              { orderable: false }, // ninth column
            ],
            //"ordering": false,
        } );
    });
  </script>
@endsection
