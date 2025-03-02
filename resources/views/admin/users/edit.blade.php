@extends('admin.layouts.layout')

@section('content')

<h2>Edit User</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- <form method="POST" action="{{route('users.update',$user->id)}}" enctype="multipart/form-data">
    @method('PATCH')
    @csrf() --}}
    {!! Form::model($user,['route'=>['users.update',$user->id],'method'=>'PATCH']) !!}
    <div class="form-group">
        <label for="name">User name</label>
        <input type="text" name="name" class="form-control" id="name" placeholder="Name..." value="{{ $user->name }}" required>
    </div>
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" class="form-control" id="email" placeholder="Username..." value="{{ $user->username }}">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" class="form-control" id="email" placeholder="Email..." value="{{ $user->email }}">
    </div>
    <div class="form-group">
        <label for="mobile">Mobile</label>
        <input type="text" name="mobile" class="form-control" id="mobile" placeholder="mobile..." value="{{ $user->mobile }}">
    </div>
    <div class="form-group">
        <label for="Designation">Designation</label>
        <input type="text" name="Designation" class="form-control" id="Designation" placeholder="Designation..." value="{{ $user->Designation }}">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" class="form-control" id="password" placeholder="Password..." minlength="8">
    </div>
    <div class="form-group">
        <label for="password_confirmation">Password Confirm</label>
        <input type="password" name="password_confirmation" class="form-control" placeholder="Password..." id="password_confirmation">
    </div>
    
    <div class="form-group">
        <label for="role">Select Role</label>
        {{ Form::select('roles[]',$roles,null,['class'=>'select2-multi form-control','id'=>'role','multiple'=>'multiple']) }}
        {{-- <select class="role form-control select2" name="roles[]" id="role" multiple>
            <option value="">Select Role...</option>
            @foreach ($roles as $role)
                <option data-role-id="{{$role->id}}" data-role-slug="{{$role->slug}}" value="{{$role->id}}" {{ $user->roles->isEmpty() || $role->name != $userRole->name ? "" : "selected"}}>{{$role->name}}</option>                
            @endforeach
        </select>           --}}
    </div>

    <div id="permissions_box" >
        <label for="roles">Select Permissions</label>        
        <div id="permissions_ckeckbox_list">                    
        </div>
    </div>   

    @if($user->permissions->isNotEmpty())
        
        @if($rolePermissions != null)
        @foreach ($rolePermissions as $key=>$items)
            <div id="user_permissions_box" >
                <label for="roles">User Permissions ({{$key}})</label>
                <div id="user_permissions_ckeckbox_list">                    
                    @foreach ($items as $permission)
                    <div class="custom-control custom-checkbox">                         
                        <input class="custom-control-input" type="checkbox" name="permissions[]" id="{{$permission->slug}}" value="{{$permission->id}}" {{ in_array($permission->id, $userPermissions->pluck('id')->toArray() ) ? 'checked="checked"' : '' }}>
                        <label class="custom-control-label" for="{{$permission->slug}}">{{$permission->name}}</label>
                    </div>
                    @endforeach
                </div>
            </div>
        @endforeach
        @endif
    @endif


    <div class="form-group pt-2">
        <input class="btn btn-primary" type="submit" value="Submit">
    </div>
</form>

@section('js')

    <script>

        $(document).ready(function(){
            var permissions_box = $('#permissions_box');
            var permissions_ckeckbox_list = $('#permissions_ckeckbox_list');
            var user_permissions_box = $('#user_permissions_box');
            var user_permissions_ckeckbox_list = $('#user_permissions_ckeckbox_list');

            permissions_box.hide(); // hide all boxes


            $('##role').on('change', function() {
                //var role = $(this).find(':selected');
                //var role_id = role.data('role-id');
                var roles = $(this).val();
                //console.log(roles);
                //var role_slug = role.data('role-slug');

                permissions_ckeckbox_list.empty();
                user_permissions_box.empty();

                $.ajax({
                    url: "{{route('users.create')}}",// /users/create/
                    method: 'get',
                    dataType: 'json',
                    data: {
                        role_id: roles,
                        //role_slug: role_slug,
                    }
                }).done(function(data) {
                    
                    console.log(data);
                    
                    permissions_box.show();                        
                    // permissions_ckeckbox_list.empty();

                    $.each(data, function(index, element){
                        $(permissions_ckeckbox_list).append(       
                            '<div class="custom-control custom-checkbox">'+                         
                                '<input class="custom-control-input" type="checkbox" name="permissions[]" id="'+ element.slug +'" value="'+ element.id +'">' +
                                '<label class="custom-control-label" for="'+ element.slug +'">'+ element.name +'</label>'+
                            '</div>'
                        );

                    });
                });
            });
        });

    </script>

@endsection

@endsection
