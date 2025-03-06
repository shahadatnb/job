@extends('frontend.layouts.master')
@section('title','Dashboard')
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
                    <li class="list-group list-group-item"><a href="{{route('student.profile')}}">Profile</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-9 col-lg-9 mt-3">
        <div class="card">
            <div class="card-header">
                <h4>Profile</h4>
            </div>
            <div class="card-body">
                <nav>
                    <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-basic-tab" data-bs-toggle="tab" data-bs-target="#nav-basic" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Basic</button>
                        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Profile</button>
                        <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</button>
                    </div>
                </nav>
                <div class="tab-content p-3 border bg-light" id="nav-basic">
                    <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <table class="table table-sm">
                            <tr>
                                <th>Name</th>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th>Father Name</th>
                                <td>{{ $user->father_name }}</td>
                            </tr>
                            <tr>
                                <th>Mother Name</th>
                                <td>{{ $user->mother_name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{ $user->phone }}</td>
                            </tr>
                            <tr>
                                <th>NID</th>
                                <td>{{ $user->nid }}</td>
                            </tr>
                            <tr>
                                <th>Date of Birth</th>
                                <td>{{ date('d-m-Y', strtotime($user->date_of_birth)) }}</td>
                            </tr>
                            <tr>
                                <th>Gender</th>
                                <td>{{ $user->gender }}</td>
                            </tr>
                            <tr>
                                <th>Religion</th>
                                <td>{{ $user->religion }}</td>
                            </tr>
                            <tr>
                                <th>Blood Group</th>
                                <td>{{ $user->blood_group }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <p><strong>This is some placeholder content the Profile tab's associated content.</strong>
                            Clicking another tab will toggle the visibility of this one for the next.
                            The tab JavaScript swaps classes to control the content visibility and styling. You can use it with
                            tabs, pills, and any other <code>.nav</code>-powered navigation.</p>
                    </div>
                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                        <p><strong>This is some placeholder content the Contact tab's associated content.</strong>
                            Clicking another tab will toggle the visibility of this one for the next.
                            The tab JavaScript swaps classes to control the content visibility and styling. You can use it with
                            tabs, pills, and any other <code>.nav</code>-powered navigation.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection


@section('js')

@endsection
