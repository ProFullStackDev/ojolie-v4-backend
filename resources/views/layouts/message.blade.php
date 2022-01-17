@if (Session::get('success') !='')
<div class="alert alert-success alert-dismissible fade in" data-dismiss="alert" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" class="text-danger">×</span>
  </button>
  <strong>Success!</strong><p>{{ Session::get('success') }}</p>
</div>
@endif

@if (Session::get('error') !='')
<div class="alert alert-danger alert-dismissible fade in" role="alert" data-dismiss="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" class="text-danger">×</span>
  </button>
  <strong>Warning!</strong><p>{{ Session::get('error') }}</p>
</div>
@endif

@if (Session::get('danger') !='')
<div class="alert alert-danger alert-dismissible fade in" role="alert" data-dismiss="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" class="text-danger">×</span>
  </button>
  <strong>Error!</strong><p>{{ Session::get('danger') }}</p>
</div>
@endif

@if (Session::get('info') !='')
<div class="alert alert-danger alert-dismissible fade in" role="alert" data-dismiss="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" class="text-danger">×</span>
  </button>
  <strong>Info!</strong><p>{{ Session::get('info') }}</p>
</div>
@endif

@if (Session::get('warning') !='')
<div class="alert alert-warning alert-dismissible fade in" role="alert" data-dismiss="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" class="text-warning">×</span>
  </button>
  <strong>Warning!</strong><p>{{ Session::get('warning') }}</p>
</div>
@endif
