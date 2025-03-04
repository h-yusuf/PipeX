<div class="navbar-wrapper">
    <div class="navbar-content scroll-div">
        <div class="">
            <div class="main-menu-header">
                <img class="img-radius" src="{{ asset('icons/profile.png') }}" alt="User-Profile-Image">
                <div class="user-details d-flex justify-content-between align-items-center w-100" id="more-details">
                    <div class="d-flex flex-column">
                        <span style="font-size: 14px; color: #ffffff !important;">{{ Auth()->user()->username }}</span>
                        <span style="font-size: 12px; color: #dddddd;">{{ Auth()->user()->role->title }}</span>
                    </div>
                    <i class="fa fa-chevron-down m-l-5"></i>
                </div>
            </div>
            <div class="collapse" id="nav-user-link">
                <ul class="list-unstyled">
                    <li class="list-group-item">
                        <a href="#!"><i class="fas fa-cog m-r-5"></i>Settings</a>
                    </li>
                    <li class="list-group-item">
                        <a href="javascript:void(0)" onclick="$('#logout-form').submit();">
                            <i class="fas fa-sign-out-alt m-r-5"></i>Logout
                        </a>
                        <form action="{{ route('logout') }}" method="POST" id="logout-form">
                            @csrf
                        </form>
                    </li>
                    <form id="logout-form" action="" method="POST" class="d-none">
                    </form>
                </ul>
            </div>
        </div>

        <ul class="nav pcoded-inner-navbar">
            <li class="nav-item pcoded-menu-caption">
                <label>Navigation</label>
            </li>

            @can('admin_panel_access')
                <li class="nav-item">
                    <a href="{{ route('admin.home') }}" class="nav-link active">
                        <span class="pcoded-micon"><i class="fas fa-tachometer-alt fa-fw" aria-hidden="true"></i></i></span>
                        <span class="pcoded-mtext">Dashboard</span>
                    </a>
                </li>
            @endcan

            @can('admin_panel_access')
                <li class="nav-item">
                    <a href="" class="nav-link active">
                        <span class="pcoded-micon"><i class="fas fa-star fa-fw" aria-hidden="true"></i></i></span>
                        <span class="pcoded-mtext">Achievement</span>
                    </a>
                </li>
            @endcan


            <li class="nav-item pcoded-menu-caption">
                <label>Management</label>
            </li>

            @canany(['users_access', 'roles_access', 'permissions_access'])
                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link">
                        <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                        <span class="pcoded-mtext">User Management</span>
                    </a>
                    <ul class="pcoded-submenu">
                        @can('users_access')
                            <li><a href="{{ route('admin.users.index') }}">Users</a></li>
                        @endcan

                        @can('roles_access')
                            <li><a href="{{ route('admin.roles.index') }}">Roles</a></li>
                        @endcan

                        @can('permissions_access')
                            <li><a href="{{ route('admin.permissions.index') }}">Permissions</a></li>
                        @endcan
                    </ul>
                </li>
            @endcanany

            @canany('product_management')
                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link">
                        <span class="pcoded-micon"><i class="fas fa-database"></i></span>
                        <span class="pcoded-mtext">Data Master</span>
                    </a>
                    <ul class="pcoded-submenu">
                        @can('product_management')
                            <li><a href="{{ route('admin.products.index') }}">Product Management</a></li>
                        @endcan
                    </ul>
                </li>
            @endcanany

            @canany(['wo_management', 'operator_management'])
                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link">
                        <span class="pcoded-micon"><i class="fas fa-file-signature"></i></span>
                        <span class="pcoded-mtext">WO Management</span>
                    </a>
                    <ul class="pcoded-submenu">
                        @can('wo_management')
                            <li><a href="{{ route('admin.workorder') }}">Work Order Management</a></li>
                        @endcan

                        @can('operator_management')
                            <li><a href="{{ route('admin.workorder') }}">Operator Management</a></li>
                        @endcan

                    </ul>
                </li>
            @endcanany

        </ul>
    </div>
</div>