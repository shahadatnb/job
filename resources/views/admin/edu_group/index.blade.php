@extends('admin.layouts.layout')
@section('title',"Edu Group")
@section('css')
<link rel="stylesheet" href="{{asset('/assets/admin')}}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
@endsection
@section('content')
<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Education Group List</h3>        
        <div class="card-tools">
          <a class="btn btn-primary" href="{{ route('eduGroup.create')}}">New Item</a>
        </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table id="example1" class="table table-sm table-bordered table-striped">
            <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Level</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($eduGroups as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->edu_level? $item->edu_level->name : ''}}</td>
                    <td>{{$item->is_active?'Active':'Inactive'}}</td>
                    <td>
                      <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Action
                        </button>
                        <div class="dropdown-menu">
                          {{-- @if (Auth::user()->hasAnyRole(['Manager','Admin'])) --}}
                          <div class="dropdown-divider"></div>
                            <a href="{{route('eduGroup.edit',$item->id)}}" class="dropdown-item"><i class="fas fa-edit"></i> Edit</a>
                            <div class="dropdown-divider"></div>
                            <form class="delete" action="{{ route('eduGroup.destroy',$item->id) }}" method="post">
                              {{ csrf_field() }}
                              {{ method_field('DELETE') }}
                              <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Are You Sure To Delete This Item?')"><i class="fas fa-trash"></i> Delete</button>
                            </form>
                            {{-- <a onclick="return confirm('Are you sure remove?');" href="{{route('insuranceRemove',$item->id)}}" class="dropdown-item"><i class="fas fa-trash text-danger"></i> Remove</a> --}}
                          {{-- @endif --}}
                        </div>
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
    </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->
@endsection
@section('js')
<script src="{{asset('/assets/admin')}}/plugins/datatables/jquery.dataTables.min.js"></script>
<script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true,
        "autoWidth": false,
        "paging": false,
      });
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>
@endsection
