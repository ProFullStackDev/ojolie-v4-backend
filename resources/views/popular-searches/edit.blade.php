@extends('layouts.master')
@section('page-header')
Popular Keyword
@endsection
@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Popular Keyword Edit</h3>
        <div class="box-tools pull-right">
            <a href="{{ route('popular-searches.index') }}" class="btn btn-danger"><i class="fa fa-undo"></i> Back</a>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <form name="" method="POST" action="{{ route('popular-searches.update', ['popular_search' => $popularSearch->id]) }}">
        <input type="hidden" name="_method" value="PUT">    
        @csrf

        <div class="row">
            <div class="col-md-10">
            <div class="row">    
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Keyword</label>
                    {{Form::text('keyword',$popularSearch->keyword,['class'=>'form-control','required'=>'required','placeholder'=>'Please enter the keyword'])}}
                    <span class="text-danger small">{{$errors->first('keyword')}}</span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Count</label>
                    {{Form::number('count',$popularSearch->count,['class'=>'form-control','min'=>0 ,'required'=>'required','placeholder'=>'Please enter the count'])}}
                    <span class="text-danger small">{{$errors->first('count')}}</span>
                </div>
            </div>
            </div>
            <div class="row">    
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Sequence</label>
                    {{Form::number('seq',$popularSearch->seq,['class'=>'form-control','min'=>0 ,'required'=>'required','placeholder'=>'Please enter the sequence'])}}
                    <span class="text-danger small">{{$errors->first('seq')}}</span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Is New</label>
                    <select name="is_new" class="form-control" required>
                        <option value="">Select Any</option>
                        <option value="1" {{ $popularSearch->is_new==1 ? 'selected' :'' }}>Yes</option>
                        <option value="0" {{ $popularSearch->is_new==0 ? 'selected' :'' }}>No</option>
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
                        <option value="1" {{ $popularSearch->status==1 ? 'selected' :'' }}>Active</option>
                        <option value="0" {{ $popularSearch->status==0 ? 'selected' :'' }}>Inctive</option>
                    </select>
                    <span class="text-danger small">{{$errors->first('status')}}</span>
                </div>
            </div>
             </div>   
            <div class="row">    
            <div class="col-sm-12">
                <div class="pull-left"> 
                    {{Form::submit('Update',['class'=>'btn btn-success'])}}
                </div>
            </div>
            </div>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection