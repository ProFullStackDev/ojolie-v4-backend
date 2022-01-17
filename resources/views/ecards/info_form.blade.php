<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label>Title/Caption</label>
            {{Form::text('caption',null,['class'=>'form-control'])}}
            <span class="text-danger small">{{$errors->first('caption')}}</span>
        </div>
        <div class="form-group">
            <label>Filename</label>
            {{Form::text('filename',null,['class'=>'form-control'])}}
            <span class="text-danger small">{{$errors->first('filename')}}</span>
        </div>
        <div class="form-group">
            <label>Image SEO suffix</label>
            {{Form::text('img_suffix',null,['class'=>'form-control','id' =>'img_suffix'])}}
            <span class="text-danger small">{{$errors->first('img_suffix')}}</span>
        </div>
        <div class="form-group">
            <label>Description</label>
            {{Form::textarea('detail',null,['class'=>'form-control'])}}
            <span class="text-danger small">{{$errors->first('detail')}}</span>
        </div>

        @for($i=0; $i<=5; $i++)
        <div class="form-group">
            <label>Greeting {{$i+1}}</label>
            {{Form::text('greetings[]',null,['class'=>'form-control'])}}
            <span class="text-danger small">{{$errors->first('greetings.'.$i)}}</span>
        </div>
        @endfor
    </div>
    <div class="col-sm-4 col-sm-offset-1">
        <div class="form-group">
            <div class="checkbox">
                  <label>
                    {{Form::checkbox('active',1,false)}} Active
                  </label>
            </div>
            <span class="text-danger small">{{$errors->first('active')}}</span>
        </div>
        <div class="form-group">
            <div class="checkbox">
                  <label>
                    {{Form::checkbox('private',1,false)}} Private
                  </label>
            </div>
            <span class="text-danger small">{{$errors->first('private')}}</span>
        </div>

        <div class="form-group">
            <label>Video ID</label>
            {{Form::text('video',null,['class'=>'form-control'])}}
            <span class="text-danger small">{{$errors->first('video')}}</span>
        </div>
        <div class="form-group">
            <label>Image Small</label>
            {{Form::file('image_small',['id'=>'image_small'])}}
            <span class="text-danger small">{{$errors->first('image_small')}}</span>
        </div>
        <img src="{{asset('img/placeholder.png')}}" alt="Placeholder Image" class="thumbnail" width="100" id="image_small_display">
        <div class="form-group">
            <label>Image Large</label>
            {{Form::file('image_large',['id'=>'image_large'])}}
            <span class="text-danger small">{{$errors->first('image_large')}}</span>
        </div>
        <img src="{{asset('img/placeholder.png')}}" alt="Placeholder Image" class="thumbnail" width="100" id="image_large_display">
    </div>
</div>

@push('js')
<script>
$(document).ready(function(){

    function showImageSmall(input) {
	  if (input.files && input.files[0]) {
	    var reader = new FileReader();
	    reader.onload = function(e) {
	      $('#image_small_display').attr('src', e.target.result);
	    }
	    reader.readAsDataURL(input.files[0]);
	  }
	}

	$("#image_small").change(function() {
        showImageSmall(this);
    });

    function showImageLarge(input) {
	  if (input.files && input.files[0]) {
	    var reader = new FileReader();
	    reader.onload = function(e) {
	      $('#image_large_display').attr('src', e.target.result);
	    }
	    reader.readAsDataURL(input.files[0]);
	  }
	}

	$("#image_large").change(function() {
        showImageLarge(this);
	});
});
</script>
@endpush
