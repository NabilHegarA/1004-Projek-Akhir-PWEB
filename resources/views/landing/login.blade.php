@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<section class="login-section">
    <div class="login-card">
        <div class="login-left slide-left"></div>

        <div class="login-right slide-right">
            <h2>Login HookPoint</h2>

            <form method="POST" action="/login">
                @csrf

                <label>Username<span class="required">*</span></label>
                <input type="text" name="email" placeholder="Masukkan Email">
                <div id="error-email" class="error-msg"></div>

                <label>Password<span class="required">*</span></label>
                <input type="password" name="password" placeholder="Masukkan Password">
                <div id="error-password" class="error-msg"></div>

                <button type="submit">Login</button>
                <p>Belum punya akun?<a href="/register">Register</a></p>
            </form>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
<script>

function loginForm() {

    let valid = true;

    const fields = ["email", "password"];

    fields.forEach(id => {

        const input =
            document.getElementById(id);

        const error =
            document.getElementById("error-" + id);

        if (!input.value.trim()) {

            error.innerText = "Wajib diisi";

            error.style.display = "block";

            valid = false;

        } else {

            error.style.display = "none";
        }
    });

    if (!valid) return;

    document.getElementById("loginForm").submit();
}

setTimeout(() => {

    const toast =
        document.querySelector('.error-box');

    if (toast) {
        toast.style.display = 'none';
    }

}, 3000);

</script>
</script>
@endsection
