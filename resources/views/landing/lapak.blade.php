@extends('layouts.main')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/lapak.css') }}">
@endsection

@section('content')
<section class="container">
    <h1 class="fade-up">Daftar Lapak Pemancingan</h1>
        <form id="filter-form" onsubmit="return false;">

            <div class="search-box fade-up">
                <input type="text" name="search" id="search" placeholder="Cari lapak..." value="{{ request('search') }}">
                <button>Cari</button>{{-- agak ga guna soalnya live search, cuma jelek klu dihapus --}}
            </div>

            <div class="filter-box fade-up">
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

        <div class="lapak-grid" id="lapak-grid">
            @forelse ($lapaks as $lapak)
                <article class="card fade-card">
                    <div class="card-content">
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
                    </div>

                    <div class="card-footer">
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
                    </div>
                </article>

            @empty
                <div class="empty-message">Pencarian tidak tersedia</div>

            @endforelse
        </div>
</section>
@include('components.modal-detail-lapak')
@endsection

@section('scripts')
<script>
let timeout = null;

/* =========================
   FADE ANIMATION (FIXED)
========================= */
function showCardsOnScroll() {
    const cards = document.querySelectorAll('.fade-card'); // 🔥 harus diambil ulang

    const triggerBottom = window.innerHeight * 0.9;

    cards.forEach((card, index) => {
        const cardTop = card.getBoundingClientRect().top;

        if (cardTop < triggerBottom) {
            setTimeout(() => {
                card.classList.add('show');
            }, index * 100);
        }
    });
}

window.addEventListener('scroll', showCardsOnScroll);
window.addEventListener('load', showCardsOnScroll);

/* =========================
   LIVE SEARCH FETCH
========================= */
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

            if (!data.length) {
                container.innerHTML = `
                    <div class="empty-message">
                        🔍 Tidak ada data lapak
                    </div>
                `;
                return;
            }

            data.forEach(lapak => {
                container.innerHTML += `
                    <article class="card fade-card">

                        <div class="card-content">
                            <img src="/uploads/${lapak.gambar}" alt="${lapak.nama}">

                            <h3>${lapak.nama}</h3>

                            <p><strong>Jenis:</strong> Kolam ${lapak.jenis}</p>

                            <p><strong>Harga:</strong> Rp ${Number(lapak.harga).toLocaleString()}</p>

                            <p>${lapak.deskripsi}</p>
                        </div>

                        <div class="card-footer">
                            <p class="status ${lapak.status}">
                                Status: ${lapak.status === 'available' ? 'Available' : 'Not Available'}
                            </p>

                            <a href="/login" class="btn ${lapak.status === 'unavailable' ? 'disabled' : ''}">
                                Booking Sekarang
                            </a>
                        </div>

                    </article>
                `;
            });

            // 🔥 PENTING: jalankan ulang animasi setelah render
            showCardsOnScroll();
        });
}

/* =========================
   EVENT LISTENER
========================= */
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

    if (status) status.addEventListener("change", fetchLapak);
    if (jenis) status.addEventListener("change", fetchLapak);
});

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
