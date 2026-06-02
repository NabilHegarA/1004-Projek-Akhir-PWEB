@extends('layouts.admin')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/profil.css') }}">
@endsection

@section('content')
<h2>Lupa Password</h2>

@if(session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<form method="POST" action="/lupa-password">
    @csrf

    <label>Username</label><br>
    <input type="text" name="username"><br><br>

    <label>Password Baru</label><br>
    <input type="password" name="password_baru"><br><br>

    <button type="submit">Reset Password</button>
</form>
@endsection

