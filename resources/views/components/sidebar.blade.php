<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{url('/')}}" class="text-primary">Vehicle Tracker</a>
        </div>
        <ul class="sidebar-menu">
            <li class='{{ Request::is('dashboard') ? 'active' : '' }}'>
                <a class="nav-link" href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
            </li>
            <li class="menu-header"><i class="fas fa-exchange-alt"></i> Transactions</li>
            <li class="nav-item dropdown {{ Request::is('bookings') || Request::is('booking-logs') || Request::is('booking-approvals') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-book"></i> <span>Bookings</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('bookings') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('bookings.index') }}"><i class="fas fa-book"></i> Bookings</a>
                    </li>
                    <li class='{{ Request::is('booking-logs') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('booking-logs.index') }}"><i class="fas fa-history"></i> Booking Logs</a>
                    </li>
                    <li class='{{ Request::is('booking-approvals') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('booking-approvals.index') }}"><i class="fas fa-user-check"></i> Booking Approvals</a>
                    </li>
                </ul>
            </li>
            <li class='{{ Request::is('service-logs') ? 'active' : '' }}'>
                <a class="nav-link" href="{{ route('service-logs.index') }}"><i class="fas fa-wrench"></i> <span>Service Logs</span></a>
            </li>
            <li class='{{ Request::is('fuel-logs') ? 'active' : '' }}'>
                <a class="nav-link" href="{{ route('fuel-logs.index') }}"><i class="fas fa-gas-pump"></i> <span>Fuel Logs</span></a>
            </li>
            <li class='{{ Request::is('documents') ? 'active' : '' }}'>
                <a class="nav-link" href="{{ route('documents.index') }}"><i class="fas fa-file-alt"></i> <span>Documents</span></a>
            </li>
            <li class="dropdown-divider"></li>
            <li class="menu-header"><i class="fas fa-database"></i> Master Data</li>
            <li class='{{ Request::is('vehicles') ? 'active' : '' }}'>
                <a class="nav-link" href="{{ route('vehicles.index') }}"><i class="fas fa-truck-monster"></i> <span>Vehicles</span></a>
            </li>
            <li class='{{ Request::is('vehicle-types') ? 'active' : '' }}'>
                <a class="nav-link" href="{{ route('vehicle-types.index') }}"><i class="fas fa-car-side"></i> <span>Vehicle Types</span></a>
            </li>
            <li class='{{ Request::is('drivers') ? 'active' : '' }}'>
                <a class="nav-link" href="{{ route('drivers.index') }}"><i class="fas fa-id-badge"></i> <span>Drivers</span></a>
            </li>
            <li class='{{ Request::is('regions') ? 'active' : '' }}'>
                <a class="nav-link" href="{{ route('regions.index') }}"><i class="fas fa-building"></i> <span>Regions</span></a>
            </li>
            <li class='{{ Request::is('roles') ? 'active' : '' }}'>
                <a class="nav-link" href="{{ route('roles.index') }}"><i class="fas fa-user-tag"></i> <span>Roles</span></a>
            </li>
            <li class='{{ Request::is('users') ? 'active' : '' }}'>
                <a class="nav-link" href="{{ route('users.index') }}"><i class="fas fa-users-gear"></i> <span>Users</span></a>
            </li>
            <li class="dropdown-divider"></li>
            <li class="menu-header"><i class="fas fa-chart-bar"></i> Reports & Logs</li>
            <li class='{{ Request::is('app-logs') ? 'active' : '' }}'>
                <a class="nav-link" href="{{ route('app-logs.index') }}"><i class="fas fa-clipboard-list"></i> <span>App Logs</span></a>
            </li>
            <li class="dropdown-divider"></li>
            <li class="menu-header"><i class="fas fa-cogs"></i> Settings</li>
            <li class='{{ Request::is('settings') ? 'active' : '' }}'>
                <a class="nav-link" href="{{ route('settings.index') }}"><i class="fas fa-gears"></i> <span>Settings</span></a>
            </li>
        </ul>
    </aside>
</div>
