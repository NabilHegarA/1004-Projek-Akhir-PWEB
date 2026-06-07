@extends('layouts.booking')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/booking.css') }}">
@endsection

@section('content')

<section class="booking-section">

    {{-- CANCEL MESSAGE --}}
    <div class="batal-msg" id="batal-msg" style="display:none;">Booking telah dibatalkan</div>

    <div class="booking-wrapper">

        {{-- TITLE --}}
        <h2 class="booking-title">
            Booking Lapak
        </h2>

        <div class="booking-content">

            {{-- LEFT --}}
            <div class="payment-section">

                <div class="booking-image">
                    <img src="{{ asset('uploads/' . $lapak->gambar) }}">
                </div>

                <div class="payment-box">
                    <p><strong>Nama Lapak</strong></p>
                    <p>{{ $lapak->nama }}</p>
                </div>

                <div class="payment-box">
                    <p><strong>Jenis Kolam</strong></p>
                    <p>{{ $lapak->jenis }}</p>
                </div>

                <div class="payment-box">
                    <p><strong>Harga / Orang</strong></p>
                    <p id="hargaLapak">
                        Rp {{ number_format($lapak->harga,0,',','.') }}
                    </p>
                </div>

                <div class="payment-box">
                    <p><strong>Deskripsi</strong></p>

                    @php
                        $deskripsiList = explode("\n", $lapak->deskripsi);
                    @endphp

                    <ul style="padding-left:18px; margin-top:8px;">
                        @foreach ($deskripsiList as $item)
                            @if(trim($item) != '')
                                <li>{{ $item }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>

            </div>

            {{-- CENTER --}}
            <div class="user-section">

                <div class="form-group">
                    <label>Nama</label>

                    <input type="text"
                           value="{{ auth()->user()->name }}"
                           readonly>
                </div>

                <div class="form-group">
                    <label>No Telepon</label>

                    <input type="text"
                           value="{{ auth()->user()->no_telepon }}"
                           readonly>
                </div>

                <div class="form-group">
                    <label>Nama Lapak</label>

                    <input type="text"
                           value="{{ $lapak->nama }}"
                           readonly>
                </div>

                <div class="form-group">
                    <label>Jenis Kolam</label>

                    <input type="text"
                           value="{{ $lapak->jenis }}"
                           readonly>
                </div>

                <div class="form-group">
                    <label>Harga</label>

                    <input type="text"
                           value="Rp {{ number_format($lapak->harga,0,',','.') }}"
                           readonly>
                </div>

            </div>

            {{-- RIGHT --}}
            <div class="booking-form-section">

                <form id="bookingForm"
                    action="{{ route('booking.store', $lapak->id) }}"
                    method="POST"
                    enctype="multipart/form-data">

                    @csrf

                    {{-- TANGGAL --}}
                    <div class="form-group">
                        <label>Tanggal Booking<span class="required">*</span></label>
                        <input type="date" name="tanggal_booking" id="tanggal_booking" required>
                        <div id="error-tanggal_booking" class="error-msg"></div>
                    </div>

                    {{-- JAM BOOKING --}}
                    <div class="form-group">
                        <label>Jam Booking<span class="required">*</span></label>

                        <select name="jam_booking" id="jam_booking" required>
                            <option value="">Pilih Jam</option>
                            <option value="08:00">08:00</option>
                            <option value="11:00">11:00</option>
                            <option value="14:00">14:00</option>
                        </select>

                        <div id="schedule-full" class="schedule-full">
                            Jadwal booking sudah penuh
                        </div>

                        <div id="error-jam_booking" class="error-msg"></div>
                    </div>

                    {{-- JUMLAH ORANG (MAX 3) --}}
                    <div class="form-group">
                        <label>Jumlah Orang<span class="required">*</span></label>
                        <select name="jumlah_orang" id="jumlah_orang" required onchange="updateTotal()">
                            <option value="">Pilih Jumlah Orang</option>
                            <option value="1">1 Orang</option>
                            <option value="2">2 Orang</option>
                            <option value="3">3 Orang</option>
                        </select>
                        <div id="error-jumlah_orang" class="error-msg"></div>
                    </div>

                    {{-- METODE PEMBAYARAN --}}
                    <div class="form-group">
                        <label>Metode Pembayaran (a.n HookPoint)<span class="required">*</span></label>
                        <select name="metode_pembayaran" id="metode_pembayaran" required>
                            <option value="">Pilih Metode Pembayaran</option>
                            <option value="BRI">BRI | 123456789054321</option>
                            <option value="BCA">BCA | 1234567890</option>
                            <option value="Mandiri">Mandiri | 1234567890567</option>
                        </select>
                        <div id="error-metode_pembayaran" class="error-msg"></div>
                    </div>

                    {{-- TOTAL HARGA --}}
                    <div class="form-group">
                        <label>Total Harga</label>
                        <input type="text"
                            id="total_harga"
                            readonly
                            value="Rp {{ number_format($lapak->harga,0,',','.') }}">
                    </div>

                    {{-- BUKTI TRANSFER --}}
                    <div class="form-group">
                        <label>Upload Bukti Transfer<span class="required">*</span></label>
                        <input type="file" name="bukti_tf" id="bukti_tf" accept="image/*" required>
                        <div id="error-bukti_tf" class="error-msg"></div>
                    </div>

                    {{-- NOTE --}}
                    <div class="booking-note">
                        <p>Silakan lakukan pembayaran sesuai dengan Total Harga dan upload bukti transfer.
                            Pembayaran yang telah dilakukan, tidak dapat dikembalikan.</p>
                    </div>

                    {{-- BUTTON --}}
                    <div class="booking-action">

                        <button type="button" class="back-btn"
                                onclick="window.location.href='/user/lapakUser'">
                            Kembali
                        </button>

                        <button type="button" class="booking-btn"
                                onclick="bookingForm()">
                            Booking Sekarang
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</section>

{{-- MODAL --}}
<div class="modal-overlay"
     id="confirmModal">

    <div class="confirm-modal">

        <h3>Konfirmasi Booking</h3>

        <p>
            Yakin ingin melakukan booking?
        </p>

        <div class="modal-btn-group">
            <button type="button"
                    class="cancel-btn"
                    onclick="batalBooking()">
                Batal
            </button>

            <button type="button"
                    class="confirm-btn"
                    onclick="submitBooking()">
                Ya
            </button>

        </div>

    </div>

</div>

@endsection

@section('scripts')
<script>
/* ========================== HITUNG TOTAL HARGA ===============================*/
function updateTotal() {
    const jumlahEl = document.getElementById("jumlah_orang");
    const jumlah = parseInt(jumlahEl?.value || 0);

    const hargaText = document.getElementById("hargaLapak")?.innerText || "0";
    const harga = parseInt(hargaText.replace(/[^0-9]/g, "")) || 0;

    const totalInput = document.getElementById("total_harga");

    if (!jumlah) {
        totalInput.value = "Rp 0";
        return;
    }

    const total = harga * jumlah;
    totalInput.value = "Rp " + total.toLocaleString("id-ID");
}

/* ========================== VALIDASI BOOKING FORM ===============================*/
function bookingForm() {
    let valid = true;

    const fields = [
        "tanggal_booking",
        "jam_booking",
        "jumlah_orang",
        "metode_pembayaran"
    ];

    fields.forEach(id => {
        // VALIDASI WAJIB ISI
        const input = document.getElementById(id);
        const error = document.getElementById("error-" + id);

        if (!input || !error) return;

        let isEmpty = false;

        // SELECT / INPUT DATE / TEXT
        isEmpty = input.value === "";

        if (isEmpty) {
            error.innerText = "Wajib diisi";
            error.style.display = "block";
            error.style.color = "red";
            valid = false;
        } else {
            error.innerText = "";
            error.style.display = "none";
        }

    });

    //VALIDASI FORMAT BUKTI TF
    const buktiTf = document.getElementById("bukti_tf");
    const errorBukti = document.getElementById("error-bukti_tf");

    if (buktiTf && errorBukti) {

        // RESET ERROR SELALU (INI PENTING)
        errorBukti.innerText = "";
        errorBukti.style.display = "none";

        //validasi file kosong
        if (buktiTf.files.length === 0) {
            errorBukti.innerText = "Wajib diisi";
            errorBukti.style.display = "block";
            errorBukti.style.color = "red";
            valid = false;
        }
        else {

            const file = buktiTf.files[0];

            const allowedTypes = [
                "image/jpeg",
                "image/png",
                "image/jpg"
            ];

            /* FORMAT CHECK */
            if (!allowedTypes.includes(file.type)) {
                errorBukti.innerText = "Format harus JPG, PNG, atau JPEG";
                errorBukti.style.display = "block";
                errorBukti.style.color = "red";
                valid = false;
            }

            /* SIZE CHECK */
            else if (file.size > 2 * 1024 * 1024) {
                errorBukti.innerText = "Ukuran maksimal 2 MB";
                errorBukti.style.display = "block";
                errorBukti.style.color = "red";
                valid = false;
            }
        }
    }

    //VALIDASI TERAKHIR
    if (!valid) return;
    document.getElementById("confirmModal").style.display = "flex";
}

/* ========================== MODAL CONTROL ===============================*/
function closeConfirmModal() {
    document.getElementById("confirmModal").style.display = "none";
}

function batalBooking() {
    closeConfirmModal();

    const msg = document.getElementById("batal-msg");
    if (!msg) return;

    msg.style.display = "block";

    setTimeout(() => {
        msg.style.opacity = "0";
        msg.style.transition = '0.5s ease';

        setTimeout(() => {
            msg.style.display = "none";
            msg.style.opacity = "1";
        }, 500);
    }, 1500);
}

function submitBooking() {
    document.getElementById("bookingForm").submit();
}

document.addEventListener("DOMContentLoaded", function () {

    //TOTAL HARGA BOOKING
    updateTotal();
    document.getElementById("jumlah_orang")
        .addEventListener("change", updateTotal);

    //DATA JADWAL DAN JAM BOOKING
    const dateInput = document.getElementById("tanggal_booking");
    const jamSelect = document.getElementById("jam_booking");
    const scheduleBox = document.getElementById("schedule-full");
    const allJam = ["08:00", "11:00", "14:00"];

    // hide warning default
    scheduleBox.style.display = "none";

    // MINIMAL TANGGAL HARI INI
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const dd = String(today.getDate()).padStart(2, '0');

    dateInput.setAttribute("min", `${yyyy}-${mm}-${dd}`);

    // RESET JAM KALAU GANTI TANGGAL
    dateInput.addEventListener("change", async function () {

        const tanggal = this.value;
        if (!tanggal) return;

        jamSelect.value = "";

        const res = await fetch(`/user/booking/{{ $lapak->id }}/jam-terpakai?tanggal=${tanggal}`);
        const bookedJam = await res.json();

        jamSelect.innerHTML = `<option value="">Pilih Jam</option>`;

        let available = 0;

        allJam.forEach(jam => {
            if (!bookedJam.includes(jam)) {
                jamSelect.innerHTML += `<option value="${jam}">${jam}</option>`;
                available++;
            }
        });

        if (available === 0) {
            scheduleBox.style.display = "block";
            scheduleBox.innerText = "Jadwal booking sudah penuh";
            jamSelect.disabled = true;
        } else {
            scheduleBox.style.display = "none";
            jamSelect.disabled = false;
        }
    });

    // RESET ERROR JAM
    jamSelect.addEventListener("change", function () {
        document.getElementById("error-jam_booking").style.display = "none";
        jamSelect.classList.remove("error");
    });

});

</script>
@endsection
