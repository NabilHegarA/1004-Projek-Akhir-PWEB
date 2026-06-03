<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HookPoint</title>

    @yield('styles')
    <link rel="stylesheet" href="{{ asset('css/darkmode.css') }}">

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

    @include('components.sidebar-admin')

    <div class="main">
        @include('components.navbar-admin')

        <div class="content">
            @yield('content')
        </div>
    </div>

    @include('components.logout-modal')

    <script>
        const sidebar = document.getElementById("sidebar");
        let pinned = false;

        /* TOGGLE */
        function toggleSidebar() {

            /* DESKTOP */
            if (window.innerWidth > 1024) {
                pinned = !pinned;
                sidebar.classList.toggle("close", !pinned);
                return;
            }

            /* TABLET */
            if (window.innerWidth > 767) {
                sidebar.classList.toggle("close");
                return;
            }

            /* MOBILE */
            sidebar.classList.toggle("show");
        }

        /* HOVER DESKTOP */
        sidebar.addEventListener("mouseenter", () => {

            if (window.innerWidth <= 1024) return;

            if (!pinned) {
                sidebar.classList.remove("close");
            }
        });

        sidebar.addEventListener("mouseleave", () => {

            if (window.innerWidth <= 1024) return;

            if (!pinned) {
                sidebar.classList.add("close");
            }
        });

        /* TABLET + MOBILE */
        function toggleMobileSidebar() {
            if (window.innerWidth > 1024) return;
            sidebar.classList.toggle("show");
            if (sidebar.classList.contains("show")) {
                sidebar.classList.remove("close");
            } else {
                sidebar.classList.add("close");
            }
        }

        // HOVER EXPAND
        sidebar.addEventListener("mouseenter", () => {
            if (!pinned) {
                sidebar.classList.remove("close");
            }
        });

        sidebar.addEventListener("mouseleave", () => {
            if (!pinned) {
                sidebar.classList.add("close");
            }
        });

        function openModal() {
            document.getElementById("logoutModal").style.display = "flex";
        }

        function closeModal() {
            document.getElementById("logoutModal").style.display = "none";
        }

        function confirmLogout() {
            document.getElementById("logoutForm").submit();
        }

        window.onclick = function(e) {
            const modal = document.getElementById("logoutModal");
            if (e.target === modal) {
                modal.style.display = "none";
            }
        }

        // TOGGLE DARK MODE
        function toggleDarkMode() {
            let html = document.documentElement;
            let toggle = document.getElementById("darkToggle");

            if (html.classList.contains("dark")) {
                html.classList.remove("dark");
                setCookie("theme", "light", 365);
                if (toggle) toggle.checked = false;
            } else {
                html.classList.add("dark");
                setCookie("theme", "dark", 365);
                if (toggle) toggle.checked = true;
            }
        }

        // AUTO APPLY SAAT HALAMAN LOAD (GLOBAL)
        window.addEventListener("load", function () {
            let html = document.documentElement;
            let toggle = document.getElementById("darkToggle");

            if (getCookie("theme") === "dark") {
                html.classList.add("dark");
                if (toggle) toggle.checked = true;
            } else {
                html.classList.remove("dark");
                if (toggle) toggle.checked = false;
            }
        });

        document.addEventListener("click", function(e) {

            const sidebar =
                document.getElementById("sidebar");

            const toggleBtn =
                document.querySelector(".toggle-btn");

            if (
                window.innerWidth <= 700 &&
                !sidebar.contains(e.target) &&
                !toggleBtn.contains(e.target)
            ) {
                sidebar.classList.remove("show");
            }
        });
        </script>

    @yield('scripts')

</body>
</html>
