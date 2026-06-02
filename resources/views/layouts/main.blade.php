<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HookPoint</title>

    @yield('styles')
</head>

<body>

    @include('components.navbar')

    <main>
        @yield('content')
    </main>

    @include('components.footer')

    <script>
        function toggleMenu() {
            document.getElementById("navbarMenu").classList.toggle("active");
        }

        const elements = document.querySelectorAll('.fade-up');

        function checkScroll() {
            const triggerBottom = window.innerHeight * 0.85;

            elements.forEach(el => {
                const boxTop = el.getBoundingClientRect().top;

                if (boxTop < triggerBottom) {
                    el.classList.add('show');
                }else {
                    el.classList.remove('show');
                }
            });
        }

        window.addEventListener('scroll', checkScroll);
        checkScroll();
    </script>

    @yield('scripts')

</body>
</html>
