<!-- Mobile sidebar menu button -->
<button class="sidebar-menu-button">
    <span class="material-symbols-outlined">menu</span>
</button>

<aside class="sidebar">
    <!-- sidebar header -->
    <header class="sidebar-header">
        <a href="{{ route('dashboard.admin') }}" class="header-logo">
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
                <a href="{{ route('dashboard.admin') }}" class="nav-link">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span class="nav-label">Dashboard</span>
                </a>
                <!-- Dropdown Menu -->
                <ul class="dropdown-menu">
                <li class="nav-item">
                        <a href="{{ route('dashboard.admin') }}" class="nav-link dropdown-title">Dashboard</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ route('dashboard.admin.komisi') }}" class="nav-link">
                <span class="material-symbols-outlined">attach_money</span>
                    <span class="nav-label">Commision</span>
                </a>
                <ul class="dropdown-menu">
                <li class="nav-item">
                        <a href="{{ route('dashboard.admin.komisi') }}" class="nav-link dropdown-title">Commision</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ route('dashboard.admin.blog') }}" class="nav-link">
                    <span class="material-symbols-outlined">web</span>
                    <span class="nav-label">Blog</span>
                </a>
                <ul class="dropdown-menu">
                <li class="nav-item">
                        <a href="{{ route('dashboard.admin.blog') }}" class="nav-link dropdown-title">Blog</a>
                    </li>
                </ul>
            </li>
            <!-- Dropdown Data-->
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
                        <a href="{{ route('dashboard.admin.event') }}" class="nav-link dropdown-link">Event</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard.admin.staff') }}" class="nav-link dropdown-link">Staff</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard.admin.tenant') }}" class="nav-link dropdown-link">Tenant</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard.admin.dept') }}" class="nav-link dropdown-link">Department</a>
                    </li>
                </ul>
            </li>

            <!-- Dropdown Verification -->
            <li class="nav-item dropdown-container">
                <a href="" class="nav-link dropdown-toggle">
                    <span class="material-symbols-outlined">verified_user</span>
                    <span class="nav-label">Verification</span>
                    <span class="dropdown-icon material-symbols-outlined">keyboard_arrow_down</span>
                </a>
                <!-- Dropdown Menu -->
                <ul class="dropdown-menu">
                    <li class="nav-item">
                        <a href="" class="nav-link dropdown-title">Verification</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard.admin.schedule') }}" class="nav-link dropdown-link">Schedule</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard.admin.registration') }}" class="nav-link dropdown-link">Registration</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard.admin.transaction') }}" class="nav-link dropdown-link">Transaction</a>
                    </li>
                </ul>
            </li>

            <!-- Dropdown History -->
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
                        <a href="{{ route('dashboard.admin.eventhist') }}" class="nav-link dropdown-link">Event</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard.admin.transactionhist') }}" class="nav-link dropdown-link">Transaction</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard.admin.staffhist') }}" class="nav-link dropdown-link">Staff</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard.admin.tenanthist') }}" class="nav-link dropdown-link">Tenant</a>
                    </li>
                </ul>
            </li>

            <!-- Dropdown Report -->
            <li class="nav-item dropdown-container">
                <a href="" class="nav-link dropdown-toggle">
                    <span class="material-symbols-outlined">description</span>
                    <span class="nav-label">Report</span>
                    <span class="dropdown-icon material-symbols-outlined">keyboard_arrow_down</span>
                </a>
                <!-- Dropdown Menu -->
                <ul class="dropdown-menu">
                <li class="nav-item">
                        <a href="" class="nav-link dropdown-title">Report</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard.admin.repevent') }}" class="nav-link dropdown-link">Event</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard.admin.reptransaction') }}" class="nav-link dropdown-link">Transaction</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard.admin.repkomisi') }}" class="nav-link dropdown-link">Commision</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard.admin.reptenant') }}" class="nav-link dropdown-link">Tenant</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ route('dashboard.admin.setting') }}" class="nav-link">
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