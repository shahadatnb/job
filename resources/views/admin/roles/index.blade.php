@extends('admin.layouts.layout')
@section('title',"Role Edit")
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Role Edit</h3>
        <div class="card-tools">
            <a href="{{route('roles.create')}}" class="btn btn-primary btn-lg float-md-right" role="button" aria-pressed="true">Create New Role</a>
        </div>
    </div>
    <div class="card-body">
        @include('admin.layouts._message')
        <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm" id="dataTable" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th>Id</th>
                <th>Role</th>
                <th>Slug</th>
                <th>Permissions</th>
                <th>Tools</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Id</th>
                <th>Role</th>
                <th>Slug</th>
                <th>Permissions</th>
                <th>Tools</th>
            </tr>
            </tfoot>
            <tbody>
                @foreach ($roles as $role)
                    <tr>
                        <td>{{ $role['id'] }}</td>
                        <td>{{ $role['name'] }}</td>
                        <td>{{ $role['slug'] }}</td>
                        <td>
                            @if ($role->permissions != null)
                                    
                                @foreach ($role->permissions as $permission)
                                <span class="badge badge-secondary">
                                    {{ $permission->name }}                                    
                                </span>
                                @endforeach
                            
                            @endif
                        </td>
                        <td>
                            <a href="{{route('roles.show',$role['id'])}}"><i class="fa fa-eye"></i></a>
                            <a href="{{route('roles.edit',$role['id'])}}"><i class="fa fa-edit"></i></a>
                            <a href="#" data-toggle="modal" data-target="#deleteModal" data-roleid="{{$role['id']}}"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>

<!-- delete Modal-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Are you shure you want to delete this?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        </div>
        <div class="modal-body">Select "delete" If you realy want to delete this role.</div>
        <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <form method="POST" action="">
            @method('DELETE')
            @csrf
            {{-- <input type="hidden" id="role_id" name="role_id" value=""> --}}
            <a class="btn btn-primary" onclick="$(this).closest('form').submit();">Delete</a>
        </form>
        </div>
    </div>
    </div>
</div>
@endsection
@section('js_role_page')

<script>
    $('#deleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) 
        var role_id = button.data('roleid') 
        
        var modal = $(this)
        // modal.find('.modal-footer #role_id').val(role_id)
        modal.find('form').attr('action','{{url('/')}}/roles/' + role_id);
    })
</script>

@endsection

