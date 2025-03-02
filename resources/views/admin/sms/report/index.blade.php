@extends('admin.layouts.layout')
@section('title',"Sms Report")
@section('content')
<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Sms Report</h3>
        <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
        <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Mobile</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Sent By</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $key=>$item)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $item->mobile }}</td>
                        <td>{{ $item->message }}</td>
                        <td>{{ $item->response }}</td>
                        <td>{{ CustomHelper::prettyDateTime($item->created_at) }}</td>
                        <td>{{ $item->user->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        {{ $logs->links() }}
    </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->
@endsection