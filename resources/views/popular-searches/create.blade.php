@extends('layouts.master')
@section('page-header')
Popular Keyword
@endsection
@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Popular Keyword New</h3>
        <div class="box-tools pull-right">
            <a href="{{ route('popular-searches.index') }}" class="btn btn-danger"><i class="fa fa-undo"></i> Back</a>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <form name="" method="POST" action="{{ route('popular-searches.store') }}">
    
        @csrf

        <div class="row">
            <div class="col-md-10">
            <div class="row">    
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Keyword</label>
                    {{Form::text('keyword',null,['class'=>'form-control','required'=>'required','placeholder'=>'Please enter the keyword'])}}
                    <span class="text-danger small">{{$errors->first('keyword')}}</span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Count</label>
                    {{Form::number('count',null,['class'=>'form-control','min'=>0 ,'required'=>'required','placeholder'=>'Please enter the count'])}}
                    <span class="text-danger small">{{$errors->first('count')}}</span>
                </div>
            </div>
            </div>
            <div class="row">    
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Sequence</label>
                    {{Form::number('seq',null,['class'=>'form-control','min'=>0 ,'required'=>'required','placeholder'=>'Please enter the sequence'])}}
                    <span class="text-danger small">{{$errors->first('seq')}}</span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Is New</label>
                    <select name="is_new" class="form-control" required>
                        <option value="">Select Any</option>
                        <option value="1" >Yes</option>
                        <option value="0" >No</option>
                    </select>
                    <span class="text-danger small">{{$errors->first('status')}}</span>
                </div>
            </div>
            </div>
            <div class="row">    
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="">Select Any</option>
                        <option value="1" >Active</option>
                        <option value="0" >Inctive</option>
                    </select>
                    <span class="text-danger small">{{$errors->first('status')}}</span>
                </div>
            </div>
            </div>            
            <div class="row">    
            <div class="col-sm-12">
                <div class="pull-left"> 
                    {{Form::submit('Save',['class'=>'btn btn-success'])}}
                </div>
            </div>
            </div>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection