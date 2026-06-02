@extends('layouts.user')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/transaksiUser.css') }}">
@endsection

@section('content')
<div class="content">

    <h2>Transaksi</h2>

    {{-- TAB --}}
    <div class="tabs">
        <button class="tab active" onclick="openTab(event, 'pending')">Menunggu</button>
        <button class="tab" onclick="openTab(event, 'confirmed')">Dikonfirmasi</button>
        <button class="tab" onclick="openTab(event, 'selesai')">Selesai</button>
    </div>

    {{-- SEARCH --}}
    <form method="GET" id="filter-form" onsubmit="return false;">

        <div class="search-box">
            <input type="text" name="search" id="search" placeholder="Cari lapak..." value="{{ request('search') }}">
            <button type="submit">Cari</button>
        </div>

        <div class="filter-box">
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

            <div>
                <label>Tanggal Booking</label>
                <input type="date" id="tanggal">
            </div>

            <div>
                <label>Jam Booking</label>
                <select id="jam">
                    <option value="">Semua Jam</option>
                    <option value="08:00">08:00</option>
                    <option value="11:00">11:00</option>
                    <option value="14:00">14:00</option>
                </select>
            </div>
        </div>

    </form>

    {{-- ================= PENDING ================= --}}
    <div class="tab-content active transaksi-wrapper" id="pending">
        <div class="card-grid">

            @forelse($pending as $booking)
                <div class="card">

                    <div class="detail-icon"
                        onclick='openDetailModal(
                            {{ Js::from($booking->id) }},
                            {{ Js::from($booking->lapak->nama) }},
                            {{ Js::from($booking->lapak->jenis) }},
                            {{ Js::from(number_format($booking->lapak->harga,0,",",".")) }},
                            {{ Js::from(\Carbon\Carbon::parse($booking->tanggal_booking)->translatedFormat("d F Y")) }},
                            {{ Js::from($booking->jam_booking) }},
                            {{ Js::from($booking->jumlah_orang) }},
                            {{ Js::from($booking->metode_pembayaran) }},
                            {{ Js::from(number_format($booking->lapak->harga * $booking->jumlah_orang,0,",",".")) }},
                            {{ Js::from(asset("bukti_tf/" . $booking->bukti_tf)) }},
                            {{ Js::from($booking->status) }},
                            {{ Js::from($booking->rejection_reason) }}
                        )'>
                        🔍
                    </div>

                    <div class="card-body">
                        <h3>{{ $booking->lapak->nama }}</h3>
                        <p><b>Jenis:</b> {{ $booking->lapak->jenis }}</p>
                        <p><b>Harga:</b> Rp {{ number_format($booking->lapak->harga, 0, ',', '.') }}</p>
                        <p><b>Tanggal:</b> {{ \Carbon\Carbon::parse($booking->tanggal_booking)->translatedFormat('d F Y') }}</p>

                        <span class="status pending">Menunggu</span>
                    </div>

                </div>
            @empty
                <div class="empty-message">Belum ada transaksi menunggu</div>
            @endforelse

        </div>
    </div>

    {{-- ================= CONFIRMED ================= --}}
    <div class="tab-content" id="confirmed">
        <div class="card-grid">

            @forelse($confirmed as $booking)
                <div class="card">

                    <div class="detail-icon"
                        onclick='openDetailModal(
                            {{ Js::from($booking->id) }},
                            {{ Js::from($booking->lapak->nama) }},
                            {{ Js::from($booking->lapak->jenis) }},
                            {{ Js::from(number_format($booking->lapak->harga,0,",",".")) }},
                            {{ Js::from(\Carbon\Carbon::parse($booking->tanggal_booking)->translatedFormat("d F Y")) }},
                            {{ Js::from($booking->jam_booking) }},
                            {{ Js::from($booking->jumlah_orang) }},
                            {{ Js::from($booking->metode_pembayaran) }},
                            {{ Js::from(number_format($booking->lapak->harga * $booking->jumlah_orang,0,",",".")) }},
                            {{ Js::from(asset("bukti_tf/" . $booking->bukti_tf)) }},
                            {{ Js::from($booking->status) }},
                            {{ Js::from($booking->rejection_reason) }}
                        )'>
                        🔍
                    </div>

                    <div class="card-body">
                        <h3>{{ $booking->lapak->nama }}</h3>
                        <p><b>Jenis:</b> {{ $booking->lapak->jenis }}</p>
                        <p><b>Harga:</b> Rp {{ number_format($booking->lapak->harga, 0, ',', '.') }}</p>
                        <p><b>Tanggal:</b> {{ \Carbon\Carbon::parse($booking->tanggal_booking)->translatedFormat('d F Y') }}</p>

                        <span class="status confirmed">Dikonfirmasi</span>
                    </div>

                </div>
            @empty
                <div class="empty-message">Belum ada transaksi dikonfirmasi</div>
            @endforelse

        </div>
    </div>

    {{-- ================= SELESAI ================= --}}
    <div class="tab-content" id="selesai">
        <div class="card-grid">

            @forelse($finished as $booking)
                <div class="card">

                    <div class="detail-icon"
                        onclick='openDetailModal(
                            {{ Js::from($booking->id) }},
                            {{ Js::from($booking->lapak->nama) }},
                            {{ Js::from($booking->lapak->jenis) }},
                            {{ Js::from(number_format($booking->lapak->harga,0,",",".")) }},
                            {{ Js::from(\Carbon\Carbon::parse($booking->tanggal_booking)->translatedFormat("d F Y")) }},
                            {{ Js::from($booking->jam_booking) }},
                            {{ Js::from($booking->jumlah_orang) }},
                            {{ Js::from($booking->metode_pembayaran) }},
                            {{ Js::from(number_format($booking->lapak->harga * $booking->jumlah_orang,0,",",".")) }},
                            {{ Js::from(asset("bukti_tf/" . $booking->bukti_tf)) }},
                            {{ Js::from($booking->status) }},
                            {{ Js::from($booking->rejection_reason) }}
                        )'>
                        🔍
                    </div>

                    <div class="card-body">

                        <h3>{{ $booking->lapak->nama }}</h3>
                        <p><b>Jenis:</b> {{ $booking->lapak->jenis }}</p>
                        <p><b>Harga:</b> Rp {{ number_format($booking->lapak->harga, 0, ',', '.') }}</p>
                        <p><b>Tanggal:</b> {{ \Carbon\Carbon::parse($booking->tanggal_booking)->translatedFormat('d F Y') }}</p>

                        @if($booking->status == 'completed')
                            <span class="status completed">Selesai</span>
                        @elseif($booking->status == 'canceled')
                            <span class="status canceled">Dibatalkan</span>
                        @elseif($booking->status == 'rejected')
                            <span class="status rejected">Ditolak</span>
                        @endif

                    </div>

                </div>
            @empty
                <div class="empty-message">Belum ada transaksi selesai</div>
            @endforelse

        </div>
    </div>

