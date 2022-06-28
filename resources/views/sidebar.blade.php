<nav class="sidebar sidebar-offcanvas sidebar-dark" id="sidebar" style=" z-index:4000 !important">
    <ul class="nav">
        <!--  Profile thingy -->
        <li class="nav-item nav-profile">
            <img src="{{ asset('images') }}/faces/user.png" alt="profile image">
            <p class="text-center font-weight-medium">{{ Auth::user()->email }}</p>
        </li>

        <!--Navigation Items -->

        <li class="nav-item">
            <a class="nav-link" href="{{ route('profile') }}">
                <i class="material-icons">account_circle</i>
                <span class="menu-title">Profile</span>
                <div class="badge badge-success d-none"></div>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="admins.php">
                <i class="material-icons">people_alt</i>
                <span class="menu-title">Admins</span>
                <div class="badge badge-success d-none"></div>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="material-icons">event</i>
                <span class="menu-title">Dashboard</span>
                <div class="badge badge-success d-none"></div>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="hubs.php">
                <i class="material-icons">device_hub</i>
                <span class="menu-title">Hubs</span>
                <div class="badge badge-success d-none"></div>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('devices') }}">
                <i class="material-icons">lightbulb</i>
                <span class="menu-title">Devices</span>
                <div class="badge badge-success d-none"></div>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="schedules.php">
                <i class="material-icons">dashboard</i>
                <span class="menu-title">Schedules</span>
                <div class="badge badge-success d-none"></div>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="errors.php">
                <i class="material-icons">warning</i>
                <span class="menu-title">Errors</span>
                <div class="badge badge-success d-none"></div>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="reports.php">
                <i class="material-icons">description</i>
                <span class="menu-title">Reports</span>
                <div class="badge badge-success d-none"></div>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="settings.php">
                <i class="material-icons">settings</i>
                <span class="menu-title">Settings</span>
                <div class="badge badge-success d-none"></div>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="material-icons">fingerprint</i>
                <span class="menu-title">Log Out</span>
                <div class="badge badge-success d-none"></div>
            </a>
        </li>

    </ul>
</nav>
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>