@extends('admin.layouts.layout')
@section('page_title',"Send Balance")
@section('content')
<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Send Balance to Agent</h3>
        <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
        <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
        </div>
    </div>
    <div class="card-body">
        @include('admin.layouts._message')
        {!! Form::open(['route'=>'sendBalance','method'=>'POST']) !!}
        <div class="row">
            <div class="col-md-4">
            {{ Form::label('agent_id','Agent Id') }}
            {{ Form::select('agent_id',$agents,null,['class'=>'form-control select2','required'=>'','placeholder'=>'Select Agent']) }} 
        </div>
        <div class="col-md-2">
            {{ Form::label('amount','Amount') }}
            {{ Form::number('amount',null,['class'=>'form-control','required'=>'']) }}
        </div>
        <div class="col-md-4">
            {{ Form::label('remark','Remark') }}
            {{ Form::text('remark',null,['class'=>'form-control']) }}
        </div>
        <div class="col-md-2">
            {{ Form::label('submit','&nbsp;') }}
            {{ Form::submit('Send',array('class'=>'form-control btn btn-success')) }}</div>
        </div>
        {!! Form::close() !!}
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <p>Recent Transactions</p>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Sent to</th>
                    <th>Amount</th>
                    <th>Remark</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tran as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->agent_id }} - {{ $item->agentInfo->name }}</td>
                        <td>{{ $item->amount }}</td>
                        <td>{{ $item->remark }}</td>
                        <td>{{ prettyDate($item->created_at) }}</td>
                    </tr>                    
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->
@endsection