@extends('admin.layouts.layout')
@section('title',"Branch List")
@section('css')
@endsection
@section('content')
<!-- Default box -->
<div class="card">
    <div class="card-header">
      <h3 class="card-title">Branch List</h3>
        <div class="card-tools">
          <a href="{{ route('branch.create') }}"><i class="fas fa-plus"></i> Add</a>
        </div>
    </div>
    <div class="card-body">
      @include('admin.layouts._message')
        <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Address</th>
              <th>Phone</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($branches as $item)
                    <tr>
                      <td>{{ $item->id }}</td>
                      <td>{{ $item->name }}</td>
                      <td>{{ $item->address }}</td>
                      <td>{{ $item->contact }}</td>
                      <td>{{ $item->status == 1 ? 'Active' : 'Inactive' }}</td>
                      <td>
                        <div class="btn-group btn-group-sm">
                          <a class="btn btn-sm btn-primary" href="{{ route('branch.edit',$item->id) }}"><i class="fas fa-edit"></i> Edit</a>
                        </div>
                      </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        
    </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->

@endsection

@section('js')

@endsection