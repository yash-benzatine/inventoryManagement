<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" sizes="76x76" href="/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/img/favicon.png">
    <title>
        @yield('title')
    </title>

    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{asset('assets/css/nucleo-icons.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/nucleo-svg.css')}}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="{{asset('assets/css/nucleo-svg.css')}}" rel="stylesheet" />

    <!-- CSS Files -->
    <link id="pagestyle" href="{{asset('assets/css/argon-dashboard.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/argon.css')}}" rel="stylesheet" />
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> --}}
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"> -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Raleway'>
    <link rel='stylesheet' href='https://fonts.googleapis.com/icon?family=Material+Icons'>
<!-- <link href="https://cdn.jsdelivr.net/npm/@coreui/coreui-pro@5.0.0/dist/css/coreui.min.css" rel="stylesheet" integrity="sha384-IWXc/Qn4K3kXUZMsZBceGfN84sg1+4HwBe2h5xrkXUexo51S/ImL+3wWnCHsh2uZ" crossorigin="anonymous"> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/@coreui/coreui-pro@5.0.0/dist/js/coreui.bundle.min.js" integrity="sha384-XhHOTYRsazIACXdXVSb4WMf8BMnDO9Pmd5nlutkwH4jryCW6NHABK94+4xk2qTYM" crossorigin="anonymous"></script>     -->
    <style>
        table.dataTable tbody th, table.dataTable tbody td {
            padding: 0 !important;
        }
    </style>
</head>

