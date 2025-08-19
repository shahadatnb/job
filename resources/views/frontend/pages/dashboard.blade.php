@extends('frontend.layouts.master')
@section('title','Dashboard')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
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
                    <li class="list-group list-group-item"><a href="{{route('/')}}">Job List</a></li>
                    <li class="list-group list-group-item"><a href="{{route('student.applied_jobs')}}">Applied Jobs</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-9 col-lg-9 mt-3">
        <div class="card">
            <div class="card-header">
							<h4>Profile
								@if(Session::has('job_info'))
									|| Post Name: {{Session::get('job_info')['job_title']}}
									<a class="btn btn-sm btn-success" href="{{ route('job.job_detail',Session::get('job_info')['job_id']) }}">Applay now</a>						
								@endif
							</h4>
            </div>
            <div class="card-body">
                <nav>
                    <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-basic-tab" data-bs-toggle="tab" data-bs-target="#nav-basic" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Basic</button>
                        <button class="nav-link" id="nav-education-tab" data-bs-toggle="tab" data-bs-target="#nav-education" type="button" role="tab" aria-controls="nav-education" aria-selected="false">Education/Training</button>
                        <button class="nav-link" id="nav-employment-tab" data-bs-toggle="tab" data-bs-target="#nav-employment" type="button" role="tab" aria-controls="nav-employment" aria-selected="false">Employment</button>
                        <button class="nav-link" id="nav-others-tab" data-bs-toggle="tab" data-bs-target="#nav-others" type="button" role="tab" aria-controls="nav-others" aria-selected="false">Other Information</button>
                        <button class="nav-link" id="nav-photograph-tab" data-bs-toggle="tab" data-bs-target="#nav-photograph" type="button" role="tab" aria-controls="nav-employment" aria-selected="false">Photograph</button>
                    </div>
                </nav>
                <div class="tab-content p-3 border bg-light" id="nav-profile">
                    <div class="tab-pane fade active show" id="nav-basic" role="tabpanel" aria-labelledby="nav-home-tab">
											@include('frontend.pages.profile.basic')
                    </div>
                    <div class="tab-pane fade" id="nav-education" role="tabpanel" aria-labelledby="nav-education-tab">
											@include('frontend.pages.profile.education')
                    </div>
                    <div class="tab-pane fade" id="nav-employment" role="tabpanel" aria-labelledby="nav-employment-tab">
											@include('frontend.pages.profile.employment')
                    </div>
                    <div class="tab-pane fade" id="nav-others" role="tabpanel" aria-labelledby="nav-others-tab">
												@include('frontend.pages.profile.others')
                    </div>
                    <div class="tab-pane fade" id="nav-photograph" role="tabpanel" aria-labelledby="nav-photograph-tab">
												<h2>Photograph</h2>
												<div id="errorMsgPhoto"></div>
												<img id="photoPreview" src="{{asset('/storage/'.$student->photo)}}" alt="" class="img-thumbnail" width="300 px">
												<br>
												<form action="{{route('student.photo.update')}}" method="POST" enctype="multipart/form-data">
													@csrf
													<label for="photo">Change Photo (Photo Size: 300px X 300px and File Size: 100kb)</label>
													<input type="file" name="photo" class="" id="photo">
												</form>

												<img id="signaturePreview" src="{{asset('/storage/'.$student->signature)}}" alt="" class="img-thumbnail mt-3" width="300 px">
												<br>
												<form action="{{route('student.signature.update')}}" method="POST" enctype="multipart/form-data">
													@csrf
													<label for="signature">Change Signature (Photo Size: 300px X 80px and File Size: 40kb)</label>
													<input type="file" name="signature" class="" id="signature">
												</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('js')
<script src="{{ asset('assets/admin/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/moment/moment.min.js') }}"> </script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
<!-- Tempusdominus -->
<script src="{{ asset('assets/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"> </script>

