@section('rightbar')
<a href="#" id="close-sidebar" data-toggle="control-sidebar" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-remove"></i> Close</a>
<div class="box-body">
	{{Form::open(['name'=>'search_form'])}}
	<div class="form-group" title="Search Filename">
	  	{{Form::text('filename',null,['class'=>'form-control input-sm search-input','placeholder'=>'Filename'])}}
	</div>
	<div class="form-group" title="Search Category">
	  	{{Form::select('ecard_category_id',$ecard_categories,null,['class'=>'form-control input-sm search-input'])}}
	</div>
	<div class="form-group">
		<button type="button" class="btn btn-default btn-sm" id="search">Search</button>
	</div>
	{{Form::close()}}
</div>
@endsection