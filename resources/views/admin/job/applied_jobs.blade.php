@extends('admin.layouts.layout')
@section('title',"Application Lists")
@section('css')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.24/b-1.7.0/b-colvis-1.7.0/b-html5-1.7.0/b-print-1.7.0/datatables.min.css"/>
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
          <div class="col-6 col-md-2">
            {!! Form::text('email',null,['class'=>'form-control form-control-sm','placeholder'=> __('Email')]) !!}
          </div>
          <div class="col-6 col-md-2">
            {!! Form::text('phone',null,['class'=>'form-control form-control-sm','placeholder'=> __('Phone')]) !!}
          </div>
          <div class="col-6 col-md-2">
            {!! Form::select('status',$applicationStatus,null,['class'=>'form-control form-control-sm select2','placeholder'=> __('Status')]) !!}
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
      <div class="row d-flex justify-content-between">        
        <div class="col-6">
          <button type="button" class="btn btn-primary btn-sm" onclick="exportTableToExcel('applied_jobs')" ><i class="fas fa-file-excel"></i> Export</button>
          <button type="button" class="btn btn-success btn-sm" onclick="PrintElem('#vivaSheet','Viva Sheet')"><i class="fas fa-print"></i> Viva Sheet</button>
          <button type="button" class="btn btn-info btn-sm" onclick="PrintElem('#attendanceSheet','Attendance Sheet')"><i class="fas fa-print"></i> Attendance Sheet</button>
          <button type="button" class="btn btn-info btn-sm" onclick="PrintElem('#selectedSheet','Selected Sheet')"><i class="fas fa-print"></i> Selected Sheet</button>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div id="errorMsg"></div>
      <div class="col-3 mb-2">
          {!! Form::open(['route' => 'job.application_status','class'=>'d-print-none row','id'=>'application_status']) !!}
          <div class="input-group">
            {!! Form::select('status',$applicationStatus,null,['class'=>'form-control form-control-sm select2','placeholder'=> __('Approval Application')]) !!}
            <div class="input-group-append">
              <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> Save</button>
            </div>
          </div>
          {!! Form::close() !!}
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
                        {{$education->exam ? $education->exam->name : '' }}: {{ $education->university }}{{ $education->board ? '(Board: '.$education->board->name.')' : '' }}, {{ $education->group ? $education->group->name : '' }}, Result: {{ $education->result }} {{ $education->result_type == 'gpa' ? ' out of '.$education->out_of : '' }}<br>
                      @endforeach
                      Phone: {{$item->student->phone }} <br>
                      Email: {{$item->student->email }} <br>
                      Address: {{$item->student->village }}, {{$item->student->post_office }}{{$item->student->upazila ? ', '.$item->student->upazila->name : '' }}{{$item->student->district ? ', '.$item->student->district->name : '' }}
                    </td>
                    <td>
                      @php $total_experience = 0 @endphp
                      @foreach ($item->student->employments as $employment)
                        @php $end_date = $employment->is_current ? \Carbon\Carbon::now() : \Carbon\Carbon::parse($employment->end_date) @endphp
                        @php $length = \Carbon\Carbon::parse($employment->start_date)->diffInDays($end_date) @endphp
                        {{$employment->company_name }}, {{$employment->job_title }}, {{ $experience =  $length>0 ? number_format($length/365,1) : 0}}+ <br>
                        @php $total_experience += $experience @endphp
                      @endforeach
                      <p><strong>Present Address: </strong> {{ $item->student->permanent_village }}, {{ $item->student->permanent_post_office }}{{ $item->student->upazilaPermanent ? ', '.$item->student->upazilaPermanent->name : '' }}{{ $item->student->districtPermanent? ', '.$item->student->districtPermanent->name : '' }}</p>
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
        <th align="left" colspan="6">Interview Sheet For {{ $data['job_title'] }}</th>
        <th colspan="3">Date: {{ date('d-m-Y') }}</th>
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
          <td>{{ ++$key }}</td>
          <td>
            <img src="{{asset('/storage/'.$item->student->photo)}}" alt="" width="100">
          </td>
          <td>
            {{$item->student->name }} <br>
            Age: {{$item->age }} <br>
            @foreach ($item->student->educations as $education)
              {{$education->exam ? $education->exam->name : '' }}: {{ $education->university }}{{ $education->board ? '(Board: '.$education->board->name.')' : '' }}, {{ $education->group ? $education->group->name : '' }}, Result: {{ $education->result }} {{ $education->result_type == 'gpa' ? ' out of '.$education->out_of : '' }} <br>
            @endforeach
            Phone: {{$item->student->phone }} <br>
            Email: {{$item->student->email }} <br>
            Address: {{$item->student->village }}, {{$item->student->post_office }}, {{$item->student->upazila ? $item->student->upazila->name : '' }}, {{$item->student->district ? $item->student->district->name : '' }}
          </td>
          <td>
            @php $total_experience = 0 @endphp
            @foreach ($item->student->employments as $employment)
              @php $end_date = $employment->is_current ? \Carbon\Carbon::now() : \Carbon\Carbon::parse($employment->end_date) @endphp
              @php $length = \Carbon\Carbon::parse($employment->start_date)->diffInDays($end_date) @endphp
              {{$employment->company_name }}, {{$employment->job_title }}, {{ $experience =  $length>0 ? number_format($length/365,1) : 0}}+ <br>
              @php $total_experience += $experience @endphp
            @endforeach
            <p><strong>Present Address: </strong> {{ $item->student->permanent_village }}, {{ $item->student->permanent_post_office }}{{ $item->student->upazilaPermanent ? ', '.$item->student->upazilaPermanent->name : '' }}{{ $item->student->districtPermanent? ', '.$item->student->districtPermanent->name : '' }}</p>
          </td>
          <td>
            {{ $total_experience > 0 ? $total_experience.'+' : 'No experience' }}  and Taka: {{$item->expected_salary}}/-
          </td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
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
        <th align="left" colspan="6">Selected Sheet For {{ $data['job_title'] }}</th>
        <th colspan="3">Date: {{ date('d-m-Y') }}</th>
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
          <td>{{ ++$key }}</td>
          <td>
            <img src="{{asset('/storage/'.$item->student->photo)}}" alt="" width="100">
          </td>
          <td>
            {{$item->student->name }} <br>
            Age: {{$item->age }} <br>
            @foreach ($item->student->educations as $education)
              {{$education->exam ? $education->exam->name : '' }}: {{ $education->university }}{{ $education->board ? '(Board: '.$education->board->name.')' : '' }}, {{ $education->group ? $education->group->name : '' }}, Result: {{ $education->result }} {{ $education->result_type == 'gpa' ? ' out of '.$education->out_of : '' }} <br>
            @endforeach
            Phone: {{$item->student->phone }} <br>
            Email: {{$item->student->email }} <br>
            Address: {{$item->student->village }}, {{$item->student->post_office }}, {{$item->student->upazila ? $item->student->upazila->name : '' }}, {{$item->student->district ? $item->student->district->name : '' }}
          </td>
          <td>
            @php $total_experience = 0 @endphp
            @foreach ($item->student->employments as $employment)
              @php $end_date = $employment->is_current ? \Carbon\Carbon::now() : \Carbon\Carbon::parse($employment->end_date) @endphp
              @php $length = \Carbon\Carbon::parse($employment->start_date)->diffInDays($end_date) @endphp
              {{$employment->company_name }}, {{$employment->job_title }}, {{ $experience =  $length>0 ? number_format($length/365,1) : 0}}+ <br>
              @php $total_experience += $experience @endphp
            @endforeach
            <p><strong>Present Address: </strong> {{ $item->student->permanent_village }}, {{ $item->student->permanent_post_office }}{{ $item->student->upazilaPermanent ? ', '.$item->student->upazilaPermanent->name : '' }}{{ $item->student->districtPermanent? ', '.$item->student->districtPermanent->name : '' }}</p>
          </td>
          <td>
            {{ $total_experience > 0 ? $total_experience.'+' : 'No experience' }}  and Taka: {{$item->expected_salary}}/-
          </td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
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
        <th align="left" colspan="4">Subject: Attendance Sheet For {{ $data['job_title'] }}</th>
        <th>Date: {{ date('d-m-Y') }}</th>
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
          <td>{{ ++$key }}</td>
          <td>
            <img src="{{asset('/storage/'.$item->student->photo)}}" alt="" width="100">
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


