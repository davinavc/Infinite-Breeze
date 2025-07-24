<!-- Mobile sidebar menu button -->
<button class="sidebar-menu-button">
    <span class="material-symbols-outlined">menu</span>
</button>

<aside class="sidebar">
    <!-- sidebar header -->
    <header class="sidebar-header">
        <a href="{{ route('dashboard.staff') }}" class="header-logo">
            <img src="{{ asset('img/logo-02_white.png') }}" alt="Infinite Organizer">
        </a>
        <button class="sidebar-toggler">
            <span class="material-symbols-outlined">chevron_left</span>
        </button>
    </header>
    <nav class="sidebar-nav">
        <!-- Primary Top Nav -->
        <ul class="nav-list primary-nav">
            <li class="nav-item">
                <a href="{{ route('dashboard.staff') }}" class="nav-link">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span class="nav-label">Dashboard</span>
                </a>
                <!-- Dropdown Menu -->
                <ul class="dropdown-menu">
                <li class="nav-item">
                        <a href="{{ route('dashboard.staff') }}" class="nav-link dropdown-title">Dashboard</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ route('dashboard.staff.komisi') }}" class="nav-link">
                <span class="material-symbols-outlined">attach_money</span>
                    <span class="nav-label">Commision</span>
                </a>
                <ul class="dropdown-menu">
                <li class="nav-item">
                        <a href="{{ route('dashboard.staff.komisi') }}" class="nav-link dropdown-title">Commision</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ route('dashboard.staff.event') }}" class="nav-link">
                    <span class="material-symbols-outlined">event</span>
                    <span class="nav-label">Event</span>
                </a>
                <ul class="dropdown-menu">
                <li class="nav-item">
                        <a href="{{ route('dashboard.staff.event') }}" class="nav-link dropdown-title">Blog</a>
                    </li>
                </ul>
            </li>
            <!-- Dropdown -->
            <li class="nav-item dropdown-container">
                <a href="" class="nav-link dropdown-toggle">
                    <span class="material-symbols-outlined">database</span>
                    <span class="nav-label">Data</span>
                    <span class="dropdown-icon material-symbols-outlined">keyboard_arrow_down</span>
                </a>
                <!-- Dropdown Menu -->
                <ul class="dropdown-menu">
                <li class="nav-item">
                        <a href="" class="nav-link dropdown-title">Data</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard.staff.schedule') }}" class="nav-link dropdown-link">Schedule</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard.staff.tenant') }}" class="nav-link dropdown-link">Tenant</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown-container">
                <a href="" class="nav-link dropdown-toggle">
                    <span class="material-symbols-outlined">history</span>
                    <span class="nav-label">History</span>
                    <span class="dropdown-icon material-symbols-outlined">keyboard_arrow_down</span>
                </a>
                <!-- Dropdown Menu -->
                <ul class="dropdown-menu">
                <li class="nav-item">
                        <a href="" class="nav-link dropdown-title">History</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard.staff.eventhist') }}" class="nav-link dropdown-link">Event</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ route('dashboard.staff.setting') }}" class="nav-link">
                    <span class="material-symbols-outlined">settings</span>
                    <span class="nav-label">Setting</span>
                </a>
                <ul class="dropdown-menu">
                <li class="nav-item">
                        <a href="" class="nav-link dropdown-title">Setting</a>
                    </li>
                </ul>
            </li>
        </ul>
        <ul class="nav-list secondary-nav">
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link">
                        <span class="material-symbols-outlined">logout</span>
                        <span class="nav-label">Logout</span>
                    </button>
                </form>
            </li>
        </ul>
</aside>