@extends('layouts.main')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/landing-page.css') }}">
@endsection

@section('content')
        <section class="hero">
            <h1 class="fade-up">Reservasi Lapak HookPoint - Club Pemancingan</h1>
            <h2 class="fade-up">Rasakan Pengalaman Memancing Eksklusif</h2>
            <h3 class="fade-up">Buka 09.00 - 16.00 WIB</h3>
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
        </section>

        <section class="container">
            <h2 class="fade-up">Lapak Populer</h2>

            <div class="slider-wrapper">
                <button class="nav-btn left" onclick="scrollLeft()">❮</button>

                <div class="lapak-slider" id="slider">
                    @foreach ($lapaks as $lapak)
                        <article class="card">
                            <img src="{{ asset('uploads/' . $lapak->gambar) }}" alt="{{ $lapak->jenis }}">

                            <h3>{{ $lapak->nama }}</h3>

                            <p><strong>Jenis:</strong> Kolam {{ $lapak->jenis }}</p>

                            <p><strong>Harga:</strong> Rp {{ number_format($lapak->harga, 0, ',', '.') }} / hari</p>

                            @php
                                $deskripsiList = array_filter(explode("\n", $lapak->deskripsi));
                            @endphp

                            <ul class="desc-list">

                                @foreach ($deskripsiList as $index => $item)

                                    @if($index < 3)
                                        <li>{{ $item }}</li>
                                    @endif

                                @endforeach

                                @if(count($deskripsiList) > 3)
                                    <li class="more-desc">
                                        +{{ count($deskripsiList) - 3 }} lainnya
                                    </li>
                                @endif

                            </ul>

                            <p class="status {{ $lapak->status }}">
                                Status: {{ $lapak->status == 'available' ? 'Available' : 'Not Available' }}
                            </p>

                            <button
                                type="button"
                                class="btn"
                                onclick="openLapakModal(
                                    `{{ $lapak->nama }}`,
                                    `{{ $lapak->jenis }}`,
                                    `{{ number_format($lapak->harga,0,',','.') }}`,
                                    `{{ asset('uploads/' . $lapak->gambar) }}`,
                                    `{!! nl2br(e($lapak->deskripsi)) !!}`,
                                    `{{ $lapak->status }}`,
                                    `/login`
                                )"
                            >
                                Detail
                            </button>
                        </article>
                    @endforeach
                </div>

                <button class="nav-btn right" onclick="scrollRight()">❯</button>
            </div>

            <div class="table">
                <h2 class="fade-up">Data Kolam</h2>
                <table class="fade-up data-table">

                    <thead>
                    <tr>
                    <th>Kolam</th>
                    <th>Jenis Ikan</th>
                    <th>Kapasitas</th>
                    <th>Status</th>
                    </tr>
                    </thead>

                    <tbody>
                        @foreach ($rekapLapak as $data)

                            <tr>
                                <td>Kolam {{ chr(64 + $loop->iteration) }}</td>
                                <td>{{ $data['jenis'] }}</td>
                                <td>{{ $data['total'] }}</td>
                                <td>
                                    @if($data['available'] > 0)
                                        {{ $data['available'] }} Tersedia
                                    @else
                                        Penuh
                                    @endif
                                </td>
                            </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
@include('components.modal-detail-lapak')
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {

        const slider = document.getElementById('slider');
        if (!slider) return;

        const scrollStep = 320;
        const delay = 2000;
        let interval;

        window.scrollLeft = function () {
            clearInterval(interval);
            slider.scrollBy({ left: -scrollStep, behavior: 'smooth' });
        }

        window.scrollRight = function () {
            clearInterval(interval);
            slider.scrollBy({ left: scrollStep, behavior: 'smooth' });
        }

        function autoScroll() {
            if (slider.scrollLeft + slider.clientWidth >= slider.scrollWidth) {
                slider.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                slider.scrollBy({ left: scrollStep, behavior: 'smooth' });
            }
        }

        function startAuto() {
            interval = setInterval(autoScroll, delay);
        }

        function stopAuto() {
            clearInterval(interval);
        }

        startAuto();

        slider.addEventListener('mouseenter', stopAuto);
        slider.addEventListener('mouseleave', startAuto);
    });

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

    /* =========================
    DETAIL MODAL
    ========================= */
    function openLapakModal(
        nama,
        jenis,
        harga,
        gambar,
        deskripsi,
        status,
        bookingUrl
    ){
        const modal = document.getElementById("lapakModal");

        modal.classList.add("show");

        document.getElementById("modalLapakNama").innerText = nama;
        document.getElementById("modalLapakJenis").innerText = jenis;
        document.getElementById("modalLapakHarga").innerText = "Rp " + harga;
        document.getElementById("modalLapakDesc").innerHTML = deskripsi;
        document.getElementById("modalLapakImg").src = gambar;

        document.getElementById("modalLapakStatus").innerText =
            status === "available"
            ? "Available"
            : "Not Available";

        document.getElementById("modalBookingBtn").href = bookingUrl;
    }

    function closeLapakModal(){
        document.getElementById("lapakModal")
            .classList.remove("show");
    }
</script>
@endsection

