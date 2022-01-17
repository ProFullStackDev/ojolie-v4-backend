@extends('layouts.master')
@section('page-header')
Blacklist
@endsection
@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Blacklist Create</h3>
        <div class="box-tools pull-right">
            <a href="{{ route('blacklist.index') }}" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i> Cancel</a>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {!! Form::open(['url' =>'/blacklist/add', 'id'=>'create-form']) !!}

        @csrf

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Email</label>
                    {{Form::text('email',null,['class'=>'form-control'])}}
                    <span class="text-danger small">{{$errors->first('email')}}</span>
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
