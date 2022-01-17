@extends('layouts.master')
@section('page-header')
Premium Subscription Type
@endsection
@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Premium Subscription Type Edit</h3>
        <div class="box-tools pull-right">
            <a href="{{ route('premium-subscription-type.index') }}" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i> Cancel</a>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">

        {!! Form::model($pricing_list, ['method'=>'PATCH', 'action' => ['PremiumSubscriptionTypeController@update', $pricing_list->id], 'id' => 'create-form']) !!}

        @csrf

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Subscription Type</label>
                    {{Form::number('subscription_type',null,['class'=>'form-control', 'value'=>'$pricing_list->subscription_type'])}}
                    <span class="text-danger small">{{$errors->first('subscription_type')}}</span>
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

