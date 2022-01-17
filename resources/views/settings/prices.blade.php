<div class="row">
    <div class="col-sm-6 col-sm-offset-3">
        {{Form::open(['route'=>'settings.store'])}}
        {{Form::hidden('type',request('type'))}}

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Subscription Type</th>
                    <th>Currency</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prices as $price)
                    <tr>
                        <td>{{$price->subscriptiontype->name}}</td>
                        <td>{{$price->currency}}</td>
                        <td>
                            {{Form::text('configurations['.$price->id.']',isset(old('configurations')[$price->id]) ? old('configurations')[$price->id] : $price->amount,['class'=>'form-control'])}}
                            <span class="text-danger small">{{$errors->first('configurations.'.$price->id)}}</span>                            
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{Form::submit('Save',['class'=>'btn btn-success pull-right'])}}
        {{Form::close()}}
    </div>
</div>