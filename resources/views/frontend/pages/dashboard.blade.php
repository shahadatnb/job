@extends('frontend.layouts.master')
@section('title','Dashboard')
@section('css')
<style src="{{ asset('assets/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}"></style>
<style type="text/css">
	#photoPreview {
		width: 150px;
		height: auto;
	}

	.badge.bg-primary {
		display: inline;
		font-size: 14px;
		border-radius: 6px;
		padding-right: 2px;
	}

	.deleteSkill {
		color: #fff;
		background: red;
		padding: 2px 5px;
		border-radius: 15px;
		margin: auto 2px 7px 5px;
		cursor: pointer;
		font-size: 10px;
	}

</style>
@endsection
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
                    <li class="list-group list-group-item"><a href="{{route('/')}}">Apply Now</a></li>
                    <li class="list-group list-group-item"><a href="{{route('student.applied_jobs')}}">Applied Jobs</a></li>
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
                        <button class="nav-link" id="nav-others-tab" data-bs-toggle="tab" data-bs-target="#nav-others" type="button" role="tab" aria-controls="nav-others" aria-selected="false">Skills</button>
                    </div>
                </nav>
                <div class="tab-content p-3 border bg-light" id="nav-profile">
                    <div class="tab-pane fade active show" id="nav-basic" role="tabpanel" aria-labelledby="nav-home-tab">
											<div class="row">
													<div class="col-12 col-md-6 col-lg-6">
														<div class="d-flex justify-content-between">
															<h2 class="d-inline-block">Basic Information</h2>
															<button class="btn btn-sm btn-primary" id="btnBasicModal">Edit</button>
														</div>
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
													</div>
													<div class="col-12 col-md-6 col-lg-6">
														<div id="errorMsgPhoto"></div>
														<img id="photoPreview" src="{{asset('/storage/'.$student->photo)}}" alt="" class="img-thumbnail" width="300 px">
														<br>
														<form action="{{route('student.photo.update')}}" method="POST" enctype="multipart/form-data">
															@csrf
															<label for="photo">Change Photo</label>
															<input type="file" name="photo" class="" id="photo">
														</form>
													</div>
											</div>
											<div id="errorMsgAddress"></div>
											{!! Form::model($student, ['route'=>['student.address.update', $student], 'method'=>'POST', 'id' => 'updateAddress']) !!}
											<div class="row">
													<div class="col-12 col-md-6 col-lg-6">
														<h3>Present Address</h3>
														<div class="form-group">
															{{ Form::label('village', 'Village') }}
															{{ Form::text('village', null, ['class' => 'form-control']) }}
														</div>
														<div class="form-group">
															{{ Form::label('post_office', 'Post Office') }}
															{{ Form::text('post_office', null, ['class' => 'form-control']) }}
														</div>
														<div class="form-group">
															{{ Form::label('district_id', 'District') }}
															{{ Form::select('district_id', $districts, null, ['class' => 'form-control', 'placeholder' => 'Select District']) }}
														</div>
														<div class="form-group">
															{{ Form::label('upazila_id', 'Thana/Upazila') }}
															{{ Form::select('upazila_id', $upazilas, null, ['class' => 'form-control', 'placeholder' => 'Select Thana/Upazila']) }}
														</div>
													</div>
													<div class="col-12 col-md-6 col-lg-6">
														<h3>Permanent Address</h3>
														<div class="form-group">
															{{ Form::label('permanent_village', 'Permanent Village') }}
															{{ Form::text('permanent_village', null, ['class' => 'form-control']) }}
														</div>
														<div class="form-group">
															{{ Form::label('permanent_post_office', 'Permanent Post Office') }}
															{{ Form::text('permanent_post_office', null, ['class' => 'form-control']) }}
														</div>
														<div class="form-group">
															{{ Form::label('permanent_district_id', 'Permanent District') }}
															{{ Form::select('permanent_district_id', $districts, null, ['class' => 'form-control', 'placeholder' => 'Select District']) }}
														</div>
														<div class="form-group">
															{{ Form::label('permanent_upazila_id', 'Permanent Thana/Upazila') }}
															{{ Form::select('permanent_upazila_id', $permanent_upazilas, null, ['class' => 'form-control', 'placeholder' => 'Select Thana/Upazila']) }}
														</div>
													</div>
													{{ Form::hidden('id', $student->id) }}
													{{ Form::button('Update Address', ['type' => 'submit', 'class' => 'btn btn-primary']) }}
											</div>
											{{ Form::close() }}
                    </div>
                    <div class="tab-pane fade" id="nav-education" role="tabpanel" aria-labelledby="nav-education-tab">
                        <h2>Academic Summary</h2>
                        <table class="table table-sm">
													<thead>
                            <tr>
                                <th>Exam</th>
                                <th>Group</th>
                                <th>Board</th>
                                <th>Year</th>
                                <th>Result</th>
                                <th>Action</th>
                            </tr>
                        	</thead>
							            <tbody id="academicTable">
                            @foreach($student->educations as $edu)
                            <tr data-id="{{ $edu->id }}">
                                <td>{{ $edu->exam->name }}</td>
                                <td>{{ $edu->group->name }}</td>
                                <td>{{ $edu->board ? $edu->board->name : $edu->university }}</td>
                                <td>{{ $edu->passing_year }}</td>    
                                <td>{{ $edu->result }}</td>
																<td>
																	<button class="btn btn-sm btn-primary editAcademic" data-id="{{ $edu->id }}">Edit</button>
																	<button class="btn btn-sm btn-danger deleteAcademic" data-id="{{ $edu->id }}">Delete</button>
																</td>
                            </tr>
                            @endforeach
													</tbody>
                        </table>
                        <button class="btn btn-primary" id="newAcademicModal">New Entry</button>
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
                                <th>Action</th>
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
																<td>
																		<button class="btn btn-sm btn-primary editTraining" data-id="{{ $edu->id }}">Edit</button>
																		<button class="btn btn-sm btn-danger deleteTraining" data-id="{{ $edu->id }}">Delete</button>
																</td>
                            </tr>
                            @endforeach
													</tbody>
                        </table>
                        <button class="btn btn-primary" id="btnTrainingModal">New Entry</button>
                    </div>
                    <div class="tab-pane fade" id="nav-employment" role="tabpanel" aria-labelledby="nav-employment-tab">
                        <h2>Employment</h2>
												<table class="table table-sm">
													<thead>
														<tr>
																<th>Job Title</th>
																<th>Company</th>
																<th>Job Description</th>
																<th>Form</th>
																<th>To</th>
																<th>Action</th>
														</tr>
													</thead>
													<tbody id="employmentTable">
														@foreach($student->employments as $edu)
														<tr data-id="{{ $edu->id }}">
																<td>{{ $edu->job_title }}</td>
																<td>{{ $edu->company_name }}</td>
																<td>{{ $edu->job_description }}</td>
																<td>{{ date('d-m-Y', strtotime($edu->start_date)) }}</td>
																<td>{{ date('d-m-Y', strtotime($edu->end_date)) }}</td>
																<td>
																		<button class="btn btn-sm btn-primary editEmployment" data-id="{{ $edu->id }}">Edit</button>
																		<button class="btn btn-sm btn-danger deleteEmployment" data-id="{{ $edu->id }}">Delete</button>
																</td>
														</tr>
														@endforeach
													</tbody>
												</table>
												<button class="btn btn-primary" id="btnEmploymentModal">New Entry</button>
                    </div>
                    <div class="tab-pane fade" id="nav-others" role="tabpanel" aria-labelledby="nav-others-tab">
												<h2>Skills</h2>
												<div id="skillTable" class="mb-3">
													@foreach($student->skills as $skill)
													<span data-id="{{ $skill->id }}" class="badge bg-primary">{{ $skill->skill }} <a class="deleteSkill" data-id="{{ $skill->id }}">X</a></span>
													@endforeach
												</div>
												<div class="input-group">
                        	<input type="text" name="skill" id="skill" class="form-control">
													<div class="input-group-append">
															<button class="btn btn-primary" id="addSkill">Add</button>
													</div>
												</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="basicModalLabel">Basic Information</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div id="errorMsgBasic"></div>
					<form action="" id="basicForm" method="post">
						@csrf
						<div class="form-group">
							<label for="name">Name</label>
							<input type="text" name="name" id="name" class="form-control">
						</div>
						<div class="form-group">
							<label for="father_name">Father Name</label>
							<input type="text" name="father_name" id="father_name" class="form-control">
						</div>
						<div class="form-group">
							<label for="mother_name">Mother Name</label>
							<input type="text" name="mother_name" id="mother_name" class="form-control">
						</div>
						<div class="form-group">
							<label for="email">Email</label>
							<input type="email" name="email" id="email" class="form-control">
						</div>
						<div class="form-group">
							<label for="phone">Phone</label>
							<input type="text" name="phone" id="phone" class="form-control">
						</div>
						<div class="form-group">
							<label for="nid">NID</label>
							<input type="text" name="nid" id="nid" class="form-control">
						</div>
						<div class="form-group">
							<label for="date_of_birth">Date of Birth</label>
							{!! Form::text('date_of_birth', $student->date_of_birth, ['class' => 'form-control datetimepicker-input','id'=>'date_of_birth', 'data-toggle'=>"datetimepicker", 'data-target'=>"#datetimepicker5", 'placeholder' => 'YYYY-MM-DD', 'required']) !!}
						</div>
						<div class="form-group">
							<label for="gender">Gender</label>
							<select name="gender" id="gender" class="form-control">
								<option value="Male">Male</option>
								<option value="Female">Female</option>
								<option value="Other">Other</option>
							</select>
						</div>
						<div class="form-group">
							<label for="religion">Religion</label>
							<select name="religion" id="religion" class="form-control">
								<option value="islam">Islam</option>
								<option value="hindu">Hindu</option>
								<option value="christian">Christian</option>
								<option value="others">Others</option>
							</select>
						</div>
						<div class="form-group">
							<label for="blood_group">Blood Group</label>
							<select name="blood_group" id="blood_group" class="form-control">
								<option value="A+">A+</option>
								<option value="A-">A-</option>
								<option value="B+">B+</option>
								<option value="B-">B-</option>
								<option value="O+">O+</option>
								<option value="O-">O-</option>
								<option value="AB+">AB+</option>
								<option value="AB-">AB-</option>
								<option value="Unknown">Unknown</option>
							</select>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-primary">Save</button>
						</div>
					</form>
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
            <div id="errorMsg"></div>
            <form action="{{route('student.education.store')}}" id="eduForm" method="post">
                @csrf
                <div class="form-group">
                    <label for="edu_level_id">Exam</label>
                    <select name="edu_level_id" id="edu_level_id" class="form-control">
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
                    <label for="edu_board_id">Board/University</label>
                    <select name="edu_board_id" id="edu_board_id" class="form-control">
                        <option value="">Select Board</option>
                    </select>
					          <input type="text" name="university" id="university" class="form-control d-none">
                </div>
                <div class="form-group">
                    <label for="passing_year">Passing Year</label>
                    <input type="text" name="passing_year" id="passing_year" class="form-control">
                </div>
                <div class="form-group">
										<input name = "result_type" type = "radio" id="gpa" value = "gpa" checked> GPA
										<input name = "result_type" type = "radio" id="division" value = "division"> Division
                    <input type="text" name="result_gpa" id="result_gpa" class="form-control">
										<select name="result_division" id="result_division" class="form-control d-none">
											<option value="">Select Division</option>
											<option value="1st">1st</option>
											<option value="2nd">2nd</option>
											<option value="3rd">3rd</option>
										</select>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Save</button>
            </form>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="newTrainingModal" tabindex="-1" role="dialog" aria-labelledby="newTrainingModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="newTrainingModalLabel">New Training</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
						<div id="errorMsgBasic"></div>
						<form action="{{route('student.training.store')}}" id="trainingForm" method="post">
								@csrf
								<div class="form-group">
										<label for="training_title">Title</label>
										<input type="text" name="training_title" id="training_title" class="form-control">
								</div>
								<div class="form-group">
										<label for="topics_covered">Topics Covered</label>
										<input type="text" name="topics_covered" id="topics_covered" class="form-control">
								</div>
								<div class="form-group">
										<label for="training_year">Year</label>
										<input type="text" name="training_year" id="training_year" class="form-control">
								</div>
								<div class="form-group">
										<label for="training_institute">Institute</label>
										<input type="text" name="training_institute" id="training_institute" class="form-control">
								</div>
								<div class="form-group">
										<label for="training_duration">Duration</label>
										<input type="text" name="training_duration" id="training_duration" class="form-control">
								</div>
								<div class="form-group">
										<label for="training_location">Location</label>
										<input type="text" name="training_location" id="training_location" class="form-control">
								</div>

								<button type="submit" class="btn btn-primary">Save</button>
						</form>
				</div>
			</div>
		</div>
