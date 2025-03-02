@extends('admin.layouts.layout')
@section('title',"Customer Details")
@section('content')
<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{$customer->name }} || Phone: {{$customer->phone }} || Address: {{$customer->address }} || Balance: {{ CustomHelper::getCustomerBalance($customer->ledger_id)['amount'] }}</h3>
        <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
        <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
        </div>
    </div>
    <div class="card-body">
        @include('admin.layouts._message')
        {!! Form::open(array('route'=>['customer.receive',$customer])) !!}
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                {!! Form::label('amount', __('Amount'),['class'=>'']) !!}
                {!! Form::text('amount',null,['class'=>'form-control','placeholder'=> __('Amount')]) !!}
                {{ Form::hidden('ledger_id',$customer->ledger_id) }}
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    {!! Form::label('naration', __('Naration'),['class'=>'']) !!}
                    {!! Form::text('naration',null,['class'=>'form-control','placeholder'=> __('Naration')]) !!}
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <br>
                    {{ Form::submit('Receive',array('class'=>'btn btn-primary')) }}
                </div>
            </div>
        </div>
            
            
        {!! Form::close() !!}
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
    <h3>Transection List <a href="{{route('account.report.ledger')}}?ledger_id={{$customer->ledger_id }}">Details</a></h3>
        <div class="table-responsive">
            <table id="report" class="table">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Date</th>
                        <th>Naration</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($vousers as $key=>$item)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{shortDate($item->voucher_date)}}</td>
                        <td>{{ $item->Naration }}</td>
                        <td class="text-right">{{ number_format($item->amount_dr,2) }}</td>
                        <td class="text-right">{{ number_format($item->amount_cr,2) }}</td>
                        <td>@if($item->amount_cr>0)<a href="{{route('customer.money.receipt',$item->id)}}" class="btn btn-sm btn-info">Receipt</a>@endif</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
        <!-- /.card-footer-->
    </div>
<!-- /.card -->
@endsection