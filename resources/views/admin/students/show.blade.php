@extends('admin.layouts.layout')
@section('title',__("Applicant"))
@section('content')
<div class="card">
    <div class="card-header d-print-none">
        {{-- <h2 class="text-center">Curriculum Vitae</h2> --}}
        <div class="card-tools">
        <button class="btn btn-sm btn-primary" id="download_cv"><i class="far fa-file-pdf"></i> Download</button>
        <button class="btn btn-sm btn-primary" onclick="window.print()" id="print_cv"><i class="fas fa-print"></i> Print</button>
        </div>
    </div>
    <div class="card-body d-print-block" id="content-to-pdf">
        <h2 class="text-center">Curriculum Vitae</h2>
        <div class="d-flex justify-content-between">
        <div class="">
            <h2 class="mb-0">{{ $student->name }}</h2>
            <p class="mb-0">{{ $student->village }}, {{ $student->post_office }}, {{ $student->upazila ? $student->upazila->name : '' }}, {{ $student->district? $student->district->name : '' }}</p>
            <p class="mb-0">{{ $student->phone }}</p>
            <p>{{ $student->email }}</p>
        </div>
        <div class="">
                            <img id="photoPreview" src="{{asset('/storage/'.$student->photo)}}" alt="" class="img-thumbnail" width="150 px">
        </div>
        </div>

        @if($student->objective != '')
        <h4>Objective</h4>
        <div class="mb-3">{!! nl2br($student->objective) !!}</div>
        @endif
        @if($student->career_summary != '')                
        <h4>Career Summary</h4>
        <div class="mb-3">{!! nl2br($student->career_summary) !!}</div>
        @endif
        @if($student->special_qualification != '')
        <h4>Special Qualification</h4>
        <div class="mb-3">{!! nl2br($student->special_qualification) !!}</div>
        @endif

        @if($student->employments->count() > 0)
        <h4>Experience</h4>
        <table class="table table-sm ">
        <thead class="table-light">
            <tr>
                <th width="15%">Job Title</th>
                <th width="15%">Company</th>
                <th width="50%">Job Description</th>
                <th width="10%">From</th>
                <th width="10%">To</th>
            </tr>
        </thead>
        <tbody id="experienceTable">
            @foreach($student->employments as $exp)
            <tr data-id="{{ $exp->id }}">
                <td>{{ $exp->job_title }}</td>
                <td>{{ $exp->company_name }}</td>
                <td>{{ $exp->job_description }}</td>
                <td>{{ date('d-m-Y', strtotime($exp->start_date)) }}</td>
                <td>{{ $exp->is_current ==1 ? 'Continuing' : date('d-m-Y', strtotime($exp->end_date)) }}</td>
            </tr>
            @endforeach
        </tbody>
        </table>
        @endif
        <h4>Academic Summary</h4>
        <table class="table table-sm">
        <thead class="table-light">
            <tr>
                <th width="15%">Exam</th>
                <th width="15%">Group</th>
                <th width="45%">Instotute</th>
                <th width="10%">Year</th>
                <th width="15%">Result</th>
            </tr>
        </thead>
        <tbody id="academicTable">
            @foreach($student->educations as $edu)
            <tr data-id="{{ $edu->id }}">
                <td>{{ $edu->exam ? $edu->exam->name : '' }}</td>
                <td>{{ $edu->group ? $edu->group->name : '' }}</td>
                <td>{{ $edu->university }}{{ $edu->board ? '(Board: '.$edu->board->name.')' : '' }}</td>
                <td>{{ $edu->passing_year }}</td>    
                <td>{{ $edu->result }}{{ $edu->result_type == 'gpa' ? ' out of '.$edu->out_of : '' }}</td>
            </tr>
            @endforeach
        </tbody>
        </table>

        @if($student->trainings->count() > 0)
        <h4>Training Summary</h4>
        <table class="table table-sm">
        <thead class="table-light">
            <tr>
                <th width="15%">Title</th>
                <th width="40%">Topics Covered</th>
                <th width="7%">Year</th>
                <th width="15%">Institute</th>
                <th width="10%">Duration</th>
                <th width="13%">Location</th>
            </tr>
        </thead>
        <tbody id="trainingTable">
            @foreach($student->trainings as $edu)
            <tr data-id="{{ $edu->id }}">
                <td>{{ $edu->training_title }}</td>
                <td>{{ $edu->topics_covered }}</td>
                <td>{{ $edu->training_year }}</td>
                <td>{{ $edu->training_institute }}</td>
                <td>{{ $edu->training_duration }}</td>
                <td>{{ $edu->training_location }}</td>
            </tr>
            @endforeach
        </tbody>
        </table>
        @endif

        @if($student->certifications->count() > 0)
        <h4>Professional Certificates</h4>
        <table class="table table-sm">
        <thead class="table-light">
            <tr>
                <th width="30%">Certification</th>
                <th width="30%">Institute</th>
                <th width="20%">Location</th>
                <th width="10%">From</th>
                <th width="10%">To</th>
            </tr>
        </thead>
        <tbody id="certificationTable">
            @foreach($student->certifications as $edu)
            <tr data-id="{{ $edu->id }}">
                <td>{{ $edu->certification }}</td>
                <td>{{ $edu->institute }}</td>
                <td>{{ $edu->location }}</td>
                <td>{{ date('d-m-Y', strtotime($edu->start_date)) }}</td>
                <td>{{ date('d-m-Y', strtotime($edu->end_date)) }}</td>
            </tr>
            @endforeach
        </tbody>
        </table>
        @endif

        @if($student->skills->count() > 0)
        <h4>Skills</h4>
        <p>
        @foreach($student->skills as $skill)
        {{ $skill->skill }}, 
        @endforeach
        </p>
        @endif

        @if($student->languages->count() > 0)
        <h4>Languages Preficiency</h4>
        <table class="table table-sm">
        <thead class="table-light">
            <tr>
                <th>Language</th>
                <th>Reading</th>
                <th>Writing</th>
                <th>Speaking</th>
            </tr>
        </thead>
        <tbody id="languageTable">
            @foreach($student->languages as $lang)
            <tr data-id="{{ $lang->id }}">
                <td>{{ $lang->language }}</td>
                <td>{{ $lang->reading }}</td>
                <td>{{ $lang->writing }}</td>
                <td>{{ $lang->speaking }}</td>
            </tr>
            @endforeach
        </tbody>
        </table>
        @endif
        <h4>Basic Information</h4>
        <table class="table table-sm">
        <tbody id="basicTable">
            <tr>
            <th>Father Name</th>
            <td id="profile_father_name">{{ $student->father_name }}</td>
            </tr>
            <tr>
            <th>Mother Name</th>
            <td id="profile_mother_name">{{ $student->mother_name }}</td>
            </tr>
            <tr>
            <th>NID</th>
            <td id="profile_nid">{{ $student->nid }}</td>
            </tr>
            <tr>
            <th>Date of Birth</th>
            <td id="profile_date_of_birth">{{ date('d-m-Y', strtotime($student->date_of_birth)) }}</td>
            </tr>
            <tr>
            <th>Gender</th>
            <td id="profile_gender">{{ $student->gender }}</td>
            </tr>
            <tr>
            <th>Religion</th>
            <td id="profile_religion">{{ $student->religion }}</td>
            </tr>
            <tr>
            <th>Blood Group</th>
            <td id="profile_blood_group">{{ $student->blood_group }}</td>
            </tr>
            {{-- <tr>
            <th colspan="2">Present Address</th>
            </tr>
            <tr>
            <th>Village</th>
            <td>{{ $student->village }}</td>
            </tr>
            <tr>
            <th>Post Office</th>
            <td>{{ $student->post_office }}</td>
            </tr>
            <tr>
            <th>Upazila</th>
            <td>{{ $student->upazila ? $student->upazila->name : '' }}</td>
            </tr>
            <tr>
            <th>District</th>
            <td>{{ $student->district ? $student->district->name : '' }}</td>
            </tr> --}}
            <tr>
            <th colspan="2">Permanent Address:</th>
            </tr>
            <tr>
            <th>Village</th>
            <td>{{ $student->permanent_village }}</td>
            </tr>
            <tr>
            <th>Post Office</th>
            <td>{{ $student->permanent_post_office }}</td>
            </tr>
            <tr>
            <th>Upazila</th>
            <td>{{ $student->upazilaPermanent ? $student->upazilaPermanent->name : '' }}</td>
            </tr>
            <tr>
            <th>District</th>
            <td>{{ $student->districtPermanent ? $student->districtPermanent->name : '' }}</td>
            </tr>
        </tbody>
        </table>

        <h4>References:</h4>
        <div class="row">
        @foreach($student->references as $reference)
        <div class="col-md-6">
            <table class="table table-sm">
            <tbody>
                <tr>
                <th>Name</th>
                <td>{{ $reference->name }}</td>
                </tr>
                <tr>
                <th>Designation</th>
                <td>{{ $reference->designation }}</td>
                </tr>
                <tr>
                <th>Organization</th>
                <td>{{ $reference->organization }}</td>
                </tr>
                <tr>
                <th>Email</th>
                <td>{{ $reference->email }}</td>
                </tr>
                <tr>
                <th>Phone</th>
                <td>{{ $reference->mobile }}</td>
                </tr>
                <tr>
                <th>Address</th>
                <td>{{ $reference->address }}</td>
                </tr>
                <tr>
                <th>Relationship</th>
                <td>{{ $reference->relation }}</td>
                </tr>
            </tbody>
            </table>
        </div>
        @endforeach
        </div>
        
        <div class="row">
            <div class="col-md-6 offset-md-6 text-center">
                <div style="width: 300px">
                    <img src="{{asset('/storage/'.$student->signature)}}" style="height: 50px;" alt="">
                    <p class="mt-0" style="border-top: 1px solid black;">Signature</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
       document.getElementById('download_cv').addEventListener('click', () => {
        var element = document.getElementById('content-to-pdf');
        var opt = {
          margin:       .3,
          filename:     'cv of {{ $student->name }}.pdf',
          image:        { type: 'jpeg', quality: 0.98 },
          html2canvas:  { scale: 2 },
          jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' },
          //pagebreak: { mode: ['avoid-all', 'css', 'legacy'] }
        };

        // New Promise-based usage:
        html2pdf().set(opt).from(element).save();
    });

    function PrintElem(elem){	
      //PrintElem('#content-to-pdf')
       //Popup($(elem).html());
    }

   function Popup(data) {
       var mywindow = window.open('', 'print_details', 'height=562,width=795');
       mywindow.document.write('<html><head><title>print_details</title>');
      mywindow.document.write(`<link rel="stylesheet" href="{{asset('/assets/frontend')}}/css/bootstrap.min.css">`);
      // mywindow.document.write('<style> table.print_slip tbody td {border:1px solid #ccc; }</style>');
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