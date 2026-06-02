@extends('layouts.main')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')

<section class="register-section">
    <div class="register-card">

        <div class="register-left slide-left"></div>

        <div class="register-right slide-right">

            <h2>Register HookPoint</h2>

            <form id="registerForm" method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <label>Nama Lengkap<span class="required">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                <div id="error-name" class="error-msg"></div>

                <!-- Email -->
                <label>Email<span class="required">*</span></label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email" required>
                <div id="error-email" class="error-msg"></div>
                @error('email')
                    <small class="error-msg" style="display:block">
                        {{ $message }}
                    </small>
                @enderror

                <!-- No Telepon -->
                <label>No Telepon<span class="required">*</span></label>
                <input type="text" id="no_telepon" name="no_telepon" placeholder="Masukkan no telepon" value="{{ old('no_telepon') }}">
                <div id="error-no_telepon" class="error-msg"></div>

                <!-- Password -->
                <label>Password<span class="required">*</span></label>
                <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                <div id="error-password" class="error-msg"></div>

                <!-- Confirm Password -->
                <label>Konfirmasi Password<span class="required">*</span></label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required>
                <div id="error-password_confirmation" class="error-msg"></div>

                <!-- Button -->
                <button type="button" onclick="registerForm()">Register</button>

                <!-- Login link -->
                <p>
                    Sudah punya akun?
                    <a href="{{ route('login') }}">Login</a>
                </p>

            </form>

        </div>

    </div>
</section>

@endsection

@section('scripts')
<script>

function registerForm() {

    let valid = true;

    const fields = [
        "name",
        "email",
        "no_telepon",
        "password",
        "password_confirmation"
    ];

    fields.forEach(id => {

        const input =
            document.getElementById(id);

        const error =
            document.getElementById("error-" + id);

        if (!input.value.trim()) {
            error.innerText = "Wajib diisi";
            error.style.display = "block";
            input.classList.add("input-error");
            valid = false;

        } else {
            error.style.display = "none";
            input.classList.remove("input-error");
        }
    });

    // PASSWORD TIDAK SAMA
    const password =
        document.getElementById("password");

    const confirm =
        document.getElementById("password_confirmation");

    const confirmError =
        document.getElementById("error-password_confirmation");

    if (
        password.value &&
        confirm.value &&
        password.value !== confirm.value
    ) {

        confirmError.innerText =
            "Konfirmasi password tidak sama";

        confirmError.style.display = "block";

        confirm.classList.add("input-error");

        valid = false;
    }

    if (!valid) return;

    document.getElementById("registerForm")
            .submit();
}

</script>
@endsection
