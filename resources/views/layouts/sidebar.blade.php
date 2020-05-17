<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/home/index') }}">
    <div class="sidebar-brand-icon rotate-n-0">
      <i class="fas fa-store"></i>
    </div>
    <div class="sidebar-brand-text mx-3">{{ trans('app.book_store_management') }}</div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item @if (Request::is('home/*')) active @endif">
    <a class="nav-link" href="{{ url('/home/index') }}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>{{ trans('app.dashboard') }}</span></a>
  </li>
  
  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">
    
  </div>

  <!-- Nav Item - Charts -->
  <li class="nav-item ">
    <a class="nav-link @if (!Request::is('book/*') or !Request::is('author/*') or !Request::is('bookcategory/*') or !Request::is('bookedition/*')) collapsed @endif" href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseTwo">
      <i class="fas fa-book"></i>
      <span>{{ trans('app.book_management') }}</span>
    </a>
    <div id="collapseOne" class="collapse @if (Request::is('book/*') or Request::is('author/*') or Request::is('bookcategory/*') or Request::is('bookedition/*')) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item  @if (Request::is('book/*')) active @endif" href="{{ url('/book/index') }}">{{ trans('app.book') }}</a>
        <a class="collapse-item  @if (Request::is('author/*')) active @endif" href="{{ url('/author/index') }}">{{ trans('app.author') }}</a>
        <a class="collapse-item  @if (Request::is('bookcategory/*')) active @endif" href="{{ url('/bookcategory/index') }}">{{ trans('app.category') }}</a>
        <a class="collapse-item  @if (Request::is('bookedition/*')) active @endif" href="{{ url('/bookedition/index') }}">{{ trans('app.search_book') }}</a>
      </div>
    </div>
  </li>


  <!-- Nav Item - Tables -->
  <li class="nav-item @if (Request::is('invoice/*')) active @endif">
    <a class="nav-link" href="{{ url('/invoice/index') }}">
      <i class="fas fa-fw fa-file-invoice"></i>
      <span>{{ trans('app.invoice') }}</span></a>
  </li>

  <li class="nav-item @if (Request::is('inputreceipt/*')) active @endif">
    <a class="nav-link" href="{{ url('/inputreceipt/index') }}">
      <i class="fas fa-fw fa-receipt"></i>
      <span>{{ trans('app.input_receipt') }}</span></a>
  </li>

  <li class="nav-item @if (Request::is('customer/*')) active @endif">
    <a class="nav-link" href="{{ url('/customer/index') }}">
      <i class="fas fa-fw fa-users"></i>
      <span>{{ trans('app.customer') }}</span></a>
  </li>

  <li class="nav-item @if (Request::is('receipt/*')) active @endif">
    <a class="nav-link" href="{{ url('/receipt/index') }}">
      <i class="fas fa-fw fa-file-invoice-dollar"></i>
      <span>{{ trans('app.receipt') }}</span></a>
  </li>

  @if(Session::get('user')->chucvu != 'staff')
  <li class="nav-item @if (Request::is('report/*')) active @endif">
    <a class="nav-link @if (!Request::is('report/*')) collapsed @endif" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
      <i class="fas fa-chart-pie"></i>
      <span>{{ trans('app.report') }}</span>
    </a>
    <div id="collapseTwo" class="collapse @if (Request::is('report/*')) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item @if (Request::is('report/inventory')) active @endif" href="{{ url('/report/inventory') }}">{{ trans('app.inventory_report') }}</a>
        <a class="collapse-item @if (Request::is('report/debt')) active @endif" href="{{ url('/report/debt') }}">{{ trans('app.debt_report') }}</a>
      </div>
    </div>
  </li>
  @endif

  @if(Session::get('user')->manguoidung == 1)
  <li class="nav-item @if (Request::is('user/index')) active @endif">
    <a class="nav-link" href="{{ url('/user/index') }}">
      <i class="fas fa-fw fa-user"></i>
      <span>{{ trans('app.user') }}</span></a>
  </li>

  <li class="nav-item @if (Request::is('policy')) active @endif">
    <a class="nav-link" href="{{ url('/policy') }}">
      <i class="fas fa-fw fa-lock"></i>
      <span>{{ trans('app.policy') }}</span></a>
  </li>
  @endif
  


  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>