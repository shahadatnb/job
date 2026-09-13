@extends('admin.layouts.layout')
@section('title', __('Edit Applicant'))
@section('content')
<!-- Default box -->
<div class="card card-outline card-info">
    <div class="card-header">
        <h3 class="card-title">{{ __('Edit Applicant') }}: {{ $applicant->name }}</h3>
        <div class="card-tools">
            <a href="{{ route('applicant.show', $applicant) }}" class="btn btn-sm btn-info"><i class="fas fa-arrow-alt-circle-left"></i> Back</a>
        </div>
    </div>
    <div class="card-body">
        @include('admin.layouts._message')

        {!! Form::model($applicant, ['route' => ['applicant.update', $applicant], 'method' => 'PUT', 'files' => true, 'class' => 'form-horizontal']) !!}

        <h5 class="mb-3"><b>{{ __('Basic Information') }}</b></h5>
        <div class="row">
            <div class="col-md-4 form-group">
                {!! Form::label('name', __('Name') . ' *') !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Name')]) !!}
            </div>
            <div class="col-md-4 form-group">
                {!! Form::label('email', __('Email') . ' *') !!}
                {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => __('Email')]) !!}
            </div>
            <div class="col-md-4 form-group">
                {!! Form::label('phone', __('Mobile') . ' *') !!}
                {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => __('Mobile')] ) !!}
            </div>

            <div class="col-md-3 form-group">
                {!! Form::label('nid', __('NID')) !!}
                {!! Form::text('nid', null, ['class' => 'form-control', 'placeholder' => __('NID')]) !!}
            </div>
            <div class="col-md-3 form-group">
                {!! Form::label('date_of_birth', __('Date of Birth')) !!}
                @php
                    $dobRaw = old('date_of_birth', $applicant->date_of_birth);
                    $dobDisplay = $dobRaw ? \Carbon\Carbon::parse($dobRaw)->format('d-m-Y') : '';
                    $dobValue = $dobRaw ? \Carbon\Carbon::parse($dobRaw)->format('Y-m-d') : null;
                @endphp
                <input type="text" class="form-control js-datepicker" id="date_of_birth_display" autocomplete="off" placeholder="dd-mm-yyyy"
                       value="{{ $dobDisplay }}"
                       data-alt-field="#date_of_birth" data-max-today="1">
                {!! Form::hidden('date_of_birth', $dobValue, ['id' => 'date_of_birth']) !!}
            </div>
            <div class="col-md-2 form-group">
                {!! Form::label('gender', __('Gender')) !!}
                {!! Form::select('gender', ['Male' => 'Male', 'Female' => 'Female'], null, ['class' => 'form-control', 'placeholder' => __('Select')]) !!}
            </div>
            <div class="col-md-2 form-group">
                {!! Form::label('religion', __('Religion')) !!}
                {!! Form::select('religion', ['islam' => 'Islam', 'hindu' => 'Hindu', 'christian' => 'Christian', 'others' => 'Others'], null, ['class' => 'form-control', 'placeholder' => __('Select')]) !!}
            </div>
            <div class="col-md-2 form-group">
                {!! Form::label('blood_group', __('Blood Group')) !!}
                {!! Form::select('blood_group', ['A+' => 'A+', 'A-' => 'A-', 'B+' => 'B+', 'B-' => 'B-', 'O+' => 'O+', 'O-' => 'O-', 'AB+' => 'AB+', 'AB-' => 'AB-', 'Unknown' => 'Unknown'], null, ['class' => 'form-control', 'placeholder' => __('Select')]) !!}
            </div>
            <div class="col-md-6 form-group">
                {!! Form::label('father_name', __('Father Name')) !!}
                {!! Form::text('father_name', null, ['class' => 'form-control', 'placeholder' => __('Father Name')]) !!}
            </div>
            <div class="col-md-6 form-group">
                {!! Form::label('mother_name', __('Mother Name')) !!}
                {!! Form::text('mother_name', null, ['class' => 'form-control', 'placeholder' => __('Mother Name')]) !!}
            </div>
            <div class="col-md-6 form-group">
                {!! Form::label('photo', __('Photo')) !!}
                <div class="custom-file">
                    {!! Form::file('photo', ['class' => 'custom-file-input', 'accept' => 'image/jpeg,image/png']) !!}
                    {!! Form::label('photo', __('Choose image (max 200KB)'), ['class' => 'custom-file-label']) !!}
                </div>
                <small class="form-text text-muted">{{ __('Leave empty to keep the current photo.') }}</small>
            </div>
            <div class="col-md-3">
                @if ($applicant->photo)
                    <img src="{{ asset('storage/' . $applicant->photo) }}" alt="{{ $applicant->name }}" class="img-thumbnail" style="height:100px;width:100px;object-fit:cover;">
                @else
                    <div class="img-thumbnail d-flex align-items-center justify-content-center text-muted" style="height:100px;width:100px;"><i class="fas fa-user fa-2x"></i></div>
                @endif
            </div>
        </div>

        <hr>
        <h5 class="mb-3"><b>{{ __('Present Address') }}</b></h5>
        <div class="row">
            <div class="col-md-3 form-group">
                {!! Form::label('village', __('Village')) !!}
                {!! Form::text('village', null, ['class' => 'form-control', 'placeholder' => __('Village')]) !!}
            </div>
            <div class="col-md-3 form-group">
                {!! Form::label('post_office', __('Post Office')) !!}
                {!! Form::text('post_office', null, ['class' => 'form-control', 'placeholder' => __('Post Office')]) !!}
            </div>
            <div class="col-md-2 form-group">
                {!! Form::label('post_code', __('Post Code')) !!}
                {!! Form::text('post_code', null, ['class' => 'form-control', 'placeholder' => __('Post Code')]) !!}
            </div>
            <div class="col-md-2 form-group">
                {!! Form::label('district_id', __('District')) !!}
                {!! Form::select('district_id', $districts, null, ['class' => 'form-control', 'id' => 'district_id', 'placeholder' => __('Select')]) !!}
            </div>
            <div class="col-md-2 form-group">
                {!! Form::label('upazila_id', __('Upazila')) !!}
                {!! Form::select('upazila_id', $upazilas, null, ['class' => 'form-control', 'id' => 'upazila_id', 'placeholder' => __('Select')]) !!}
            </div>
        </div>

        <hr>
        <h5 class="mb-3"><b>{{ __('Permanent Address') }}</b></h5>
        <div class="row">
            <div class="col-md-3 form-group">
                {!! Form::label('permanent_village', __('Village')) !!}
                {!! Form::text('permanent_village', null, ['class' => 'form-control', 'placeholder' => __('Village')]) !!}
            </div>
            <div class="col-md-3 form-group">
                {!! Form::label('permanent_post_office', __('Post Office')) !!}
                {!! Form::text('permanent_post_office', null, ['class' => 'form-control', 'placeholder' => __('Post Office')]) !!}
            </div>
            <div class="col-md-2 form-group">
                {!! Form::label('permanent_post_code', __('Post Code')) !!}
                {!! Form::text('permanent_post_code', null, ['class' => 'form-control', 'placeholder' => __('Post Code')]) !!}
            </div>
            <div class="col-md-2 form-group">
                {!! Form::label('permanent_district_id', __('District')) !!}
                {!! Form::select('permanent_district_id', $districts, null, ['class' => 'form-control', 'id' => 'permanent_district_id', 'placeholder' => __('Select')]) !!}
            </div>
            <div class="col-md-2 form-group">
                {!! Form::label('permanent_upazila_id', __('Upazila')) !!}
                {!! Form::select('permanent_upazila_id', $permanentUpazilas, null, ['class' => 'form-control', 'id' => 'permanent_upazila_id', 'placeholder' => __('Select')]) !!}
            </div>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('Update') }}</button>
            <a href="{{ route('applicant.index') }}" class="btn btn-default">{{ __('Cancel') }}</a>
        </div>

        {!! Form::close() !!}
    </div>
</div>

<script>
    function loadUpazilas(districtSelectId, upazilaSelectId, selectedId) {
        var districtId = $('#' + districtSelectId).val();
        var $upazila = $('#' + upazilaSelectId);
        $upazila.html('<option value="">Select</option>');
        if (!districtId) {
            return;
        }
        $.getJSON('{{ url('childLocation') }}', { option: districtId }, function (data) {
            $.each(data, function (key, value) {
                $upazila.append($('<option>', { value: value.id, text: value.name, selected: String(value.id) === String(selectedId) }));
            });
        });
    }

    $(document).ready(function () {
        $('#district_id').on('change', function () {
            loadUpazilas('district_id', 'upazila_id', null);
        });
        $('#permanent_district_id').on('change', function () {
            loadUpazilas('permanent_district_id', 'permanent_upazila_id', null);
        });
        $('.custom-file-input').on('change', function () {
            $(this).next('.custom-file-label').html($(this).val().split('\\').pop());
        });
    });
</script>
@include('admin.layouts._datepicker')
@endsection
