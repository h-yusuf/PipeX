<header class="navbar pcoded-header navbar-expand-lg navbar-light header-dark">
    @if(auth()->user()->role_id != 3)
        <div class="m-header">
            <a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
            <a href="#!" class="b-brand">
            </a>
            <a href="#!" class="mob-toggler">
                <i class="feather icon-more-vertical"></i>
            </a>
        </div>
    @else
        <a href="javascript:void(0)" onclick="$('#logout-form').submit();">
            <i class="fas fa-sign-out-alt m-r-5"></i>Logout
        </a>
        <form action="{{ route('logout') }}" method="POST" id="logout-form">
            @csrf
        </form>
    @endif  
    <div class="collapse navbar-collapse">
       
        <ul class="navbar-nav ml-auto">

            <li class="nav-item">
                <span id="realtime-clock" style="font-size: 1.2rem; font-weight: 700;"
                    class="nav-link text-white"></span>
            </li>
            <li class="nav-item">
                <span style="font-size: 1.1rem; font-weight: 500;" class="nav-link text-white">
                    {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                </span>
            </li>
            <li>
                <a id="notification-box-trigger"
                    class="notification-box position-relative d-flex align-items-center justify-content-center p-3 rounded-circle mt-2"
                    style="" href="#">
                    <i class="fa fa-bell fa-lg"></i>
                    <span id="notification-dot"
                        class="position-absolute mt-3 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"
                        style="display: none;"></span>
                </a>
            </li>
        </ul>
    </div>
</header>
<script>


    function updateClock() {
        const now = new Date();
        const hours = now.getHours().toString().padStart(2, '0');
        const minutes = now.getMinutes().toString().padStart(2, '0');
        const seconds = now.getSeconds().toString().padStart(2, '0');
        const timeString = `${hours}:${minutes}:${seconds}`;
        document.getElementById('realtime-clock').textContent = timeString;
    }

    setInterval(updateClock, 1000);
    updateClock();

    document.getElementById('notification-box-trigger').addEventListener('click', function () {
        notificationSeen = true;
        $('#notification-dot').hide();
        console.log('Notifikasi telah dilihat');
    });
</script>