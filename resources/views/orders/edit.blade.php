{{Form::model($order->payment,['route'=>['orders.update',$order->id],'method'=>'put'])}}
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span></button>
    <h4 class="modal-title">Order/Payment Edit</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Subscription Type</label>
                {{Form::select('subscription_type',$subscription_types,$order->subscription_type,['class'=>'form-control','required'])}}
            </div>
            <div class="form-group">
                <label>Pay Type</label>
                {{Form::select('pay_via_type',$pay_via_types,null,['class'=>'form-control','required'])}}
            </div>
            <div class="form-group">
                <label>Pay Via</label>
                {{Form::text('pay_via',null,['class'=>'form-control','required'])}}
            </div>
            <div class="form-group">
                <label>Currency</label>
                {{Form::select('pay_currency',$currencies,null,['class'=>'form-control','required'])}}
            </div>
            <div class="form-group">
                <label>Amount</label>
                {{Form::text('pay_amount',null,['class'=>'form-control','required'])}}
            </div>
        </div>

        <div class="col-sm-6">

            <div class="form-group">
                <label>Payment Status</label>
                {{Form::select('pay_status',$payment_status,$order->pay_status,['class'=>'form-control','required'])}}
            </div>

            <div class="form-group">
                <label>Payer's Name</label>
                {{Form::text('pay_name',null,['class'=>'form-control','required'])}}
            </div>
            <div class="form-group">
                <label>Payer's Email</label>
                {{Form::text('pay_email',null,['class'=>'form-control'])}}
            </div>
            <div class="form-group">
                <label>Transaction ID</label>
                {{Form::text('transaction_id',null,['class'=>'form-control','required'])}}
            </div>
            <div class="form-group">
                <label>Date</label>
                {{Form::text('pay_date',null,['class'=>'form-control date','required'])}}
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
    {{Form::submit('Update',['class'=>'btn btn-success'])}}
</div>
{{Form::close()}}
