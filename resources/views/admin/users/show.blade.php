@extends('admin.layouts.layout')
@section('title',"Users")
@section('content')      
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">User asign store, permission</h3>
            <div class="card-tools">
                <a href="{{route('users.index')}}" class="btn btn-primary btn-sm float-md-right" role="button" aria-pressed="true"><i class="fas fa-arrow-left"></i> Back</a>
            </div>
        </div>
        <div class="card-body">
            <h3>Name: {{$user->name}}</h3>  
            <h4>Email: {{$user->email}}</h4>
            @if ($user->banned_till == '')
                {!! Form::open(['route' => 'user-ban','class'=>'form-horizontal']) !!}  
                <div class="input-group">
                  {!! Form::select('days',['0'=>'Permanently Ban', '7'=>'Next 7 Days', '15'=>'Next 15 Days', '30'=>'Next 30 Days'],null,['class'=>'form-control', 'placeholder'=>'Ban Type']) !!}
                  <span class="input-group-btn">
                    <button type="submit" class="btn btn-info btn-flat">Save</button>
                  </span>
                </div>            
                <input type="hidden" name="user_id" value="{{ $user->id }}">
              {!! Form::close() !!}
            @else
                <a href="{{route('user-unban',$user->id)}}" class="btn btn-success">Unban</a>
            @endif
            
        </div>
        <div class="card-body">
            <h5 class="card-title">Role</h5>
            <p class="card-text">
                @if ($user->roles->isNotEmpty())
                    @foreach ($user->roles as $role)
                        <span class="badge badge-primary">
                            {{ $role->name }}
                        </span>
                    @endforeach
                @endif
            </p>
            <h5 class="card-title">Permissions</h5>
            <p class="card-text">
                @if ($user->permissions->isNotEmpty())                                        
                    @foreach ($user->permissions as $permission)
                        <span class="badge badge-success">
                            {{ $permission->name }}                                    
                        </span>
                    @endforeach            
                @endif
            </p>
            {!! Form::model($user,['route'=>['user.assignPermission',$user->id],'method'=>'post','class'=>'input-group input-group-sm']) !!}
            <div class="input-group">    
                {{ Form::select('permissions[]',$permissions,null,['class'=>'form-control select2','multiple'=>'multiple']) }}
                <span class="input-group-btn">
                <button type="submit" class="btn btn-info">Assign Permission</button>
                </span>
            </div>
            {!! Form::close() !!}
        </div>
        <div class="card-body">
            <h5 class="card-title">Assign Branch</h5>
            {!! Form::model($user,['route'=>['user.assignBranch',$user->id],'method'=>'post','class'=>'input-group input-group-sm']) !!}
            <div class="input-group">    
                {{ Form::select('branches[]',$branches,null,['class'=>'form-control select2','multiple'=>'multiple']) }}
                <span class="input-group-btn">
                <button type="submit" class="btn btn-info">Assign</button>
                </span>
            </div>
            {!! Form::close() !!}
        </div>
    </div>    
@endsection