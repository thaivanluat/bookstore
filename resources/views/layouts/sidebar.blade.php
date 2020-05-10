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
  <li class="nav-item active">
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
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseTwo">
      <i class="fas fa-book"></i>
      <span>{{ trans('app.book_management') }}</span>
    </a>
    <div id="collapseOne" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{ url('/book/index') }}">{{ trans('app.book') }}</a>
        <a class="collapse-item" href="{{ url('/author/index') }}">{{ trans('app.author') }}</a>
        <a class="collapse-item" href="{{ url('/bookcategory/index') }}">{{ trans('app.category') }}</a>
      </div>
    </div>
  </li>


  <!-- Nav Item - Tables -->
  <li class="nav-item">
    <a class="nav-link" href="{{ url('/invoice/index') }}">
      <i class="fas fa-fw fa-file-invoice"></i>
      <span>{{ trans('app.invoice') }}</span></a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="{{ url('/inputreceipt/index') }}">
      <i class="fas fa-fw fa-receipt"></i>
      <span>{{ trans('app.input_receipt') }}</span></a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="{{ url('/customer/index') }}">
      <i class="fas fa-fw fa-users"></i>
      <span>{{ trans('app.customer') }}</span></a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="{{ url('/receipt/index') }}">
      <i class="fas fa-fw fa-file-invoice-dollar"></i>
      <span>{{ trans('app.receipt') }}</span></a>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
      <i class="fas fa-chart-pie"></i>
      <span>{{ trans('app.report') }}</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{ url('/report/inventory') }}">{{ trans('app.inventory_report') }}</a>
        <a class="collapse-item" href="{{ url('/report/debt') }}">{{ trans('app.debt_report') }}</a>
      </div>
    </div>
  </li>


  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>