@extends('layouts.user')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/editprofil.css') }}">
@endsection

@section('content')
<div class="content profile-page">
    @if(request('batal'))
        <div class="batal-msg">
            Profil batal diperbarui
        </div>
    @endif

    <form id="formEdit" method="POST" action="{{ route('user.profile.update') }}">
        @csrf

        <div class="profile-card">
            <h2>Edit Profil</h2>

            <div class="field">
                <label for="name">Nama Lengkap<span class="required">*</span></label>
                <input type="text" name="name" id="name" value="{{ auth()->user()->name }}">
                <div id="error-name" class="error-msg"></div>
            </div>

            <div class="field">
                <label for="email">Email<span class="required">*</span></label>
                <input type="text" name="email" id="email" value="{{ auth()->user()->email }}">
                <div id="error-email" class="error-msg"></div>
            </div>

            <div class="field">
                <label for="no_telepon">No Telepon<span class="required">*</span></label>
                <input type="text" name="no_telepon" id="no_telepon" value="{{ auth()->user()->no_telepon }}">
                <div id="error-no_telepon" class="error-msg"></div>
            </div>

            <div class="edit-btn edit-mode">
                <button type="button" onclick="kembali()" class="btn-kembali">Kembali</button>
                <button type="button" onclick="editForm()">Simpan Perubahan</button>
            </div>
        </div>
    </form>
</div>
@include('components.confirm-edit')
@endsection

@section('scripts')
<script>
function kembali() {
    window.location.href = "/user/profileUser";
}

function editForm() {
    let valid = true;

    const fields = ["name", "email", "no_telepon"];

    fields.forEach(id => {
        const input = document.getElementById(id);
        const error = document.getElementById("error-" + id);

        if (!input.value.trim()) {
            error.innerText = "Wajib diisi";
            error.style.display = "block";
            valid = false;
        } else {
            error.style.display = "none";
        }
    });

    if (!valid) return;

    openConfirmModal();
}

function openConfirmModal() {
    const modal = document.getElementById("confirmModal");
    if (modal) modal.style.display = "flex";
}

function closeConfirmModal() {
    const modal = document.getElementById("confirmModal");
    if (modal) modal.style.display = "none";
}

function batalSimpan() {
    window.location.href = "/user/edit-profileUser?batal=true";
}

function confirmSave() {
    document.getElementById("formEdit").submit();
}

function togglePassword() {
    const input = document.getElementById("password");
    input.type = (input.type === "password") ? "text" : "password";
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
