<div class="sidebar close" id="sidebar">

    <div class="sidebar-header">
        <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
        <span class="menu-title">Menu</span>
    </div>

    @php
        $user = session('user');
        $username = request('username') ?? ($user['username'] ?? '');
    @endphp

    <a href="/user/dashboard" class="{{ request()->is('user/dashboard') ? 'active' : '' }}">
        <span class="icon">🏠</span>
        <span class="text">Dashboard</span>
    </a>

    <a href="/user/profileUser" class="{{ request()->is('user/profileUser*') ? 'active' : '' }}">
        <span class="icon">👤</span>
        <span class="text">Profil</span>
    </a>

    <a href="/user/lapakUser" class="{{ request()->is('user/lapakUser*') ? 'active' : '' }}">
        <span class="icon">🎣</span>
        <span class="text">Lapak</span>
    </a>

    <a href="/user/transaksiUser" class="{{ request()->is('user/transaksiUser*') ? 'active' : '' }}">
        <span class="icon">📄</span>
        <span class="text">Transaksi</span>
    </a>

    <div class="sidebar-bottom">
        <hr>
        <a href="#" onclick="openModal()">
            <span class="icon">🚪</span>
            <span class="text">Logout</span>
        </a>

        <form id="logoutForm" method="POST" action="/logout" style="display:none;">
            @csrf
        </form>
    </div>
</div>
