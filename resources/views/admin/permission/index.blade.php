@extends('admin.layouts.layout')
@section('title',"Permissions")
<link href="//cdn.datatables.net/v/bs4/dt-1.13.6/datatables.min.css" rel="stylesheet">
@section('content')
<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Permissions</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#newModal" title="Leave">New</button>
        </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table id="permissions" class="table table-bordered table-striped table-sm">
            <thead>
            <tr>
              <th>Name</th>
              <th>Slug</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($permissions as $item)                    
                <tr>
                    <td>{{$item->name}}</td>
                    <td>{{$item->slug}}</td>
                    <td>
                      <div class="btn-group">
                        <a href="{{route('permissions.edit',$item->id)}}" class="btn btn-success btn-sm"><i class="fas fa-edit"></i> Edit</a>
                        <form class="delete" action="{{ route('permissions.destroy',$item->id) }}" method="post">
                          {{ csrf_field() }}
                          {{ method_field('DELETE') }}
                          <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are You Sure To Delete This Item?')"><i class="fas fa-trash"></i> Delete</button>
                        </form>
                      </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
      </div>
    </div>
</div>
<!-- /.card -->

<!-- Modal -->
<div class="modal fade" id="newModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    {!! Form::open(array('route'=>['permissions.store'])) !!}
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New Entry</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                {!! Form::label('name', __('Name'),['class'=>'']) !!}
                {!! Form::text('name',null,['class'=>'form-control','placeholder'=> __('Name')]) !!}
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </div>
    </div>
    {!! Form::close() !!}
  </div>
@endsection
@section('js')
<script src="//cdn.datatables.net/v/bs4/dt-1.13.6/datatables.min.js"></script>
<script>
  (function ($) {

    $(document).ready( function () {
      $('#permissions').DataTable();
    } );

    })(jQuery)
  </script>
@endsection