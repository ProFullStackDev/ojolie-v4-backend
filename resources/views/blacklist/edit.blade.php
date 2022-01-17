@extends('layouts.master')
@section('page-header')
Blacklist
@endsection
@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Blacklist Edit</h3>
        <div class="box-tools pull-right">
            <a href="{{ route('blacklist.index') }}" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i> Cancel</a>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
    {!! Form::model($black_list, ['method'=>'PATCH', 'action' => ['BlackListController@update', $black_list->id], 'id' => 'create-form']) !!}

        @csrf

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Email</label>
                    {!! Form::text('email', null, ['class'=>'form-control', 'value'=>'{{$black_list->email}}']) !!}
                    <span class="text-danger small">{{$errors->first('email')}}</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                {{Form::submit('Update',['class'=>'btn btn-success'])}}
            </div>
        </div>

        {{Form::close()}}
    </div>
</div>
@endsection

