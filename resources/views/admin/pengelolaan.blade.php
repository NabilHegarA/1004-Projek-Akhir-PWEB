@extends('layouts.admin')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/pengelolaan.css') }}">
@endsection

@section('content')
<section class="content">

    @if(session('success'))
        <div class="success-msg">
            {{ session('success') }}
        </div>
    @endif

    <h2>Daftar Lapak Pemancingan</h2>

    <form id="filter-form" onsubmit="return false;">

        <div class="search-box">
            <input type="text" name="search" id="search" placeholder="Cari lapak..." value="{{ request('search') }}">
            <button>Cari</button>
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

        <div class="content-header">
            <a href="{{ url('/admin/tambahlapak') }}" class="btn-tambah">
                + Tambah Data Lapak
            </a>
        </div>

    </form>

    <div class="lapak-grid" id="lapak-grid">

        @forelse ($lapaks as $lapak)
            <article class="card">
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

                    <p class="status {{ $lapak->status }}" style="font-size: 16px; margin-bottom:-10px">
                        Status: {{ $lapak->status == 'available' ? 'Available' : 'Not Available' }}
                    </p>

                    <div class="admin-btn">
                        <button
                            type="button"
                            class="btn-detail"
                            onclick="openLapakModal(
                                `{{ $lapak->nama }}`,
                                `{{ $lapak->jenis }}`,
                                `{{ number_format($lapak->harga,0,',','.') }}`,
                                `{{ asset('uploads/' . $lapak->gambar) }}`,
                                `{!! nl2br(e($lapak->deskripsi)) !!}`,
                                `{{ $lapak->status }}`,
                                `{{ url('/admin/editlapak/' . $lapak->id) }}`
                            )"
                        >
                            Detail
                        </button>
                    </div>

                </div>
            </article>

        @empty
            <div class="empty-message">🔍 Tidak ada data lapak</div>
        @endforelse

    </div>
</section>
@include('components.modal-detail-lapak', ['isAdmin' => true])
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

                    <div class="card-content">

                        <img
                            src="/uploads/${lapak.gambar}"
                            alt="${lapak.jenis}"
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

                    </div>

                    <div class="card-footer">

                        <p
                            class="status ${lapak.status}"
                            style="font-size:16px; margin-bottom:-10px"
                        >
                            Status:
                            ${
                                lapak.status === 'available'
                                ? 'Available'
                                : 'Not Available'
                            }
                        </p>

                        <div class="admin-btn">

                            <button
                                type="button"
                                class="btn-detail"

                                onclick="openLapakModal(
                                    '${lapak.nama.replace(/'/g, "\\'")}',
                                    '${lapak.jenis.replace(/'/g, "\\'")}',
                                    '${Number(lapak.harga).toLocaleString('id-ID')}',
                                    '/uploads/${lapak.gambar}',
                                    '${lapak.deskripsi
                                        .replace(/'/g, "\\'")
                                        .replace(/\n/g, "<br>")}',
                                    '${lapak.status}',
                                    '/admin/editlapak/${lapak.id}'
                                )"
                            >
                                Detail
                            </button>

                        </div>

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
    const msg = document.querySelector('.success-msg');

    if (msg) {
        msg.style.opacity = '0';
        msg.style.transition = '0.5s ease';

        setTimeout(() => {
            msg.remove();
        }, 500);
    }
}, 1600);

function openLapakModal(
    nama,
    jenis,
    harga,
    gambar,
    deskripsi,
    status,
    editUrl
){
    document.getElementById("lapakModal")
        .classList.add("active");

    document.getElementById("modalLapakNama").innerText = nama;
    document.getElementById("modalLapakJenis").innerText = jenis;
    document.getElementById("modalLapakHarga").innerText = "Rp " + harga;
    document.getElementById("modalLapakDesc").innerHTML = deskripsi;
    document.getElementById("modalLapakImg").src = gambar;

    document.getElementById("modalLapakStatus").innerText =
        status === "available"
            ? "Available"
            : "Not Available";

    document.getElementById("modalEditBtn").href = editUrl;
}

function closeLapakModal(){
    document.getElementById("lapakModal")
        .classList.remove("active");
}
</script>
@endsection
