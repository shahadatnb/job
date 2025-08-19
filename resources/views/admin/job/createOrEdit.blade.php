@extends('admin.layouts.layout')
@section('title',"Circular Add/Edit")
@section('css')
<link href="//cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<style type="text/css">
  .summary p{
    margin-bottom: 1px;
  }
</style>
@endsection
@section('content')
<!-- Default box -->
<div class="card card-outline card-info">
    <div class="card-header">
        <h3 class="card-title">{{__('Circular')}}</h3>
        <div class="card-tools">
          <a href="{{route('job.index')}}" class="btn btn-sm btn-info"><i class="fas fa-arrow-alt-circle-left"></i> Back</a>
        </div>
    </div>
    <div class="card-body">
      @include('admin.layouts._message')
      @if (request()->routeIs('job.edit'))
        {!! Form::model($job, array('route'=>['job.update',$job],'method'=>'PUT','files' => true)) !!}
      @else
        {!! Form::open(array('route'=>['job.store'],'files' => true)) !!}
      @endif
        <div class="row">
          <div class="col-9">
            <div class="form-group">
              {!! Form::label('title', __('Job Title'),['class'=>'']) !!}
              {!! Form::text('title',null,['class'=>'form-control','placeholder'=> __('Job Title')]) !!}
            </div>
            <div class="form-group">
              {!! Form::label('designation_id', __('Designation'),['class'=>'']) !!}
              {!! Form::select('designation_id',$designations,null,['class'=>'form-control select2','placeholder'=> __('Designation')]) !!}
            </div>
            <div class="form-group">
              {!! Form::label('requirements', __('Requirements'),['class'=>'']) !!}
              {!! Form::textarea('requirements',null,['class'=>'form-control textarea','placeholder'=> __('Requirements')]) !!}
            </div>
            <div class="form-group">
              {!! Form::label('responsibility', __('Responsibilities & Context'),['class'=>'']) !!}
              {!! Form::textarea('responsibility',null,['class'=>'form-control textarea','placeholder'=> __('Responsibility')]) !!}
            </div>
            <div class="form-group">
              {!! Form::label('compensation_other_benefits', __('Compensation & Other Benefits'),['class'=>'']) !!}
              {!! Form::textarea('compensation_other_benefits',null,['class'=>'form-control textarea','placeholder'=> __('Compensation & Other Benefits')]) !!}
            </div>
          </div>
          <div class="col-3">
            @if (request()->routeIs('designation.edit'))
            <div class="form-group">
              {!! Form::label('status', __('Status'),['class'=>'']) !!}
              {{ Form::checkbox('status',1,null) }}
            </div>
            @endif
            <div class="form-group">
              {!! Form::label('vacancy', __('Vacancy'),['class'=>'']) !!}
              {!! Form::text('vacancy',null,['class'=>'form-control','placeholder'=> __('Vacancy')]) !!}
            </div>
            <div class="form-group">
              {!! Form::label('job_nature', __('Job Nature'),['class'=>'']) !!}
              {!! Form::select('job_nature', ['Full Time'=>'Full Time','Part Time'=>'Part Time','Contractual'=>'Contractual'],null,['class'=>'form-control','placeholder'=> __('Job Nature')]) !!}
            </div>
            <div class="form-group">
              {!! Form::label('location', __('Job Location'),['class'=>'']) !!}
              {!! Form::text('location',null,['class'=>'form-control','placeholder'=> __('Job Location')]) !!}
            </div>
            <div class="form-group">
              {!! Form::label('last_date', __('Last Apply Date').' *',['class'=>'']) !!}
              {!! Form::text('last_date',null,['class'=>'form-control datetimepicker-input', 'data-toggle'=>"datetimepicker", 'data-target'=>"#last_date", 'placeholder'=> __('Last Date')]) !!}
            </div>
            <div class="form-group">
              {!! Form::label('age_min', __('Age Min').' *',['class'=>'']) !!}
              {!! Form::number('age_min',null,['class'=>'form-control','placeholder'=> __('Age Min')]) !!}
            </div>
            <div class="form-group">
              {!! Form::label('age_max', __('Age Max').' *',['class'=>'']) !!}
              {!! Form::number('age_max',null,['class'=>'form-control','placeholder'=> __('Age Max')]) !!}
            </div>
            <div class="form-group">
              {!! Form::label('minimum_experience', __('Minimum Experience').' *',['class'=>'']) !!}
              {!! Form::number('minimum_experience',null,['class'=>'form-control','placeholder'=> __('Minimum Experience')]) !!}
            </div>
            <div class="form-group">
              {!! Form::label('gender', __('Gender').' *',['class'=>'']) !!}
              {!! Form::select('gender', ['Any'=>'Any','Male'=>'Male','Female'=>'Female'],null,['class'=>'form-control','placeholder'=> __('Select Gender')]) !!}
            </div>
            <div class="form-group">
              {!! Form::label('edu_level_id', __('Edu Level').' *',['class'=>'']) !!}
              {!! Form::select('edu_level_id',$exams,null,['class'=>'form-control','placeholder'=> __('Edu Level')]) !!}
              {!! Form::label('edu_group_any', __('Any Education Group'),['class'=>'']) !!}
              {{ Form::checkbox('edu_group_any',1,null) }}
            </div>
            <div class="form-group">
              {!! Form::label('edu_group_ids', __('Education Group'),['class'=>'']) !!}
              {!! Form::select('edu_group_ids[]',$eduGroups,null,['class'=>'form-control select2','id'=>'edu_group_ids','multiple'=>true]) !!}
            </div>
            <div class="form-group">
              {!! Form::label('edu_level2_id', __('Or Edu Level'),['class'=>'']) !!}
              {!! Form::select('edu_level2_id',$exams,null,['class'=>'form-control','placeholder'=> __('Or Edu Level')]) !!}
              {!! Form::label('edu_group2_any', __('Any Education Group'),['class'=>'']) !!}
              {{ Form::checkbox('edu_group2_any',1,null) }}
            </div>
            <div class="form-group">
              {!! Form::label('edu_group2_ids', __('Or Education Group'),['class'=>'']) !!}
              {!! Form::select('edu_group2_ids[]',$eduGroups2,null,['class'=>'form-control select2','id'=>'edu_group2_ids','multiple'=>true]) !!}
            </div>
            <div class="form-group">
              {!! Form::label('salary', __('Salary'),['class'=>'']) !!}
              {!! Form::text('salary',null,['class'=>'form-control','placeholder'=> __('Salary')]) !!}
              {!! Form::label('nagotiable', __('Nagotiable'),['class'=>'']) !!}
              {{ Form::checkbox('nagotiable',1,null) }}
            </div>
            {{-- <div class="form-group">
              {!! Form::label('status', __('Publish Status'),['class'=>'']) !!}
              {{ Form::checkbox('status',1,null) }}
            </div> --}}
            <div class="form-group">
              @if (request()->routeIs('job.edit'))
                @if ($job->status == 1)
                  <span class="badge badge-success">Live</span>
                  <button type="submit" class="btn btn-warning" name="save" value="draft"><i class="fas fa-save"></i> Make Draft</button>
                @else
                  <span class="badge badge-info">Draft</span>
                @endif
              @endif
            </div>
            <div class="btn-group">
              <button type="button" class="btn btn-info" id="preview" {{ request()->routeIs('job.create') ? 'disabled' : '' }}><i class="fas fa-eye"></i> Preview</button>
              <button type="submit" class="btn btn-primary" name="save" value="save"><i class="fas fa-save"></i> Save</button>
              <button type="submit" class="btn btn-success" name="save" value="publish"><i class="fas fa-save"></i> Save & Publish</button>
            </div>
          </div>
        </div>
      </div>
      {!! Form::close() !!}
    <!-- /.card-body -->
    <!-- /.card-footer-->

