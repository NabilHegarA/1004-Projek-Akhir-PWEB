<div class="sidebar close" id="sidebar">

    <div class="sidebar-header">
        <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
        <span class="menu-title">Menu</span>
    </div>

    <a href="/admin/dashboard" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
        <span class="icon">🏠</span>
        <span class="text">Dashboard</span>
    </a>

    <a href="/admin/profile" class="{{ request()->is('admin/profile*') ? 'active' : '' }}">
        <span class="icon">👤</span>
        <span class="text">Profil</span>
    </a>

    <a href="/admin/pengelolaan" class="{{ request()->is('admin/pengelolaan*') ? 'active' : '' }}">
        <span class="icon">🎣</span>
        <span class="text">Pengelolaan</span>
    </a>

    <a href="/admin/transaksiAdmin" class="{{ request()->is('admin/transaksiAdmin*') ? 'active' : '' }}">
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
