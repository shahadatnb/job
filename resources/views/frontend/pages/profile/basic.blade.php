<div class="row">
    {{-- <div class="col-12 col-md-6 col-lg-6">
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
    </div> --}}
</div>
<div id="errorMsgAddress"></div>
{!! Form::model($student, ['route'=>['student.address.update', $student], 'method'=>'POST', 'id' => 'updateAddress']) !!}
<div class="row">
    <div class="col-12 mb-3">
        <h3>Basic Information</h3>
        <div class="form-group">
            {{ Form::label('name', 'Name') }}
            {{ Form::text('name', null, ['class' => 'form-control']) }}
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    {{ Form::label('father_name', 'Father Name') }}
                    {{ Form::text('father_name', null, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    {{ Form::label('mother_name', 'Mother Name') }}
                    {{ Form::text('mother_name', null, ['class' => 'form-control']) }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    {{ Form::label('email', 'Email') }}
                    {{ Form::email('email', null, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    {{ Form::label('phone', 'Phone') }}
                    {{ Form::text('phone', null, ['class' => 'form-control']) }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    {{ Form::label('nid', 'NID') }}
                    {{ Form::text('nid', null, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    {{ Form::label('date_of_birth', 'Date of Birth') }}
                    {!! Form::text('date_of_birth', $student->date_of_birth == '' ? null : date('d-m-Y', strtotime($student->date_of_birth)), ['class' => 'form-control datetimepicker-input','id'=>'date_of_birth', 'data-toggle'=>"datetimepicker", 'data-target'=>"#date_of_birth", 'placeholder' => 'YYYY-MM-DD', 'required'=>true]) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    {{ Form::label('gender', 'Gender') }}
                    {{ Form::select('gender', ['Male' => 'Male', 'Female' => 'Female'], null, ['class' => 'form-control', 'placeholder' => 'Select Gender']) }}
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    {{ Form::label('religion', 'Religion') }}
                    {{ Form::select('religion', ['islam' => 'Islam', 'hindu' => 'Hindu', 'christian' => 'Christian', 'others' => 'Others'], null, ['class' => 'form-control select2', 'placeholder' => 'Select Religion']) }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    {{ Form::label('blood_group', 'Blood Group') }}
                    {{ Form::select('blood_group', ['A+' => 'A+', 'A-' => 'A-', 'B+' => 'B+', 'B-' => 'B-', 'O+' => 'O+', 'O-' => 'O-', 'AB+' => 'AB+', 'AB-' => 'AB-', 'Unknown' => 'Unknown'], null, ['class' => 'form-control select2', 'placeholder' => 'Select Blood Group']) }}
                </div>
            </div>
        </div>
    </div>
</div>
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
            {{ Form::select('district_id', $districts, null, ['class' => 'form-control select2', 'placeholder' => 'Select District']) }}
        </div>
        <div class="form-group">
            {{ Form::label('upazila_id', 'Thana/Upazila') }}
            {{ Form::select('upazila_id', $upazilas, null, ['class' => 'form-control select2', 'placeholder' => 'Select Thana/Upazila']) }}
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-6">
        <h3>Permanent Address</h3>
        <div class="custom-control custom-checkbox">
            {{ Form::checkbox('sameAsPresent', 1, null, ['class' => 'custom-control-input', 'id' => 'sameAsPresent']) }}
            {!! Form::label('sameAsPresent', __('Same As Present'),['class'=>'custom-control-label']) !!}
        </div>
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
            {{ Form::select('permanent_district_id', $districts, null, ['class' => 'form-control select2', 'placeholder' => 'Select District']) }}
        </div>
        <div class="form-group">
            {{ Form::label('permanent_upazila_id', 'Permanent Thana/Upazila') }}
            {{ Form::select('permanent_upazila_id', $permanent_upazilas, null, ['class' => 'form-control select2', 'placeholder' => 'Select Thana/Upazila']) }}
        </div>
    </div>
    {{ Form::hidden('id', $student->id) }}
    {{ Form::button('Update', ['type' => 'submit', 'class' => 'btn btn-primary mt-3']) }}
</div>
{{ Form::close() }}

<div id="errorMsgCareer" class="mt-3"></div>
{!! Form::model($student, ['route'=>['student.career.update', $student], 'method'=>'POST', 'id' => 'updateCareer']) !!}
<div class="row">
    <div class="col-12 mb-3">
        <h3>Career and Application Information</h3>
        <div class="form-group">
            {{ Form::label('objective', 'Objective') }}
            {{ Form::textarea('objective', null, ['class' => 'form-control', 'rows' => 4]) }}
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    {{ Form::label('present_salary', 'Present Salary') }}
                    {{ Form::number('present_salary', null, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    {{ Form::label('expected_salary', 'Expected Salary') }}
                    {{ Form::number('expected_salary', null, ['class' => 'form-control']) }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    {{ Form::label('looking_for', 'Looking For (Job Level)') }}
                    {{ Form::select('looking_for',['Entry Level'=>'Entry Level', 'Mid Level'=>'Mid Level', 'Top Level'=>'Top Level'], null, ['class' => 'form-control select2', 'placeholder' => 'Select Job Level']) }}
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    {{ Form::label('available_for', 'Available For (Job Nature)') }}
                    {{ Form::select('available_for',['Full Time'=>'Full Time','Part Time'=>'Part Time','Contract'=>'Contract','Internship'=>'Internship','Freelance'=>'Freelance'], null, ['class' => 'form-control select2', 'placeholder' => 'Select Job Nature']) }}
                </div>
            </div>
        </div>
        {{ Form::hidden('id', $student->id) }}
        {{ Form::button('Update', ['type' => 'submit', 'class' => 'btn btn-primary mt-3']) }}
    </div>
</div>
{{ Form::close() }}

<div id="errorMsgOther" class="mt-3"></div>
{!! Form::model($student, ['route'=>['student.other.update', $student], 'method'=>'POST', 'id' => 'updateOther']) !!}
<div class="row">
    <div class="col-12 mb-3">
        <h3>Other Relevant Information</h3>
        <div class="form-group">
            {{ Form::label('career_summary', 'Career Summary') }}
            {{ Form::textarea('career_summary', null, ['class' => 'form-control', 'rows' => 4]) }}
        </div>
        <div class="form-group">
            {{ Form::label('special_qualification', 'Special Qualification') }}
            {{ Form::textarea('special_qualification', null, ['class' => 'form-control', 'rows' => 4]) }}
        </div>
        <div class="form-group">
            {{ Form::label('keywords', 'Keywords') }}
            {{ Form::text('keywords', null, ['class' => 'form-control']) }}
        </div>
        {{ Form::hidden('id', $student->id) }}
        {{ Form::button('Update', ['type' => 'submit', 'class' => 'btn btn-primary mt-3']) }}
    </div>
</div>
{{ Form::close() }}
<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="basicModalLabel">Basic Information</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div id="errorMsgBasic"></div>
					{{-- <form action="" id="basicForm" method="post">
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
							{!! Form::text('date_of_birth', date('d-m-Y', strtotime($student->date_of_birth)), ['class' => 'form-control datetimepicker-input','id'=>'date_of_birth', 'data-toggle'=>"datetimepicker", 'data-target'=>"#date_of_birth", 'placeholder' => 'YYYY-MM-DD', 'required'=>true]) !!}
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
					</form> --}}
				</div>
		</div>
	</div>
</div>