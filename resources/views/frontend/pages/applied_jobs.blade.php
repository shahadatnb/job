@extends('frontend.layouts.master')
@section('title','Applied Jobs')
@section('css')

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
                <h4>Applied Jobs</h4>
            </div>
            <div class="card-body">
                @include('admin.layouts._message')
                <table id="example1" class="table table-sm table-bordered table-striped">
					<thead>
					<tr>
					  <th>ID</th>
					  <th>Designation</th>
					  <th>Expected Salary</th>
					  {{-- <th>Status</th> --}}
					  <th>Applied Date</th>
					</tr>
					</thead>
					<tbody>
						@foreach ($applied_jobs as $item)
						<tr>
							<td>{{$item->id}}</td>
							<td>{{$item->job->title }}</td>
							<td>{{$item->expected_salary}}</td>
							{{-- <td>{{$item->status}}</td> --}}
							<td>{{prettyDate($item->created_at)}}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
            </div>
        </div>
    </div>
</div>

@endsection


@section('js')
@endsection
