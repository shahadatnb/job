@extends('admin.layouts.layout')
@section('title',"Signature")
@section('css')
<link rel="stylesheet" href="{{asset('/assets/admin')}}/plugins/datatables/datatables.min.css">
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/jquery-ui/jquery-ui.min.css') }}">
<style>
    .sortable {
        list-style-type: none;
        margin-top: 10px;
        padding: 0;
    }
    .sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; }
    .sortable li span { position: absolute; margin-left: -1.3em; }
</style>
@endsection
@section('content')
<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Signature List</h3>
        <div class="card-tools">
          <a class="btn btn-primary" href="{{ route('signature.create')}}">New Item</a>
        </div>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-6">
          <div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped table-sm">
                <thead>
                <tr>
                  {{-- <th>ID</th> --}}
                  <th>Name</th>
                  <th>Description</th>
                  {{-- <th>Status</th> --}}
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($signatures as $item)
                    <tr>
                        {{-- <td>{{$item->id}}</td> --}}
                        <td>{{$item->name}}</td>
                        <td>{!! $item->description !!}</td>
                        {{-- <td>{{$item->status}}</td> --}}
                        <td>
                          <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Action
                            </button>
                            <div class="dropdown-menu">
                              {{-- @if (Auth::user()->hasAnyRole(['Manager','Admin'])) --}}
                              <div class="dropdown-divider"></div>
                                <a href="{{route('signature.edit',$item->id)}}" class="dropdown-item"><i class="fas fa-edit"></i> Edit</a>
                                <div class="dropdown-divider"></div>
                                <form class="delete" action="{{ route('signature.destroy',$item->id) }}" method="post">
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
        <div class="col-6">
          {!! Form::open(['route' => 'signature.add', 'method' => 'post','class' => 'row']) !!}
            <div class="col-5">
              <div class="form-group">
                {{ Form::label('job_id', 'Job Title') }}
                {{ Form::select('job_id', $jobs, null, ['class' => 'form-control select2', 'placeholder' => 'Job Title']) }}
              </div>
            </div>
            <div class="col-5">
              <div class="form-group">
                {{ Form::label('signature_id', 'Signature') }}
                {{ Form::select('signature_id', $signature_arr, null, ['class' => 'form-control select2', 'placeholder' => 'Signature']) }}
              </div>
            </div>
            <div class="col-2">
              <button type="submit" class="btn btn-primary">Add</button>
            </div>
          {!! Form::close() !!}

          <div class="mt-3">
            {{ Form::model($data, ['route' => 'signature.index', 'method' => 'get','class' => '']) }}
            <div class="input-group">
              {{ Form::select('sjob_id', $jobs, null, ['class' => 'form-control select2', 'placeholder' => 'Job Title']) }}
              <div class="input-group-append">
                <button type="submit" class="btn btn-primary">Filter</button>
              </div>
            </div>
            {{ Form::close() }}
            <ul id="sortable" class="sortable">
            @foreach ($jobSignature as $item)
              <li id="{{$item->id}}" class="ui-state-default">{{ $item->signature ? $item->signature->name : '' }}
                <div class="float-right">                               
                    <a onclick="return confirm('Are You Sure To Delete This Item?')" href="{{route('signature.delete',$item->id)}}" class="btn btn-xs btn-danger">Delete</a>
                </div>
              </li>
            @endforeach
            </ul>
          </div>
        </div>
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
<script src="{{asset('/assets/admin')}}/plugins/datatables/datatables.min.js"></script>
<script src="{{ asset('assets/admin/plugins/jquery-ui/jquery-ui.min.js') }}"> </script>
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

    $( function() {
        $( ".sortable" ).sortable({
            update: function(event, ui) {
            var productOrder = $(this).sortable('toArray').toString();
              //$("#sortable-9").text (productOrder);
            $.ajax({
                type:'POST',
                url:'{{ route('signature.serial') }}',
                
                data: {
                    _token: '{{ csrf_token() }}',
                  ids: productOrder,
              },
                success:function(data) {
                    //$("#msg").html(data.msg);
                    //console.log(data.msg);
                }
            });
              //console.log(productOrder);
            }
          });
        //$( "#sortable" ).disableSelection();

        
    } );
  </script>
@endsection
