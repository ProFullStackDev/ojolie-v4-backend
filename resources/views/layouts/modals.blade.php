<div class="modal fade in" id="delete_modal">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Item Delete Confirmation</h4>
        </div>
        <div class="modal-body">
          <p class="alert alert-warning text-justify">
            You are about to delete an item permanently. Do you want to delete this item permanently? Remember that this action cannot be undone.
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
          {{Form::open(['method'=>'delete','id'=>'delete_form'])}}
            {{Form::submit('Delete',['class'=>'btn btn-danger'])}}
          {{Form::close()}}
        </div>
    </div>
  </div>
</div>


<div class="modal fade in" id="confirm_modal">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Confirmation</h4>
        </div>
        <div class="modal-body">
          <p class="alert alert-warning text-justify">
            Please confirm your actions.
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
          <a href="#" id="confirmed_link" class="btn btn-success">Confirm</a>
        </div>
    </div>
  </div>
</div>


<div class="modal fade in" id="common_modal">
  <div class="modal-dialog">
    <div class="modal-content" id="common_modal_content">

    </div>
  </div>
</div>


@push('js')
<script type="text/javascript">
$(document).ready(function(){
  $(document.body).on('click','.delete',function(){
    $("#delete_form").attr('action',$(this).attr('href'));
    $("#delete_modal").modal('show');
    return false;
  });

  $(document.body).on('click','.confirm',function(){  
    $("#confirmed_link").attr('href',$(this).attr('href'));
    $("#confirm_modal").modal('show');
    return false;
  });

  $(document.body).on('click','.show_in_modal',function(e){
    $.ajax({
      type:'GET',
      url:$(this).attr('href'),
      success:function(response)
      {
        $("#common_modal_content").html(response);
        $("#common_modal").modal('show');
      }
    });    
    return false;
  });
});  
</script>
@endpush