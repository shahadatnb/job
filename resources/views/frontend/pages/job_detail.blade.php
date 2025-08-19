@extends('frontend.layouts.master')
@section('content')
<!-- Job Detail Start -->
<div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <div class="row gy-5 gx-4">
            <div class="col-lg-8">
                <div class="d-flex align-items-center mb-5">
                    {{-- <img class="flex-shrink-0 img-fluid border rounded" src="img/com-logo-2.jpg" alt="" style="width: 80px; height: 80px;"> --}}
                    <div class="text-start ps-4">
                        @include('admin.layouts._message')
                        <h3 class="mb-3">{{$job->title}}</h3>
                        <span class="text-truncate me-3"><i class="fa fa-map-marker-alt text-primary me-2"></i>{{$job->location}}</span>
                        <span class="text-truncate me-3"><i class="far fa-clock text-primary me-2"></i>{{ $job->job_nature }}</span>
                        <span class="text-truncate me-0"><i class="far fa-money-bill-alt text-primary me-2"></i>{{ $job->nagotiable == 1 ? 'Nagotiable' : $job->salary }}</span>
                    </div>
                </div>

                <div class="bg-light rounded p-5 mb-4 wow slideInUp" data-wow-delay="0.1s">
                    <h4 class="mb-4">Job Summery</h4>
                    {{-- <p><i class="fa fa-angle-right text-primary me-2"></i>Published On: 01 Jan, 2045</p> --}}
                    <p><i class="fa fa-angle-right text-primary me-2"></i>Vacancy: {{ $job->vacancy==0 ? 'Not defined' : $job->vacancy }}</p>
                    <p><i class="fa fa-angle-right text-primary me-2"></i>Age: {{ $job->age_min }} - {{ $job->age_max }} Years</p>
                    <p><i class="fa fa-angle-right text-primary me-2"></i>Job Nature: {{ $job->job_nature }}</p>
                    <p><i class="fa fa-angle-right text-primary me-2"></i>Gender: {{ $job->gender }}</p>
                    <p><i class="fa fa-angle-right text-primary me-2"></i>Salary: {{ $job->nagotiable == 1 ? 'Nagotiable' : $job->salary }}</p>
                    <p><i class="fa fa-angle-right text-primary me-2"></i>Location: {{ $job->location }}</p>
                    <p class="m-0"><i class="fa fa-angle-right text-primary me-2"></i>Date Line: {{ date('d-m-Y', strtotime($job->last_date)) }}</p>
                </div>

                <div class="mb-5">
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

                <div class="">
                    {{-- <h4 class="mb-4">Apply For The Job</h4>
                    <a class="btn btn-primary apply_now" data-job_id="{{ $job->id }}" data-post="{{ $job->title }}"  href="javascript:void(0)">Apply Now</a>
                    <form>
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <input type="text" class="form-control" placeholder="Your Name">
                            </div>
                            <div class="col-12 col-sm-6">
                                <input type="email" class="form-control" placeholder="Your Email">
                            </div>
                            <div class="col-12 col-sm-6">
                                <input type="text" class="form-control" placeholder="Portfolio Website">
                            </div>
                            <div class="col-12 col-sm-6">
                                <input type="file" class="form-control bg-white">
                            </div>
                            <div class="col-12">
                                <textarea class="form-control" rows="5" placeholder="Coverletter"></textarea>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100" type="submit">Apply Now</button>
                            </div>
                        </div>
                    </form>
                </div> --}}
            </div>

            <div class="col-lg-4">                
                <div class="bg-light rounded p-5 mb-4 wow slideInUp" data-wow-delay="0.1s">
                    <a class="btn btn-primary apply_now" data-job_id="{{ $job->id }}" data-post="{{ $job->title }}"  href="javascript:void(0)">Apply Now</a>
                </div>
                <div class="bg-light rounded p-5 wow slideInUp" data-wow-delay="0.1s">
                    <h4 class="mb-4">Job List</h4>
                    @foreach ($jobs as $job)
                    <p> <a href="{{ route('job.job_detail', $job->id) }}">{{ $job->title }}</a> </p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Job Detail End -->


<div class="modal fade" id="applyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <form action="{{ route('job.apply') }}" id="applyForm" method="POST">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Apply Now</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                    @csrf
                    <input type="hidden" name="job_id" id="job_id">
                    <p class="text-center post_name"></p>
                    <div id="errorMsg"></div>
                    <div class="form-group">
                        <label for="name">Expected Salary</label>
                        <input type="text" class="form-control" name="expected_salary" id="expected_salary" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" id="applyBtn" class="btn btn-primary">Apply Now</button>
            </div>
        </form>
        </div>
    </div>
</div>

@endsection


@section('js')
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
<script>
    $(document).on('click', '.apply_now', function () {
        $.LoadingOverlay("show");
        let check_login = "{{ auth('student')->check() ? '1' : '0' }}";
        if(check_login == 0){
            $.ajax({
                url: "{{ route('job.set_session') }}",
                type: "GET",
                data: {'job_id': $(this).data('job_id'), 'job_title': $(this).data('post')},
                success: function (data) {
                    //console.log(data);
                    location.href = "{{ route('student.register', ['redirect' => url()->current()]) }}";
                }
            })
        }else{
            let job_id = $(this).data('job_id');
            let post = $(this).data('post');
            $('.post_name').text(post);
            $('#job_id').val(job_id);
            $('#applyModal').modal('show');
        }
        $.LoadingOverlay("hide");
    });

    $("#applyForm").submit(function(e) {
        e.preventDefault();
        $.LoadingOverlay("show");
        var formData = $(this).serialize();
        let url = $(this).attr('action');
        $("#errorMsg").empty();
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            success: function (data) {
                //console.log(data);
                if (data.status == true) {
                    $("#applyModal").modal('hide');
                    location.href = "{{route('student.applied_jobs')}}";
                }else {
                    //$("#errorMsg").html(data.error);
                    if(data.message){
                        $("#errorMsg").append(`<div class="alert alert-danger"><strong>Warning: </strong>${data.message}</div>`);
                    }
                    if(data.errors){
                        data.errors.forEach(function(element){
                            $("#errorMsg").append(`<div class="alert alert-danger"><strong>Warning: </strong>${element}</div>`);
                        });
                    }                    
                }
            }
        });
        $.LoadingOverlay("hide");
    })
</script>
@endsection
