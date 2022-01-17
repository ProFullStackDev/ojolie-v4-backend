{{-- @extends('layouts.master')
@section('page-header')
Newsletter Subscriber
@endsection
@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Newsletter Subscriber Edit</h3>
        <div class="box-tools pull-right">
            <a href="{{ route('newsletter-subscription.index') }}" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i> Cancel</a>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {!! Form::model($mailing_list, ['method'=>'PATCH', 'action' => ['NewsletterSubscriptionController@update', $mailing_list->id], 'id' => 'create-form']) !!}

        @csrf

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Subscriber Email</label>
                    <p>{{$mailing_list->email}}</p>
                </div>
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            {{Form::checkbox('blacklist',1,$mailing_list->blacklist,['id' =>'blacklist'])}} Blacklist
                        </label>
                    </div>
                    <span class="text-danger small">{{$errors->first('blacklist')}}</span>
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
@endsection --}}
