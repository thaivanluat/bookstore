<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/home/index') }}">
    <div class="sidebar-brand-icon rotate-n-0">
      <i class="fas fa-store"></i>
    </div>
    <div class="sidebar-brand-text mx-3">BookStore Management</div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item active">
    <a class="nav-link" href="{{ url('/home/index') }}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
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
      <span>Book</span>
    </a>
    <div id="collapseOne" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{ url('/book/index') }}">Book</a>
        <a class="collapse-item" href="{{ url('/author/index') }}">Author</a>
        <a class="collapse-item" href="{{ url('/bookcategory/index') }}">Book Category</a>
      </div>
    </div>
  </li>


  <!-- Nav Item - Tables -->
  <li class="nav-item">
    <a class="nav-link" href="{{ url('/invoice/index') }}">
      <i class="fas fa-fw fa-file-invoice"></i>
      <span>Invoice</span></a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="{{ url('/inputreceipt/index') }}">
      <i class="fas fa-fw fa-receipt"></i>
      <span>Goods Receipt</span></a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="{{ url('/customer/index') }}">
      <i class="fas fa-fw fa-users"></i>
      <span>Customer</span></a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="{{ url('/receipt/index') }}">
      <i class="fas fa-fw fa-file-invoice-dollar"></i>
      <span>Receipt</span></a>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
      <i class="fas fa-chart-pie"></i>
      <span>Report</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{ url('/report/inventory') }}">Inventory Report</a>
        <a class="collapse-item" href="{{ url('/report/debt') }}">Debt Report</a>
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