</div>

@include('components.detail-modal-transaksi')
@include('components.img-preview-modal')
@endsection


@section('scripts')
<script>
window.APP_ROLE = "user";

let timeout = null;
let currentTab = "pending";

/* ================= TAB ================= */
function openTab(event, tabName)
{
    currentTab = tabName;

    document.querySelectorAll(".tab-content")
        .forEach(el => el.classList.remove("active"));

    document.querySelectorAll(".tab")
        .forEach(el => el.classList.remove("active"));

    const target = document.getElementById(tabName);

    if (target) {
        target.classList.add("active");
    }

    event.currentTarget.classList.add("active");

    // optional: refresh data
    fetchTransaksi();
}

/* ================= DETAIL MODAL ================= */
function openDetailModal(
    id, nama, jenis, harga, tanggal, jam,
    jumlah, metode, total, buktiTf, status, rejectionReason
){
    document.getElementById("detailModal").style.display = "flex";

    document.getElementById("detailNama").innerText = nama;
    document.getElementById("detailJenis").innerText = jenis;
    document.getElementById("detailHarga").innerText = "Rp " + harga;
    document.getElementById("detailTanggal").innerText = tanggal;
    document.getElementById("detailJam").innerText = jam;
    document.getElementById("detailJumlah").innerText = jumlah + " Orang";
    document.getElementById("detailMetode").innerText = metode;
    document.getElementById("detailTotal").innerText = "Rp " + total;
    document.getElementById("detailBuktiTf").src = buktiTf;

    // 🔥 INI BAGIAN BARU (ROLE CHECK)
    if (window.APP_ROLE === "admin") {
        document.getElementById("boxUser").style.display = "block";
        document.getElementById("detailUser").innerText = user;
    } else {
        document.getElementById("boxUser").style.display = "none";
    }

    let badge = "";

    if(status === "pending")
        badge = '<span class="status pending">Menunggu</span>';
    else if(status === "confirmed")
        badge = '<span class="status confirmed">Dikonfirmasi</span>';
    else if(status === "completed")
        badge = '<span class="status completed">Selesai</span>';
    else if(status === "canceled")
        badge = '<span class="status canceled">Dibatalkan</span>';
    else if(status === "rejected")
        badge = '<span class="status rejected">Ditolak</span>';

    document.getElementById("detailStatus").innerHTML = badge;

    const rejectBox = document.getElementById("detailRejectReason");

    if(status === "rejected" && rejectionReason){
        rejectBox.style.display = "block";
        rejectBox.innerHTML =
            `<label>Alasan Penolakan</label>
             <p>${rejectionReason}</p>`;
    } else {
        rejectBox.style.display = "none";
        rejectBox.innerHTML = "";
    }

    const actionBox = document.getElementById("detailAction");
    let html = "";

    if(status === "pending"){
        html = `
            <button type="button" class="btn reject-btn"
                onclick="cancelBooking('${id}')">
                Batalkan Booking
            </button>
        `;
    }

    actionBox.innerHTML = html;
}

