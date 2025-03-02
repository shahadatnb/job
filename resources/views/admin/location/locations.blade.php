@extends('admin.layouts.layout')
@section('title',"Locations")
@section('css')
<link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
@endsection
@section('content')
<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Locations</h3>
        <div class="card-tools">
            {{-- <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#newModal" title="Leave">New</button> --}}
            <a href="{{ route('location.create') }}" class="btn btn-sm btn-primary">New</a>
        </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Bangla</th>
              <th>Parant</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($locations as $item)                    
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->name_bn}}</td>
                    <td>{{$item->locationParant? $item->locationParant->name : ''}}</td>
                    <td>
                      <div class="btn-group btn-group-sm">
                      <a href="{{route('location.edit',$item->id)}}" class="btn btn-success btn-sm"><i class="fas fa-edit"></i> Edit</a>
                      <form class="delete" action="{{ route('location.destroy',$item) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are You Sure To Delete This Item?')"><i class="fas fa-trash"></i></button>
                      </form>
                      </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
      </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        Footer
    </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->

<!-- Modal -->
<div class="modal fade" id="newModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    {!! Form::open(array('route'=>['location.store'])) !!}
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
                {!! Form::label('name', __('Location Name'),['class'=>'']) !!}
                {!! Form::text('name',null,['class'=>'form-control','placeholder'=> __('Location Name')]) !!}
            </div>
            <div class="form-group">
              {!! Form::label('parent_id', __('Parant Location'),['class'=>'']) !!}
              {!! Form::select('parent_id',$plocations,null,['class'=>'form-control select2','placeholder'=> __('Parant Location')]) !!}
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
<script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
<script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true,
        "autoWidth": false,
      });
    });
  </script>
@endsection
