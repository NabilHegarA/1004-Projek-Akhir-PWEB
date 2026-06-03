<div class="navbar">
    <button class="mobile-toggle" onclick="toggleMobileSidebar()">
        ☰
    </button>

    <div class="left">
        <img src="{{ asset('images/logo.png') }}" alt="Logo HookPoint">
        <span class="brand">HookPoint - Club Pemancingan</span>
    </div>

    <div class="right">
        @if(auth()->check())
            <p>Selamat datang, {{ auth()->user()->name }}</p>
        @endif
    </div>
</div>
