<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'LSP Application') }} | @yield('title')</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('admin/assets/adminlte3/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/rapid/vendor/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/datepicker/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/adminlte3/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/adminlte3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link href="{{ asset('admin/form/logo/logoFull.png') }}" rel="icon">
    <script src="{{ asset('admin/assets/adminlte3/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('admin/assets/adminlte3/plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/adminlte3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/adminlte3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
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
    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">
    <div class="wrapper">
        <!-- Include topbar and sidebar components -->
        @include('components.topbar')
        @include('components.sidebar')

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Content Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6" style="margin-left: 10px;">
                            <h1 class="m-0">@yield('title')</h1>
                        </div>
                        <!-- <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                @yield('breadcrumb')
                            </ol>
                        </div> -->
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>

        <!-- Footer -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0.0
            </div>
            <strong>Copyright &copy; {{ date('Y') }} <a href="{{ url('/') }}">HRIS Cubiconia</a>.</strong> All rights reserved.
        </footer>
    </div>

    <!-- Scripts -->
    <!-- Before @stack('scripts') -->
    <script src="{{ asset('assets/rapid/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/rapid/vendor/bootstrap4/js/bootstrap.bundle.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.13.6/r-2.5.0/datatables.min.js"></script>
    <script src="{{ asset('admin/assets/adminlte3/dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('admin/assets/datepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('admin/assets/adminlte3/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/assets/adminlte3/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
   
    <script src="{{ asset('admin/assets/adminlte3/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('admin/assets/tinymce/tinymce.min.js') }}"></script>

    <script>
        function hideMenu() {
            $('body').toggleClass('sidebar-collapse');
        }
    </script>
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