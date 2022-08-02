            
<nav class="sidebar sidebar-offcanvas sidebar-dark" id="sidebar" style=" z-index:4000 !important; background-image: linear-gradient(#000000, #13479d);">
    <ul class="nav">
        <!--  Profile thingy -->
        <li class="nav-item nav-profile">
            <img src="{{ asset('images') }}/logo.png" alt="profile image">
            <p class="text-center font-weight-medium">{{ Auth::user()->email }}</p>
        </li>
        <hr>
        <!--Navigation Items -->



        <!-- <li class="nav-item">
            <a class="nav-link" href="admins.php">
                <i class="material-icons">people_alt</i>
                <span class="menu-title">Admins</span>
                <div class="badge badge-success d-none"></div>
            </a>
        </li> -->

        <!-- <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="material-icons">event</i>
                <span class="menu-title">Dashboard</span>
                <div class="badge badge-success d-none"></div>
            </a>
        </li> -->

        <li class="nav-item">
            <a class="nav-link" href="{{ route('hubs') }}">
                <i class="material-icons">device_hub</i>
                <span class="menu-title">Hubs</span>
                <div class="badge badge-success d-none"></div>
            </a>
        </li>



        <li class="nav-item">
            <a class="nav-link" onclick="backUp();">
                <i class="material-icons">backup</i>
                <span class="menu-title">Backup</span>
                <div class="badge badge-success d-none"></div>
            </a>
        </li>

        <!-- <li class="nav-item">
            <a class="nav-link" href="settings.php">
                <i class="material-icons">settings</i>
                <span class="menu-title">Settings</span>
                <div class="badge badge-success d-none"></div>
            </a>
        </li> -->

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
<script>
function backUp(){
    Swal.fire({
        title: 'Backup',
        html: 'Please select an option below',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Restore Last Backup',
        denyButtonText: `Upload Current State To Backup`,
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            Swal.fire('Changes are reverted', '', 'info')

        } else if (result.isDenied) {
            Swal.fire('Saved!', '', 'success')

        }
    })
}
</script>