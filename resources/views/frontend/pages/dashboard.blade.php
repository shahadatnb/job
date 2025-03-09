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
                <div class="tab-content p-3 border bg-light" id="nav-profile">
                    <div class="tab-pane fade active show" id="nav-basic" role="tabpanel" aria-labelledby="nav-home-tab">
                        <table class="table table-sm">
													<tbody id="basicTable">
														<tr>
															<th colspan="2" class="text-right"><button class="btn btn-primary" id="btnBasicModal">Edit</button></th>
														</tr>
                            <tr>
                                <th>Name</th>
                                <td id="profile_name">{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th>Father Name</th>
                                <td id="profile_father_name">{{ $user->father_name }}</td>
                            </tr>
                            <tr>
                                <th>Mother Name</th>
                                <td id="profile_mother_name">{{ $user->mother_name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td id="profile_email">{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td id="profile_phone">{{ $user->phone }}</td>
                            </tr>
                            <tr>
                                <th>NID</th>
                                <td id="profile_nid">{{ $user->nid }}</td>
                            </tr>
                            <tr>
                                <th>Date of Birth</th>
                                <td id="profile_date_of_birth">{{ date('d-m-Y', strtotime($user->date_of_birth)) }}</td>
                            </tr>
                            <tr>
                                <th>Gender</th>
                                <td id="profile_gender">{{ $user->gender }}</td>
                            </tr>
                            <tr>
                                <th>Religion</th>
                                <td id="profile_religion">{{ $user->religion }}</td>
                            </tr>
                            <tr>
                                <th>Blood Group</th>
                                <td id="profile_blood_group">{{ $user->blood_group }}</td>
                            </tr>
													</tbody>
                        </table>
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
                            @foreach($user->educations as $edu)
                            <tr data-id="{{ $edu->id }}">
                                <td>{{ $edu->exam->name }}</td>
                                <td>{{ $edu->group->name }}</td>
                                <td>{{ $edu->board->name }}</td>
                                <td>{{ $edu->passing_year }}</td>    
                                <td>{{ $edu->gpa }}</td>
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
                            @foreach($user->trainings as $edu)
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
                        
                    </div>
                    <div class="tab-pane fade" id="nav-others" role="tabpanel" aria-labelledby="nav-others-tab">
                        
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
					<h5 class="modal-title" id="basicModalLabel">New Entry</h5>
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
							<label for="email">Email</label>
							<input type="email" name="email" id="email" class="form-control">
						</div>
						<div class="form-group">
							<label for="phone">Phone</label>
							<input type="text" name="phone" id="phone" class="form-control">
						</div>
						<div class="form-group">
							<label for="address">Address</label>
							<textarea name="address" id="address" class="form-control"></textarea>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-primary">Save</button>
						</div>
					</form>
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

@endsection


@section('js')
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
                        $('#edu_board_id').append('<option value="">Select Board</option>');
                        $.each(data.boards, function(index, value) {
                            $('#edu_board_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });                        
                    }
                }
            });
        });

				$("#btnBasicModal").click(function() {
					$('#basicForm').attr('action', "{{route('student.updateProfile')}}");
					$('#name').val($("#profile_name").text());
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
								$("#profile_email").text(data.student.email);
								$("#profile_phone").text(data.student.phone);
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
            $('#eduForm').attr('action', "{{route('student.education.store')}}");
            $('#newEduModal').modal('show');
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
													<td>${data.education.gpa}</td>
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
												.find('td').eq(4).html(data.education.gpa);
											}
                        $('#eduForm')[0].reset();
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
						$('#edu_board_id').append('<option value="">Select Board</option>');
						$.each(data.boards, function(index, value) {
								$('#edu_board_id').append('<option value="' + value.id + '">' + value.name + '</option>');
						}); 
					$("#edu_group_id").val(data.education.edu_group_id);
					$("#edu_board_id").val(data.education.edu_board_id);
					$("#passing_year").val(data.education.passing_year);
					$("#gpa").val(data.education.gpa);
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
			$('#newTrainingModal').modal('show');
		})
		$('#trainingForm').submit(function(e) {
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
							$("#errorMsg").append(`<div class="alert alert-danger"><strong>Warning: </strong>${data.message}</div>`);
						}
							data.errors.forEach(function(element){
							$("#errorMsg").append(`<div class="alert alert-danger"><strong>Warning: </strong>${element}</div>`);
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

});
</script>
@endsection
