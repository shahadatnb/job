@extends('frontend.layouts.master')
@section('content')
<!-- Jobs Start -->
<div class="container-xxl py-5">
    <div class="container">
        <marquee behavior="scroll" direction="left" scrollamount="4" style="font-size: 22px" class="text-danger mb-5">For any technical problems, please contact: 01332-533535</marquee>
        <h1 class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">Job Listing</h1>
        @foreach ($jobs as $job)
        <div class="job-item p-4 mb-4">
            <div class="row g-4">
                <div class="col-sm-12 col-md-8 d-flex align-items-center">
                    {{-- <img class="flex-shrink-0 img-fluid border rounded" src="{{asset('/assets/frontend')}}/img/com-logo-1.jpg" alt="" style="width: 80px; height: 80px;"> --}}
                    <div class="text-start ps-4">
                        <h5 class="mb-3"><a href="{{ route('job.job_detail', $job->id) }}">{{$job->title}}</a></h5>
                        <span class="text-truncate me-3"><i class="fa fa-map-marker-alt text-primary me-2"></i>{{ $job->location }}</span>
                        <span class="text-truncate me-3"><i class="far fa-clock text-primary me-2"></i>{{ $job->job_nature }}</span>
                        <span class="text-truncate me-0"><i class="far fa-money-bill-alt text-primary me-2"></i>{{ $job->nagotiable == 1 ? 'Nagotiable' : $job->salary }}</span>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                    <div class="d-flex mb-3">
                        <a class="btn btn-primary" href="{{ route('job.job_detail', $job->id) }}">Details</a>
                        {{-- <a class="btn btn-primary apply_now" data-job_id="{{ $job->id }}" data-post="{{ $job->title }}"  href="javascript:void(0)">Apply Now</a> --}}
                    </div>
                    <small class="text-truncate"><i class="far fa-calendar-alt text-primary me-2"></i>Date Line: {{ date('d-m-Y', strtotime($job->last_date)) }}</small>
                </div>
            </div>
        </div>
        @endforeach
        {{-- <div class="job-item p-4 mb-4">
            <div class="row g-4">
                <div class="col-sm-12 col-md-8 d-flex align-items-center">
                    <img class="flex-shrink-0 img-fluid border rounded" src="{{asset('/assets/frontend')}}/img/com-logo-5.jpg" alt="" style="width: 80px; height: 80px;">
                    <div class="text-start ps-4">
                        <h5 class="mb-3">Wordpress Developer</h5>
                        <span class="text-truncate me-3"><i class="fa fa-map-marker-alt text-primary me-2"></i>New York, USA</span>
                        <span class="text-truncate me-3"><i class="far fa-clock text-primary me-2"></i>Full Time</span>
                        <span class="text-truncate me-0"><i class="far fa-money-bill-alt text-primary me-2"></i>$123 - $456</span>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                    <div class="d-flex mb-3">
                        <a class="btn btn-light btn-square me-3" href=""><i class="far fa-heart text-primary"></i></a>
                        <a class="btn btn-primary" href="">Apply Now</a>
                    </div>
                    <small class="text-truncate"><i class="far fa-calendar-alt text-primary me-2"></i>Date Line: 01 Jan, 2045</small>
                </div>
            </div>
        </div> --}}
        <a class="btn btn-primary py-3 px-5" href="">Browse More Jobs</a>
    </div>
</div>
<!-- Jobs End -->



@endsection


@section('js')
<script>
    $(document).on('click', '.apply_now', function () {
        let check_login = "{{ auth('student')->check() ? '1' : '0' }}";
        if(check_login == 0){
            location.href = "{{ route('student.login') }}";
        }
        let job_id = $(this).data('job_id');
        let post = $(this).data('post');
        $('.post_name').text(post);
        $('#job_id').val(job_id);
        $('#applyModal').modal('show');
    });

    $("#applyForm").submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        let url = $(this).attr('action');
        $("#errorMsg").empty();
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            success: function (data) {
                if (data.status == true) {
                    $("#applyModal").modal('hide');
                    location.href = "{{route('student.applied_jobs')}}";
                }else {
                    //$("#errorMsg").html(data.error);
                    if(data.message){
                            $("#errorMsg").append(`<div class="alert alert-danger"><strong>Warning: </strong>${data.message}</div>`);
                        }
                    data.errors.forEach(function(element){
                        $("#errorMsg").append(`<div class="alert alert-danger"><strong>Warning: </strong>${element}</div>`);
                    });
                }
            }
        });
    })
</script>
@endsection
