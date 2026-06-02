<x-guest-layout>

    <h2>Lupa Password</h2>

    <p class="desc">
        Masukkan email akun Anda untuk menerima link reset password.
    </p>

    {{-- SUCCESS MESSAGE --}}
    @if (session('status'))
        <div class="success-box">
            Silakan cek email Anda.
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        {{-- EMAIL --}}
        <label>Email</label>

        <input type="email"
               name="email"
               value="{{ old('email') }}"
               placeholder="Masukkan email"
               required
               autofocus>

        {{-- VALIDATION ERROR --}}
        @error('email')
            <small class="error-text">
                Email tidak ditemukan.
            </small>
        @enderror

        {{-- BUTTON --}}
        <button type="submit">
            Kirim Link Reset
        </button>

        <p>
            Ingat password?
            <a href="{{ route('login') }}">
                Kembali ke login
            </a>
        </p>

    </form>

</x-guest-layout>
