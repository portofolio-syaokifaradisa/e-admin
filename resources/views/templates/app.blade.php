<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ $title ?? '' }}</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="#">
    <meta name="keywords" content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="#">

    <link rel="icon" href="{{ asset('logo.png') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/adminty/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/adminty/assets/icon/themify-icons/themify-icons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/adminty/assets/icon/icofont/css/icofont.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/adminty/assets/icon/feather/css/feather.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/adminty/assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/adminty/assets/css/jquery.mCustomScrollbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/fontawesome-free-5.7.2/css/all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/adminty/select2/css/select2.min.css') }}">
    
    {{-- Datatables --}}
  <link rel="stylesheet" href="{{ asset('vendor/datatables/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/datatables/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
</head>

<body>
<!-- Pre-loader start -->
<div class="theme-loader">
    <div class="ball-scale">
        <div class='contain'>
            <div class="ring">
                <div class="frame"></div>
            </div>
            <div class="ring">
                <div class="frame"></div>
            </div>
            <div class="ring">
                <div class="frame"></div>
            </div>
            <div class="ring">
                <div class="frame"></div>
            </div>
            <div class="ring">
                <div class="frame"></div>
            </div>
            <div class="ring">
                <div class="frame"></div>
            </div>
            <div class="ring">
                <div class="frame"></div>
            </div>
            <div class="ring">
                <div class="frame"></div>
            </div>
            <div class="ring">
                <div class="frame"></div>
            </div>
            <div class="ring">
                <div class="frame"></div>
            </div>
        </div>
    </div>
</div>
<!-- Pre-loader end -->
<div id="pcoded" class="pcoded">
    <div class="pcoded-overlay-box"></div>
    <div class="pcoded-container navbar-wrapper">

        <nav class="navbar header-navbar pcoded-header">
            <div class="navbar-wrapper">

                <div class="navbar-logo text-center">
                    <a class="mobile-menu" id="mobile-collapse" href="#!">
                        <i class="feather icon-menu"></i>
                    </a>
                    <a href="{{ route('home') }}" class="py-1">
                        <img class="img-fluid mr-1" src="{{ asset('logo.png') }}" width="40px;">
                        e - Admin
                    </a>
                    <a class="mobile-options">
                        <i class="feather icon-more-horizontal"></i>
                    </a>
                </div>

                @include('templates.topbar')
            </div>
        </nav>
        <!-- Sidebar inner chat end-->
        <div class="pcoded-main-container">
            <div class="pcoded-wrapper">
                <nav class="pcoded-navbar">
                    <div class="pcoded-inner-navbar main-menu pb-0">
                        @include('templates.sidebar')
                    </div>
                </nav>
                <div class="pcoded-content">
                    <div class="pcoded-inner-content">
                        <div class="main-body">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="{{ asset('vendor/adminty/jquery/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/adminty/jquery-ui/js/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/adminty/popper.js/js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/adminty/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="{{ asset('vendor/adminty/jquery-slimscroll/js/jquery.slimscroll.js') }}"></script>
    <!-- modernizr js -->
    <script type="text/javascript" src="{{ asset('vendor/adminty/modernizr/js/modernizr.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/adminty/modernizr/js/css-scrollbars.js') }}"></script>

    <!-- i18next.min.js -->
    <script type="text/javascript" src="{{ asset('vendor/adminty/i18next/js/i18next.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/adminty/i18next-xhr-backend/js/i18nextXHRBackend.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/adminty/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/adminty/jquery-i18next/js/jquery-i18next.min.js') }}"></script>
    <!-- Custom js -->

    <script src="{{ asset('vendor/adminty/assets/js/pcoded.min.js') }}"></script>
    <script src="{{ asset('vendor/adminty/assets/js/vartical-layout.min.js') }}"></script>
    <script src="{{ asset('vendor/adminty/assets/css/jquery.mCustomScrollbar.css') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/adminty/assets/js/script.js') }}"></script>

    {{-- Datatables --}}
    <script src="{{ asset('vendor/datatables/datatables/media/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('vendor/datatables/datatables.net-bs4/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('vendor/datatables/datatables.net-select-bs4/js/select.bootstrap4.js') }}"></script>
    <script src="{{ asset('vendor/fontawesome-free-5.7.2/js/all.min.js') }}"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/alert.js') }}"></script>

    @yield('js-extends')
    
<script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-23581568-13');
</script>
</body>

</html>
