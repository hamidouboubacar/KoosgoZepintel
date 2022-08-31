<!Doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
   @include('layouts.template.meta')
    <!-- CSS FILES -->
    @yield('cssfiles')
    <style>
        .pdfobject-container { height: 40rem; border: 1rem solid rgba(0,0,0,.1); }
        </style>
    <!-- CSRF Token -->

    <title>{{ env('APP_NAME') }} @yield('title')</title>
    <!-- Styles -->
    @include('layouts.template.cssfiles')
    
    @livewireStyles

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <style>
        .duplicate {
            border: 1px solid red;
            color: red;
        }
        .scroll {
            max-height: 500px;
            overflow-y: auto;
        }
    </style>
</head>

<body class="loading"
    data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "dark"}, "showRightSidebarOnPageLoad": true}'>
    <div id="wrapper">
        @include('layouts.template.menu')
        <div class="left-side-menu">
            <div class="h-100" data-simplebar>
                <div class="user-box text-center">
                    <img src="../assets/images/users/user-1.jpg" alt="user-img" title="Mat Helme"
                        class="rounded-circle avatar-md">
                    <div class="dropdown">
                        <a href="javascript: void(0);" class="text-dark dropdown-toggle h5 mt-2 mb-1 d-block"
                            data-toggle="dropdown">Geneva Kennedy</a>
                        <div class="dropdown-menu user-pro-dropdown">
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="fe-user mr-1"></i>
                                <span>My Account</span>
                            </a>
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="fe-settings mr-1"></i>
                                <span>Settings</span>
                            </a>
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="fe-lock mr-1"></i>
                                <span>Lock Screen</span>
                            </a>

                            <!-- item-->
                         {{--    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="fe-log-out mr-1"></i>
                                <span>Logout</span>
                            </a --}}>

                        </div>
                    </div>
                    <p class="text-muted">Admin Head</p>
                </div>

                <!--- Sidemenu -->
                @include('layouts.template.sidemenu')

                <!-- End Sidebar -->

                <div class="clearfix"></div>

            </div>
            <!-- Sidebar -left -->

        </div>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content mt-2">

                <!-- Start Content-->

                <h3 class="m-3">@yield('title')</h3> 
                @if (Session::has("message"))
                    <div class="alert alert-success alert-dismissible fade show pt-3" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                <strong> {{ Session::get('message', '')}}</strong>
                    </div>
                @endif

                @if (Session::has("error"))
                <div class="alert alert-danger alert-dismissible fade show pt-3" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            <strong> {{ Session::get('error', '')}}</strong>
                </div>
            @endif

            @if (Session::has("delete"))
            <div class="alert alert-warning alert-dismissible fade show pt-3" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        <strong> {{ Session::get('delete', '')}}</strong>
            </div>
        @endif


                {{-- <script>
                  $(".alert").alert();
                </script> --}}
                @yield('content')
                <!-- container -->

            </div> <!-- content -->

            <!-- Footer Start -->
            @include('layouts.template.footer')
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->

    <!-- Right Sidebar -->

    <!-- jsfiles -->
    @include('layouts.template.jsfiles')
    <script>
        $(document).ready(function () {
            $('.supprimer').click(function (e) {
                if (!confirm("Voulez vous supprimer ?")) {
                    e.preventDefault ();
                }
            })
        })
    </script>
    @stack('js_files')
</body>

</html>
