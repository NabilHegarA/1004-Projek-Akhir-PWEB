<header class="main-header">
    <div class="logo-section">
        <img src="{{ asset('images/logo.png') }}" alt="Logo HookPoint">
        <p>HookPoint - Club Pemancingan</p>
    </div>

    <div class="menu-toggle" onclick="toggleMenu()">☰</div>

    <nav class="navbar" id="navbarMenu">
        <ul>
            <li>
                <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">
                    Beranda
                </a>
            </li>

            <li>
                <a href="/lapak" class="{{ request()->is('lapak') ? 'active' : '' }}">
                    Lapak
                </a>
            </li>

            @auth
                <li>
                    <a href="/dashboard" class="{{ request()->is('dashboard') ? 'active' : '' }}">
                        Dashboard
                    </a>
                </li>

                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                </li>
            @endauth

            @guest
                <li>
                    <a href="/login" class="{{ request()->is('login') ? 'active' : '' }}">
                        Login
                    </a>
                </li>

                <li>
                    <a href="/register" class="{{ request()->is('register') ? 'active' : '' }}">
                        Register
                    </a>
                </li>
            @endguest
        </ul>
    </nav>
</header>