<script>
    $(document).ready(function() {
        $('#edu_level_id').change(function() {
						$.LoadingOverlay("show");
            var edu_level_id = $(this).val();
            $.ajax({
                url: "{{route('student.education.group')}}?edu_level_id=" + edu_level_id,
                method: 'GET',
                success: function(data) {
                    //console.log(data);                    
                    if(data.status == true){
                        $('#edu_group_id').empty();
												if(data.groups.length > 0){
													$('#edu_group_id').append('<option value="">Select Group</option>');
													$.each(data.groups, function(index, value) {
															$('#edu_group_id').append('<option value="' + value.id + '">' + value.name + '</option>');
													});
												}else{
													$('#edu_group_id').append('<option value="0">Select Group</option>');
												}
                        
                        $('#edu_board_id').empty();
                        //$('#university').val('');
                        if(data.boards.length > 0){
                          $('#boardDiv').removeClass('d-none');
                          //$('#universityDiv').addClass('d-none');
                          //$('#university').attr('required', false);
                          $('#edu_board_id').attr('required', true);

                          $('#edu_board_id').append('<option value="">Select Board</option>');
                          $.each(data.boards, function(index, value) {
                              $('#edu_board_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                          });
                        }else{
                          $('#boardDiv').addClass('d-none');
                          //$('#universityDiv').removeClass('d-none');
                          //$('#university').attr('required', true);
                          $('#edu_board_id').attr('required', false);
                        }
                    }
                }
            });
						$.LoadingOverlay("hide");
					});

		$("#sameAsPresent").change(function(){
				if($(this).is(":checked")) {
						$("#permanent_village").val($("#village").val());
						$("#permanent_post_office").val($("#post_office").val());
						$("#permanent_district_id").empty();
						$("#permanent_district_id").append(`<option value='${$("#district_id").val()}'>${$("#district_id").find(':selected').text()}</option>`);
						$("#permanent_district_id").val($("#district_id").val());
						$("#permanent_upazila_id").append(`<option value='${$("#upazila_id").val()}'>${$("#upazila_id").find(':selected').text()}</option>`);
						$("#permanent_upazila_id").val($("#upazila_id").val());
				}
		});

// basic
		$('#date_of_birth').datetimepicker({
				format: 'DD-MM-YYYY'
				//format: 'YYYY-MM-DD'
		});
		$('#start_date').datetimepicker({
				//format: 'DD/MM/YYYY'
				format: 'DD-MM-YYYY'
		});
		$('#end_date').datetimepicker({
				//format: 'DD/MM/YYYY'
				format: 'DD-MM-YYYY'
		});
		$('.datetimepicker').datetimepicker({
				//format: 'DD/MM/YYYY'
				format: 'DD-MM-YYYY'
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
					$.LoadingOverlay("show");
					var formData = $(this).serialize();
					let url = $(this).attr('action');
					$("#errorMsgBasic").empty();
					$.ajax({
						url: url,
						method: 'POST',
						data: formData,
						success: function(data) {
							//console.log(data);
							if(data.status == true){
								$("#profile_name").text(data.student.name);
								$("#profile_father_name").text(data.student.father_name);
								$("#profile_mother_name").text(data.student.mother_name);
								$("#profile_email").text(data.student.email);
								$("#profile_phone").text(data.student.phone);
								$("#profile_nid").text(data.student.nid);
								$("#profile_date_of_birth").text( moment(data.student.date_of_birth).format('DD-MM-YYYY'));
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
					$.LoadingOverlay("hide");
				});



		$("#photo").change(function(){
			$.LoadingOverlay("show");
			$("#errorMsgPhoto").empty();
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
					//console.log(data.errors);
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
			$.LoadingOverlay("hide");
		});

		$("#signature").change(function(){
			$.LoadingOverlay("show");
			$("#errorMsgPhoto").empty();
			var signature = this.files[0];
			let formData = new FormData();
			//const blob = new Blob([metadata], { type: 'application/json' });
			//formData.append('metadata', blob);
			formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
			formData.append('signature', signature);
			$.ajax({
				url: "{{route('student.signature.update')}}",
				method: 'POST',
				data: formData,
				contentType: false,
				processData: false,
				success: function(data){
					//console.log(data.errors);
					//$('#photoPreview').html(data);
					if(data.status == true){
						$("#signaturePreview").attr('src', data.signature);
					}else{
						if(data.message){
								$("#errorMsgPhoto").append(`<div class="alert alert-danger"><strong>Warning: </strong>${data.message}</div>`);
							}
						data.errors.signature.forEach(function(element){
							$("#errorMsgPhoto").append(`<div class="alert alert-danger"><strong>Warning: </strong>${element}</div>`);
						});
					}
				}
			})
			$.LoadingOverlay("hide");
		});

		$("#updateAddress").submit(function(e){
			e.preventDefault();
			$.LoadingOverlay("show");
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
						//$('#nav-education-tab').tab('show');
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
			$.LoadingOverlay("hide");
		})

		$("#updateCareer").submit(function(e){
			e.preventDefault();
			$.LoadingOverlay("show");
			var formData = $(this).serialize();
			let url = $(this).attr('action');
			$("#errorMsgCareer").empty();
			$.ajax({
				url: url,
				method: 'POST',
				data: formData,
				success: function(data){
					//console.log(data);
					if(data.status == true){
						//$("#addressModal").modal('hide');
						$("#errorMsgCareer").append(`<div class="alert alert-success"><strong>Success: </strong>${data.message}</div>`);
						//$('#nav-education-tab').tab('show');
					}else{
						if(data.message){
								$("#errorMsgCareer").append(`<div class="alert alert-danger"><strong>Warning: </strong>${data.message}</div>`);
							}
						data.errors.forEach(function(element){
							$("#errorMsgCareer").append(`<div class="alert alert-danger"><strong>Warning: </strong>${element}</div>`);
						});
					}
				}
			})
			$.LoadingOverlay("hide");
		})

		$("#updateOther").submit(function(e){
			e.preventDefault();
			$.LoadingOverlay("show");
			var formData = $(this).serialize();
			let url = $(this).attr('action');
			$("#errorMsgOther").empty();
			$.ajax({
				url: url,
				method: 'POST',
				data: formData,
				success: function(data){
					//console.log(data);
					if(data.status == true){
						//$("#addressModal").modal('hide');
						$("#errorMsgOther").append(`<div class="alert alert-success"><strong>Success: </strong>${data.message}</div>`);
						//$('#nav-education-tab').tab('show');
					}else{
						if(data.message){
								$("#errorMsgOther").append(`<div class="alert alert-danger"><strong>Warning: </strong>${data.message}</div>`);
							}
						data.errors.forEach(function(element){
							$("#errorMsgOther").append(`<div class="alert alert-danger"><strong>Warning: </strong>${element}</div>`);
						});
					}
				}
			})
			$.LoadingOverlay("hide");
		})

		$("#addSkill").click(function(){
			$.LoadingOverlay("show");
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
			$.LoadingOverlay("hide");
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


		//Language Proficiency
		$("#btnLanguageModal").click(function(){
			$("#languageForm").attr('action', "{{route('student.language.store')}}");
			$('#newLanguageModal').modal('show');
		});

		$('#languageForm').submit(function(e) {
			e.preventDefault();
			$.LoadingOverlay("show");
			var formData = $(this).serialize();
			let url = $(this).attr('action');
			$("#errorMsgLanguage").empty();
			$.ajax({
				url: url,
				method: 'POST',
				data: formData,
				success: function(data) {
					//console.log(data);
					if(data.status == true){
						$('#newLanguageModal').modal('hide');
						$('#languageForm')[0].reset();
						if(data.type == 'save'){
						$("#languageTable").append(`
							<tr data-id="${data.language.id}">
								<td>${data.language.language}</td>
								<td>${data.language.reading}</td>
								<td>${data.language.writing}</td>
								<td>${data.language.speaking}</td>
								<td>
									<a class="btn btn-primary btn-sm editLanguage" data-id="${data.language.id}">Edit</a>
									<a class="btn btn-danger btn-sm deleteLanguage" data-id="${data.language.id}">Delete</a>
								</td>
							</tr>
						`);
							
						}else{
							$("#languageTable").find('tr[data-id="'+data.language.id+'"]')
							.find('td').eq(0).html(data.language.language);
							$("#languageTable").find('tr[data-id="'+data.language.id+'"]')
							.find('td').eq(1).html(data.language.reading);
							$("#languageTable").find('tr[data-id="'+data.language.id+'"]')
							.find('td').eq(2).html(data.language.writing);
							$("#languageTable").find('tr[data-id="'+data.language.id+'"]')
							.find('td').eq(3).html(data.language.speaking);
						}
					}else{
						//console.log(data);
						if(data.message){
							$("#errorMsgLanguage").append(`<div class="alert alert-danger"><strong>Warning: </strong>${data.message}</div>`);
						}
							data.errors.forEach(function(element){
							$("#errorMsgLanguage").append(`<div class="alert alert-danger"><strong>Warning: </strong>${element}</div>`);
						});
					}
				}
			});
			$.LoadingOverlay("hide");
		});

		$("#languageTable").on('click', '.editLanguage', function(){
			$.LoadingOverlay("show");
			var id = $(this).data('id');
			$.ajax({
				url: "{{route('student.language.edit')}}?id=" + id,
				method: 'GET',
				success: function(data){
					console.log(data);
					$("#languageForm").attr('action', "{{route('student.language.update')}}?id=" + id);
					$("#lan_language").val(data.language.language);
					$("#lan_reading").val(data.language.reading);
					$("#lan_writing").val(data.language.writing);
					$("#lan_speaking").val(data.language.speaking);
					$('#newLanguageModal').modal('show');
				}
			});
			$.LoadingOverlay("hide");
		});

		$("#languageTable").on('click', '.deleteLanguage', function(){
			if(confirm("Are you sure?")){
				var id = $(this).data('id');
				$.ajax({
					url: "{{route('student.language.destroy')}}?id=" + id,
					method: 'GET',
					success: function(data){
						console.log(data);
						if(data.status == true){
							$("#languageTable").find('tr[data-id="'+id+'"]').remove();
						}
					}
				});
			}
		});


		//Reference
		$("#btnReferenceModal").click(function(){
			$("#referenceForm").attr('action', "{{route('student.reference.store')}}");
			$('#newReferenceModal').modal('show');
		});

		$('#referenceForm').submit(function(e) {
			e.preventDefault();
			$.LoadingOverlay("show");
			var formData = $(this).serialize();
			let url = $(this).attr('action');
			$("#errorMsgReference").empty();
			$.ajax({
				url: url,
				method: 'POST',
				data: formData,
				success: function(data) {
					//console.log(data);
					if(data.status == true){
						$('#newReferenceModal').modal('hide');
						$('#referenceForm')[0].reset();
						if(data.type == 'save'){
						$("#referenceTable").append(`
							<tr data-id="${data.reference.id}">
								<td>${data.reference.name}</td>
								<td>${data.reference.designation}</td>
								<td>${data.reference.organization}</td>
								<td>${data.reference.email}</td>
								<td>${data.reference.relation}</td>
								<td>${data.reference.mobile}</td>
								<td>${data.reference.address}</td>
								<td>
									<a class="btn btn-primary btn-sm editReference" data-id="${data.reference.id}">Edit</a>
									<a class="btn btn-danger btn-sm deleteReference" data-id="${data.reference.id}">Delete</a>
								</td>
							</tr>
						`);
							
						}else{
							$("#referenceTable").find('tr[data-id="'+data.reference.id+'"]')
							.find('td').eq(0).html(data.reference.name);
							$("#referenceTable").find('tr[data-id="'+data.reference.id+'"]')
							.find('td').eq(1).html(data.reference.designation);
							$("#referenceTable").find('tr[data-id="'+data.reference.id+'"]')
							.find('td').eq(2).html(data.reference.organization);
							$("#referenceTable").find('tr[data-id="'+data.reference.id+'"]')
							.find('td').eq(3).html(data.reference.email);
							$("#referenceTable").find('tr[data-id="'+data.reference.id+'"]')
							.find('td').eq(4).html(data.reference.relation);
							$("#referenceTable").find('tr[data-id="'+data.reference.id+'"]')
							.find('td').eq(5).html(data.reference.mobile);
							$("#referenceTable").find('tr[data-id="'+data.reference.id+'"]')
							.find('td').eq(6).html(data.reference.address);
						}
					}else{
						//console.log(data);
						if(data.message){
							$("#errorMsgReference").append(`<div class="alert alert-danger"><strong>Warning: </strong>${data.message}</div>`);
						}
							data.errors.forEach(function(element){
							$("#errorMsgReference").append(`<div class="alert alert-danger"><strong>Warning: </strong>${element}</div>`);
						});
					}
				}
			});
			$.LoadingOverlay("hide");
		});

		$("#referenceTable").on('click', '.editReference', function(){
			$.LoadingOverlay("show");
			var id = $(this).data('id');
			$.ajax({
				url: "{{route('student.reference.edit')}}?id=" + id,
				method: 'GET',
				success: function(data){
					console.log(data);
					$("#referenceForm").attr('action', "{{route('student.reference.update')}}?id=" + id);
					$("#ref_name").val(data.reference.name);
					$("#ref_designation").val(data.reference.designation);
					$("#ref_organization").val(data.reference.organization);
					$("#ref_email").val(data.reference.email);
					$("#ref_relation").val(data.reference.relation);
					$("#ref_mobile").val(data.reference.mobile);
					$("#ref_address").val(data.reference.address);
					$('#newReferenceModal').modal('show');
				}
			});
			$.LoadingOverlay("hide");
		});

		$("#referenceTable").on('click', '.deleteReference', function(){
			if(confirm("Are you sure?")){
				var id = $(this).data('id');
				$.ajax({
					url: "{{route('student.reference.destroy')}}?id=" + id,
					method: 'GET',
					success: function(data){
						console.log(data);
						if(data.status == true){
							$("#referenceTable").find('tr[data-id="'+id+'"]').remove();
						}
					}
				});
			}
		});

});
</script>
@endsection
