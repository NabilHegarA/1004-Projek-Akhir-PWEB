<div class="navbar">
    <div class="left">
        <img src="{{ asset('images/logo.png') }}" alt="Logo HookPoint">
        <span class="brand">HookPoint - Club Pemancingan</span>
    </div>

    <div class="right">
        @if(auth()->check())
            <p>Selamat datang, {{ auth()->user()->name }}</p>
        @endif
        <label class="switch">
            <input type="checkbox" id="darkToggle" onclick="toggleDarkMode()">
            <span class="slider"></span>
        </label>
    </div>
</div>
