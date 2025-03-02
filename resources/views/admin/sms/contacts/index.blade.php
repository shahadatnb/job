@extends('admin.layouts.layout')
@section('title',"Contacts")
@section('css')
<link rel="stylesheet" href="{{asset('/assets/admin')}}/plugins/datatables/datatables.min.css">
@endsection
@section('content')
<!-- Default box -->
<div class="card">
    <div class="card-header">
      <h3 class="card-title">Contact List</h3>
        <div class="card-tools">
          <a href="{{ route('contact.create') }}"><i class="fas fa-plus"></i> Add</a>
        </div>
    </div>
    <div class="card-body">
      @include('admin.layouts._message')
      {{ Form::open(array('route'=>'contact.import','method'=>'POST','files' => true)) }}
      <div class="form-group">
        <div class="input-group">
          <div class="custom-file">
            {!! Form::file('file',['class'=>'form-control','required'=>true]) !!}
          </div>
          <div class="input-group-append">
            <button type="submit" class="btn btn-primary"><i class="fas fa-upload"></i> Import</button>
          </div>
          <div class="input-group-append">
            <a href="{{ asset('/assets/files/contacts.xlsx')}}" class="btn btn-info"><i class="fas fa-download"></i>Template</a>
          </div>
        </div>
      </div>
      {{ Form::close() }}
        <table id="contacts" class="table table-bordered table-striped table-sm">
            <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Phone</th>
              <th>Category</th>
              <th>Note</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($contacts as $item)
                    <tr>
                      <td>{{ $item->id }}</td>
                      <td>{{ $item->name }}</td>
                      <td>{{ $item->mobile }}</td>
                      <td>{{ $item->category? $item->category->name : '' }}</td>
                      <td>{{ $item->note }}</td>
                      {{-- <td>{{ $item->status == 1 ? 'Active' : 'Inactive' }}</td> --}}
                      <td>
                        <div class="btn-group btn-group-sm">
                          <a class="btn btn-sm btn-primary" href="{{ route('contact.edit',$item->id) }}"><i class="fas fa-edit"></i> Edit</a>
                          <form class="delete" action="{{ route('contact.destroy',$item->id) }}" method="post">
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
    <!-- /.card-body -->
    <div class="card-footer">
        {{ $contacts->links() }}
    </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->

@endsection
@section('js')
<script src="{{asset('/assets/admin')}}/plugins/datatables/datatables.min.js"></script>
<script>
(function($) {
    $(function () {
      $("#contacts").DataTable({
        "responsive": true,
        "autoWidth": false,
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
})(jQuery);
  </script>
@endsection