@extends('layouts.admin')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/tambah-lapak.css') }}">
@endsection

@section('content')
<div class="content profile-page">
    @if(request('batal'))
        <div class="batal-msg">
            Lapak batal disimpan
        </div>
    @endif

    <form id="formTambah" method="POST" action="{{ url('/admin/tambahlapak') }}" enctype="multipart/form-data">
        @csrf

        <div class="profile-card">
            <h2>Tambah Lapak</h2>

            <div class="form-grid">

                <!-- KIRI -->
                <div class="form-column">

                    <div class="field">
                        <label>Nama Lapak<span class="required">*</span></label>
                        <input type="text" name="nama" id="nama">
                        <small id="error-nama" class="error-msg"></small>
                    </div>

                    <div class="field">
                        <label>Harga<span class="required">*</span></label>
                        <input type="number" name="harga" id="harga">
                        <small id="error-harga" class="error-msg"></small>
                    </div>

                    <div class="field">
                        <label>Deskripsi<span class="required">*</span></label>
                        <textarea name="deskripsi" id="deskripsi"></textarea>
                        <small class="info-text">
                            Gunakan ENTER untuk membuat poin (1 baris= 1 fasilitas/bonus)
                        </small>
                        <small id="error-deskripsi" class="error-msg"></small>
                    </div>

                    <div class="field">
                        <label>Status<span class="required">*</span></label>
                        <select name="status" id="status">
                            <option value="">-- Pilih Status --</option>
                            <option value="available">Available</option>
                            <option value="unavailable">Not Available</option>
                        </select>
                        <small id="error-status" class="error-msg"></small>
                    </div>

                </div>

                <!-- KANAN -->
                <div class="form-column">

                    <div class="field">
                        <label>Jenis Kolam<span class="required">*</span></label>
                        <select name="jenis" id="jenis">
                            <option value="">-- Pilih Jenis --</option>
                            <option value="Lele">Lele</option>
                            <option value="Nila">Nila</option>
                            <option value="Gurame">Gurame</option>
                            <option value="Patin">Patin</option>
                        </select>
                        <small id="error-jenis" class="error-msg"></small>
                    </div>

                    <div class="field">
                        <label>Gambar<span class="required">*</span></label>
                        <input type="file" name="gambar" id="gambar">
                        <small class="info-text">
                            Format: PNG, JPEG, JPG <br>Ukuran Maks: 2MB
                        </small>
                        <small id="error-gambar" class="error-msg"></small>
                    </div>

                </div>

            </div>

            <div class="edit-btn edit-mode">
                <button type="button" onclick="kembali()" class="btn-kembali">Kembali</button>
                <button type="button" onclick="submitForm()">Simpan</button>
            </div>
        </div>
    </form>
</div>

@include('components.confirm-tambah')

@endsection

@section('scripts')
<script>
function kembali() {
    window.location.href = "/admin/pengelolaan";
}

function submitForm() {
    let valid = true;

    const fields = ["nama", "jenis", "harga", "deskripsi", "status", "gambar"];

    fields.forEach(id => {
        const input = document.getElementById(id);
        const error = document.getElementById("error-" + id);

        if (!input.value.trim()) {
            error.style.display = "block";
            error.innerText = "Wajib diisi";
            valid = false;
        } else {
            error.style.display = "none";
        }
    });

    const harga = document.getElementById("harga");
    const errorHarga = document.getElementById("error-harga");

    if (harga.value.trim() && isNaN(harga.value)) {
        errorHarga.innerText = "Harga harus berupa angka";
        errorHarga.style.display = "block";
        valid = false;
    }

    const gambar = document.getElementById("gambar");
    const errorGambar = document.getElementById("error-gambar");

    if(gambar.files.length > 0){

        const file = gambar.files[0];

        const allowedTypes = [
            "image/jpeg",
            "image/png"
        ];

        if(!allowedTypes.includes(file.type)){

            errorGambar.style.display = "block";
            errorGambar.innerText = "Format gambar harus JPG, JPEG, atau PNG";

            valid = false;

        } else if(file.size > 2 * 1024 * 1024){

            errorGambar.style.display = "block";
            errorGambar.innerText = "Ukuran gambar maksimal 2 MB";

            valid = false;

        } else {

            errorGambar.style.display = "none";
            errorGambar.innerText = "";
        }
    }

    if (!valid) return;

    openConfirmModal();
}

function openConfirmModal() {
    document.getElementById("confirmtambahModal").style.display = "flex";
}

function closeConfirmModal() {
    document.getElementById("confirmtambahModal").style.display = "none";
}

function confirmSave() {
    closeConfirmModal();
    document.getElementById("formTambah").submit();
}

function batalSimpan() {
    window.location.href = "/admin/tambahlapak?batal=true";
}

setTimeout(() => {
    const msg = document.querySelector('.batal-msg');

    if (msg) {
        msg.style.opacity = '0';
        msg.style.transition = '0.5s ease';

        setTimeout(() => {
            msg.remove();
        }, 500);
    }
}, 1600);
</script>
@endsection