</div>

	<div class="modal fade" id="newEmploymentModal" tabindex="-1" role="dialog" aria-labelledby="newEmploymentModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="newEmploymentModalLabel">New Employment</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
						<div id="errorMsgEmployment"></div>
						<form action="{{route('student.experience.store')}}" id="employmentForm" method="post">
								@csrf
								<div class="form-group">
										<label for="company_name">Company Name</label>
										<input type="text" name="company_name" id="company_name" class="form-control">
								</div>
								<div class="form-group">
										<label for="job_title">Job Title/Designation</label>
										<input type="text" name="job_title" id="job_title" class="form-control">
								</div>
								<div class="form-group">
										<label for="start_date">Start Date</label>
										<input type="text" name="start_date" id="start_date" class="form-control datetimepicker-input" data-toggle="datetimepicker" data-target="#datetimepicker5">
								</div>
								<div class="form-group">
										<label for="end_date">End Date</label>
										<input type="text" name="end_date" id="end_date" class="form-control  datetimepicker-input" data-toggle="datetimepicker" data-target="#datetimepicker5">
								</div>
								<div class="form-group">
										<label for="job_description">Job Description</label>
										<input type="text" name="job_description" id="job_description" class="form-control">
								</div>
								<div class="form-group">
										<label for="company_location">Company Location</label>
										<input type="text" name="company_location" id="company_location" class="form-control">
								</div>

								<button type="submit" class="btn btn-primary">Save</button>
						</form>
				</div>
			</div>
		</div>
	</div>

