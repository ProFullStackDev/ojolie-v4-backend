@extends('layouts.master')
@section('page-header')
Pricing
@endsection
@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Pricing Edit</h3>
        <div class="box-tools pull-right">
            <a href="{{ route('pricing-list.index') }}" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i> Cancel</a>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">

        {!! Form::model($pricing_list, ['method'=>'PATCH', 'action' => ['PricesController@update', $pricing_list->id], 'id' => 'create-form']) !!}

        @csrf

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Subscription Type</label>
                    {{Form::number('subscription_type',null,['class'=>'form-control', 'value'=>'$pricing_list->subscription_type'])}}
                    <span class="text-danger small">{{$errors->first('subscription_type')}}</span>
                </div>
                <div class="form-group">
                    <label>Currency</label>
                    {{Form::text('currency',null,['class'=>'form-control', 'value'=>'$pricing_list->currency'])}}
                    <span class="text-danger small">{{$errors->first('currency')}}</span>
                </div>
                <div class="form-group">
                    <label>Currency Symbol</label>
                    {{Form::text('currency_symbol',null,['class'=>'form-control', 'value'=>'$pricing_list->currency_symbol'])}}
                    <span class="text-danger small">{{$errors->first('currency_symbol')}}</span>
                </div>
                <div class="form-group">
                    <label>Amount</label>
                    {{Form::text('amount',null,['class'=>'form-control', 'value'=>'$pricing_list->amount'])}}
                    <span class="text-danger small">{{$errors->first('amount')}}</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                {{Form::submit('Save',['class'=>'btn btn-success'])}}
            </div>
        </div>

        {{Form::close()}}
    </div>
</div>
@endsection

