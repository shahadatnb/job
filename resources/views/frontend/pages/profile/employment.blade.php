<div class="d-flex justify-content-between">
<h2>Employment</h2>
<button class="btn btn-sm btn-primary" id="btnEmploymentModal">New Entry</button>
</div>
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
					<td>{{ $edu->is_current ==1 ? 'Continuing' : date('d-m-Y', strtotime($edu->end_date)) }}</td>
					<td>
						<button class="btn btn-sm btn-primary editEmployment" data-id="{{ $edu->id }}"><i class="fa fa-edit"></i></button>
						<button class="btn btn-sm btn-danger deleteEmployment" data-id="{{ $edu->id }}"><i class="fa fa-trash"></i></button>
					</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	
	



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
										<input type="checkbox" name="is_current" id="is_current" value="1">Continuing
								</div>
								<div class="form-group">
										<label for="job_description">Job Description</label>
										<textarea name="job_description" id="job_description" class="form-control"></textarea>
										{{-- <input type="text" name="job_description" id="job_description" class="form-control"> --}}
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

@push('js')
<script>
	$(document).ready(function() {
						//employment

		$("#is_current").on('change', function(){
			if($(this).is(':checked')){
				$("#end_date").prop('disabled', true);
				$("#end_date").val('');
			}else{
				$("#end_date").prop('disabled', false);
			}
		});


		$("#btnEmploymentModal").click(function(){
			$("#employmentForm").attr('action', "{{route('student.experience.store')}}");
			$('#newEmploymentModal').modal('show');
		});

		$('#employmentForm').submit(function(e) {
			e.preventDefault();
			$.LoadingOverlay("show");
			var formData = $(this).serialize();
			let url = $(this).attr('action');
			$("#errorMsgEmployment").empty();
			$.ajax({
				url: url,
				method: 'POST',
				data: formData,
				success: function(data) {
					//console.log(data);
					if(data.status == true){
						$('#newEmploymentModal').modal('hide');
						$('#employmentForm')[0].reset();
						if(data.type == 'save'){
						$("#employmentTable").append(`
							<tr data-id="${data.employment.id}">
								<td>${data.employment.job_title}</td>
								<td>${data.employment.company_name}</td>
								<td>${data.employment.job_description}</td>
								<td>${ moment(data.employment.start_date).format('DD-MM-YYYY')}</td>
								<td>${ data.employment.is_current == 1 ? 'Continuing' : moment(data.employment.end_date).format('DD-MM-YYYY') } </td>
								<td>
									<a class="btn btn-primary btn-sm editEmployment" data-id="${data.employment.id}">Edit</a>
									<a class="btn btn-danger btn-sm deleteEmployment" data-id="${data.employment.id}">Delete</a>
								</td>
							</tr>
						`);
							
						}else{
							$("#employmentTable").find('tr[data-id="'+data.employment.id+'"]')
							.find('td').eq(0).html(data.employment.job_title);
							$("#employmentTable").find('tr[data-id="'+data.employment.id+'"]')
							.find('td').eq(1).html(data.employment.company_name);
							$("#employmentTable").find('tr[data-id="'+data.employment.id+'"]')
							.find('td').eq(2).html(data.employment.job_description);
							$("#employmentTable").find('tr[data-id="'+data.employment.id+'"]')
							.find('td').eq(3).html(moment(data.employment.start_date).format('DD-MM-YYYY')); //data.employment.start_date);
							$("#employmentTable").find('tr[data-id="'+data.employment.id+'"]')
							.find('td').eq(4).html( data.employment.is_current == 1 ? 'Continuing' : moment(data.employment.end_date).format('DD-MM-YYYY'));
							// $("#employmentTable").find('tr[data-id="'+data.employment.id+'"]')
							// .find('td').eq(8).html(data.employment.job_description);
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
			$.LoadingOverlay("hide");
		});

		$("#nav-employment").on('click', '.editEmployment', function(){
			$.LoadingOverlay("show");
			var id = $(this).data('id');
			$.ajax({
				url: "{{route('student.experience.edit')}}?id=" + id,
				method: 'GET',
				success: function(data){
					//console.log(data);
					$("#employmentForm").attr('action', "{{route('student.experience.update')}}?id=" + id);
					$("#employment_title").val(data.employment.employment_title);
					$("#company_name").val(data.employment.company_name);
					$("#company_location").val(data.employment.company_location);
					$("#company_phone").val(data.employment.company_phone);
					$("#company_email").val(data.employment.company_email);
					$("#job_title").val(data.employment.job_title);
					$("#start_date").val( moment(data.employment.start_date).format('DD-MM-YYYY') ); // data.employment.start_date);
					$("#is_current").prop('checked', data.employment.is_current == 1 ? true : false);
					$("#end_date").val( data.employment.is_current == 1 ? '' : moment(data.employment.end_date).format('DD-MM-YYYY') );
					$("#job_description").val(data.employment.job_description);
					$('#newEmploymentModal').modal('show');
				}
			});
			$.LoadingOverlay("hide");
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
	});
</script>
@endpush