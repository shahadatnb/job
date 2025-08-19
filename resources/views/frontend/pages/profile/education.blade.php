<div class="d-flex justify-content-between">
	<h2>Academic Summary</h2>
	<button class="btn btn-sm btn-primary" id="newAcademicModal">Add Academic Certificate</button>
</div>
<table class="table table-sm">
	<thead>
		<tr>
				<th>Exam</th>
				<th>Group</th>
				<th>Institute Name</th>
				<th>Year</th>
				<th>Result</th>
				<th width="10%">Action</th>
		</tr>
	</thead>
	<tbody id="academicTable">
		@foreach($student->educations as $edu)
		<tr data-id="{{ $edu->id }}">
				<td>{{ $edu->exam->name }}</td>
				<td>{{ $edu->group ? $edu->group->name : '' }}</td>
				{{-- <td>{{ $edu->board ? $edu->board->name : $edu->university }}</td> --}}
				<td>{{ $edu->university }}{{ $edu->board ? '(Board: '.$edu->board->name.')' : '' }}</td>
				<td>{{ $edu->passing_year }}</td>
				<td>{{ $edu->result }}</td>
				<td>
					<button class="btn btn-sm btn-primary editAcademic" data-id="{{ $edu->id }}"><i class="fa fa-edit"></i></button>
					<button class="btn btn-sm btn-danger deleteAcademic" data-id="{{ $edu->id }}"><i class="fa fa-trash"></i></button>
				</td>
		</tr>
		@endforeach
	</tbody>
</table>

<div class="d-flex justify-content-between">
	<h2>Training Summary</h2>
	<button class="btn btn-sm btn-primary" id="btnTrainingModal">Add Training</button>
</div>
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
						<button class="btn btn-sm btn-primary editTraining" data-id="{{ $edu->id }}"><i class="fa fa-edit"></i></button>
						<button class="btn btn-sm btn-danger deleteTraining" data-id="{{ $edu->id }}"><i class="fa fa-trash"></i></button>
				</td>
		</tr>
		@endforeach
	</tbody>
</table>

<div class="d-flex justify-content-between">
	<h2>Professional Certificates</h2>
	<button class="btn btn-sm btn-primary" id="btnProfessionalModal">Add New</button>
</div>
<table class="table table-sm">
	<thead>
		<tr>
				<th>Certification</th>
				<th>Institute</th>
				<th>Location</th>
				<th>From</th>
				<th>To</th>
				<th>Action</th>
		</tr>
	</thead>
	<tbody id="professionalTable">
		@foreach($student->certifications as $certificate)
		<tr data-id="{{ $certificate->id }}">
				<td>{{ $certificate->certification }}</td>
				<td>{{ $certificate->institute }}</td>
				<td>{{ $certificate->location }}</td>
				<td>{{ date('d-m-Y', strtotime($certificate->start_date)) }}</td>
				<td>{{ date('d-m-Y', strtotime($certificate->end_date)) }}</td>
				<td>
						<button class="btn btn-sm btn-primary editProfessional" data-id="{{ $certificate->id }}"><i class="fa fa-edit"></i></button>
						<button class="btn btn-sm btn-danger deleteProfessional" data-id="{{ $certificate->id }}"><i class="fa fa-trash"></i></button>
				</td>
		</tr>
		@endforeach
	</tbody>
</table>



{{-- Academic Modal --}}
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
                    <label for="university">Institute Name</label>
					          <input type="text" name="university" id="university" class="form-control">
                </div>
                <div class="form-group" id="groupDiv">
                    <label for="edu_group_id">Group</label>
                    <select name="edu_group_id" id="edu_group_id" class="form-control">
                        <option value="">Select Group</option>
                    </select>
                </div>
                <div class="form-group d-none" id="boardDiv">
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
					<input name = "result_type" type = "radio" id="gpa" value = "gpa" checked> GPA
					<input name = "result_type" type = "radio" id="division" value = "division"> Division
					<input name = "result_type" type = "radio" id="pass" value = "pass"> Pass
					<div class="input-group" id="gpaInput">
						<input type="text" name="result_gpa" id="result_gpa" class="form-control" placeholder="GPA">
						<input type="text" name="out_of" id="out_of" class="form-control" placeholder="Out of">
					</div>
          <input type="text" name="result_pass" id="result_pass" class="form-control" value="Pass" readonly>
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

