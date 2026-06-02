@extends('layouts.user')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/profil.css') }}">
@endsection

@section('content')
<section class="content profile-page">

    @if(session('success'))
        <div class="success-msg">
            {{ session('success') }}
        </div>
    @endif

    <div class="profile-card">
        <h2>Profil Akun</h2>

        <div class="field">
            <label>Nama</label>
            <p>{{ auth()->user()->name }}</p>
        </div>

        <div class="field">
            <label>Email</label>
            <p>{{ auth()->user()->email }}</p>
        </div>

        <div class="field">
            <label>No Telepon</label>
            <p>{{ auth()->user()->no_telepon }}</p>
        </div>

        <div class="edit-btn">
            <a href="edit-profileUser" class="btn">Edit Profil</a>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
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
</script>
@endsection