/* ================= CLOSE MODAL ================= */
function closeDetailModal(){
    document.getElementById("detailModal").style.display = "none";
}

/* ================= FETCH ================= */
function fetchTransaksi()
{
    let search = document.getElementById("search").value;
    let jenis = document.getElementById("jenis").value;
    let tanggal = document.getElementById("tanggal")?.value || "";
    let jam = document.getElementById("jam")?.value || "";

    fetch(`/transaksi/live-search?search=${encodeURIComponent(search)}&jenis=${encodeURIComponent(jenis)}&tanggal=${encodeURIComponent(tanggal)}&jam=${encodeURIComponent(jam)}`)
    .then(res => res.json())
    .then(data => {

        const pendingGrid = document.querySelector("#pending .card-grid");
        const confirmedGrid = document.querySelector("#confirmed .card-grid");
        const selesaiGrid = document.querySelector("#selesai .card-grid");

        pendingGrid.innerHTML = "";
        confirmedGrid.innerHTML = "";
        selesaiGrid.innerHTML = "";

        data.forEach(b => {

            let statusText = "";
            if(b.status === "pending") statusText = "Menunggu";
            else if(b.status === "confirmed") statusText = "Dikonfirmasi";
            else if(b.status === "completed") statusText = "Selesai";
            else if(b.status === "rejected") statusText = "Ditolak";
            else if(b.status === "canceled") statusText = "Dibatalkan";

            const card = `
                <div class="card">

                    <div class="detail-icon"
                        onclick='openDetailModal(
                            ${JSON.stringify(b.id)},
                            ${JSON.stringify(b.lapak.nama)},
                            ${JSON.stringify(b.lapak.jenis)},
                            ${JSON.stringify(Number(b.lapak.harga).toLocaleString())},
                            ${JSON.stringify(b.tanggal_booking)},
                            ${JSON.stringify(b.jam_booking)},
                            ${JSON.stringify(b.jumlah_orang)},
                            ${JSON.stringify(b.metode_pembayaran)},
                            ${JSON.stringify(Number(b.lapak.harga * b.jumlah_orang).toLocaleString())},
                            ${JSON.stringify('/bukti_tf/' + b.bukti_tf)},
                            ${JSON.stringify(b.status)},
                            ${JSON.stringify(b.rejection_reason || '')}
                        )'>
                        🔍
                    </div>

                    <div class="card-body">
                        <h3>${b.lapak.nama}</h3>
                        <p><b>Jenis:</b> ${b.lapak.jenis}</p>
                        <p><b>Harga:</b> Rp ${Number(b.lapak.harga).toLocaleString()}</p>
                        <p><b>Tanggal:</b> ${b.tanggal_booking}</p>

                        <span class="status ${b.status}">
                            ${statusText}
                        </span>
                    </div>
                </div>
            `;

            if(b.status === "pending") pendingGrid.innerHTML += card;
            else if(b.status === "confirmed") confirmedGrid.innerHTML += card;
            else {selesaiGrid.innerHTML += card;}
        });

        if (pendingGrid.innerHTML.trim() === "") {
            pendingGrid.innerHTML = `
                <div class="empty-message">
                    🔍 Tidak ada transaksi menunggu
                </div>
            `;
        }

        if (confirmedGrid.innerHTML.trim() === "") {
            confirmedGrid.innerHTML = `
                <div class="empty-message">
                    🔍 Tidak ada transaksi dikonfirmasi
                </div>
            `;
        }

        if (selesaiGrid.innerHTML.trim() === "") {
            selesaiGrid.innerHTML = `
                <div class="empty-message">
                    🔍 Tidak ada transaksi selesai
                </div>
            `;
        }

        // SAFE: jangan paksa active tab kalau error
        const active = document.getElementById(currentTab);
        if(active) active.classList.add("active");
    });
}

