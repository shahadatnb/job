@extends('admin.layouts.layout')
@section('title',"Menus")
@section('content')
<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Menus</h3>
        <div class="card-tools">
            <a href="{{route('siteCache')}}" class="btn btn-primary btn-sm"> <i class="fas fa-sync"></i> Applay</a>
        </div>
    </div>
    <div class="card-body">
        @include('admin.layouts._message')
        @role('superadmin')
        {!! Form::open(['route'=>'menus.store','method'=>'POST','class'=>'form']) !!}
        
        <div class="row">
            <div class="col-sm-5">
                <!-- text input -->
                <div class="form-group">
                    {!! Form::label('Title', __('Title')) !!}
                    {!! Form::text('Title',null,['class'=>'form-control','placeholder'=> __('Title')]) !!}
                </div>
            </div>
            <div class="col-sm-5">
                <div class="form-group">
                    {!! Form::label('menu_id', __('Menu ID')) !!}
                    {!! Form::text('menu_id',null,['class'=>'form-control','placeholder'=> __('Menu ID')]) !!}
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    {{ Form::submit('Save', ['class'=>'btn btn-success']) }}
                </div>
            </div>
        </div> 
        
        {!! Form::close() !!}
        @endrole

        <table class="table">
            <tr>
                <th>Menu ID</th>
                <th>Title</th>
                <th>Action</th>
            </tr>
            @foreach ($menus as $item)
                <tr>
                <td>{{$item->menu_id}}</td>
                <td>{{$item->Title}}</td>
                <td>
                    <div class="btn-group">
                    <a href="{{route('menus.show',$item->id)}}" class="btn btn-sm btn-success">Edit</a>
                    @role('superadmin')
                    <form action="{{route('menus.destroy',$item->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                    @endrole
                    </div>
                </td>
                </tr>
            @endforeach
        </table>
        
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        Footer
    </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->
@endsection