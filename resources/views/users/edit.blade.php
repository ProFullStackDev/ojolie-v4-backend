@extends('layouts.master')
@section('page-header')
Users Edit
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
        {{Form::model($user->toArray() + $member->toArray(),['route'=>['users.update',$user->id],'method'=>'put'])}}
        <div class="row">
            <div class="col-sm-4">
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
                            <span class="text-info small">Keep this empty if no change intended.</span>
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

                </div>

                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            {{Form::checkbox('notify_pickup',1,$member->notify_pickup)}} Pickup Notification
                        </label>
                    </div>
                    <span class="text-danger small">{{$errors->first('notify_pickup')}}</span>
                </div>

                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            {{Form::checkbox('notify_sent',1,$member->notify_sent)}} Sent Notification
                        </label>
                    </div>
                    <span class="text-danger small">{{$errors->first('notify_sent')}}</span>
                </div>

                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            {{Form::checkbox('notify_reply',1,$member->notify_reply)}} Reply Notification
                        </label>
                    </div>
                    <span class="text-danger small">{{$errors->first('notify_reply')}}</span>
                </div>

                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            {{Form::checkbox('newsletter_subscribed',1,$member->newsletter_subscribed)}} Newsletter Subscripton
                        </label>
                    </div>
                    <span class="text-danger small">{{$errors->first('newsletter_subscribed')}}</span>
                </div>

                {{Form::submit('Save',['class'=>'btn btn-success pull-right'])}}
            </div>
            <div class="col-sm-8">
                <div class="box box-primary">
                    <div class="box-header">
                        <h4 class="box-title">Orders & Payments</h4>
                        <div class="box-tools pull-right">
                            <a href="{{ route('orders.create',['user_id'=>$user->id]) }}" class="btn btn-success btn-xs show_in_modal"><i class="fa fa-plus"></i> Create New</a>
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table small">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Payment ID</th>
                                    <th>Pay Via</th>
                                    <th>Pay Type</th>
                                    <th>Currency</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Transaction ID</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->orders as $order)
                                <tr>
                                    <td>{{$order->id}}</td>
                                    <td>{{$order->payment->id}}</td>
                                    <td>{{$order->payment->pay_via}}</td>
                                    <td>{{$order->payment->pay_via_type}}</td>
                                    <td>{{$order->payment->pay_currency}}</td>
                                    <td>{{$order->payment->pay_amount}}</td>
                                    <td>{{$order->payment->pay_date}}</td>
                                    <td>{{$order->payment->pay_status}}</td>
                                    <td>{{$order->payment->pay_name}}</td>
                                    <td>{{$order->payment->pay_email}}</td>
                                    <td>{{$order->payment->transaction_id}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{route('orders.edit',$order->id)}}" title='Edit' class='btn btn-default btn-xs show_in_modal'><i class='fa fa-edit'></i></a>
                                            <a href="{{route('orders.destroy',$order->id)}}" title='Delete' class='btn btn-danger btn-xs delete'><i class='fa fa-trash'></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{Form::close()}}
    </div>
</div>
@endsection

@push('js')
<script type="text/javascript">
$(document).ready(function(){

    $('.modal').on('shown.bs.modal', function(e) {
        $('.date').datepicker({
        format: "yyyy-mm-dd",
        todayBtn: "linked",
        autoclose: true,
        });
    });
});
</script>
@endpush
