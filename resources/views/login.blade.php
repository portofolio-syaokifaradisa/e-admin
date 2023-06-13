<!DOCTYPE html>
<html lang="en">

<head>
    <title>Halaman Login</title>
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
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/adminty/assets/css/style.css') }}">
</head>

<body class="fix-menu py-0">
    <section class="login-block py-0" style="background-color: lightslategray">
        <div class="container">
            <div class="row py-0">
                <div class="col-sm-12">
                
                    <form class="md-float-material form-material py-0" action="{{ route('verify') }}" method="POST">
                        @csrf

                        <div class="text-center">
                            <img src="{{ asset('logo.png') }}" width="120px">
                        </div>
                        <div class="auth-box card">
                            <div class="card-block">
                                <div class="row m-b-20">
                                    <div class="col-md-12">
                                        <h3 class="text-center">Halaman Login</h3>
                                    </div>
                                </div>
                                @if(Session::has('error'))
                                    <div class="alert alert-danger">{{ Session::get('error') }}</div>
                                @endif
                                <div class="form-group form-primary">
                                    <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <small>{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group form-primary">
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <small>{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                                <div class="row m-t-30">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Login</button>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript" src="{{ asset('vendor/adminty/jquery/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/adminty/jquery-ui/js/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/adminty/popper.js/js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/adminty/bootstrap/css/bootstrap.min.css') }}"></script>

    <script type="text/javascript" src="{{ asset('vendor/adminty/jquery-slimscroll/js/jquery.slimscroll.js') }}"></script>

    <script type="text/javascript" src="{{ asset('vendor/adminty/modernizr/js/modernizr.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/adminty/modernizr/js/css-scrollbars.js') }}"></script>

    <script type="text/javascript" src="{{ asset('vendor/adminty/i18next/js/i18next.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/adminty/i18next-xhr-backend/js/i18nextXHRBackend.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/adminty/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/adminty/jquery-i18next/js/jquery-i18next.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/adminty/assets/js/common-pages.js') }}"></script>

<script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-23581568-13');
</script>
</body>

</html>
