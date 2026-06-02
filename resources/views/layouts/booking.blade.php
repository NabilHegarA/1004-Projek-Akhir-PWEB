<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking</title>

    <link rel="stylesheet" href="{{ asset('css/darkmode.css') }}">
    @yield('styles')

    <script>
    function setCookie(name, value, days) {
        let d = new Date();
        d.setTime(d.getTime() + (days*24*60*60*1000));
        document.cookie = name + "=" + value + ";expires=" + d.toUTCString() + ";path=/";
    }

    function getCookie(name) {
        let match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
        return match ? match[2] : null;
    }

    (function () {
        let theme = getCookie("theme");

        if (theme === "dark") {
            document.documentElement.classList.add("dark");
        } else {
            document.documentElement.classList.remove("dark");
        }
    })();
    </script>
</head>

<body>

    @include('components.navbar-admin')

    <main>
        @yield('content')
    </main>

    @yield('scripts')

</body>
</html>