async function exportTableToExcel(tableID, options = {}) {
    // Default options
    const defaults = {
        filename: 'export',
        excludeColumns: [],
        includeBorder: true,
        sheetName: 'Sheet1',
        imageOptions: {
            includeImages: true,
            imageWidth: 100,
            imageHeight: 100
        }
    };
    const config = {...defaults, ...options};

    // Get table element
    const table = document.getElementById(tableID);
    if (!table) {
        console.error(`Table with ID "${tableID}" not found`);
        return;
    }

    // Create workbook
    const wb = XLSX.utils.book_new();
    
    // Clone table and process it
    const tableClone = table.cloneNode(true);
    document.body.appendChild(tableClone);
    tableClone.style.visibility = 'hidden';
    tableClone.style.position = 'absolute';

    // Process images if enabled
    if (config.imageOptions.includeImages) {
        await processTableImages(tableClone, config.imageOptions);
    }

    // Convert table to worksheet
    const ws = XLSX.utils.table_to_sheet(tableClone, {raw: true});
    document.body.removeChild(tableClone);

    // Process column exclusion
    if (config.excludeColumns.length > 0) {
        excludeColumnsFromWorksheet(ws, config.excludeColumns);
    }

    // Apply styling
    if (config.includeBorder) {
        applyWorksheetBorders(ws);
    }

    // Add worksheet to workbook
    XLSX.utils.book_append_sheet(wb, ws, config.sheetName);

    // Generate and download Excel file
    XLSX.writeFile(wb, `${config.filename}.xlsx`);
}

