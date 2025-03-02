@extends('admin.layouts.layout')
@section('title',"Role Edit")
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Role Edit</h3>
        <div class="card-tools">
            <a href="{{route('roles.index')}}" class="btn btn-primary btn-sm float-md-right"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
    </div>
    <div class="card-body">
        @include('admin.layouts._message')

        <form method="POST" action="{{route('roles.store')}}">
            {{ csrf_field() }}
            
            <div class="form-group">
                <label for="role_name">Role name</label>
                <input type="text" name="role_name" class="form-control" id="role_name" placeholder="Role name..." value="{{ old('role_name') }}" required>
            </div>
            <div class="form-group">
                <label for="role_slug">Role Slug</label>
                <input type="text" name="role_slug" tag="role_slug" class="form-control" id="role_slug" placeholder="Role Slug..." value="{{ old('role_slug') }}" required>
            </div>
            {{-- <div class="form-group" >
                <label for="roles_permissions">Add Permissions</label>
                <input type="text" data-role="tagsinput" name="roles_permissions" class="form-control" id="roles_permissions" value="{{ old('roles_permissions') }}">   
            </div>      --}}
            <div class="form-group">
                {!! Form::label('permissions[]', 'Permissions') !!}
                {!! Form::select('permissions[]', $permissions, null, ['class'=>'select2-multi form-control','id'=>'role','multiple'=>'multiple']) !!}
            </div>
            <div class="form-group pt-2">
                <input class="btn btn-primary" type="submit" value="Submit">
            </div>
        </form>
    </div>
<!-- /.card-body -->
</div>
@endsection
@section('css')
    <link rel="stylesheet" href="{{url('/public')}}/assets/admin/css/bootstrap-tagsinput.css">
@endsection

@section('js')
    <script src="{{url('/public')}}/assets/admin/js/bootstrap-tagsinput.js"></script>

    <script>

        $(document).ready(function(){
            $('#role_name').keyup(function(e){
                var str = $('#role_name').val();
                str = str.replace(/\W+(?!$)/g, '-').toLowerCase();//rplace stapces with dash
                $('#role_slug').val(str);
                $('#role_slug').attr('placeholder', str);
            });
        });
        
    </script>

@endsection
