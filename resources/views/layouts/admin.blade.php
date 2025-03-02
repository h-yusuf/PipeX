<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>{{ $title ?? 'PIPX' }}</title>
    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('icons/mtc.png') }}">

    <!-- slim select -->
    <link rel="stylesheet" href="{{ asset('admin_assets/plugins/slim-select/slimselect.min.css') }}">


    <!-- highchart -->
    <script src="{{ asset('theme/js/cdn/highcharts.js') }}"></script>
    <!-- <script src="{{ asset('theme/js/cdn/highcharts-exporting.js') }}"></script> -->

    <!-- fullcalender -->

    <script src="{{ asset('theme/js/cdn/fullcalendar.min.js') }}"></script>

    <!-- vendor css -->

    <link rel="stylesheet" href="{{ asset('theme/css/style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Custom CSS -->
    <link href="{{ asset('admin_assets/css/style.min.css') }}" rel="stylesheet">

    <style>
        .btn {
            margin: 2.5px;
        }
    </style>


    @yield('styles')
</head>

<body class="{{ Request::is('admin') ? 'bg-gray' : '' }}">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>

    <nav class="pcoded-navbar  ">
        @include('layouts.sidebar')
    </nav>
    <!-- [ navigation menu ] end -->

    <!-- [ Header ] start -->
    @include('layouts.navbar')
    <!-- [ Header ] end -->


    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-content">

            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- [ sample-page ] start -->
                <div class="col-sm-12">

                    @yield('content')

                </div>
                <!-- [ sample-page ] end -->
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>



    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ asset('admin_assets/plugins/jquery/dist/jquery.min.js') }}"></script>

    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('admin_assets/plugins/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('admin_assets/plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin_assets/js/app-style-switcher.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('admin_assets/js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ asset('admin_assets/js/sidebarmenu.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('admin_assets/js/custom.js') }}"></script>
    <!--This page JavaScript -->

    <!--flot chart-->
    <script src="{{ asset('admin_assets/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('admin_assets/plugins/flot.tooltip/js/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('admin_assets/js/pages/dashboards/dashboard1.js') }}"></script>

    <!-- slim-select -->
    <script src="{{ asset('admin_assets/plugins/slim-select/slimselect.min.js') }}"></script>

    <script src="{{ asset('theme/js/vendor-all.min.js') }}"></script>
    <script src="{{ asset('theme/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('theme/js/pcoded.min.js') }}"></script>

    <!--Moment js -->
    <script src="{{ asset('admin_assets/js/moment.min.js') }}"></script>

    <!-- DataTables JS & CSS with Bootstrap and Buttons integration -->
    <link rel="stylesheet" href="{{ asset('theme/css/plugins/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/css/plugins/buttons.bootstrap4.min.css') }}">


    <script src="{{ asset('theme/js/cdn/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('theme/js/cdn/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('theme/js/cdn/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('theme/js/cdn/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('theme/js/cdn/jszip.min.js') }}"></script>
    <script src="{{ asset('theme/js/cdn/buttons.html5.min.js') }}"></script>



    {{-- alert confirm delete --}}

    <script>
        $(document).on('click', '.btn-delete', function (event) {
            event.preventDefault();

            const form = $(this).closest('form');

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>


    <link rel="stylesheet" href="{{ asset('theme/css/plugins/sweetalert2.min.css') }}">
    <script src="{{ asset('theme/js/cdn/sweetalert2.all.min.js') }}"></script>


    @yield('scripts')
</body>

</html>