{{-- Training Modal --}}
<div class="modal fade" id="newTrainingModal" tabindex="-1" role="dialog" aria-labelledby="newTrainingModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="newTrainingModalLabel">New Training</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
						<div id="errorMsgTraining"></div>
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


{{-- Professional Certification Modal --}}
<div class="modal fade" id="newProfessionalModal" tabindex="-1" role="dialog" aria-labelledby="newProfessionalModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="newProfessionalModalLabel">Professional Certification</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
						<div id="errorMsgProfessional"></div>
						<form action="{{route('student.certification.store')}}" id="professionalForm" method="post">
								@csrf
								<div class="form-group">
										<label for="pro_certification">Certificate</label>
										<input type="text" name="certification" id="pro_certification" class="form-control">
								</div>
								<div class="form-group">
										<label for="pro_institute">Institute</label>
										<input type="text" name="institute" id="pro_institute" class="form-control">
								</div>
								<div class="form-group">
										<label for="pro_location">location</label>
										<input type="text" name="location" id="pro_location" class="form-control">
								</div>
								<div class="form-group">
										<label for="pro_start_date">Start Date</label>
										<input type="text" name="start_date" id="pro_start_date" class="form-control datetimepicker datetimepicker-input" data-toggle="datetimepicker" data-target="#datetimepicker5">
								</div>
								<div class="form-group">
										<label for="pro_end_date">End Date</label>
										<input type="text" name="end_date" id="pro_end_date" class="form-control datetimepicker datetimepicker-input" data-toggle="datetimepicker" data-target="#datetimepicker5">
								</div>
								<button type="submit" class="btn btn-primary">Save</button>
						</form>
				</div>
			</div>
		</div>
</div>

