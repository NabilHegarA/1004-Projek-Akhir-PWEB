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
            <span>Selamat Datang,</span>
            <strong>{{ auth()->user()->name }}</strong>
        @endif
    </div>
</div>
