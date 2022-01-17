<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{asset('img/user.png')}}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>{{Auth::user()->getFullName()}}</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- search form -->
    <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
          <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
          </button>
        </span>
      </div>
    </form>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MAIN NAVIGATION</li>
      <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="{{route('ecardcategories.index')}}"><i class="fa fa-file"></i> Ecard Categories</a></li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-file" aria-hidden="true"></i>
          <span>Ecards</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ route('ecards.index') }}"><i class="fa fa-circle-o"></i> Ecard List</a></li>
          <li><a href="{{ route('ecards.sort') }}"><i class="fa fa-circle-o"></i> Ecard Sort</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-file" aria-hidden="true"></i>
          <span>Ecard Template</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ route('ecard-template.index') }}"><i class="fa fa-circle-o"></i> Template List</a></li>
          <li><a href="{{ route('ecard-template.create') }}"><i class="fa fa-circle-o"></i> Add New Template</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-file" aria-hidden="true"></i>
          <span>Home Page</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{route('dynamic-video.index')}}"><i class="fa fa-circle-o"></i> Dynamic Video</a></li>
          <li><a href="{{route('home-dynamic-cards.index')}}"><i class="fa fa-circle-o"></i> Dynamic Cards</a></li>
          <li><a href="{{route('mailing-list.index')}}"><i class="fa fa-circle-o"></i> Mailing List</a></li>
          <li><a href="{{route('newsletter-subscription.index')}}"><i class="fa fa-circle-o"></i> Newsletter Subscription</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-file" aria-hidden="true"></i>
          <span>Pricing Page</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{route('pricing-list.index')}}"><i class="fa fa-circle-o"></i> Pricing List</a></li>
          <li><a href="{{route('pricing-list.create')}}"><i class="fa fa-circle-o"></i> Add New Pricing</a></li>
          <li><a href="{{route('premium-subscription-type.index')}}"><i class="fa fa-circle-o"></i> Premium Subscription Types</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-file" aria-hidden="true"></i>
          <span>About Us Page</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{route('contact-messages.index')}}"><i class="fa fa-circle-o"></i> Our Story </a></li>
        </ul>
      </li>      
      <li class="treeview">
        <a href="#">
          <i class="fa fa-file" aria-hidden="true"></i>
          <span>Contact Us Page</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{route('contact-messages.index')}}"><i class="fa fa-circle-o"></i> Contact Messages List</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-file" aria-hidden="true"></i>
          <span>Popular Searches</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{route('popular-searches.index')}}"><i class="fa fa-circle-o"></i> Popular Searches List</a></li>
          <li><a href="{{route('popular-searches.create')}}"><i class="fa fa-circle-o"></i> Add New Popular Searches</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-file" aria-hidden="true"></i>
          <span>Blacklist</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ route('blacklist.index') }}"><i class="fa fa-circle-o"></i> Blacklists</a></li>
          <li><a href="{{ route('blacklist.create') }}"><i class="fa fa-circle-o"></i> Add New Blacklist Email</a></li>
        </ul>
      </li>
      <li><a href="{{route('pages.index')}}"><i class="fa fa-file"></i> Pages</a></li>
      <li><a href="{{route('users.index')}}"><i class="fa fa-user"></i> Users</a></li>
      <li><a href="{{route('sentcards.index')}}"><i class="fa fa-file"></i> Sent Cards</a></li>
      <li><a href="{{route('settings.index')}}"><i class="fa fa-gear"></i> Settings</a></li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
