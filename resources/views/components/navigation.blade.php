<nav class="navbar navbar-expand-lg bg-nav">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="{{ asset('img/logo_white.png') }}" class="logo-img" alt=""></a>
            <button class="navbar-toggler bg-nav" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active text-white" aria-current="page" href="{{ route('blog.home')}}">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Event
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('blog.upcoming')}}">Up Coming Event</a></li>
                        <li><a class="dropdown-item" href="{{ route('blog.ongoing')}}">On Going Event</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    News
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('blog.news')}}">News</a></li>
                        <li><a class="dropdown-item" href="{{ route('blog.event')}}">Highlight Event</a></li>
                        <li><a class="dropdown-item" href="{{ route('blog.tips')}}">Tips</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('blog.aboutus')}}">About Us</a>
                </li>
                
            </ul>
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"/>
                <button class="btn btn-outline-light" type="submit">Search</button>
            </form>
            @if (Route::has('login'))
                <nav class="space-x-4 ">
                    @auth
                        @if (Auth::user()->role == 'Admin')
                            <a href="{{ route('dashboard.admin') }}" class="btn btn-light ms-2 hover:text-red-500">Dashboard</a>
                        @elseif (Auth::user()->role == 'Staff')
                            <a href="{{ route('dashboard.staff') }}" class="btn btn-light ms-2 hover:text-red-500">Staff</a>
                        @elseif (Auth::user()->role == 'Tenant')
                            <a href="{{ route('dashboard.tenant') }}" class="btn btn-light ms-2 hover:text-red-500">Tenant</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-light ms-3 me-1 d-inline-flex hover:text-red-500 justify-content-center" >
                            <span class="material-symbols-outlined black">person</span>Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn me-3 btn-outline-light d-inline-flex hover:text-red-500">
                                <span class="material-symbols-outlined">person_edit</span>Register</a>
                        @endif
                    @endauth
                </nav>
            @endif
            </div>
        </div>
    </nav>