async function processTableImages(table, imageOptions) {
    const images = table.querySelectorAll('img');
    const promises = [];
    
    images.forEach(img => {
        promises.push(processImageElement(img, imageOptions));
    });
    
    await Promise.all(promises);
}

async function processImageElement(img, options) {
    try {
        // Create canvas to handle the image
        const canvas = document.createElement('canvas');
        canvas.width = options.imageWidth;
        canvas.height = options.imageHeight;
        const ctx = canvas.getContext('2d');
        
        // Handle CORS
        if (!img.crossOrigin && !img.src.startsWith('data:')) {
            img.crossOrigin = 'Anonymous';
        }
        
        // Load image
        await new Promise((resolve, reject) => {
            img.onload = resolve;
            img.onerror = reject;
            // Force reload if already loaded
            if (img.complete) {
                const src = img.src;
                img.src = '';
                img.src = src;
            }
        });
        
        // Draw image to canvas
        ctx.drawImage(img, 0, 0, options.imageWidth, options.imageHeight);
        
        // Replace img with canvas
        const container = document.createElement('div');
        container.appendChild(canvas);
        img.parentNode.replaceChild(container, img);
        
    } catch (error) {
        console.error('Error processing image:', error);
        // Fallback to alt text
        const span = document.createElement('span');
        span.textContent = img.alt || '[IMAGE]';
        img.parentNode.replaceChild(span, img);
    }
}

function excludeColumnsFromWorksheet(ws, columnsToExclude) {
    const range = XLSX.utils.decode_range(ws['!ref']);
    
    for (let C = range.e.c; C >= range.s.c; --C) {
        if (columnsToExclude.includes(C)) {
            // Delete excluded column cells
            for (let R = range.s.r; R <= range.e.r; ++R) {
                delete ws[XLSX.utils.encode_cell({r: R, c: C})];
            }
            
            // Shift remaining cells left
            for (let c = C + 1; c <= range.e.c; ++c) {
                for (let R = range.s.r; R <= range.e.r; ++R) {
                    const cell = ws[XLSX.utils.encode_cell({r: R, c: c})];
                    if (cell) {
                        ws[XLSX.utils.encode_cell({r: R, c: c - 1})] = cell;
                        delete ws[XLSX.utils.encode_cell({r: R, c: c})];
                    }
                }
            }
            range.e.c--;
        }
    }
    ws['!ref'] = XLSX.utils.encode_range(range);
}

function applyWorksheetBorders(ws) {
    const range = XLSX.utils.decode_range(ws['!ref']);
    
    for (let R = range.s.r; R <= range.e.r; ++R) {
        for (let C = range.s.c; C <= range.e.c; ++C) {
            const cellAddress = XLSX.utils.encode_cell({r: R, c: C});
            ws[cellAddress] = ws[cellAddress] || {};
            ws[cellAddress].s = ws[cellAddress].s || {};
            ws[cellAddress].s.border = {
                top: {style: "thin", color: {rgb: "000000"}},
                bottom: {style: "thin", color: {rgb: "000000"}},
                left: {style: "thin", color: {rgb: "000000"}},
                right: {style: "thin", color: {rgb: "000000"}}
            };
            
            // Header styling
            if (R === range.s.r) {
                ws[cellAddress].s.fill = {fgColor: {rgb: "F2F2F2"}};
                ws[cellAddress].s.font = {bold: true};
            }
        }
    }
}


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
