@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<section class="register-section">
    <div class="register-card">
        <div class="register-left slide-left"></div>

        <div class="register-right slide-right">
            <h2>Register HookPoint</h2>

            <form method="POST" action="/register">
                @csrf

                <label>Email<span class="required">*</span></label>
                <input type="text" name="email" placeholder="Masukkan Email" required>
                @error('email')
                    <small class="error-text">{{ $message }}</small>
                @enderror

                <label>Nama Lengkap<span class="required">*</span></label>
                <input type="text" name="nama" placeholder="Masukkan nama lengkap" required>
                @error('nama')
                    <small class="error-text">{{ $message }}</small>
                @enderror

                <label>No Telepon<span class="required">*</span></label>
                <input type="text" name="no_telepon" placeholder="Masukkan no telepon" required>
                @error('telepon')
                    <small class="error-text">{{ $message }}</small>
                @enderror

                <label>Password<span class="required">*</span></label>
                <div class="password-box">
                    <input type="password" name="password" placeholder="Masukkan password" required>
                </div>
                @error('password')
                    <small class="error-text">{{ $message }}</small>
                @enderror

                <button type="submit">Register</button>
                <p>Sudah punya akun?<a href="/login">Login</a></p>
            </form>
        </div>
    </div>
</section>
@endsection
