<aside class="main-sidebar sidebar-dark-primary elevation-4 bg-purple">
    <!-- Brand Logo -->
    <a href="{{route('admin::dashboard')}}" class="brand-link">
      <img src="{{asset('images/logo-webacademy.svg')}}" alt="AdminLTE Logo" class=""
           style="opacity: .8">
      <span class=""></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block">{{Auth::user()->name}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          @role('admin')
          <li class="nav-item">
            <a href="{{ route('admin::series.index') }}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Series
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin::plan.index') }}" class="nav-link">
              <i class="nav-icon fas fa-money-bill"></i>
              <p>
                Plan
              </p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="{{ route('admin::user.subscription') }}" class="nav-link">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
                User Subscription
              </p>
            </a>
          </li>
          @endrole
          
          @hasanyrole('executive|admin')
          <li class="nav-item">
            <a href="{{ route('admin::user.payment') }}" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Laporan Pembayaran
              </p>
            </a>
          </li>
          @endhasanyrole
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>