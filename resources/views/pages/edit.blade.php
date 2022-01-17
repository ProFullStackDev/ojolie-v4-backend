@extends('layouts.master')
@section('page-header')
Pages Edit
@endsection
@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"></h3>
        <div class="box-tools pull-right">
            <a href="{{ route('pages.index') }}" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i> Cancel</a>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-6">
                {{Form::model($page,['route'=>['pages.update',$page->id],'method'=>'put'])}}
                    <div class="form-group">
                        <label>Name</label>
                        {{Form::text('name',null,['class'=>'form-control'])}}
                        <span class="text-danger small">{{$errors->first('name')}}</span>
                    </div>
                    <div class="form-group">
                        <label>Page Title</label>
                        {{Form::text('title',null,['class'=>'form-control'])}}
                        <span class="text-danger small">{{$errors->first('title')}}</span>
                    </div>
                    <div class="form-group">
                        <label>Page Description</label>
                        {{Form::textarea('description',null,['class'=>'form-control'])}}
                        <span class="text-danger small">{{$errors->first('description')}}</span>
                    </div>
                    <div class="form-group">
                        <label>Page Keywords</label>
                        {{Form::textarea('keywords',null,['class'=>'form-control'])}}
                        <span class="text-danger small">{{$errors->first('keywords')}}</span>
                    </div>
                    {{Form::submit('Update',['class'=>'btn btn-success'])}}        
                {{Form::close()}}            
            </div>        
        </div>
    </div>
</div>
@endsection