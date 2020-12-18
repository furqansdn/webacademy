<nav class="main-header navbar navbar-expand-md navbar-light navbar-dark bg-purple">
    <div class="container">
      <a href="../../index3.html" class="navbar-brand">
        <img src="{{ asset('dist/img/logo.png') }}" alt="AdminLTE Logo" class="brand-image mt-2">
      </a>
      
      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          @guest
          <li class="nav-item">
            <a href="{{route('landingpage')}}" class="nav-link">Home</a>
          </li>
          @endguest
          @auth              
          <li class="nav-item">
            <a href="{{route('home')}}" class="nav-link">Home</a>
          </li>
          @endauth
          <li class="nav-item">
            <a href="{{route('discussion.index')}}" class="nav-link">Discussion</a>
          </li>
          @auth
          <li class="nav-item">
            <a href="{{ route('client::series.list') }}" class="nav-link">Course List</a>
          </li>
                       
          <li class="nav-item">
            <a href="{{ route('client::series.mycourse')}}" class="nav-link">My Course</a>
          </li>
          @endauth
        </ul>
      </div>

      <!-- Right navbar links -->
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        @guest
          <li class="nav-item">
              <a class="nav-link" href="{{ route('login') }}">
                  Login
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="{{ route('register') }}">
                  Register
              </a>
          </li>
        @endguest
        @auth 
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fas fa-user fa-2x"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            @if (Auth()->user()->isSubscribed())
              <span class="dropdown-header">Premium User</span>
            @else
              <a href="{{ route('client::subscription.plan') }}" class="dropdown-header">Want to Subsribe?</a>
            @endif
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-user mr-2"></i>Profile
            </a>
            <div class="dropdown-divider"></div>
            <a href="{{route('client::subscription.purchase.index')}}" class="dropdown-item">
              <i class="fa fa-credit-card mr-2"></i>Payment
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
              <i class="fas fa-sign-out-alt mr-2"></i>Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </div>
        </li>
        @endauth
      </ul>
    </div>
  </nav>