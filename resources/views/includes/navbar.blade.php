{{-- Navigation --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
  <a class="navbar-brand" href="/">Auto Gen Codeigniter</a>
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive"
    aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarResponsive">
    
    @guest
      <!-- left side Links Before Login Links -->
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="User Login">
          <a class="nav-link" href="{{ route('login') }}">
            <i class="fa fa-fw fa-sign-in"></i>
            <span class="nav-link-text">User Login</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="User Register">
          <a class="nav-link" href="{{ route('register') }}">
            <i class="fa fa-fw fa-user-plus"></i>
            <span class="nav-link-text">User Registration</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Go Home">
          <a class="nav-link" href="/">
            <i class="fa fa-fw fa-arrow-left"></i>
            <span class="nav-link-text">Go Home</span>
          </a>
        </li>
      </ul>
      <!-- End Of Left Side Links After Login -->
      <!-- Bottom -->
      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>
      <!-- End Of Bottom -->
    @else
      <!-- Left Side Links -->
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="User Dashboard">
          <a class="nav-link" href="{{ route('home') }}">
          <i class="fa fa-fw fa-dashboard"></i>
            <span class="nav-link-text">Dashboard</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="User Projects">
          <a class="nav-link" href="{{ route('projects') }}">
          <i class="fa fa-fw fa-sitemap"></i>
            <span class="nav-link-text">Projects</span>
          </a>
        </li>
      </ul>
      <!-- End Of Left Side Links -->
      <!-- Bottom -->
      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>
      <!-- End Of Bottom -->
      <!-- Top Right Links -->
      <ul class="navbar-nav ml-auto">
        <!-- Profile Links -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle mr-lg-2" id="messagesDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:white;">
            <i class="fa fa-user-circle-o" aria-hidden="true"></i> {{ Auth::user()->name }}
          </a>
          <!-- <a href="" class="nav-link" style="color:white;">{{ Auth::user()->name }}</a> -->
          <div class="dropdown-menu" aria-labelledby="messagesDropdown">
            <a class="dropdown-item" href="#">
              <i class="fa fa-user" aria-hidden="true"></i>
              <strong>Profile</strong>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <i class="fa fa-bell" aria-hidden="true"></i>
              <strong>Notifications</strong>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <i class="fa fa-cog" aria-hidden="true"></i>
              <strong>Settings</strong>
            </a>
        </li>
        <!-- End Of Profile Links -->
        <!-- Logout -->
        <li class="nav-item">
          <a class="nav-link" data-toggle="modal" data-target="#logoutModal" style="color:white;">
            <i class="fa fa-fw fa-sign-out"></i><span class="nav-link-text">Logout</span></a>
        </li>
        <!-- End Of Logout -->
      </ul>
      <!-- End Of Top Right Links -->
    @endguest
    <!-- End of Links -->

  </div>
</nav>
<!-- End of navigation -->

<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="logoutModalLabel"><center>Do You Want To Logout?</center></h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Select "Logout" to end your current session.</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <a class="btn btn-primary" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          {{ __('Logout') }}
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </div>
    </div>
  </div>
</div>
<!-- End Of Logout Modal -->