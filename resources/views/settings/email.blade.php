<div class="row">
    <div class="col-sm-6 col-sm-offset-3">
        {{Form::open(['route'=>'settings.store'])}}
        {{Form::hidden('type',request('type'))}}
        @foreach($email_configs as $config)
        <div class="form-group">
            <label>{{ucwords(str_replace('_',' ',$config->key))}}</label>
            {{Form::text('configurations['.$config->key.']',isset(old('configurations')[$config->key]) ? old('configurations')[$config->key] : $config->value,['class'=>'form-control'])}}
            <span class="text-danger small">{{$errors->first('configurations.'.$config->key)}}</span>
        </div>
        @endforeach
        {{Form::submit('Save',['class'=>'btn btn-success pull-right'])}}
        {{Form::close()}}
    </div>
</div>