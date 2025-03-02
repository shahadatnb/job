@extends('admin.layouts.layout')
@section('title',"Services")
@section('css')
<link rel="stylesheet" href="{{asset('assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection
@section('content')
<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Services</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#newModal" title="Leave">New</button>
        </div>
    </div>
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>ID</th>
              <th>Code</th>
              <th>English</th>
              <th>Bangla</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($languages as $item)                    
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->code}}</td>
                    <td>{{$item->en}}</td>
                    <td>{{$item->bn}}</td>
                    <td>
                      <a href="{{ route('language.edit',$item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
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
  {!! Form::open(array('route'=>['language.store'])) !!}
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
              {!! Form::label('code', __('Code'),['class'=>'']) !!}
              {!! Form::text('code',null,['class'=>'form-control','autocomplete'=>'off','placeholder'=> __('Code')]) !!}
          </div>
          <div class="form-group">
              {!! Form::label('en', __('English'),['class'=>'']) !!}
              {!! Form::text('en',null,['class'=>'form-control','autocomplete'=>'off','placeholder'=> __('English')]) !!}
          </div>
          <div class="form-group">
              {!! Form::label('bn', __('Bangla'),['class'=>'']) !!}
              {!! Form::text('bn',null,['class'=>'form-control','autocomplete'=>'off','placeholder'=> __('Bangla')]) !!}
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
<script src="{{asset('assets/admin/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script>
    $(function () {
      $("#example1").DataTable({
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
  </script>
@endsection