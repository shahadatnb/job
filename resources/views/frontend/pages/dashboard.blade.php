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
                    <li class="list-group list-group-item"><a href="{{route('student.profile')}}">Profile</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-9 col-lg-9 mt-3">
        <div class="card">
            <div class="card-header">
                <h4>Profile</h4>
            </div>
            <div class="card-body">
                <nav>
                    <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-basic-tab" data-bs-toggle="tab" data-bs-target="#nav-basic" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Basic</button>
                        <button class="nav-link" id="nav-education-tab" data-bs-toggle="tab" data-bs-target="#nav-education" type="button" role="tab" aria-controls="nav-education" aria-selected="false">Education/Training</button>
                        <button class="nav-link" id="nav-employment-tab" data-bs-toggle="tab" data-bs-target="#nav-employment" type="button" role="tab" aria-controls="nav-employment" aria-selected="false">Employment</button>
                        <button class="nav-link" id="nav-others-tab" data-bs-toggle="tab" data-bs-target="#nav-others" type="button" role="tab" aria-controls="nav-others" aria-selected="false">Others</button>
                    </div>
                </nav>
                <div class="tab-content p-3 border bg-light" id="nav-basic">
                    <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <table class="table table-sm">
                            <tr>
                                <th>Name</th>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th>Father Name</th>
                                <td>{{ $user->father_name }}</td>
                            </tr>
                            <tr>
                                <th>Mother Name</th>
                                <td>{{ $user->mother_name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{ $user->phone }}</td>
                            </tr>
                            <tr>
                                <th>NID</th>
                                <td>{{ $user->nid }}</td>
                            </tr>
                            <tr>
                                <th>Date of Birth</th>
                                <td>{{ date('d-m-Y', strtotime($user->date_of_birth)) }}</td>
                            </tr>
                            <tr>
                                <th>Gender</th>
                                <td>{{ $user->gender }}</td>
                            </tr>
                            <tr>
                                <th>Religion</th>
                                <td>{{ $user->religion }}</td>
                            </tr>
                            <tr>
                                <th>Blood Group</th>
                                <td>{{ $user->blood_group }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="nav-education" role="tabpanel" aria-labelledby="nav-education-tab">
                        <h2>Academic Summary</h2>
                        <table class="table table-sm">
                            <tr>
                                <th>Exam</th>
                                <th>Group</th>
                                <th>Passing Year</th>
                                <th>Board</th>
                                <th>Year</th>
                                <th>Result</th>
                                <th>Action</th>
                            </tr>
                            @foreach($user->educations as $edu)
                            <tr>
                                <td>{{ $edu->exam->name }}</td>
                                <td>{{ $edu->group->name }}</td>
                                <td>{{ $edu->passing_year }}</td>
                                <td>{{ $edu->board->name }}</td>
                                <td>{{ $edu->passing_year }}</td>    
                                <td>{{ $edu->gpa }}</td>
                            </tr>
                            @endforeach
                        </table>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newEduModal">New Entry</button>
                        <h2>Training Summary</h2>
                        <table class="table table-sm">
                            <tr>
                                <th>Training</th>
                                <th>Training Center</th>
                                <th>Training Year</th>
                                <th>Training Type</th>
                                <th>Training Duration</th>
                                <th>Training Result</th>
                                <th>Action</th>
                            </tr>
                            @foreach($user->trainings as $edu)
                            <tr>
                                <td>{{ $edu->training->name }}</td>
                                <td>{{ $edu->training_center }}</td>
                                <td>{{ $edu->training_year }}</td>
                                <td>{{ $edu->training_type }}</td>
                                <td>{{ $edu->training_duration }}</td>
                                <td>{{ $edu->training_result }}</td>
                            </tr>
                            @endforeach
                        </table>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#newTrainingModal">New Entry</button>
                    </div>
                    <div class="tab-pane fade" id="nav-employment" role="tabpanel" aria-labelledby="nav-employment-tab">
                        
                    </div>
                    <div class="tab-pane fade" id="nav-others" role="tabpanel" aria-labelledby="nav-others-tab">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="newEduModal" tabindex="-1" role="dialog" aria-labelledby="newEduModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newEduModalLabel">New Education</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{route('student.education.store')}}" method="post">
                @csrf
                <div class="form-group">
                    <label for="exam_id">Exam</label>
                    <select name="exam_id" id="exam_id" class="form-control">
                        <option value="">Select Exam</option>
                        @foreach($exams as $exam)
                        <option value="{{$exam->id}}">{{$exam->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="edu_group_id">Group</label>
                    <select name="edu_group_id" id="edu_group_id" class="form-control">
                        <option value="">Select Group</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="edu_board_id">Board</label>
                    <select name="edu_board_id" id="edu_board_id" class="form-control">
                        <option value="">Select Board</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="passing_year">Passing Year</label>
                    <input type="text" name="passing_year" id="passing_year" class="form-control">
                </div>
                <div class="form-group">
                    <label for="gpa">GPA</label>
                    <input type="text" name="gpa" id="gpa" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
      </div>
    </div>
</div>

@endsection


@section('js')

@endsection
