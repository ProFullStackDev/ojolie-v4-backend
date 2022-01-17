@extends('layouts.master')
@section('page-header')
E Cards Create
@endsection
@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"></h3>
        <div class="box-tools pull-right">
            <a href="{{ route('ecards.index') }}" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i> Cancel</a>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {{Form::open(['route'=>'ecards.store','files'=>true])}}
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#info" data-toggle="tab" aria-expanded="true">Card Information</a></li>
                <li class=""><a href="#category" data-toggle="tab" aria-expanded="false">Categories</a></li>
                <li class="pull-right">{{Form::submit('Save Card',['class'=>'btn btn-success'])}}</li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="info">
                    @include('ecards.info_form')
                </div>
                <div class="tab-pane" id="category">
                    @include('ecards.category_form')
                </div>
            </div>
        </div>
        {{Form::close()}}
    </div>
</div>
@endsection
