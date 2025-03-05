<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-0 fixed-start ms-3" id="sidenav-main">
    <div class="sidenav-header">
      <a class="navbar-brand m-0" href="{{ route(Auth::user()->role . '-dashboard') }}">
        <span class="ms-1 font-weight-bold">STUDENT INFORMATION</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto h-auto" id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs(Auth::user()->role . '-dashboard') ? 'active' : '' }}" href="{{ route(Auth::user()->role . '-dashboard') }}">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center">
              <i class="fas fa-home text-dark"></i>
            </div>
            <span class="nav-link-text">Dashboard</span>
          </a>
        </li>

        <!-- Grades Module -->
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('student-grade') ? 'active' : '' }}" href="{{ route('student-grade') }}">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center">
              <i class="fas fa-graduation-cap text-dark"></i>
            </div>
            <span class="nav-link-text">My Grades</span>
          </a>
        </li>

        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account pages</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}" href="{{ route('profile')}}">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center">
              <i class="fas fa-user text-dark"></i>
            </div>
            <span class="nav-link-text">Profile</span>
          </a>
        </li>
        @if(Auth::check())
        <!-- Logout Button -->
        <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link border-0 bg-transparent w-100">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center">
                        <i class="fas fa-sign-out-alt text-dark"></i>
                    </div>
                    <span class="nav-link-text">Log Out</span>
                </button>
            </form>
        </li>
        @endif
      </ul>
    </div>
</aside>

<style>
.sidenav {
    background: white;
    box-shadow: 0 0 2rem 0 rgba(136, 152, 170, .15);
    height: 100vh;
    max-height: 100vh;
    width: 250px;
}

.sidenav .navbar-collapse {
    height: calc(100vh - 100px);
    overflow-y: auto;
    overflow-x: hidden;
}

/* Hide scrollbar for Chrome, Safari and Opera */
.navbar-collapse::-webkit-scrollbar {
    display: none;
}

/* Hide scrollbar for IE, Edge and Firefox */
.navbar-collapse {
    -ms-overflow-style: none;  /* IE and Edge */
    scrollbar-width: none;  /* Firefox */
}

.nav-link {
    margin: 0.25rem 1rem;
    padding: 0.675rem 1rem;
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    white-space: nowrap;
}

.nav-link.active {
    background: #f6f9fc;
}

.nav-link:hover {
    background: #f6f9fc;
}

.nav-link-text {
    margin-left: 0.5rem;
}

.icon-shape {
    width: 32px;
    height: 32px;
    background-position: center;
    border-radius: 0.5rem;
    margin-right: 0.5rem;
}

.sidenav-header {
    padding: 1rem;
}

.horizontal.dark {
    margin: 1rem 0;
}

/* Additional fixes for student sidebar */
.navbar-vertical.navbar-expand-xs {
    display: block;
    position: fixed;
    top: 0;
    bottom: 0;
    width: 100%;
    max-width: 250px;
    overflow-y: auto;
    padding: 0;
    box-shadow: none;
}

.navbar-vertical.navbar-expand-xs.fixed-start {
    left: 0;
}

.navbar-vertical.navbar-expand-xs .navbar-collapse {
    display: block;
    overflow: auto;
    height: calc(100vh - 100px);
}

.sidenav #sidenav-collapse-main {
    height: auto;
}

button.nav-link {
    background: transparent;
    border: none;
    width: 100%;
    text-align: left;
}
</style>