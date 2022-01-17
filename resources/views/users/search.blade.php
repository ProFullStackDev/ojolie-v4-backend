@section('rightbar')
<a href="#" id="close-sidebar" data-toggle="control-sidebar" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-remove"></i> Close</a>
<div class="box-body">
	{{Form::open(['name'=>'search_form'])}}
	<div class="form-group" title="Search User ID">
	  	{{Form::text('user_id',request('user_id'),['class'=>'form-control input-sm search-input','placeholder'=>'User ID'])}}
    </div>
	<div class="form-group" title="Search Name">
	  	{{Form::text('name',request('name'),['class'=>'form-control input-sm search-input','placeholder'=>'Name'])}}
    </div>
    <div class="form-group" title="Search Email">
	  	{{Form::text('email',request('email'),['class'=>'form-control input-sm search-input','placeholder'=>'Email'])}}
	</div>
	<div class="form-group" title="Search Active">
	  	{{Form::select('active',$users_active_options,request('active'),['class'=>'form-control input-sm search-input'])}}
    </div>
    <div class="form-group" title="Search Type">
	  	{{Form::select('type',$members_type_options,request('type'),['class'=>'form-control input-sm search-input'])}}
    </div>
	<div class="form-group">
		<button type="button" class="btn btn-default btn-sm" id="search">Search</button>
	</div>
	{{Form::close()}}
</div>
@endsection
