@extends('admin.layouts.layout')
@section('title',"Result Entry")
@section('css')

@endsection
@section('content')
<!-- Default box -->
<div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-12 mb-2">
          {!! Form::model($data,['route' => 'job.result_entry','method'=>'get','class'=>'d-print-none row']) !!}
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
          {{-- <div class="col-6 col-md-3">
            <div class="input-group">              
              {!! Form::text('date',null,['class'=>'form-control date js-datepicker','id'=>'date','autocomplete'=>'off','placeholder'=> __('dd-mm-yyyy')]) !!}
              {{ Form::text('time',null,array('class'=>'form-control timepicker datetimepicker-input', 'data-toggle'=>"datetimepicker", 'data-target'=>"#time", 'id'=>'time', 'maxlenth'=>'60','placeholder'=>'Time')) }}
            </div>
          </div> --}}
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
    </div>
    <div class="card-body">
      <div id="errorMsg"></div>
      <div class="row d-flex justify-content-between mb-2">
          <div class="col-3 text-right">
            @if ($applied_jobs)
            Showing {{ $sl = $applied_jobs->firstItem() }} to {{ $applied_jobs->lastItem() }} of {{ $applied_jobs->total() }} Applications
            @endif
          </div>
      </div>
      {!! Form::open(['route' => 'job.result_save','id'=>'result_save']) !!}
      <div class="table-responsive">
        <table id="applied_jobs" class="table table-sm table-bordered table-striped">
            <thead>
            <tr>
              <th>SL</th>
              <th>Image</th>
              <th>Name & Details</th>
              <th>Present Salary</th>
              <th>Preferred Salary</th>
              <th>Marks</th>
              <th>Position</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($applied_jobs as $key => $item)
                <tr>
                    <td>
                      {{ $sl++ }}
                    </td>
                    <td>
                      <img src="{{asset('/storage/'.$item->applicant->photo)}}" alt="" style="width: 80px;height: 80px;" class="rounded">
                    </td>
                    <td>
                      {{$item->applicant->name }} <br>
                      Age: {{$item->age }} <br>
                      Phone: {{$item->applicant->phone }} <br>
                      Email: {{$item->applicant->email }} <br>
                      Address: {{$item->applicant->village }}, {{$item->applicant->post_office }}{{$item->applicant->upazila ? ', '.$item->applicant->upazila->name : '' }}{{$item->applicant->district ? ', '.$item->applicant->district->name : '' }}
                    </td>
                    <td>
                      <input type="hidden" class="form-control" name="application_id[]" value="{{$item->id}}">
                      <input type="number" class="form-control" name="present_salary[]" value="{{$item->result ? $item->result->present_salary : ''}}">
                    </td>
                    <td>
                      <input type="number" class="form-control" name="preferred_salary[]" value="{{$item->result ? $item->result->preferred_salary : ''}}">
                    </td>
                    <td>
                      <input type="number" class="form-control" name="marks[]" value="{{$item->result ? $item->result->marks : ''}}">
                    </td>
                    <td>
                      <input type="number" class="form-control" name="position[]" value="{{$item->result ? $item->result->position : ''}}">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
      {!! Form::close() !!}
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      @if($applied_jobs != [])
      {{ $applied_jobs->appends($_GET)->links() }}
      @endif
    </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->

@endsection
@section('js')
<script src="{{ asset('assets/admin/plugins/moment/moment.min.js') }}"> </script>
<!-- Tempusdominus -->
<script src="{{ asset('assets/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"> </script>
@include('admin.layouts._datepicker')
<script>

  $("#result_save").submit(function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
      url: $(this).attr('action'),
      method: $(this).attr('method'),
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: formData,
      dataType: 'json',
      contentType: false,
      cache: false,
      processData: false,
      beforeSend: function() {
        $('#loading').show();
        $('#errorMsg').empty();
      },
      success: function(response) {
        $('#loading').hide();
        if (response.status == true) {
          if (response.message) {
            $('#errorMsg').append(
              `<div class="alert alert-success"><strong>Success: </strong>${response.message}</div>`);
          }
        } else {
          if (response.message) {
            $('#errorMsg').append(
              `<div class="alert alert-danger"><strong>Warning: </strong>${response.message}</div>`);
          }
          if (response.errors) {
            $.each(response.errors, function(key, value) {
              $('#errorMsg').append(
                `<div class="alert alert-danger"><strong>Warning: </strong>${value}</div>`);
            });
          }
        }
      }
    });
  });

  $('.timepicker').datetimepicker({
      format: 'LT',
  });


  </script>
@endsection