@endsection


@section('js')
<script src="{{ asset('assets/admin/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/moment/moment.min.js') }}"> </script>
<!-- Tempusdominus -->
<script src="{{ asset('assets/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"> </script>

<script>
    $(document).ready(function() {
        $('#edu_level_id').change(function() {
            var edu_level_id = $(this).val();
            $.ajax({
                url: "{{route('student.education.group')}}?edu_level_id=" + edu_level_id,
                method: 'GET',
                success: function(data) {
                    console.log(data);                    
                    if(data.status == true){
                        $('#edu_group_id').empty();
                        $('#edu_group_id').append('<option value="">Select Group</option>');
                        $.each(data.groups, function(index, value) {
                            $('#edu_group_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                        $('#edu_board_id').empty();
                        //$('#university').val('');
                        if(data.boards.length > 0){

                          $('#edu_board_id').removeClass('d-none');
                          $('#university').addClass('d-none');
                          $('#university').attr('required', false);
                          $('#edu_board_id').attr('required', true);

                          $('#edu_board_id').append('<option value="">Select Board</option>');
                          $.each(data.boards, function(index, value) {
                              $('#edu_board_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                          });
                        }else{
                          $('#edu_board_id').addClass('d-none');
                          $('#university').removeClass('d-none');
                          $('#university').attr('required', true);
                          $('#edu_board_id').attr('required', false);
                        }
                    }
                }
            });
        });

// basic
		$('#date_of_birth').datetimepicker({
				format: 'DD-MM-YYYY'
				//format: 'YYYY-MM-DD'
		});
		$('#start_date').datetimepicker({
				//format: 'DD/MM/YYYY'
				format: 'YYYY-MM-DD'
		});
		$('#end_date').datetimepicker({
				//format: 'DD/MM/YYYY'
				format: 'YYYY-MM-DD'
		});
		

        $('.select2').select2();
        $('.select2-multi').select2();

        $('#district_id').change(function(){
          $.get('{{ route('childLocation') }}', {
                option: $(this).val()
            },
            function(data) {
                var subcat = $('#upazila_id');
                subcat.empty();
                subcat.append("<option value=''>-----</option>");
                $.each(data, function(index, element) {
                    subcat.append("<option value='"+ element.id +"'>" + element.name + "</option>");
                });
            });
        });

        $('#permanent_district_id').change(function(){
          $.get('{{ route('childLocation') }}', {
                option: $(this).val()
            },
            function(data) {
                var subcat = $('#permanent_upazila_id');
                subcat.empty();
                subcat.append("<option value=''>-----</option>");
                $.each(data, function(index, element) {
                    subcat.append("<option value='"+ element.id +"'>" + element.name + "</option>");
                });
            });
        });

        $("#sameAsPresent").change(function(){
            if($(this).is(":checked")) {
                $("#permanentVillage").val($("#presentVillage").val());
                $("#permanentPost").val($("#presentPost").val());
                $("#permanentDistrict").empty();
                $("#permanentDistrict").append(`<option value='${$("#presentDistrict").val()}'>${$("#presentDistrict").find(':selected').text()}</option>`);
                $("#permanentDistrict").val($("#presentDistrict").val());
                $("#permanentUpazila").append(`<option value='${$("#presentUpazila").val()}'>${$("#presentUpazila").find(':selected').text()}</option>`);
                $("#permanentUpazila").val($("#presentUpazila").val());
            }
        }); 

				$("#btnBasicModal").click(function() {
					$('#basicForm').attr('action', "{{route('student.updateProfile')}}");
					$('#name').val($("#profile_name").text());
					$('#father_name').val($("#profile_father_name").text());
					$('#mother_name').val($("#profile_mother_name").text());
					$('#nid').val($("#profile_nid").text());
					$('#date_of_birth').val($("#profile_date_of_birth").text());
					$('#gender').val($("#profile_gender").text());
					$('#religion').val($("#profile_religion").text());
					$('#blood_group').val($("#profile_blood_group").text());					
					$('#email').val($("#profile_email").text());
					$('#phone').val($("#profile_phone").text());
					$('#basicModal').modal('show');
				});

				$('#basicForm').submit(function(e) {
					e.preventDefault();
					var formData = $(this).serialize();
					let url = $(this).attr('action');
					$("#errorMsgBasic").empty();
					$.ajax({
						url: url,
						method: 'POST',
						data: formData,
						success: function(data) {
							console.log(data);
							if(data.status == true){
								$("#profile_name").text(data.student.name);
								$("#profile_father_name").text(data.student.father_name);
								$("#profile_mother_name").text(data.student.mother_name);
								$("#profile_email").text(data.student.email);
								$("#profile_phone").text(data.student.phone);
								$("#profile_nid").text(data.student.nid);
								$("#profile_date_of_birth").text(data.student.date_of_birth);
								$("#profile_gender").text(data.student.gender);
								$("#profile_religion").text(data.student.religion);
								$("#profile_blood_group").text(data.student.blood_group);
								$('#basicModal').modal('hide');
							}else{
								if(data.message){
										$("#errorMsgBasic").append(`<div class="alert alert-danger"><strong>Warning: </strong>${data.message}</div>`);
								}
									data.errors.forEach(function(element){
										$("#errorMsgBasic").append(`<div class="alert alert-danger"><strong>Warning: </strong>${element}</div>`);
								});
							}
						}
					});
				});


				// EDUCATION

        $('#newAcademicModal').click(function() {
						$('#eduForm')[0].reset();
						$("input[name='result_type']").trigger('change');
						$("#errorMsg").empty();
            $('#eduForm').attr('action', "{{route('student.education.store')}}");
            $('#newEduModal').modal('show');
        });

				$('input[name="result_type"]').on('change', function() {
					var value = $("input[name='result_type']:checked").val();
					if (value == 'gpa' || value == '') {
						$('#result_gpa').removeClass('d-none');
						$('#result_division').addClass('d-none');
					} else {
						$('#result_gpa').addClass('d-none');
						$('#result_division').removeClass('d-none');
					}
				});
    
        $('#eduForm').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            let url = $(this).attr('action');
            $("#errorMsg").empty();
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                success: function(data) {
                    console.log(data);
                    if(data.status == true){
											if(data.type == 'save'){
												$("#academicTable").append(`<tr>
													<td>${data.education.exam_name}</td>
													<td>${data.education.board_name}</td>
													<td>${data.education.group_name}</td>
													<td>${data.education.passing_year}</td>
													<td>${data.education.result}</td>
													<td>
														<button class="btn btn-sm btn-primary editAcademic" data-id="${data.education.id}">Edit</button>
														<button class="btn btn-sm btn-danger deleteAcademic" data-id="${data.education.id}">Delete</button>
													</td>
												</tr>`);
											}else{
												$("#academicTable").find('tr[data-id="'+data.education.id+'"]')
												.find('td').eq(0).html(data.education.exam_name);
												$("#academicTable").find('tr[data-id="'+data.education.id+'"]')
												.find('td').eq(1).html(data.education.board_name);
												$("#academicTable").find('tr[data-id="'+data.education.id+'"]')
												.find('td').eq(2).html(data.education.group_name);
												$("#academicTable").find('tr[data-id="'+data.education.id+'"]')
												.find('td').eq(3).html(data.education.passing_year);
												$("#academicTable").find('tr[data-id="'+data.education.id+'"]')
												.find('td').eq(4).html(data.education.result);
											}
                        $('#newEduModal').modal('hide');
                    }else{
                        //console.log(data);
                        if(data.message){
                            $("#errorMsg").append(`<div class="alert alert-danger"><strong>Warning: </strong>${data.message}</div>`);														
                        }
                            data.errors.forEach(function(element){
                            $("#errorMsg").append(`<div class="alert alert-danger"><strong>Warning: </strong>${element}</div>`);
                        });
                    }
                }
            });
        });

		$("#nav-education").on('click', '.editAcademic', function(){
			$('#eduForm')[0].reset();
			$("#errorMsg").empty();
			var id = $(this).data('id');
			$.ajax({
				url: "{{route('student.education.edit')}}?id=" + id,
				method: 'GET',
				success: function(data){
					console.log(data);
					$("#eduForm").attr('action', "{{route('student.education.update')}}?id=" + id);
					$("#edu_level_id").val(data.education.edu_level_id);
					//$('#edu_level_id').trigger('change');
						$('#edu_group_id').empty();
						$('#edu_group_id').append('<option value="">Select Group</option>');
						$.each(data.groups, function(index, value) {
								$('#edu_group_id').append('<option value="' + value.id + '">' + value.name + '</option>');
						});
						$('#edu_board_id').empty();
            if(data.boards.length > 0){
              $('#edu_board_id').removeClass('d-none');
              $('#university').addClass('d-none');
              $('#university').attr('required', false);
              $('#edu_board_id').attr('required', true);

              $('#edu_board_id').append('<option value="">Select Board</option>');
              $.each(data.boards, function(index, value) {
                  $('#edu_board_id').append('<option value="' + value.id + '">' + value.name + '</option>');
              }); 
            }else{
              $('#edu_board_id').addClass('d-none');
              $('#university').removeClass('d-none');
              $('#university').attr('required', true);
              $('#edu_board_id').attr('required', false);
            }
						
					$("#edu_group_id").val(data.education.edu_group_id);
					$("#edu_board_id").val(data.education.edu_board_id);
					$("#passing_year").val(data.education.passing_year);
					//console.log(data.education.result_type);
					if(data.education.result_type == 'gpa'){
						$("#gpa").prop('checked', true);
						$("#result_gpa").val(data.education.result);
					} else {
						$("#division").prop('checked', true);
						$("#result_division").val(data.education.result).change();
					}
					$("input[name='result_type']").change();
					$('#newEduModal').modal('show');
				}
			});
		});

		$("#nav-education").on('click', '.deleteAcademic', function(){
			if(confirm("Are you sure?")){
				var id = $(this).data('id');
				$.ajax({
					url: "{{route('student.education.destroy')}}?id=" + id,
					method: 'GET',
					success: function(data){
						console.log(data);
						if(data.status == true){
							$("#academicTable").find('tr[data-id="'+id+'"]').remove();
						}
					}
				});
			}
		});


		// TRAINING
		$("#btnTrainingModal").click(function(){
			$("#trainingForm").attr('action', "{{route('student.training.store')}}");
			$('#newTrainingModal').modal('show');
		})
		$('#trainingForm').submit(function(e) {
			e.preventDefault();
			var formData = $(this).serialize();
			let url = $(this).attr('action');
			$("#errorMsgTraining").empty();
			$.ajax({
				url: url,
				method: 'POST',
				data: formData,
				success: function(data) {
					console.log(data);
					if(data.status == true){
						if(data.type == 'save'){
							$("#trainingTable").append(`
								<tr data-id="${data.training.id}">
									<td>${data.training.training_title}</td>
									<td>${data.training.topics_covered}</td>
									<td>${data.training.training_year}</td>
									<td>${data.training.training_institute}</td>
									<td>${data.training.training_duration}</td>
									<td>${data.training.training_location}</td>
									<td>
										<a class="btn btn-primary btn-sm editTraining" data-id="${data.training.id}">Edit</a>
										<a class="btn btn-danger btn-sm deleteTraining" data-id="${data.training.id}">Delete</a>
									</td>
								</tr>
							`);
						}else{
							$("#trainingTable").find('tr[data-id="'+data.training.id+'"]')
							.find('td').eq(0).html(data.training.training_title);
							$("#trainingTable").find('tr[data-id="'+data.training.id+'"]')
							.find('td').eq(1).html(data.training.topics_covered);
							$("#trainingTable").find('tr[data-id="'+data.training.id+'"]')
							.find('td').eq(2).html(data.training.training_year);
							$("#trainingTable").find('tr[data-id="'+data.training.id+'"]')
							.find('td').eq(3).html(data.training.training_institute);
							$("#trainingTable").find('tr[data-id="'+data.training.id+'"]')
							.find('td').eq(4).html(data.training.training_duration);
							$("#trainingTable").find('tr[data-id="'+data.training.id+'"]')
							.find('td').eq(5).html(data.training.training_location);
						}
						$('#trainingForm')[0].reset();
						$('#newTrainingModal').modal('hide');
					}else{
						//console.log(data);
						if(data.message){
							$("#errorMsgTraining").append(`<div class="alert alert-danger"><strong>Warning: </strong>${data.message}</div>`);
						}
							data.errors.forEach(function(element){
							$("#errorMsgTraining").append(`<div class="alert alert-danger"><strong>Warning: </strong>${element}</div>`);
						});
					}
				}
			});
		});

		$("#nav-education").on('click', '.editTraining', function(){
			var id = $(this).data('id');
			$.ajax({
				url: "{{route('student.training.edit')}}?id=" + id,
				method: 'GET',
				success: function(data){
					console.log(data);
					$("#trainingForm").attr('action', "{{route('student.training.update')}}?id=" + id);
					$("#training_title").val(data.training.training_title);
					$("#topics_covered").val(data.training.topics_covered);
					$("#training_year").val(data.training.training_year);
					$("#training_institute").val(data.training.training_institute);
					$("#training_duration").val(data.training.training_duration);
					$("#location").val(data.training.training_location);
					$('#newTrainingModal').modal('show');
				}
			});
		});

		$("#nav-education").on('click', '.deleteTraining', function(){
			if(confirm("Are you sure?")){
				var id = $(this).data('id');
				$.ajax({
					url: "{{route('student.training.destroy')}}?id=" + id,
					method: 'GET',
					success: function(data){
						console.log(data);
						if(data.status == true){
							$("#trainingTable").find('tr[data-id="'+id+'"]').remove();
						}
					}
				});
			}
		});


		//employment
		$("#btnEmploymentModal").click(function(){
			$("#employmentForm").attr('action', "{{route('student.experience.store')}}");
			$('#newEmploymentModal').modal('show');
		});

		$('#employmentForm').submit(function(e) {
			e.preventDefault();
			var formData = $(this).serialize();
			let url = $(this).attr('action');
			$("#errorMsgEmployment").empty();
			$.ajax({
				url: url,
				method: 'POST',
				data: formData,
				success: function(data) {
					console.log(data);
					if(data.status == true){
						$('#newEmploymentModal').modal('hide');
						$('#employmentForm')[0].reset();
						if(data.type == 'save'){
						$("#employmentTable").append(`
							<tr data-id="${data.employment.id}">
								<td>${data.employment.job_title}</td>
								<td>${data.employment.company_name}</td>
								<td>${data.employment.job_description}</td>
								<td>${data.employment.start_date}</td>
								<td>${data.employment.end_date}</td>
								<td>
									<a class="btn btn-primary btn-sm editEmployment" data-id="${data.employment.id}">Edit</a>
									<a class="btn btn-danger btn-sm deleteEmployment" data-id="${data.employment.id}">Delete</a>
								</td>
							</tr>
						`);
							
						}else{
							$("#employmentTable").find('tr[data-id="'+data.employment.id+'"]')
							.find('td').eq(0).html(data.employment.employment_title);
							$("#employmentTable").find('tr[data-id="'+data.employment.id+'"]')
							.find('td').eq(1).html(data.employment.company_name);
							$("#employmentTable").find('tr[data-id="'+data.employment.id+'"]')
							.find('td').eq(5).html(data.employment.job_title);
							$("#employmentTable").find('tr[data-id="'+data.employment.id+'"]')
							.find('td').eq(6).html(data.employment.start_date);
							$("#employmentTable").find('tr[data-id="'+data.employment.id+'"]')
							.find('td').eq(7).html(data.employment.end_date);
							$("#employmentTable").find('tr[data-id="'+data.employment.id+'"]')
							.find('td').eq(8).html(data.employment.description);
						}
					}else{
						//console.log(data);
						if(data.message){
							$("#errorMsgEmployment").append(`<div class="alert alert-danger"><strong>Warning: </strong>${data.message}</div>`);
						}
							data.errors.forEach(function(element){
							$("#errorMsgEmployment").append(`<div class="alert alert-danger"><strong>Warning: </strong>${element}</div>`);
						});
					}
				}
			});
		});

		$("#nav-employment").on('click', '.editEmployment', function(){
			var id = $(this).data('id');
			$.ajax({
				url: "{{route('student.experience.edit')}}?id=" + id,
				method: 'GET',
				success: function(data){
					console.log(data);
					$("#employmentForm").attr('action', "{{route('student.experience.update')}}?id=" + id);
					$("#employment_title").val(data.employment.employment_title);
					$("#company_name").val(data.employment.company_name);
					$("#company_location").val(data.employment.company_location);
					$("#company_phone").val(data.employment.company_phone);
					$("#company_email").val(data.employment.company_email);
					$("#job_title").val(data.employment.job_title);
					$("#start_date").val(data.employment.start_date);
					$("#end_date").val(data.employment.end_date);
					$("#description").val(data.employment.description);
					$('#newEmploymentModal').modal('show');
				}
			});
		});

		$("#nav-employment").on('click', '.deleteEmployment', function(){
			if(confirm("Are you sure?")){
				var id = $(this).data('id');
				$.ajax({
					url: "{{route('student.experience.destroy')}}?id=" + id,
					method: 'GET',
					success: function(data){
						console.log(data);
						if(data.status == true){
							$("#employmentTable").find('tr[data-id="'+id+'"]').remove();
						}
					}
				});
			}
		});

		$("#photo").change(function(){
			var photo = this.files[0];
			let formData = new FormData();			
			//const blob = new Blob([metadata], { type: 'application/json' });
			//formData.append('metadata', blob);
			formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
			formData.append('photo', photo);
			$.ajax({
				url: "{{route('student.photo.update')}}",
				method: 'POST',
				data: formData,
				contentType: false,
				processData: false,
				success: function(data){
					console.log(data.errors);
					//$('#photoPreview').html(data);
					if(data.status == true){
						$("#photoPreview").attr('src', data.photo);
					}else{
						if(data.message){
								$("#errorMsgPhoto").append(`<div class="alert alert-danger"><strong>Warning: </strong>${data.message}</div>`);
							}
						data.errors.photo.forEach(function(element){
							$("#errorMsgPhoto").append(`<div class="alert alert-danger"><strong>Warning: </strong>${element}</div>`);
						});
					}
				}
			})
		});

		$("#updateAddress").submit(function(e){
			e.preventDefault();
			var formData = $(this).serialize();
			let url = $(this).attr('action');
			$("#errorMsgAddress").empty();
			$.ajax({
				url: url,
				method: 'POST',
				data: formData,
				success: function(data){
					console.log(data);
					if(data.status == true){
						//$("#addressModal").modal('hide');
						$("#errorMsgAddress").append(`<div class="alert alert-success"><strong>Success: </strong>${data.message}</div>`);
						$('#nav-education-tab').tab('show');
					}else{
						if(data.message){
								$("#errorMsgAddress").append(`<div class="alert alert-danger"><strong>Warning: </strong>${data.message}</div>`);
							}
						data.errors.forEach(function(element){
							$("#errorMsgAddress").append(`<div class="alert alert-danger"><strong>Warning: </strong>${element}</div>`);
						});
					}
				}
			})
		})

		$("#addSkill").click(function(){
			var skill = $("#skill").val();
			let formData = new FormData();
			formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
			formData.append('skill', skill);
			$.ajax({
				url: "{{route('student.skill.store')}}",
				method: 'POST',
				data: formData,
				contentType: false,
				processData: false,
				success: function(data){
					console.log(data);
					//$('#photoPreview').html(data);
					if(data.status == true){
						$("#skill").val('');
						$("#skillTable").append(
							`<span data-id="${data.skill.id}" class="badge bg-primary">${data.skill.skill }<a class="deleteSkill" data-id="${data.skill.id}">X</a></span>`
						);
					}else{
						if(data.message){
								$("#errorMsgSkill").append(`<div class="alert alert-danger"><strong>Warning: </strong>${data.message}</div>`);
							}
						data.errors.skill.forEach(function(element){
							$("#errorMsgSkill").append(`<div class="alert alert-danger"><strong>Warning: </strong>${element}</div>`);
						})
					}
				}
			})
		});

		$("#skillTable").on('click', '.deleteSkill', function(){
			if(confirm("Are you sure?")){
				var id = $(this).data('id');
				$.ajax({
					url: "{{route('student.skill.destroy')}}?id=" + id,
					method: 'GET',
					success: function(data){
						console.log(data);
						if(data.status == true){
							$("#skillTable").find('span[data-id="'+id+'"]').remove();
						}
					}
				});
			}
		});

});
</script>
@endsection
