<ul class="navbar-nav bg-gradient-primary-admin sidebar sidebar-dark accordion py-4" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
    <h2 class="text-white">siperpus</h2>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Divider -->
  <hr class="sidebar-divider">

  <?php if (session()->get('role') == 'admin') : ?>
    <!-- MENU ADMIN -->
    <li class="nav-item">
      <a class="nav-link" href="books">
        <span>Manage Book Data</span></a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="payment">
        <span>Payment</span></a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="report">
        <span>Generate Report</span></a>
    </li>
  <?php else : ?>
    <!-- MENU PETUGAS -->
    <li class="nav-item">
      <a class="nav-link" href="borrowing">
        <span>Borrowing Book</span></a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="return">
        <span>Return Book</span></a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="report">
        <span>Generate Report</span></a>
    </li>
  <?php endif; ?>
</ul>