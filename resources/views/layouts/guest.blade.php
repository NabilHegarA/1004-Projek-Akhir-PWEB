<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HookPoint</title>

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>

<header class="main-header">
    <div class="logo-section">
        <img src="{{ asset('images/logo.png') }}" alt="Logo HookPoint">
        <p>HookPoint - Club Pemancingan</p>
    </div>
</header>

<section class="login-section">

    <div class="login-card single-card">

        <div class="login-right full-width">

            {{ $slot }}

        </div>

    </div>

</section>

    @include('components.footer')

</body>
</html>