@push('js')
<script>
	$(document).ready(function() {
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
				$('#gpaInput').removeClass('d-none');
				$('#result_division').addClass('d-none');
				$('#result_pass').addClass('d-none');
			} else if (value == 'division') {
				$('#gpaInput').addClass('d-none');
				$('#result_division').removeClass('d-none');
				$('#result_pass').addClass('d-none');
			}else{
				$('#gpaInput').addClass('d-none');
				$('#result_division').addClass('d-none');
				$('#result_pass').removeClass('d-none');
			}
		});
    
        $('#eduForm').submit(function(e) {
            e.preventDefault();
						$.LoadingOverlay("show");
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
								<td>${data.education.group_name}</td>
								<td>${data.education.university}</td>
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
							.find('td').eq(1).html(data.education.group_name);
							$("#academicTable").find('tr[data-id="'+data.education.id+'"]')
							.find('td').eq(2).html(data.education.university);
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
					$.LoadingOverlay("hide");
        });

		$("#nav-education").on('click', '.editAcademic', function(){
			$('#eduForm')[0].reset();
			$.LoadingOverlay("show");
			$("#errorMsg").empty();
			var id = $(this).data('id');
			$.ajax({
				url: "{{route('student.education.edit')}}?id=" + id,
				method: 'GET',
				success: function(data){
					//console.log(data);
					$("#eduForm").attr('action', "{{route('student.education.update')}}?id=" + id);
					$("#edu_level_id").val(data.education.edu_level_id);
					//$('#edu_level_id').trigger('change');
							$('#edu_group_id').empty();
						if(data.groups.length > 0){
							$('#edu_group_id').append('<option value="">Select Group</option>');
							$.each(data.groups, function(index, value) {
									$('#edu_group_id').append('<option value="' + value.id + '">' + value.name + '</option>');
							});
						}else{
							$('#edu_group_id').append('<option value="0" selected>Select Group</option>');
							$('#edu_group_id').val('0').change();
						}
						$('#edu_board_id').empty();
            if(data.boards.length > 0){
              $('#boardDiv').removeClass('d-none');
              //$('#university').addClass('d-none');
              //$('#university').attr('required', false);
              $('#edu_board_id').attr('required', true);

              $('#edu_board_id').append('<option value="">Select Board</option>');
              $.each(data.boards, function(index, value) {
                  $('#edu_board_id').append('<option value="' + value.id + '">' + value.name + '</option>');
              }); 
            }else{
              $('#boardDiv').addClass('d-none');
              //$('#university').removeClass('d-none');
              //$('#university').attr('required', true);
              $('#edu_board_id').attr('required', false);
            }
						
					$("#edu_group_id").val(data.education.edu_group_id);
					$("#edu_board_id").val(data.education.edu_board_id);
					$("#university").val(data.education.university);
					$("#passing_year").val(data.education.passing_year);
					//console.log(data.education.result_type);
					if(data.education.result_type == 'gpa'){
						$("#gpa").prop('checked', true);
						$("#result_gpa").val(data.education.result);
						$("#out_of").val(data.education.out_of);
					} else if(data.education.result_type == 'division'){
						$("#division").prop('checked', true);
						$("#result_division").val(data.education.result).change();
					} else{
						$("#pass").prop('checked', true);
					}
					$("input[name='result_type']").change();
					$('#newEduModal').modal('show');
				}
			});
			$.LoadingOverlay("hide");
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
			$.LoadingOverlay("show");
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
			$.LoadingOverlay("hide");
		});

		$("#nav-education").on('click', '.editTraining', function(){
			var id = $(this).data('id');
			$.ajax({
				url: "{{route('student.training.edit')}}?id=" + id,
				method: 'GET',
				success: function(data){
					//console.log(data);
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

		// Proffessional Certificate
		$("#btnProfessionalModal").click(function(){
			$("#professionalForm").attr('action', "{{route('student.certification.store')}}");
			$('#newProfessionalModal').modal('show');
		})
		$('#professionalForm').submit(function(e) {
			e.preventDefault();
			$.LoadingOverlay("show");
			var formData = $(this).serialize();
			let url = $(this).attr('action');
			$("#errorMsgProfessional").empty();
			$.ajax({
				url: url,
				method: 'POST',
				data: formData,
				success: function(data) {
					console.log(data);
					if(data.status == true){
						if(data.type == 'save'){
							$("#professionalTable").append(`
								<tr data-id="${data.professional.id}">
									<td>${data.professional.certification}</td>
									<td>${data.professional.institute}</td>
									<td>${data.professional.location}</td>
									<td>${data.professional.start_date}</td>
									<td>${data.professional.end_date}</td>
									<td>
										<a class="btn btn-primary btn-sm editProfessional" data-id="${data.professional.id}">Edit</a>
										<a class="btn btn-danger btn-sm deleteProfessional" data-id="${data.professional.id}">Delete</a>
									</td>
								</tr>
							`);
						}else{
							$("#professionalTable").find('tr[data-id="'+data.professional.id+'"]')
							.find('td').eq(0).html(data.professional.certification);
							$("#professionalTable").find('tr[data-id="'+data.professional.id+'"]')
							.find('td').eq(1).html(data.professional.institute);
							$("#professionalTable").find('tr[data-id="'+data.professional.id+'"]')
							.find('td').eq(2).html(data.professional.location);
							$("#professionalTable").find('tr[data-id="'+data.professional.id+'"]')
							.find('td').eq(3).html(data.professional.start_date);
							$("#professionalTable").find('tr[data-id="'+data.professional.id+'"]')
							.find('td').eq(4).html(data.professional.end_date);
						}
						$('#professionalForm')[0].reset();
						$('#newProfessionalModal').modal('hide');
					}else{
						//console.log(data);
						if(data.message){
							$("#errorMsgProfessional").append(`<div class="alert alert-danger"><strong>Warning: </strong>${data.message}</div>`);
						}
							data.errors.forEach(function(element){
							$("#errorMsgProfessional").append(`<div class="alert alert-danger"><strong>Warning: </strong>${element}</div>`);
						});
					}
				}
			});
			$.LoadingOverlay("hide");
		});

		$("#nav-education").on('click', '.editProfessional', function(){
			var id = $(this).data('id');
			$.ajax({
				url: "{{route('student.certification.edit')}}?id=" + id,
				method: 'GET',
				success: function(data){
					//console.log(data);
					$("#professionalForm").attr('action', "{{route('student.certification.update')}}?id=" + id);
					$("#pro_certification").val(data.professional.certification);
					$("#pro_institute").val(data.professional.institute);
					$("#pro_location").val(data.professional.location);
					$("#pro_start_date").val(data.professional.start_date);
					$("#pro_end_date").val(data.professional.end_date);
					$('#newProfessionalModal').modal('show');
				}
			});
		});

		$("#nav-education").on('click', '.deleteProfessional', function(){
			if(confirm("Are you sure?")){
				var id = $(this).data('id');
				$.ajax({
					url: "{{route('student.certification.destroy')}}?id=" + id,
					method: 'GET',
					success: function(data){
						console.log(data);
						if(data.status == true){
							$("#professionalTable").find('tr[data-id="'+id+'"]').remove();
						}
					}
				});
			}
		});

	});
	</script>
@endpush