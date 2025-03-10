@extends('admin.layouts.layout')
@section('title',__("Student"))
@section('content')
<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{__('Student')}}</h3>
        <div class="card-tools">
        <a href="{{route('student.edit',$student->id)}}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
        <a target="_blank" href="{{route('admissionForm',$student->id)}}" class="btn btn-sm btn-danger">
            <i class="far fa-file-pdf"></i> Download
        </a>
    </div>
    <div class="card-body">
        <div class="justify-content-center text-center">
            <img width="80" class="attachment-img" src="{{asset('/upload/site_file/'.config('settings.siteLogo',''))}}" alt="{{ config('settings.siteTitle','') }}">
            <div class=" position-relative">
                <h2 class="text-center m-0">{{ config('settings.siteTitle','') }}</h2>
                <p class="text-center m-0">{{ config('settings.tagLine') }}</p>
                <p class="text-center m-0">({{ config('settings.siteWeb') }})</p>
                
                <div class="student_photo position-absolute" style="top:0; right:0">
                    <img width="150" class="img-thumbnail" src="{{asset('/storage/'.$student->photo)}}" alt="">
                </div>
            </div>
            
        </div>
        <table class="table">
            <tr>
                <td>{{__('Name Of Student')}}</td>
                <td colspan="3">{{$student->name}}</td>
            </tr>
            <tr>
                <td>{{__('Reg No')}}</td>
                <td colspan="3">{{$student->reg_no}}</td>
            </tr>
            <tr>
                <td>{{__('class_roll No')}}</td>
                <td colspan="3">{{$student->class_roll}}</td>
            </tr>
            <tr>
                <td>{{__('Session')}}</td>
                <td colspan="3">{{$student->session}}</td>
            </tr>
            <tr>
                <td>{{__('Department')}}</td>
                <td colspan="3">@if($student->department){{$student->department->title}}@endif</td>
            </tr>
            <tr>
                <td>{{__('Probidhan')}}</td>
                <td colspan="3">{{$student->probidhan}}</td>
            </tr>
            <tr>
                <td>{{__('Father`s Name')}}</td>
                <td colspan="3">{{$student->fathersName}}</td>
            </tr>
            <tr>
                <td>{{__('Address')}}</td>
                <td colspan="3">{{$student->address}}</td>
            </tr>
            <tr>
                <td>{{__('Mother`s Name')}}</td>
                <td colspan="3">{{$student->mothersName}}</td>
            </tr>
            <tr>
                <td>{{__('Shift')}}</td>
                <td colspan="3">{{$student->shift}}</td>
            </tr>
            <tr>
                <td>{{__('Group')}}</td>
                <td colspan="3">{{$student->student_group}}</td>
            </tr>
            <tr>
                <td>{{__('Sex')}}</td>
                <td colspan="3">{{$student->sex}}</td>
            </tr>
            <tr>
                <td>{{__('Student Mobile')}}</td>
                <td colspan="3">{{$student->student_mobile}}</td>
            </tr>
            <tr>
                <td>{{__('Gardian Mobile')}}</td>
                <td colspan="3">{{$student->mobileFather}}</td>
            </tr>
        </table>
        
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        
    </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->
@endsection