@extends('layouts.main')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<section class="login-section">
    <div class="login-card">

        <div class="login-left slide-left"></div>

        <div class="login-right slide-right">

            <h2>Login HookPoint</h2>

            {{-- FORM LOGIN --}}
            <form id="loginForm" method="POST" action="{{ route('login') }}">
                @csrf

                <!-- EMAIL -->
                <label>Email<span class="required">*</span></label>
                <input type="email" id="email" name="email"
                       value="{{ old('email', Cookie::get('remember_email')) }}"
                       placeholder="Masukkan email" required autofocus>
                <div id="error-email" class="error-msg"></div>

                <!-- PASSWORD -->
                <label>Password<span class="required">*</span></label>
                <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                <div id="error-password" class="error-msg"></div>

                @if ($errors->any())
                    <div class="error-box" style="color:red; font-size:13px">
                        {{ $errors->first() }}
                    </div>
                @endif

                <!-- Forgot Password -->
                <div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" style="font-size: 12px; color:#2f7a4d;">
                            Lupa password?
                        </a>
                    @endif
                </div>

                <!-- REMEMBER -->
                <div style="margin-bottom: 10px;">
                    <label style="font-size: 14px;">
                        <input type="checkbox" name="remember">
                        Remember me
                    </label>
                </div>

                <!-- BUTTON -->
                <button type="button" onclick="loginForm()">Login</button>

                <!-- LINK REGISTER -->
                <p>
                    Belum punya akun?
                    <a href="/register">Register</a>
                </p>

            </form>

        </div>
    </div>
</section>
@endsection

@section('scripts')
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

// setTimeout(() => {
//     const toast = document.querySelector('.error-box');
//     if (toast) {
//         toast.style.display = 'none';
//     }
// }, 3000);
</script>
@endsection
