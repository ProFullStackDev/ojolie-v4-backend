@extends('layouts.master')
@section('page-header')
Users Create
@endsection
@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"></h3>
        <div class="box-tools pull-right">
            <a href="{{ route('users.index') }}" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i> Cancel</a>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {{Form::open(['route'=>'users.store'])}}
        <div class="row">
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>First Name</label>
                            {{Form::text('first_name',null,['class'=>'form-control'])}}
                            <span class="text-danger small">{{$errors->first('first_name')}}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Last Name</label>
                            {{Form::text('last_name',null,['class'=>'form-control'])}}
                            <span class="text-danger small">{{$errors->first('last_name')}}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Email</label>
                            {{Form::text('email',null,['class'=>'form-control'])}}
                            <span class="text-danger small">{{$errors->first('email')}}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Password</label>
                            {{Form::password('password',['class'=>'form-control'])}}
                            <span class="text-danger small">{{$errors->first('password')}}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Active/Status</label>
                            {{Form::select('active',$users_active_options,null,['class'=>'form-control'])}}
                            <span class="text-danger small">{{$errors->first('active')}}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Timezone</label>
                            {{Form::select('timezone',$timezones,null,['class'=>'form-control'])}}
                            <span class="text-danger small">{{$errors->first('timezone')}}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Type</label>
                            {{Form::select('type',$members_type_options,null,['class'=>'form-control'])}}
                            <span class="text-danger small">{{$errors->first('type')}}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">

                    </div>
                </div>

                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            {{Form::checkbox('notify_pickup',1,false)}} Pickup Notification
                        </label>
                    </div>
                    <span class="text-danger small">{{$errors->first('notify_pickup')}}</span>
                </div>

                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            {{Form::checkbox('notify_sent',1,false)}} Sent Notification
                        </label>
                    </div>
                    <span class="text-danger small">{{$errors->first('notify_sent')}}</span>
                </div>

                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            {{Form::checkbox('notify_reply',1,false)}} Reply Notification
                        </label>
                    </div>
                    <span class="text-danger small">{{$errors->first('notify_reply')}}</span>
                </div>

                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            {{Form::checkbox('newsletter_subscribed',1,false)}} Newsletter Subscripton
                        </label>
                    </div>
                    <span class="text-danger small">{{$errors->first('newsletter_subscribed')}}</span>
                </div>

                {{Form::submit('Save',['class'=>'btn btn-success pull-right'])}}
            </div>
        </div>
        {{Form::close()}}
    </div>
</div>
@endsection
