<!-- resources/views/layouts/main.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>HRIS | {{ $title ?? ($data['title'] ?? 'Home') }}</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('admin/form/logo/logoFull.png') }}" rel="icon">
    <link href="{{ asset('assets/rapid/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Montserrat:300,400,500,600,700" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/rapid/vendor/fontawesome-free/css/all.min.css') }}">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/rapid/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/rapid/vendor/bootstrap4/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/rapid/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/rapid/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/rapid/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin/assets/adminlte3/plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/adminlte3/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/adminlte3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/rapid/vendor/datepicker/css/bootstrap-datetimepicker.min.css') }}">
    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/rapid/css/style.css') }}" rel="stylesheet">

    <script src="{{ asset('assets/rapid/js/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/assets/adminlte3/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/rapid/vendor/datepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('admin/assets/adminlte3/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('admin/assets/adminlte3/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 3000
        });

        const Delete = Swal.mixin({
            width: '22rem',
            position: 'top',
            icon: 'warning',
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        });
    </script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top d-flex align-items-center header-transparent">
        <div class="container d-flex align-items-center">

            <!-- <h1 class="logo me-auto"><a href="index.html">PORTAL</a></h1> -->
            <!-- Uncomment below if you prefer to use an image logo -->
            <a href="{{ url('/') }}" class="logo me-auto">
                <img src="{{ asset('admin/form/logo/logoFull.png') }}" alt="" class="img-fluid img-thumbnail">
                HRIS Cubiconia
            </a>

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto" href="{{ url('lowongan/#index') }}">Job Vacancy</a></li>
                    <li><a class="nav-link scrollto" href="{{ url('/#home') }}">Beranda</a></li>
                    <li><a class="nav-link scrollto" href="{{ url('/#contact') }}">Kontak</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle mr-1"></i>
            </nav><!-- .navbar -->
            <div class="pt-4"></div>
            <div class="social-links">
                @auth
                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                    {{ auth()->user()->firstname }} {{ auth()->user()->lastname }}
                </button>
                <div class="dropdown-menu p-0 mt-3" style="width:250px">
                    <div class="card">
                        <div class="card-body text-center">
                            <p class="m-0">Welcome,</p>
                            <h5>{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</h5>
                            <img class="rounded-circle" src="{{ asset('admin/assets/img/users/' . auth()->user()->photo) }}" width="100px">
                        </div>
                        <div class="card-footer p-2">
                            <div class="btn-group" style="width:100%">

                                <button type="button" onclick="location.href='{{route('dashboard') }}'" class="btn btn-info">
                                    <i class="fas fa-fw fa-tachometer-alt"></i>
                                    Admin
                                </button>
                                <button type="button" onclick="document.getElementById('logout-form').submit();" class="btn btn-danger">
                                    <i class="fas fa-sign-out-alt"></i>
                                    Logout
                                </button>
                                <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <button type="button" class="btn bg-cubiconia text-light btn-sm" data-toggle="modal" data-target="#modal-login">LOGIN</button>
                @endauth
            </div>
        </div>
    </header><!-- End Header -->

    @yield('content')

    <section id="contact" class="section-bg">
        <div class="contact-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="contact-links">
                            <img src="{{ asset('admin/form/logo/logoFull.png') }}" width="60px" class="float-left mr-2 img-thumbnail">
                            <h4>HRIS 
                                <br>Cubiconia
                            </h4>
                            <h6>
                            Signature Park Grande CTB/L1/03
                                <br>  MT Haryono St No.Kav. 20 <br>
                                Cawang, Jakarta 16360
                            </h6>
                            <strong>Phone:</strong>0822-2118-8192<br>
                            <strong>Email:</strong> hello@cubiconia.com<br>
                        </div>
                    </div>

                    <div class="col-lg-6">

                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- ======= Call To Action Section ======= -->
    <div id="call-to-action" class="call-to-action bg-cubiconia">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center text-white">
                    <small>
                        &copy; Copyright <strong>HRIS</strong>. All Rights Reserved
                    </small>
                    <br>
                    <small>
                        <strong>HRIS Cubiconia</strong>
                    </small>
                </div>
            </div>
        </div>
    </div><!--  End Call To Action Section -->

    <a class="back-to-top d-flex align-items-center justify-content-center nav-link scrollto" href="#header"><i class="bi bi-arrow-up-short"></i></a>

    <!-- The Modal -->
    <div class="modal fade" id="modal-login">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <!-- Modal Header -->
                    <div class="modal-header bg-cubiconia m-2">
                        <h4 class="modal-title text-white">
                            <i class="fas fa-id-badge"></i>
                            Login Form
                        </h4>
                        <a type="button" class="close" data-dismiss="modal">&times;</a>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="email">Username:</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                                <input type="email" class="form-control" placeholder="Enter Username" id="email" name="email" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pwd">Password:</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-key"></i>
                                    </span>
                                </div>
                                <input type="password" class="form-control" placeholder="Enter password" id="pwd" name="password" required>
                            </div>
                        </div>
                        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.key') }}"></div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer bg-light">
                        <!-- <button type="button" class="btn btn-default btn-sm" onclick="showForgot()">
                            <i class="fas fa-unlock"></i>
                            Forgot Password
                        </button> -->
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-sign-in-alt"></i>
                            Login
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-forgot">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">


            </div>
        </div>
    </div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/rapid/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/rapid/vendor/bootstrap4/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/rapid/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/rapid/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/rapid/vendor/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/rapid/js/main.js') }}"></script>
    <script>
       @if(session('status') || session('success') || session('error') || session('warning'))
        $(function() {
            @if(session('status'))
            Toast.fire({
                icon: 'success',
                title:  "&nbsp;&nbsp;{{ session('status') }}"
            });
            @endif

            @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: "&nbsp;&nbsp;{{ session('success') }}"
            });
            @endif

            @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: "&nbsp;&nbsp;{{ session('error') }}"
            });
            @endif

            @if(session('warning'))
            Toast.fire({
                icon: 'warning',
                title: "&nbsp;&nbsp;{{ session('warning') }}"
            });
            @endif
        });
        @endif

        function showForgot() {
            $('#modal-login').modal('hide');
            $('#modal-forgot').modal('show');
        }
    </script>

    @stack('scripts')
</body>

</html>