@section('rightbar')
<a href="#" id="close-sidebar" data-toggle="control-sidebar" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-remove"></i> Close</a>
<div class="box-body">
	{{Form::open(['name'=>'search_form'])}}
	<div class="form-group" title="Search User ID">
	  	{{Form::text('user_id',null,['class'=>'form-control input-sm search-input','placeholder'=>'User ID'])}}
    </div>
    <div class="form-group" title="Search From Email">
	  	{{Form::text('from_email',null,['class'=>'form-control input-sm search-input','placeholder'=>'From Email'])}}
    </div>
    <div class="form-group" title="Search To Email">
	  	{{Form::text('to_email',null,['class'=>'form-control input-sm search-input','placeholder'=>'To Email'])}}
	</div>
	<div class="form-group">
		<button type="button" class="btn btn-default btn-sm" id="search">Search</button>
	</div>
	{{Form::close()}}
</div>
@endsection