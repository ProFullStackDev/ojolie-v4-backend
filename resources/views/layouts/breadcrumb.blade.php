<section class="content-header">
  <h1>
    @yield('page-header')
  </h1>

  {{--  
    @if(Breadcrumbs::exists(Route::currentRouteName()))
      {{ Breadcrumbs::render(Route::currentRouteName()) }}
    @endif
  --}}
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Examples</a></li>
    <li class="active">Blank page</li>
  </ol>
</section>