/* ================= INIT ================= */
document.addEventListener("DOMContentLoaded", function(){

    const search = document.getElementById("search");
    const jenis = document.getElementById("jenis");
    const tanggal = document.getElementById("tanggal");
    const jam = document.getElementById("jam");

    if(search){
        search.addEventListener("keyup", function(){
            clearTimeout(timeout);
            timeout = setTimeout(fetchTransaksi, 300);
        });
    }

    if(jenis) jenis.addEventListener("change", fetchTransaksi);
    if(tanggal) tanggal.addEventListener("change", fetchTransaksi);
    if(jam) jam.addEventListener("change", fetchTransaksi);

    fetchTransaksi();
});

document.addEventListener("DOMContentLoaded", function () {

    const urlParams = new URLSearchParams(window.location.search);
    const tab = urlParams.get("tab");

    let mappedTab = "pending";

    if (tab === "confirmed") mappedTab = "confirmed";
    else if (tab === "pending") mappedTab = "pending";
    else mappedTab = "selesai"; // completed, canceled, rejected masuk sini

    if (tab) {
        const btn = document.querySelector(`.tab[onclick*="${mappedTab}"]`);
        const target = document.getElementById(mappedTab);

        if (btn) {
            btn.click(); // INI KUNCI UTAMANYA
        } else {
            // fallback
            openTab({ currentTarget: document.querySelector(".tab") }, "pending");
        }
    }
});

function cancelBooking(id)
{
    fetch(`/user/booking/${id}/cancel`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        }
    })
    .then(() => {

        // langsung tutup modal
        closeDetailModal();

        // refresh data
        fetchTransaksi();

        // pindah ke tab selesai
        currentTab = "selesai";
        document.querySelector('.tab[onclick*="selesai"]').click();
    })
    .catch(err => {
        console.error(err);
    });
}

</script>
@endsection
