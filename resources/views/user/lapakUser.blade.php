@extends('layouts.user')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/lapakUser.css') }}">
@endsection

@section('content')
    <div class="content">
        @if(session('success'))
            <div class="success-msg">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="error-msg">
                {{ session('error') }}
            </div>
        @endif

        <h1 class="fade-up">Daftar Lapak Pemancingan</h1>
        <form id="filter-form" onsubmit="return false;">
            <div class="search-box">
                <input type="text" name="search" id="search" placeholder="Cari lapak..." value="{{ request('search') }}">
                <button>Cari</button>{{-- agak ga guna soalnya live search, cuma jelek klu dihapus --}}
            </div>

            <div class="filter-box">
                <div>
                    <label>Filter Status</label>
                    <select name="status" id="status">
                        <option value="">Semua Status</option>
                        <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="unavailable" {{ request('status') == 'unavailable' ? 'selected' : '' }}>Not Available</option>
                    </select>
                </div>

                <div>
                    <label>Filter Jenis</label>
                    <select name="jenis" id="jenis">
                        <option value="">Semua Jenis</option>
                        <option value="Lele" {{ request('jenis') == 'Lele' ? 'selected' : '' }}>Lele</option>
                        <option value="Nila" {{ request('jenis') == 'Nila' ? 'selected' : '' }}>Nila</option>
                        <option value="Gurame" {{ request('jenis') == 'Gurame' ? 'selected' : '' }}>Gurame</option>
                        <option value="Patin" {{ request('jenis') == 'Patin' ? 'selected' : '' }}>Patin</option>
                    </select>
                </div>
            </div>
        </form>

        <!-- GRID -->
        <div class="lapak-grid" id="lapak-grid">

            @forelse ($lapaks as $lapak)
                <article class="card">

                    {{-- GAMBAR --}}
                    <img src="{{ asset('uploads/' . $lapak->gambar) }}" alt="{{ $lapak->jenis }}">

                    {{-- NAMA --}}
                    <h3>{{ $lapak->nama }}</h3>

                    {{-- JENIS --}}
                    <p><strong>Jenis:</strong> Kolam {{ $lapak->jenis }}</p>

                    {{-- HARGA --}}
                    <p><strong>Harga:</strong> Rp {{ number_format($lapak->harga, 0, ',', '.') }} / hari</p>

                    {{-- DESKRIPSI --}}
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

                    {{-- STATUS --}}
                    <p class="status {{ $lapak->status }}" style="font-size: 16px; margin-bottom: -15px;">
                        Status: {{ $lapak->status == 'available' ? 'Available' : 'Not Available' }}
                    </p>

                    {{-- ACTION BUTTON --}}
                    <div class="user-btn">

                        <button
                            type="button"
                            class="btn-detail"

                            data-nama="{{ $lapak->nama }}"
                            data-jenis="{{ $lapak->jenis }}"
                            data-harga="{{ number_format($lapak->harga,0,',','.') }}"
                            data-gambar="{{ asset('uploads/' . $lapak->gambar) }}"
                            data-deskripsi="{!! nl2br(e($lapak->deskripsi)) !!}"
                            data-status="{{ $lapak->status }}"
                            data-booking="{{ route('booking.create', $lapak->id) }}"

                            onclick="openLapakModal(this)"
                        >
                            Detail
                        </button>

                    </div>

                </article>
            @empty
                <div class="empty-message">🔍 Tidak ada data lapak</div>
            @endforelse
        </div>
    </div>

    @include('components.modal-detail-lapak')
@endsection


