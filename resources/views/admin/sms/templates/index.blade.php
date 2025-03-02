@extends('admin.layouts.layout')
@section('title',"SMS Templates")
@section('css')
<link rel="stylesheet" href="{{asset('/assets/admin')}}/plugins/datatables/datatables.min.css">
@endsection
@section('content')
<!-- Default box -->
<div class="card">
    <div class="card-header">
      <h3 class="card-title">Template List</h3>
        <div class="card-tools">
          <a href="{{ route('smsTemplate.create') }}"><i class="fas fa-plus"></i> Add</a>
        </div>
    </div>
    <div class="card-body">
      @include('admin.layouts._message')
        <table id="contacts" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Content</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($templates as $item)
                    <tr>
                      <td>{{ $item->id }}</td>
                      <td>{{ $item->title }}</td>
                      <td>{{ $item->content }}</td>
                      <td>
                        <div class="btn-group btn-group-sm">
                          <a class="btn btn-sm btn-primary" href="{{ route('smsTemplate.edit',$item->id) }}"><i class="fas fa-edit"></i> Edit</a>
                          <form class="delete" action="{{ route('smsTemplate.destroy',$item->id) }}" method="post">
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
        {{ $templates->links() }}
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