@extends('layouts.master')
@section('page-header')
    Ecard Categories Set Date
@endsection
@section('content')
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">{{ $ecardcategory->parent->name }} -> {{ $ecardcategory->name }}</h3>
            <div class="box-tools pull-right">
                <a href="{{ route('ecardcategories.index') }}" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i>
                    Cancel</a>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            {!! Form::model($ecardcategory, ['method' => 'PUT', 'route' => ['ecardcategories.setdate_add', $ecardcategory->id], 'id' => 'create-form']) !!}
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Date</label>
                        {{ Form::date('date', null, ['class' => 'form-control date', 'autocomplete' => 'off']) }}
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </div>
            {{ Form::close() }}

        </div>
    </div>
@endsection