<body class="{{ $class ?? '' }}">
    <div class="min-height-300 bg-primary position-absolute w-100"></div>
    @include('admin.layout.sidebar')

    <main class="main-content border-radius-lg">
        @include('admin.layout.header')
        <div class="container-fluid">
            @yield('content')
            @include('admin.layout.footer')
        </div>
    </main>

    @yield('page-script')
    <!--   Core JS Files   -->
    <script src="{{asset('assets/js/core/popper.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
      <script src="{{ asset('assets/vendor/js-cookie/js.cookie.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
    <script src="{{asset('assets/js/core/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/smooth-scrollbar.min.js')}}"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }

    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="{{ asset('assets/js/argon-dashboard.js') }}"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->


    <script>
        // $(document).ready(function() {

        var theme = localStorage.getItem('theme');
        var body = document.getElementsByTagName('body')[0];
        var hr = document.querySelectorAll('div:not(.sidenav) > hr');
        var sidebar = document.querySelector('.sidenav');
        var sidebarWhite = document.querySelectorAll('.sidenav.bg-white');
        var hr_card = document.querySelectorAll('div:not(.bg-gradient-dark) hr');
        var text_btn = document.querySelectorAll('button:not(.btn) > .text-dark');
        var text_span = document.querySelectorAll('span.text-dark, .breadcrumb .text-dark');
        var text_span_white = document.querySelectorAll('span.text-white');
        var text_strong = document.querySelectorAll('strong.text-dark');
        var text_strong_white = document.querySelectorAll('strong.text-white');
        var text_nav_link = document.querySelectorAll('a.nav-link.text-dark');
        var secondary = document.querySelectorAll('.text-secondary');
        var bg_gray_100 = document.querySelectorAll('.bg-gray-100');
        var bg_gray_600 = document.querySelectorAll('.bg-gray-600');
        var btn_text_dark = document.querySelectorAll('.btn.btn-link.text-dark, .btn .ni.text-dark');
        var btn_text_white = document.querySelectorAll('.btn.btn-link.text-white, .btn .ni.text-white');
        var card_border = document.querySelectorAll('.card.border');
        var card_border_dark = document.querySelectorAll('.card.border.border-dark');
        var svg = document.querySelectorAll('g');
        var navbarBrand = document.querySelector('.navbar-brand-img');
        var navbarBrandImg = navbarBrand.src;
        var navLinks = document.querySelectorAll(
            '.navbar-main .nav-link, .navbar-main .breadcrumb-item, .navbar-main .breadcrumb-item a, .navbar-main h6'
        );
        var cardNavLinksIcons = document.querySelectorAll('.card .nav .nav-link i');
        var cardNavSpan = document.querySelectorAll('.card .nav .nav-link span');

        if (theme == "dark") {
            body.classList.add('dark-version');

            if (navbarBrandImg.includes('logo-ct-dark.png')) {
                var navbarBrandImgNew = navbarBrandImg.replace("logo-ct-dark", "logo-ct");
                navbarBrand.src = navbarBrandImgNew;
            }

            for (var i = 0; i < cardNavLinksIcons.length; i++) {
                if (cardNavLinksIcons[i].classList.contains('text-dark')) {
                    cardNavLinksIcons[i].classList.remove('text-dark');
                    cardNavLinksIcons[i].classList.add('text-white');
                }
            }

            for (var i = 0; i < cardNavSpan.length; i++) {
                if (cardNavSpan[i].classList.contains('text-sm')) {
                    cardNavSpan[i].classList.add('text-white');
                }
            }

            for (var i = 0; i < hr.length; i++) {
                if (hr[i].classList.contains('dark')) {
                    hr[i].classList.remove('dark');
                    hr[i].classList.add('light');
                }
            }

            for (var i = 0; i < hr_card.length; i++) {
                if (hr_card[i].classList.contains('dark')) {
                    hr_card[i].classList.remove('dark');
                    hr_card[i].classList.add('light');
                }
            }

            for (var i = 0; i < text_btn.length; i++) {
                if (text_btn[i].classList.contains('text-dark')) {
                    text_btn[i].classList.remove('text-dark');
                    text_btn[i].classList.add('text-white');
                }
            }

            for (var i = 0; i < text_span.length; i++) {
                if (text_span[i].classList.contains('text-dark')) {
                    text_span[i].classList.remove('text-dark');
                    text_span[i].classList.add('text-white');
                }
            }

            for (var i = 0; i < text_strong.length; i++) {
                if (text_strong[i].classList.contains('text-dark')) {
                    text_strong[i].classList.remove('text-dark');
                    text_strong[i].classList.add('text-white');
                }
            }

            for (var i = 0; i < text_nav_link.length; i++) {
                if (text_nav_link[i].classList.contains('text-dark')) {
                    text_nav_link[i].classList.remove('text-dark');
                    text_nav_link[i].classList.add('text-white');
                }
            }

            for (var i = 0; i < secondary.length; i++) {
                if (secondary[i].classList.contains('text-secondary')) {
                    secondary[i].classList.remove('text-secondary');
                    secondary[i].classList.add('text-white');
                    secondary[i].classList.add('opacity-8');
                }
            }

            for (var i = 0; i < bg_gray_100.length; i++) {
                if (bg_gray_100[i].classList.contains('bg-gray-100')) {
                    bg_gray_100[i].classList.remove('bg-gray-100');
                    bg_gray_100[i].classList.add('bg-gray-600');
                }
            }

            for (var i = 0; i < btn_text_dark.length; i++) {
                btn_text_dark[i].classList.remove('text-dark');
                btn_text_dark[i].classList.add('text-white');
            }

            for (var i = 0; i < sidebarWhite.length; i++) {
                sidebarWhite[i].classList.remove('bg-white');
            }

            for (var i = 0; i < svg.length; i++) {
                if (svg[i].hasAttribute('fill')) {
                    svg[i].setAttribute('fill', '#fff');
                }
            }

            for (var i = 0; i < card_border.length; i++) {
                card_border[i].classList.add('border-dark');
            }
        } else {
            body.classList.remove('dark-version');
            sidebar.classList.add('bg-white');

            if (navbarBrandImg.includes('logo-ct.png')) {
                var navbarBrandImgNew = navbarBrandImg.replace("logo-ct", "logo-ct-dark");
                navbarBrand.src = navbarBrandImgNew;
            }

            for (var i = 0; i < navLinks.length; i++) {
                if (navLinks[i].classList.contains('text-dark')) {
                    navLinks[i].classList.add('text-white');
                    navLinks[i].classList.remove('text-dark');
                }
            }

            for (var i = 0; i < cardNavLinksIcons.length; i++) {
                if (cardNavLinksIcons[i].classList.contains('text-white')) {
                    cardNavLinksIcons[i].classList.remove('text-white');
                    cardNavLinksIcons[i].classList.add('text-dark');
                }
            }

            for (var i = 0; i < cardNavSpan.length; i++) {
                if (cardNavSpan[i].classList.contains('text-white')) {
                    cardNavSpan[i].classList.remove('text-white');
                }
            }

            for (var i = 0; i < hr.length; i++) {
                if (hr[i].classList.contains('light')) {
                    hr[i].classList.add('dark');
                    hr[i].classList.remove('light');
                }
            }

            for (var i = 0; i < hr_card.length; i++) {
                if (hr_card[i].classList.contains('light')) {
                    hr_card[i].classList.add('dark');
                    hr_card[i].classList.remove('light');
                }
            }

            for (var i = 0; i < text_btn.length; i++) {
                if (text_btn[i].classList.contains('text-white')) {
                    text_btn[i].classList.remove('text-white');
                    text_btn[i].classList.add('text-dark');
                }
            }

            for (var i = 0; i < text_span_white.length; i++) {
                if (text_span_white[i].classList.contains('text-white') && !text_span_white[i].closest(
                        '.sidenav') && !text_span_white[i].closest('.card.bg-gradient-dark')) {
                    text_span_white[i].classList.remove('text-white');
                    text_span_white[i].classList.add('text-dark');
                }
            }

            for (var i = 0; i < text_strong_white.length; i++) {
                if (text_strong_white[i].classList.contains('text-white')) {
                    text_strong_white[i].classList.remove('text-white');
                    text_strong_white[i].classList.add('text-dark');
                }
            }

            for (var i = 0; i < secondary.length; i++) {
                if (secondary[i].classList.contains('text-white')) {
                    secondary[i].classList.remove('text-white');
                    secondary[i].classList.remove('opacity-8');
                    secondary[i].classList.add('text-dark');
                }
            }

            for (var i = 0; i < bg_gray_600.length; i++) {
                if (bg_gray_600[i].classList.contains('bg-gray-600')) {
                    bg_gray_600[i].classList.remove('bg-gray-600');
                    bg_gray_600[i].classList.add('bg-gray-100');
                }
            }

            for (var i = 0; i < svg.length; i++) {
                if (svg[i].hasAttribute('fill')) {
                    svg[i].setAttribute('fill', '#252f40');
                }
            }

            for (var i = 0; i < btn_text_white.length; i++) {
                if (!btn_text_white[i].closest('.card.bg-gradient-dark')) {
                    btn_text_white[i].classList.remove('text-white');
                    btn_text_white[i].classList.add('text-dark');
                }
            }

            for (var i = 0; i < card_border_dark.length; i++) {
                card_border_dark[i].classList.remove('border-dark');
            }
        }
        // })

    </script>

    <!-- <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-select/js/dataTables.select.min.js') }}"></script>
    <script>
         // Function to enable dark mode
    function enableDarkMode() {
        // Add classes or styles to switch to dark mode
        document.body.classList.add('g-sidenav-show');
        document.body.classList.add('dark-mode');
        document.body.classList.add('dark-version');
        document.body.classList.add('bg-gray-600');

        document.querySelector('.navbar').classList.replace('bg-white', 'bg-default');
        document.querySelector('.sidenav').classList.replace('bg-white', 'bg-default');
    }

    // Function to disable dark mode
    function disableDarkMode() {
        // Remove classes or styles to switch to light mode
        document.body.classList.remove('g-sidenav-show');
        document.body.classList.remove('dark-mode');
        document.body.classList.remove('dark-version');
        document.body.classList.remove('bg-gray-600');

        document.querySelector('.navbar').classList.replace('bg-default', 'bg-white');
        document.querySelector('.sidenav').classList.replace('bg-default', 'bg-white');
    }

    // Function to toggle dark mode
    function toggleDarkMode() {
        if (localStorage.getItem('darkMode') === 'enabled') {
            enableDarkMode(); // Enable dark mode if stored preference is 'enabled'
        } else {
            disableDarkMode(); // Disable dark mode if stored preference is not 'enabled'
        }
    }

    // Event listener for toggling dark mode when the DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        toggleDarkMode(); // Check and toggle dark mode based on user preference
    });

    // Event listener for dark mode toggle button click
    document.getElementById('theme-btn-dark').addEventListener('click', function() {
        enableDarkMode(); // Enable dark mode
        localStorage.setItem('darkMode', 'enabled'); // Store dark mode preference
    });

    // Event listener for light mode toggle button click
    document.getElementById('theme-btn-light').addEventListener('click', function() {
        disableDarkMode(); // Disable dark mode
        localStorage.removeItem('darkMode'); // Remove dark mode preference
    });
    </script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            }
        });
    </script>
    <script>
        @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}"
        switch (type) {
            case 'info':

                toastr.options.timeOut = 10000;
                toastr.info("{{ Session::get('message') }}");
                var audio = new Audio('audio.mp3');
                audio.play();
                break;
            case 'success':

                toastr.options.timeOut = 10000;
                toastr.success("{{ Session::get('message') }}");
                var audio = new Audio('audio.mp3');
                audio.play();

                break;
            case 'warning':

                toastr.options.timeOut = 10000;
                toastr.warning("{{ Session::get('message') }}");
                var audio = new Audio('audio.mp3');
                audio.play();

                break;
            case 'error':

                toastr.options.timeOut = 10000;
                toastr.error("{{ Session::get('message') }}");
                var audio = new Audio('audio.mp3');
                audio.play();

                break;
        }
        @endif

    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@coreui/coreui-pro@5.0.0/dist/js/coreui.min.js" integrity="sha384-P55oEtbpJcbKNSX0lgAPDYscDoCN5JqAnSPTimkcSTygCzQ6W8l60nRD09Vzfzx6" crossorigin="anonymous"></script>
</body>
</html>