@if (request()->routeIs('job.edit'))
    <div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="previewModalLabel">Preview</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="text-start ps-4">
                <h3 class="mb-1">{{$job->title}}</h3>
                <span class="text-truncate me-3"><i class="fa fa-map-marker-alt text-primary me-2"></i>{{$job->location}}</span>
                <span class="text-truncate me-3"><i class="far fa-clock text-primary me-2"></i>{{ $job->job_nature }}</span>
                <span class="text-truncate me-0"><i class="far fa-money-bill-alt text-primary me-2"></i>{{ $job->nagotiable == 1 ? 'Nagotiable' : $job->salary }}</span>
            </div>
            <div class="bg-light rounded p-3 mb-4 summary">
                <h4 class="mb-2">Job Summery</h4>
                {{-- <p><i class="fa fa-angle-right text-primary me-2"></i>Published On: 01 Jan, 2045</p> --}}
                <p><i class="fa fa-angle-right text-primary me-2"></i>Vacancy: {{ $job->vacancy==0 ? 'Not defined' : $job->vacancy }}</p>
                <p><i class="fa fa-angle-right text-primary me-2"></i>Age: {{ $job->age_min }} - {{ $job->age_max }} Years</p>
                <p><i class="fa fa-angle-right text-primary me-2"></i>Job Nature: {{ $job->job_nature }}</p>
                <p><i class="fa fa-angle-right text-primary me-2"></i>Gender: {{ $job->gender }}</p>
                <p><i class="fa fa-angle-right text-primary me-2"></i>Salary: {{ $job->nagotiable == 1 ? 'Nagotiable' : $job->salary }}</p>
                <p><i class="fa fa-angle-right text-primary me-2"></i>Location: {{ $job->location }}</p>
                <p class="m-0"><i class="fa fa-angle-right text-primary me-2"></i>Date Line: {{ date('d-m-Y', strtotime($job->last_date)) }}</p>
            </div>
            <h4 class="mb-3">Job Requirement</h4>
            {!! $job->requirements !!}
            <p><strong>Education:</strong> {{ $job->eduLevel? $job->eduLevel->name : 'Not defined' }}
                @php
                    if($job->edu_group_any !=1 && $job->edu_group_ids != ''){
                    echo ' in ';
                    if(count(json_decode($job->edu_group_ids)) > 1){
                        echo implode(', ', array_map(function($value) use ($eduGroups) {
                            return $eduGroups[$value];
                        }, json_decode($job->edu_group_ids)));
                    }else{
                        echo $eduGroups[json_decode($job->edu_group_ids)[0]];
                    }
                    /*
                        foreach (json_decode($job->edu_group_ids) as $value) {
                            echo $eduGroups[$value].', ';
                        }
                    */
                    }
                @endphp
                @if($job->edu_level2_id != '') 
                    Or {{ $job->eduLevel2? $job->eduLevel2->name : 'Not defined' }}
                    @php
                        if($job->edu_group2_any !=1 && $job->edu_group2_ids != ''){
                        echo ' in ';
                        if(count(json_decode($job->edu_group2_ids)) > 1){
                            echo implode(', ', array_map(function($value) use ($eduGroups2) {
                                return $eduGroups2[$value];
                            }, json_decode($job->edu_group2_ids)));
                        }else{
                            echo $eduGroups2[json_decode($job->edu_group2_ids)[0]];
                        }
                        /*
                            foreach (json_decode($job->edu_group2_ids) as $value) {
                                echo $eduGroups2[$value].', ';
                            }
                        */
                        }
                    @endphp
                @endif
            </p>
            <h4 class="mb-3">Responsibilities & Context</h4>
            {!! $job->responsibility !!}
            <h4 class="mb-3">Compensation & Other Benefits</h4>
            {!! $job->compensation_other_benefits !!}
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
@endif
</div>
<!-- /.card -->
@endsection
@section('js')
{{-- <script src="{{ asset('assets/admin/plugins/summernote/summernote-bs4.min.js') }}"> </script> --}}
<script src="//cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="{{ asset('assets/admin/plugins/moment/moment.min.js') }}"> </script>
<!-- Tempusdominus -->
<script src="{{ asset('assets/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"> </script>
    <script>
        $(document).ready(function(){
          $('.textarea').summernote();

          $('#last_date').datetimepicker({
              //format: 'DD/MM/YYYY'
              format: 'YYYY-MM-DD'
          });

          $('#edu_level_id').change(function() {
            var edu_level_id = $(this).val();
            $.ajax({
                url: "{{route('student.education.group')}}?edu_level_id=" + edu_level_id,
                method: 'GET',
                success: function(data) {
                    //console.log(data);
                    if(data.status == true){
                        $('#edu_group_ids').empty();
                        //$('#edu_group_id').append('<option value="">Any Group</option>');
                        $.each(data.groups, function(index, value) {
                            $('#edu_group_ids').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                }
            });
          });

          $('#edu_level2_id').change(function() {
            var edu_level_id = $(this).val();
            $.ajax({
                url: "{{route('student.education.group')}}?edu_level_id=" + edu_level_id,
                method: 'GET',
                success: function(data) {
                    //console.log(data);                    
                    if(data.status == true){
                        $('#edu_group2_ids').empty();
                        //$('#edu_group_id').append('<option value="">Any Group</option>');
                        $.each(data.groups, function(index, value) {
                            $('#edu_group2_ids').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                }
            });
          });

          $("#preview").on('click', function(){
            $("#previewModal").modal('show');
          });

        });
    </script>
@endsection