@section('scripts')
<script>
    let timeout = null;

    function fetchLapak() {
        let search = document.getElementById("search")?.value || "";
        let status = document.getElementById("status")?.value || "";
        let jenis = document.getElementById("jenis")?.value || "";

        fetch(`/lapak/live-search?search=${search}&status=${status}&jenis=${jenis}`)
            .then(res => res.json())
            .then(data => {

            const container = document.getElementById("lapak-grid");

            if (!container) return;

            container.innerHTML = "";

            if (data.length === 0) {

                container.innerHTML = `
                    <div class="empty-message">
                        🔍 Tidak ada data lapak
                    </div>
                `;

                return;
            }

            data.forEach(lapak => {

                let deskripsiArray = lapak.deskripsi
                    ? lapak.deskripsi.split('\n').filter(item => item.trim() !== '')
                    : [];

                let deskripsiPreview = '';

                deskripsiArray.slice(0, 3).forEach(item => {
                    deskripsiPreview += `<li>${item}</li>`;
                });

                if(deskripsiArray.length > 3){
                    deskripsiPreview += `
                        <li class="more-desc">
                            +${deskripsiArray.length - 3} lainnya
                        </li>
                    `;
                }

                container.innerHTML += `
                    <article class="card">

                        <img
                            src="/uploads/${lapak.gambar}"
                            alt="${lapak.nama}"
                        >

                        <h3>${lapak.nama}</h3>

                        <p>
                            <strong>Jenis:</strong>
                            Kolam ${lapak.jenis}
                        </p>

                        <p>
                            <strong>Harga:</strong>
                            Rp ${Number(lapak.harga).toLocaleString('id-ID')} / hari
                        </p>

                        <ul class="desc-list">
                            ${deskripsiPreview}
                        </ul>

                        <p
                            class="status ${lapak.status}"
                            style="font-size:16px; margin-bottom:-15px;"
                        >
                            Status:
                            ${
                                lapak.status === 'available'
                                ? 'Available'
                                : 'Not Available'
                            }
                        </p>

                        <div class="user-btn">

                            <button
                                type="button"
                                class="btn-detail"

                                data-nama="${lapak.nama}"
                                data-jenis="${lapak.jenis}"
                                data-harga="${Number(lapak.harga).toLocaleString('id-ID')}"
                                data-gambar="/uploads/${lapak.gambar}"

                                data-deskripsi="${lapak.deskripsi
                                    .replace(/"/g, '&quot;')
                                    .replace(/\n/g, '&#10;')}"

                                data-status="${lapak.status}"

                                data-booking="/user/booking/${lapak.id}"

                                onclick="openLapakModal(this)"
                            >
                                Detail
                            </button>

                        </div>

                    </article>
                `;
            });
        });
    }

    // debounce search
    document.addEventListener("DOMContentLoaded", function () {

        const search = document.getElementById("search");
        const status = document.getElementById("status");
        const jenis = document.getElementById("jenis");

        if (search) {
            search.addEventListener("keyup", function () {
                clearTimeout(timeout);
                timeout = setTimeout(fetchLapak, 300);
            });
        }

        if (status) {
            status.addEventListener("change", fetchLapak);
        }

        if (jenis) {
            jenis.addEventListener("change", fetchLapak);
        }
    });

    setTimeout(() => {
        const msg = document.querySelector('.success-msg', 'error-msg');

        if (msg) {
            msg.style.opacity = '0';
            msg.style.transition = '0.5s ease';

            setTimeout(() => {
                msg.remove();
            }, 500);
        }
    }, 1600);

    /* ================= MODAL LAPAK ================= */

    function openLapakModal(button){

        const modal = document.getElementById("lapakModal");
        modal.classList.add("active");

        document.getElementById("modalLapakNama").innerText =
            button.dataset.nama;
        document.getElementById("modalLapakJenis").innerText =
            button.dataset.jenis;
        document.getElementById("modalLapakHarga").innerText =
            "Rp " + button.dataset.harga;
        document.getElementById("modalLapakDesc").innerHTML =
            button.dataset.deskripsi;
        document.getElementById("modalLapakImg").src =
            button.dataset.gambar;
        document.getElementById("modalLapakStatus").innerText =
            button.dataset.status === "available"
            ? "Available"
            : "Not Available";

        const bookingBtn = document.getElementById("modalBookingBtn");

        if(button.dataset.status === "available"){

            bookingBtn.href = button.dataset.booking;
            bookingBtn.innerText = "Booking Sekarang";

            bookingBtn.classList.remove("disabled-btn");

            bookingBtn.style.pointerEvents = "auto";
            bookingBtn.style.opacity = "1";

        }else{

            bookingBtn.href = "#";
            bookingBtn.innerText = "Tidak Tersedia";

            bookingBtn.classList.add("disabled-btn");

            bookingBtn.style.pointerEvents = "none";
            bookingBtn.style.opacity = "0.6";
        }
    }

    function closeLapakModal(){
        document.getElementById("lapakModal")
            .classList.remove("active");
    }
</script>
@endsection
