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


<div class="d-flex justify-content-between mt-5">
	<h2>Language Proficiency</h2>
	<button class="btn btn-sm btn-primary" id="btnLanguageModal">Add Language</button>
</div>
<table class="table table-sm">
	<thead>
		<tr>
				<th>Language</th>
				<th>Reading</th>
				<th>Writing</th>
				<th>Speaking</th>
				<th>Action</th>
		</tr>
	</thead>
	<tbody id="languageTable">
		@foreach($student->languages as $lang)
		<tr data-id="{{ $lang->id }}">
				<td>{{ $lang->language }}</td>
				<td>{{ $lang->reading }}</td>
				<td>{{ $lang->writing }}</td>
				<td>{{ $lang->speaking }}</td>
				<td>
						<button class="btn btn-sm btn-primary editLanguage" data-id="{{ $lang->id }}">Edit</button>
						<button class="btn btn-sm btn-danger deleteLanguage" data-id="{{ $lang->id }}">Delete</button>
				</td>
		</tr>
		@endforeach
	</tbody>
</table>


<div class="d-flex justify-content-between">
	<h2>References</h2>
	<button class="btn btn-sm btn-primary" id="btnReferenceModal">Add Reference</button>
</div>
<table class="table table-sm">
	<thead>
		<tr>
				<th>Name</th>
				<th>Designation</th>
				<th>Organization</th>
				<th>Email</th>
				<th>Relation</th>
				<th>Mobile</th>
				<th>Address</th>
				<th>Action</th>
		</tr>
	</thead>
	<tbody id="referenceTable">
		@foreach($student->references as $ref)
		<tr data-id="{{ $ref->id }}">
				<td>{{ $ref->name }}</td>
				<td>{{ $ref->designation }}</td>
				<td>{{ $ref->organization }}</td>
				<td>{{ $ref->email }}</td>
				<td>{{ $ref->relation }}</td>
				<td>{{ $ref->mobile }}</td>
				<td>{{ $ref->address }}</td>
				<td>
						<button class="btn btn-sm btn-primary editReference" data-id="{{ $ref->id }}">Edit</button>
						<button class="btn btn-sm btn-danger deleteReference" data-id="{{ $ref->id }}">Delete</button>
				</td>
		</tr>
		@endforeach
	</tbody>
</table>

{{-- Language Modal --}}
<div class="modal fade" id="newLanguageModal" tabindex="-1" role="dialog" aria-labelledby="newLanguageModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="newLanguageModalLabel">New Language</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
						<div id="errorMsgLanguage"></div>
						<form action="{{route('student.language.store')}}" id="languageForm" method="post">
								@csrf
								<div class="form-group">
										<label for="lan_language">Title</label>
										<input type="text" name="language" id="lan_language" class="form-control">
								</div>
								<div class="form-group">
										<label for="lan_reading">Reading</label>
										{{ Form::select('reading', ['High' => 'High', 'Medium' => 'Medium', 'Low' => 'Low'], null, ['class' => 'form-control', 'id' => 'lan_reading', 'placeholder' => 'Select Level']) }}
								</div>
								<div class="form-group">
										<label for="lan_writing">Writing</label>
										{{ Form::select('writing', ['High' => 'High', 'Medium' => 'Medium', 'Low' => 'Low'], null, ['class' => 'form-control', 'id' => 'lan_writing', 'placeholder' => 'Select Level']) }}
								</div>
								<div class="form-group">
										<label for="lan_speaking">Speaking</label>
										{{ Form::select('speaking', ['High' => 'High', 'Medium' => 'Medium', 'Low' => 'Low'], null, ['class' => 'form-control', 'id' => 'lan_speaking', 'placeholder' => 'Select Level']) }}
								</div>
								<button type="submit" class="btn btn-primary">Save</button>
						</form>
				</div>
			</div>
		</div>
</div>

{{-- Reference Modal --}}
<div class="modal fade" id="newReferenceModal" tabindex="-1" role="dialog" aria-labelledby="newReferenceModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="newReferenceModalLabel">New Reference</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
						<div id="errorMsgReference"></div>
						<form action="{{route('student.reference.store')}}" id="referenceForm" method="post">
								@csrf
								<div class="form-group">
										<label for="ref_name">Name</label>
										<input type="text" name="name" id="ref_name" class="form-control">
								</div>
								<div class="form-group">
										<label for="ref_designation">Designation</label>
										<input type="text" name="designation" id="ref_designation" class="form-control">
								</div>
								<div class="form-group">
										<label for="ref_organization">Organization</label>
										<input type="text" name="organization" id="ref_organization" class="form-control">
								</div>
								<div class="form-group">
										<label for="ref_email">Email</label>
										<input type="text" name="email" id="ref_email" class="form-control">
								</div>
								<div class="form-group">
										<label for="ref_relation">Relation</label>
										<input type="text" name="relation" id="ref_relation" class="form-control">
								</div>
								<div class="form-group">
										<label for="ref_mobile">Mobile</label>
										<input type="text" name="mobile" id="ref_mobile" class="form-control">
								</div>
								<div class="form-group">
										<label for="ref_address">Address</label>
										<input type="text" name="address" id="ref_address" class="form-control">
								</div>
								<button type="submit" class="btn btn-primary">Save</button>
						</form>
				</div>
			</div>
		</div>
</div>

