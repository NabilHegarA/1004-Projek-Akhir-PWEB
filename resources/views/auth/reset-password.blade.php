<x-guest-layout>

    <h2>Reset Password</h2>

    <p class="desc">
        Masukkan password baru untuk akun Anda.
    </p>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        {{-- TOKEN --}}
        <input type="hidden"
               name="token"
               value="{{ request()->route('token') }}"

        {{-- EMAIL --}}
        <label>Email</label>

        <input type="email"
               name="email"
               value="{{ old('email', $request->email) }}"
               placeholder="Masukkan email"
               required
               autofocus>

        @error('email')
            <small class="error-text">
                {{ $message }}
            </small>
        @enderror

        {{-- PASSWORD BARU --}}
        <label>Password Baru</label>

        <input type="password"
               name="password"
               placeholder="Masukkan password baru"
               required>

        @error('password')
            <small class="error-text">
                {{ $message }}
            </small>
        @enderror

        {{-- KONFIRMASI PASSWORD --}}
        <label>Konfirmasi Password</label>

        <input type="password"
               name="password_confirmation"
               placeholder="Konfirmasi password baru"
               required>

        @error('password_confirmation')
            <small class="error-text">
                {{ $message }}
            </small>
        @enderror

        {{-- BUTTON --}}
        <button type="submit">
            Reset Password
        </button>

        <p>
            Kembali ke
            <a href="{{ route('login') }}">
                Login
            </a>
        </p>

    </form>

</x-guest-layout>
