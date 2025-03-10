@extends('frontend.layouts.master')
@section('title','Dashboard')
@section('content')
<!-- Start Schedule Area -->
<div class="row">
    <div class="col-12 col-md-3 col-lg-3 mt-3">
        <div class="card">
            <div class="card-header">
                <h4>Dashboard</h4>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group list-group-item"><a href="{{route('student.dashboard')}}">Dashboard</a></li>
                    <li class="list-group list-group-item"><a href="{{route('student.view_cv')}}">View CV</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-9 col-lg-9 mt-3">
        <div class="card">
            <div class="card-header">
                {{-- <h2 class="text-center">Curriculum Vitae</h2> --}}
              <div class="card-tools">
                <button class="btn btn-sm btn-primary" id="download_cv"><i class="far fa-file-pdf"></i> Download</button>
              </div>
                  </div>
                  <div class="card-body" id="content-to-pdf">
              <h2 class="text-center">Curriculum Vitae</h2>
              <table class="table table-sm">
                <tbody id="basicTable">
                  <tr>
                    <th>Name</th>
                    <td id="profile_name">{{ $student->name }}</td>
                  </tr>
                  <tr>
                    <th>Father Name</th>
                    <td id="profile_father_name">{{ $student->father_name }}</td>
                  </tr>
                  <tr>
                    <th>Mother Name</th>
                    <td id="profile_mother_name">{{ $student->mother_name }}</td>
                  </tr>
                  <tr>
                    <th>Email</th>
                    <td id="profile_email">{{ $student->email }}</td>
                  </tr>
                  <tr>
                    <th>Phone</th>
                    <td id="profile_phone">{{ $student->phone }}</td>
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
                </tbody>
              </table>

              <h2>Experience</h2>
              <table class="table table-sm">
                <thead>
                  <tr>
                      <th>Job Title</th>
                      <th>Company</th>
                      <th>Job Description</th>
                      <th>From</th>
                      <th>To</th>
                  </tr>
                </thead>
                <tbody id="experienceTable">
                  @foreach($student->employments as $exp)
                  <tr data-id="{{ $exp->id }}">
                      <td>{{ $exp->job_title }}</td>
                      <td>{{ $exp->company_name }}</td>
                      <td>{{ $exp->job_description }}</td>
                      <td>{{ date('d-m-Y', strtotime($exp->from)) }}</td>
                      <td>{{ date('d-m-Y', strtotime($exp->to)) }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>

              <h2>Academic Summary</h2>
              <table class="table table-sm">
                <thead>
                  <tr>
                      <th>Exam</th>
                      <th>Group</th>
                      <th>Board</th>
                      <th>Year</th>
                      <th>Result</th>
                  </tr>
                </thead>
                <tbody id="academicTable">
                  @foreach($student->educations as $edu)
                  <tr data-id="{{ $edu->id }}">
                      <td>{{ $edu->exam->name }}</td>
                      <td>{{ $edu->group->name }}</td>
                      <td>{{ $edu->board->name }}</td>
                      <td>{{ $edu->passing_year }}</td>    
                      <td>{{ $edu->gpa }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>

              <h2>Training Summary</h2>
              <table class="table table-sm">
                <thead>
                  <tr>
                      <th>Title</th>
                      <th>Topics Covered</th>
                      <th>Year</th>
                      <th>Institute</th>
                      <th>Duration</th>
                      <th>Location</th>
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
          filename:     'curriculum-vitae.pdf',
          image:        { type: 'jpeg', quality: 0.98 },
          html2canvas:  { scale: 2 },
          jsPDF:        { unit: 'in', format: 'a4', orientation: 'landscape' }
        };

        // New Promise-based usage:
        html2pdf().set(opt).from(element).save();
    });
</script>
@endsection
