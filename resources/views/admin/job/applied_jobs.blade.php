@extends('admin.layouts.layout')
@section('title',"Application Lists")
@section('css')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.24/b-1.7.0/b-colvis-1.7.0/b-html5-1.7.0/b-print-1.7.0/datatables.min.css"/>
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<style>
        @media print {
            body * {
                visibility: hidden;
            }
            .print-container, .print-container * {
                visibility: visible;
            }
            .print-container {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            .no-print {
                display: none;
            }
        }
        .print-container {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .print-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .print-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
        }
    </style>
@endsection
@section('content')
<!-- Default box -->
<div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-12 mb-2">
          {!! Form::model($data,['route' => 'job.application','method'=>'get','class'=>'d-print-none row']) !!}
          <div class="col-6 col-md-3">
            {!! Form::select('job_id',$jobs,null,['class'=>'form-control form-control-sm select2','placeholder'=> __('Job Title')]) !!}
          </div>
          {{-- <div class="col-6 col-md-2">
            {!! Form::text('email',null,['class'=>'form-control form-control-sm','placeholder'=> __('Email')]) !!}
          </div> --}}
          <div class="col-6 col-md-2">
            {!! Form::text('phone',null,['class'=>'form-control form-control-sm','placeholder'=> __('Phone')]) !!}
          </div>
          <div class="col-6 col-md-2">
            {!! Form::select('status',$applicationStatus,null,['class'=>'form-control form-control-sm select2','placeholder'=> __('Status')]) !!}
          </div>
          <div class="col-6 col-md-3">
            <div class="input-group">              
              {!! Form::text('date',null,['class'=>'form-control date js-datepicker','id'=>'date','autocomplete'=>'off','placeholder'=> __('dd-mm-yyyy')]) !!}
              {{ Form::text('time',null,array('class'=>'form-control timepicker datetimepicker-input', 'data-toggle'=>"datetimepicker", 'data-target'=>"#time", 'id'=>'time', 'maxlenth'=>'60','placeholder'=>'Time')) }}
            </div>
          </div>
          <div class="col-6 col-md-2">
            <div class="btn-group">
              <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-search"></i> Filter</button>
              <a class="btn btn-danger btn-sm ml-1" href="{{ route('job.application')}}"><i class="fas fa-sync"></i> Reset</a>
              {{-- <button type="button" class="btn btn-info btn-sm" onclick="sendSMS()" ><i class="fas fa-sms"></i> SMS</button> --}}
            </div>              
          </div>
          {!! Form::close() !!}
        </div>
      </div>
      <div class="row d-flex justify-content-end">        
        <div class="col-6 d-flex justify-content-end">
          <a class="btn btn-warning btn-sm ml-1" href="{{ route('job.application.export', request()->query()) }}" target="_blank"><i class="fas fa-file-image"></i> Export with Photo</a>
          <button type="button" class="btn btn-success btn-sm" onclick="PrintElem('#vivaSheet','Viva Sheet')"><i class="fas fa-print"></i> Viva Sheet</button>
          <button type="button" class="btn btn-info btn-sm" onclick="PrintElem('#attendanceSheet','Attendance Sheet')"><i class="fas fa-print"></i> Attendance Sheet</button>
          <button type="button" class="btn btn-info btn-sm" onclick="PrintElem('#selectedSheet','Selected Sheet')"><i class="fas fa-print"></i> Selected Sheet</button>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div id="errorMsg"></div>
      <div class="row d-flex justify-content-between mb-2">
        <div class="col-3">
            {!! Form::open(['route' => 'job.application_status','class'=>'d-print-none row','id'=>'application_status']) !!}
            <div class="input-group">
              {!! Form::select('status',$applicationStatus,null,['class'=>'form-control form-control-sm select2','placeholder'=> __('Approval Application')]) !!}
              <div class="input-group-append">
                <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> Save</button>
              </div>
            </div>
            {!! Form::close() !!}
          </div>
          <div class="col-3 text-right">
            Showing {{ $sl = $sl2 = $sl3 = $sl4 = $applied_jobs->firstItem() }} to {{ $applied_jobs->lastItem() }} of {{ $applied_jobs->total() }} Applications
          </div>
      </div>
      <div class="table-responsive">
        <table id="applied_jobs" class="table table-sm table-bordered table-striped">
            <thead>
            <tr>
              <th class="not-exported"><input class="checkbox" id="selectAll" name="selectAll" type="checkbox"> <label for="selectAll">All</label></th>
              <th>SL</th>
              <th>Image</th>
              <th>Name & Details</th>
              <th>Career Summary</th>
              <th>Experience and expected salary</th>
              <th>Applied On</th>
              {{-- <th>Remarks</th> --}}
              <th>Status</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($applied_jobs as $key => $item)
                <tr>
                  <td class="not-exported"><input class="candidate_list" name="candidate[]" type="checkbox" value="{{$item->id}}"></td>
                    <td>
                      {{-- {{ ($applied_jobs->currentPage() - 1) * $applied_jobs->perPage() + $loop->iteration }} --}}
                      {{ $sl++ }}
                    </td>
                    <td>
                      {{-- @dd($item->applicant) --}}
                      {{-- {{$item->applicant}} --}}
                      <img src="{{asset('/storage/'.$item->applicant->photo)}}" alt="" style="width: 80px;height: 80px;" class="rounded">
                    </td>
                    <td>
                      {{$item->applicant->name }} <br>
                      Age: {{$item->age }} <br>
                      @foreach ($item->applicant->educations as $education)
                        @if($education->examTitle)
                          {{$education->examTitle->name}}
                        @else
                          {{$education->exam ? $education->exam->name : '' }}
                        @endif
                          :  {{ $education->institute }}, {{ $education->group ? $education->group->name : '' }}, Result: {{ $education->result }} {{ $education->result_type == 'gpa' ? ' out of '.$education->out_of : '' }}<br>
                        {{-- {{ $education->board ? '(Board: '.$education->board->name.')' : '' }} --}}
                      @endforeach
                      Phone: {{$item->applicant->phone }} <br>
                      Email: {{$item->applicant->email }} <br>
                      Address: {{$item->applicant->village }}, {{$item->applicant->post_office }}{{$item->applicant->upazila ? ', '.$item->applicant->upazila->name : '' }}{{$item->applicant->district ? ', '.$item->applicant->district->name : '' }}
                    </td>
                    <td>
                      @php $total_experience = 0 @endphp
                      @foreach ($item->applicant->employments as $employment)
                        @php $end_date = $employment->is_current ? \Carbon\Carbon::now() : \Carbon\Carbon::parse($employment->end_date) @endphp
                        @php $length = \Carbon\Carbon::parse($employment->start_date)->diffInDays($end_date) @endphp
                        {{$employment->company_name }}, {{$employment->job_title }}, {{ $experience =  $length>0 ? number_format($length/365,1) : 0}}+ <br>
                        @php $total_experience += $experience @endphp
                      @endforeach
                      {{-- <p><strong>Present Address: </strong> {{ $item->applicant->permanent_village }}, {{ $item->applicant->permanent_post_office }}{{ $item->applicant->upazilaPermanent ? ', '.$item->applicant->upazilaPermanent->name : '' }}{{ $item->applicant->districtPermanent? ', '.$item->applicant->districtPermanent->name : '' }}</p> --}}
                    </td>
                    <td>
                      {{ $total_experience > 0 ? $total_experience.'+' : 'No experience' }}  and Taka: {{$item->expected_salary}}/-
                    </td>
                    <td>
                      {{ date('d-m-Y', strtotime($item->created_at)) }}
                    </td>
                    {{-- <td>
                      {{$item->remarks}}
                    </td> --}}
                    <td class="not-exported">
                      {{ $item->application_status->name }}
                    </td>
                    <td class="not-exported">
                      <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Action
                        </button>
                        <div class="dropdown-menu">
                          <a href="{{route('applicant.show',$item->applicant_id)}}" class="dropdown-item"><i class="fas fa-eye"></i> View CV</a>
                          <a href="{{route('applicant.edit',$item->applicant_id)}}" class="dropdown-item"><i class="fas fa-edit"></i> Edit Applicant</a>
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
      {{ $applied_jobs->appends($_GET)->links() }}
    </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->

<div class="d-none" id="vivaSheet">
  {{-- <div class="print-header">
      <h1>Viva Sheet</h1>
  </div> --}}
  <table border="1" width="100%" cellspacing="0">
    <thead>
      <tr>
        <th colspan="9" class="text-center">{{ config('settings.appTitle') }}</th>
      </tr>
      <tr>
        <th colspan="9" class="text-center">{{ config('settings.appAddress') }}</th>
      </tr>
      <tr>
        <th align="left" colspan="5">Interview Sheet For {{ $data['job_title'] }}</th>
        <th colspan="4">Date: {{ $data['date'] }} {{ $data['time'] }}</th>
      </tr>
      {{-- <tr>
        <th colspan="9">Interview Sheet For {{ $data['job_title'] }}</th>
      </tr> --}}
      <tr>
        <th>Roll No</th>
        <th>Image</th>
        <th>Name and Details</th>
        <th>Career Summary</th>
        <th>Experience And Salary</th>
        <th>Present Salary</th>
        <th>Viva Expected Salary</th>
        <th>Marks</th>
        <th>Position</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($applied_jobs as $key => $item)
        <tr>
          <td>{{ $sl2++ }}</td>
          <td>
            <img src="{{asset('/storage/'.$item->applicant->photo)}}" alt="" width="100">
          </td>
          <td>
            {{$item->applicant->name }} <br>
            Age: {{$item->age }} <br>
            @foreach ($item->applicant->educations as $education)
              @if($education->examTitle)
                {{$education->examTitle->name}}
              @else
                {{$education->exam ? $education->exam->name : '' }}
              @endif
              :  {{ $education->institute }}, {{ $education->group ? $education->group->name : '' }}, Result: {{ $education->result }} {{ $education->result_type == 'gpa' ? ' out of '.$education->out_of : '' }} <br>
              {{-- {{ $education->board ? '(Board: '.$education->board->name.')' : '' }} --}}
            @endforeach
            Phone: {{$item->applicant->phone }} <br>
            Email: {{$item->applicant->email }} <br>
            Address: {{$item->applicant->village }}, {{$item->applicant->post_office }}, {{$item->applicant->upazila ? $item->applicant->upazila->name : '' }}, {{$item->applicant->district ? $item->applicant->district->name : '' }}
          </td>
          <td>
            @php $total_experience = 0 @endphp
            @foreach ($item->applicant->employments as $employment)
              @php $end_date = $employment->is_current ? \Carbon\Carbon::now() : \Carbon\Carbon::parse($employment->end_date) @endphp
              @php $length = \Carbon\Carbon::parse($employment->start_date)->diffInDays($end_date) @endphp
              {{$employment->company_name }}, {{$employment->job_title }}, {{ $experience =  $length>0 ? number_format($length/365,1) : 0}}+ <br>
              @php $total_experience += $experience @endphp
            @endforeach
            {{-- <p><strong>Present Address: </strong> {{ $item->applicant->permanent_village }}, {{ $item->applicant->permanent_post_office }}{{ $item->applicant->upazilaPermanent ? ', '.$item->applicant->upazilaPermanent->name : '' }}{{ $item->applicant->districtPermanent? ', '.$item->applicant->districtPermanent->name : '' }}</p> --}}
          </td>
          <td>
            {{ $total_experience > 0 ? $total_experience.'+' : 'No experience' }}  and Taka: {{$item->expected_salary}}/-
          </td>
          <td>{{$item->result ? $item->result->present_salary : ''}}</td>
          <td>{{$item->result ? $item->result->preferred_salary : ''}}</td>
          <td>{{$item->result ? $item->result->marks : ''}}</td>
          <td>{{$item->result ? $item->result->position : ''}}</td>
        </tr>
      @endforeach
    </tbody>
  </table> 
</div>

<div class="d-none" id="selectedSheet">
  {{-- <div class="print-header">
      <h1>Viva Sheet</h1>
  </div> --}}
  <table border="1" width="100%" cellspacing="0">
    <thead>
      <tr>
        <th colspan="9" class="text-center">{{ config('settings.appTitle') }}</th>
      </tr>
      <tr>
        <th colspan="9" class="text-center">{{ config('settings.appAddress') }}</th>
      </tr>
      <tr>
        <th align="left" colspan="5">Selected Sheet For {{ $data['job_title'] }}</th>
        <th colspan="4">Date: {{ $data['date'] }} {{ $data['time'] }}</th>
      </tr>
      {{-- <tr>
        <th colspan="9">Interview Sheet For {{ $data['job_title'] }}</th>
      </tr> --}}
      <tr>
        <th>Roll No</th>
        <th>Image</th>
        <th>Name and Details</th>
        <th>Career Summary</th>
        <th>Experience And Salary</th>
        <th>Present Salary</th>
        <th>Viva Expected Salary</th>
        <th>Marks</th>
        <th>Position</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($applied_jobs as $key => $item)
        <tr>
          <td>{{ $sl3++ }}</td>
          <td>
            <img src="{{asset('/storage/'.$item->applicant->photo)}}" alt="" width="100">
          </td>
          <td>
            {{$item->applicant->name }} <br>
            Age: {{$item->age }} <br>
            @foreach ($item->applicant->educations as $education)
            @if($education->examTitle)
              {{$education->examTitle->name}}
            @else
              {{$education->exam ? $education->exam->name : '' }}
            @endif
              : {{ $education->institute }}, {{ $education->group ? $education->group->name : '' }}, Result: {{ $education->result }} {{ $education->result_type == 'gpa' ? ' out of '.$education->out_of : '' }} <br>
              {{-- {{ $education->board ? '(Board: '.$education->board->name.')' : '' }} --}}
            @endforeach
            Phone: {{$item->applicant->phone }} <br>
            Email: {{$item->applicant->email }} <br>
            Address: {{$item->applicant->village }}, {{$item->applicant->post_office }}, {{$item->applicant->upazila ? $item->applicant->upazila->name : '' }}, {{$item->applicant->district ? $item->applicant->district->name : '' }}
          </td>
          <td>
            @php $total_experience = 0 @endphp
            @foreach ($item->applicant->employments as $employment)
              @php $end_date = $employment->is_current ? \Carbon\Carbon::now() : \Carbon\Carbon::parse($employment->end_date) @endphp
              @php $length = \Carbon\Carbon::parse($employment->start_date)->diffInDays($end_date) @endphp
              {{$employment->company_name }}, {{$employment->job_title }}, {{ $experience =  $length>0 ? number_format($length/365,1) : 0}}+ <br>
              @php $total_experience += $experience @endphp
            @endforeach
            {{-- <p><strong>Present Address: </strong> {{ $item->applicant->permanent_village }}, {{ $item->applicant->permanent_post_office }}{{ $item->applicant->upazilaPermanent ? ', '.$item->applicant->upazilaPermanent->name : '' }}{{ $item->applicant->districtPermanent? ', '.$item->applicant->districtPermanent->name : '' }}</p> --}}
          </td>
          <td>
            {{ $total_experience > 0 ? $total_experience.'+' : 'No experience' }}  and Taka: {{$item->expected_salary}}/-
          </td>
          <td>{{$item->result ? $item->result->present_salary : ''}}</td>
          <td>{{$item->result ? $item->result->preferred_salary : ''}}</td>
          <td>{{$item->result ? $item->result->marks : ''}}</td>
          <td>{{$item->result ? $item->result->position : ''}}</td>
        </tr>
      @endforeach
    </tbody>
  </table>  
  <div class="row d-flex justify-content-around">
    @foreach ($jobSignature as $item)
       <div class="col-md-3 text-center" style="margin-top: 60px"> 
         <p class="m-0 font-weight-bold text-center">
          {{ $item->signature ? $item->signature->name : '' }} <br>
          {!! $item->signature ? $item->signature->description : '' !!}
        </p>
       </div>
    @endforeach
  </div>
</div>

<div class="d-none" id="attendanceSheet">
  <table border="1" width="100%" cellspacing="0">
    <thead>
      <tr>
        <th colspan="5" class="text-center">{{ config('settings.appTitle') }}</th>
      </tr>
      <tr>
        <th colspan="5" class="text-center">{{ config('settings.appAddress') }}</th>
      </tr>
      <tr>
        <th align="left" colspan="3">Subject: Attendance Sheet For {{ $data['job_title'] }}</th>
        <th colspan="2">Date: {{ $data['date'] }} {{ $data['time'] }}</th>
      </tr>
      {{-- <tr>
        <th colspan="9">Interview Sheet For {{ $data['job_title'] }}</th>
      </tr> --}}
      <tr>
        <th>Roll No</th>
        <th>Image</th>
        <th>Name and Details</th>
        <th>SMS & Call</th>
        <th>Signature</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($applied_jobs as $key => $item)
        <tr>
          <td>{{ $sl4++ }}</td>
          <td>
            <img src="{{asset('/storage/'.$item->applicant->photo)}}" alt="" width="100">
          </td>
          <td>
            {{$item->applicant->name }} <br>
            Age: {{$item->age }} <br>
            @foreach ($item->applicant->educations as $education)
              {{$education->exam ? $education->exam->name : '' }}, {{$education->edu_board_id != '' ? $education->board->name : $education->institute }} <br>
            @endforeach
            Phone: {{$item->applicant->phone }} <br>
            Email: {{$item->applicant->email }} <br>
            Address: {{$item->applicant->village }}, {{$item->applicant->post_office }}, {{$item->applicant->upazila ? $item->applicant->upazila->name : '' }}, {{$item->applicant->district ? $item->applicant->district->name : '' }}
          </td>          
          <td></td>
          <td></td>
        </tr>
      @endforeach
    </tbody>
  </table> 
</div>

@endsection
@section('js')
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.24/b-1.7.0/b-colvis-1.7.0/b-html5-1.7.0/b-print-1.7.0/datatables.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/file-saver@2.0.5/dist/FileSaver.min.js"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/html-to-image@1.11.11/dist/html-to-image.min.js"></script> --}}
{{-- <script src="{{asset('/assets/admin/js/main.js')}}"></script> --}}
<script src="{{ asset('assets/admin/plugins/moment/moment.min.js') }}"> </script>
<!-- Tempusdominus -->
<script src="{{ asset('assets/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"> </script>
@include('admin.layouts._datepicker')
<script>
/*
    function exportToExcel() {
      let html = document.getElementById('applied_jobs').outerHTML;
      let blob = new Blob([html], {type: 'application/vnd.ms-excel'});
      let a = document.createElement('a');
      a.href = URL.createObjectURL(blob);
      a.download = 'export.xls';
      a.click();
    }
*/

  $('.timepicker').datetimepicker({
      format: 'LT',
  });

    $(function () {

      $(':checkbox[name=selectAll]').click (function () {
        //$(':checkbox[name=applicant_list]').prop('checked', this.checked);
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
    });

      function PrintElem(elem,title){	     
	        Popup($(elem).html(),title);
	    }

	    function Popup(data,title) {
	        var mywindow = window.open('', title, 'height=562,width=795');
	        mywindow.document.write('<html><head><title>'+title+'</title>');
          //mywindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">');
	        mywindow.document.write(`<style type="text/css">
             table td, table th {border:1px solid #ccc; }
             .row {
                display: flex;
                flex-wrap: wrap;
                margin-right: -15px;
                margin-left: -15px;
              }

              .d-flex {
                display: flex !important;
              }

              .justify-content-around {
                justify-content: space-around !important;
              }

              .col-md-3 {
                position: relative;
                width: 100%;
                /* For medium screens and up (≥768px), width is 25% */
                flex: 0 0 25%;
                max-width: 25%;
              }

              .text-center {
                text-align: center !important;
              }

              .m-0 {
                margin: 0 !important;
              }

              .font-weight-bold {
                font-weight: 700 !important;
              }

              /* Inline style equivalent */
              .custom-margin-top {
                margin-top: 60px;
              }
            </style>`);
          mywindow.document.oriantation = 'landscape';
	        mywindow.document.write('</head><body >');
	        mywindow.document.write(data);
	        mywindow.document.write('</body></html>');
	        mywindow.document.close();
	        mywindow.print();
	        mywindow.close();
	        return true;
	    }

  </script>
@endsection
