<div class="row">
  <div class="col-sm-6">
    <div class="form-group">
    <input type="hidden" id="id" value="{{$ecard->id}}" name="ecard_id">
      <label>Title/Caption</label>
      {{Form::text('caption',null,['class'=>'form-control autosave', 'id' =>'caption'])}}
      <span class="text-danger small">{{$errors->first('caption')}}</span>
    </div>
    <div class="form-group">
      <label>Filename</label>
      {{Form::text('filename',null,['class'=>'form-control autosave', 'id' =>'filename'])}}
      <span class="text-danger small">{{$errors->first('filename')}}</span>
    </div>
    <div class="form-group">
        <label>Image SEO suffix</label>
        {{Form::text('img_suffix',$ecard->img_suffix,['class'=>'form-control autosave','id' =>'img_suffix'])}}
        <span class="text-danger small">{{$errors->first('img_suffix')}}</span>
    </div>
    <div class="form-group">
      <label>Description</label>
      {{Form::textarea('detail',null,['class'=>'form-control autosave', 'id' =>'detail'])}}
      <span class="text-danger small">{{$errors->first('detail')}}</span>
    </div>

    @for($i=0; $i<=5; $i++) <div class="form-group">
      <label>Greeting {{$i+1}}</label>
      {{Form::text('greetings[]',isset($greetings[$i]) ? $greetings[$i] : null,['class'=>'form-control autosave', 'id' =>'greetings'])}}
      <span class="text-danger small">{{$errors->first('greetings.'.$i)}}</span>
  </div>
  @endfor
</div>
<div class="col-sm-4 col-sm-offset-1">
  <div class="form-group">
    <div class="checkbox">
      <label>
        {{Form::checkbox('active',1,$ecard->active,['id' =>'active'])}} Active
      </label>
    </div>
    <span class="text-danger small">{{$errors->first('active')}}</span>
  </div>
  <div class="form-group">
    <div class="checkbox">
      <label>
        {{Form::checkbox('private',1,$ecard->private,['id' =>'private', 'class' =>'autosave'])}} Private
      </label>
    </div>
    <span class="text-danger small">{{$errors->first('private')}}</span>
  </div>
  <div class="form-group">
    <label>Video ID</label>
    {{Form::text('video',null,['class'=>'form-control autosave','id' =>'video'])}}
    <span class="text-danger small">{{$errors->first('video')}}</span>
  </div>
  <div class="form-group">
    <label>Image Small</label>
    {{Form::file('image_small',['id'=>'image_small', 'class' =>'autosave'])}}
    <span class="text-danger small">{{$errors->first('image_small')}}</span>
  </div>
  <img src="{{asset('storage/img/ecards/'.$ecard->filename.'.jpg')}}" alt="Placeholder Image" class="thumbnail" width="100" id="image_small_display">
  <div class="form-group">
    <label>Image Large</label>
    {{Form::file('image_large',['id'=>'image_large', 'class' =>'autosave'])}}
    <span class="text-danger small">{{$errors->first('image_large')}}</span>
  </div>
  @if ($ecard->img_suffix != null)
  <img src="{{asset('storage/img/ecards/'.$ecard->filename.'P_'.$ecard->img_suffix.'.jpg')}}" alt="Placeholder Image" class="thumbnail" width="100" id="image_large_display">
  @elseif ($ecard->img_suffix == null)
  <img src="{{asset('storage/img/ecards/'.$ecard->filename.'P.jpg')}}" alt="Placeholder Image" class="thumbnail" width="100" id="image_large_display">
  @endif
</div>
</div>

@push('js')
<script>

  $(document).ready(function() {
    // $(".autosave").change(function() {
    //   var id = $('#id').val();
    //   var caption = $('#caption').val();
    //   var filename = $('#filename').val();
    //   var detail = $('#detail').val();
    //   var greetings = $('#greetings').val();
    //   var active = $('#active').val();
    //   var private = $('#private').val();
    //   var recommended_card = $('#recommended_card').val();
    //   var photo = $('#photo').val();
    //   var video = $('#video').val();
    //   var image_small = $('#image_small').val();
    //   var image_large = $('#image_large').val();

    //   if (caption != '' && filename != '' && detail != '') {

    //     var $form = $('form');

    //     var data = {
    //       ecard_id: "{{$ecard->id}}",
    //     };

    //     data = $form.serialize() + '&' + $.param(data);
    //     $.ajax({
    //       url: "/ecards/autoupdate/" + id,
    //       type: "PUT",
    //       data: data,
    //       dataType: "text",
    //       success: function(data) {
    //         $('#autoSave').text("Cards auto saving.");
    //         setInterval(function() {
    //             $('#autoSave').text('');
    //         }, 3000);
    //       },

    //     });

        // $.ajax({
        //   url: "/ecards/draftsave",
        //   type: "POST",
        //   data: data,
        //   success: function(data) {
        //     $('#autoSave').text("Post save as draft");
        //     setInterval(function() {
        //         $('#autoSave').text('');
        //     }, 3000);
        //   },

        // });
    //   }
    // });

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

