@extends('layouts.user')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/dashboardUser.css') }}">
@endsection

@section('content')

<section class="hero">
    <div class="overlay">
        <h1>Selamat Datang di</h1>
        <h2>Reservasi Lapak HookPoint - Club Pemancingan</h2>
        <p>Rasakan Pengalaman Memancing Eksklusif</p>
        <span>Buka 09.00 - 17.00 WIB</span>
        <div class="weather-mini">
            <span id="icon" class="weather-mini-icon">⛅</span>

            <span id="temp" class="weather-mini-temp">31°C</span>

            <span class="weather-mini-text">
                Cerah — Cocok untuk memancing
            </span>

            <span id="weather-loading" class="weather-mini-loading">
                Loading...
            </span>
        </div>
    </div>
</section>

<!-- BOOKING CTA -->
<section class="booking content">
    <h3>Mulai Booking</h3>
    <p>Yuk pesan lapak sekarang dan nikmati pengalaman memancing terbaik 🎣</p>

    <a href="{{ route('lapak.user') }}" class="btn-booking">
        Lihat Lapak
    </a>
</section>

<!-- STATISTIK -->
<section class="stats">

    {{-- TOTAL BOOKING --}}
    <a href="{{ route('user.transaksi', ['tab' => 'pending']) }}" class="card">
        <h4>Total Booking</h4>
        <h1>{{ $total ?? 0 }}</h1>
    </a>

    {{-- MENUNGGU --}}
    <a href="{{ route('user.transaksi', ['tab' => 'pending']) }}" class="card">
        <h4>Menunggu</h4>
        <h1>{{ $pending ?? 0 }}</h1>
    </a>

    {{-- DIKONFIRMASI --}}
    <a href="{{ route('user.transaksi', ['tab' => 'confirmed']) }}" class="card">
        <h4>Dikonfirmasi</h4>
        <h1>{{ $confirmed ?? 0 }}</h1>
    </a>

    {{-- DIBATALKAN --}}
    <a href="{{ route('user.transaksi', ['tab' => 'selesai']) }}" class="card">
        <h4>Dibatalkan</h4>
        <h1>{{ $canceled ?? 0 }}</h1>
    </a>

    {{-- DITOLAK --}}
    <a href="{{ route('user.transaksi', ['tab' => 'selesai']) }}" class="card">
        <h4>Ditolak</h4>
        <h1>{{ $rejected ?? 0 }}</h1>
    </a>

    {{-- SELESAI --}}
    <a href="{{ route('user.transaksi', ['tab' => 'selesai']) }}" class="card">
        <h4>Selesai</h4>
        <h1>{{ $completed ?? 0 }}</h1>
    </a>

</section>

@endsection

@section('scripts')
<script>
    async function loadWeather() {
        try {
            const res = await fetch("https://wttr.in/Jember?format=j1");
            const data = await res.json();

            const current = data.current_condition[0];

            const temp = current.temp_C;
            const descRaw = current.weatherDesc[0].value.toLowerCase();

            let icon = "⛅";
            let text = "Cerah — Cocok untuk memancing";

            if (descRaw.includes("sun") || descRaw.includes("clear")) {
                icon = "☀️";
                text = "Cerah — Cocok untuk memancing";
            }
            else if (descRaw.includes("rain")) {
                icon = "🌧️";
                text = "Hujan — Kurang cocok untuk memancing";
            }
            else if (descRaw.includes("cloud")) {
                icon = "☁️";
                text = "Berawan — Masih aman untuk memancing";
            }
            else if (descRaw.includes("storm")) {
                icon = "⛈️";
                text = "Badai — Tidak disarankan memancing";
            }

            document.getElementById("icon").innerText = icon;
            document.getElementById("temp").innerText = temp + "°C";

            document.querySelector(".weather-mini-text").innerText = text;

            document.getElementById("weather-loading").style.display = "none";

        } catch (err) {
            document.getElementById("weather-loading").innerText =
                "Gagal memuat cuaca";
        }
    }

    loadWeather();
</script>
@endsection
