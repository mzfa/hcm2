<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="">
    <title>{{ env('APP_NAME_HCM')}}</title>

    <!-- manifest meta -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="manifest" href="manifest.json" />

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('assets/modules/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/weather-icon/css/weather-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/weather-icon/css/weather-icons-wind.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-94034622-3');
    </script>
</head>

<body class="body-scroll" data-page="index">

    <!-- loader section -->
    <!-- <div class="container-fluid loader-wrap">
        <div class="row h-100">
            <div class="col-10 col-md-6 col-lg-5 col-xl-3 mx-auto text-center align-self-center">
                <div class="loader-cube-wrap loader-cube-animate mx-auto">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo">
                </div>
                <p class="mt-4">It's time for track budget<br><strong>Please wait...</strong></p>
            </div>
        </div>
    </div> -->
    <!-- loader section ends -->

    <!-- Sidebar main menu -->
    <div class="sidebar-wrap  sidebar-pushcontent">
        <!-- Add overlay or fullmenu instead overlay -->
        <div class="closemenu text-muted">Close Menu</div>
            <div class="sidebar dark-bg">
                <!-- user information -->
                <div class="row my-3">
                    <div class="col-12 ">
                        <div class="card shadow-sm bg-opac text-white border-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-auto">
                                        <figure class="avatar avatar-44 rounded-15">
                                            <img src="{{ Session('foto_profile') }}" alt="">
                                        </figure>
                                    </div>
                                    <div class="col px-0 align-self-center">
                                        <p class="mb-1">{{ Auth::user()->name }}</p>
                                        <p class="text-muted size-12">Online</p>
                                    </div>
                                    <div class="col-auto">
                                        <form action="{{ route('logout') }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-44 btn-light">
                                                <i class="bi bi-box-arrow-right"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="card bg-opac text-white border-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <h1 class="display-6">2</h1>
                                        </div>
                                        <div class="col-auto">
                                            <p class="text-muted">Uang Hari Ini</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        
                <!-- user emnu navigation -->
                @include('layouts.sidebar')
            </div>
        </div>
    <!-- Sidebar main menu ends -->

    <!-- Begin page -->
    <main class="h-100">

        <!-- Header -->
        <header class="header position-fixed">
            <div class="row">
                <div class="col-auto">
                    <a href="javascript:void(0)" target="_self" class="btn btn-light btn-44 menu-btn">
                        <i class="bi bi-list"></i>
                    </a>
                </div>
                <div class="col align-self-center text-center">
                    <div class="logo-small">
                        <img src="{{ asset(env('APP_LOGO_HCM')) }}" alt="">
                        <h5>{{ env('APP_NAME_HCM')}}</h5>
                    </div>
                </div>
                <div class="col-auto">
                    <a  type="button" data-bs-toggle="modal" data-bs-target="#notification" class="btn btn-light btn-44">
                        <i class="bi bi-bell"></i>
                        <span class="count-indicator"></span>
                    </a>
                </div>
                
            </div>
        </header>
        <!-- Header ends -->

        <!-- main page content -->
        <div class="container">
            
            @yield('content')
        </div>  
        <!-- main page content ends -->

    </main>
    <!-- Page ends-->

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <ul class="nav nav-pills nav-justified">
                <li class="nav-item">
                    <a class="nav-link active" href="home.php">
                        <span>
                            <i class="nav-icon bi bi-house"></i>
                            <span class="nav-text">Home</span>
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="home.php?mod=siswa">
                        <span>
                            <i class="nav-icon bi bi-laptop"></i>
                            <span class="nav-text">Siswa</span>
                        </span>
                    </a>
                </li>
                <li class="nav-item centerbutton">
                    <div class="nav-link">
                        <span class="theme-radial-gradient">
                            <i class="close bi bi-x"></i>
                            <img src="{{ asset('assets/img/centerbutton.svg') }}" class="nav-icon" alt="" />
                        </span>
                        <div class="nav-menu-popover justify-content-between">
                            <button type="button" class="btn btn-lg btn-icon-text"
                                onclick="window.location.replace('home.php?mod=spp');">
                                <i class="bi bi-credit-card size-32"></i><span>SPP</span>
                            </button>

                            <button type="button" class="btn btn-lg btn-icon-text"
                                onclick="window.location.replace('sendmoneyhome.php?mod=kas');">
                                <i class="bi bi-arrow-up-right-circle size-32"></i><span>KAS</span>
                            </button>

                            <button type="button" class="btn btn-lg btn-icon-text"
                                onclick="window.location.replace('home.php?mod=laporanspp');">
                                <i class="bi bi-receipt size-32"></i><span>Laporan SPP</span>
                            </button>

                            <button type="button" class="btn btn-lg btn-icon-text"
                                onclick="window.location.replace('home.php?mod=laporankas');">
                                <i class="bi bi-arrow-down-left-circle size-32"></i><span>Laporan KAS</span>
                            </button>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="home.php?mod=siswa">
                        <span>
                            <i class="nav-icon bi bi-gift"></i>
                            <span class="nav-text">Cetak Struk</span>
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="home.php?mod=siswa">
                        <span>
                            <i class="nav-icon bi bi-wallet2"></i>
                            <span class="nav-text">Kategori Kas</span>
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </footer>
    <!-- Footer ends-->

    
    <!-- Required jquery and libraries -->
    <script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-5/js/bootstrap.bundle.min.js') }}"></script>

    <!-- cookie js -->
    <script src="{{ asset('assets/js/jquery.cookie.js') }}"></script>

    <!-- Customized jquery file  -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/color-scheme.js') }}"></script>

    <!-- PWA app service registration and works -->
    <script src="{{ asset('assets/js/pwa-services.js') }}"></script>

    <!-- Chart js script -->
    <script src="{{ asset('assets/vendor/chart-js-3.3.1/chart.min.js') }}"></script>

    <!-- Progress circle js script -->
    <script src="{{ asset('assets/vendor/progressbar-js/progressbar.min.js') }}"></script>

    <!-- swiper js script -->
    <script src="{{ asset('assets/vendor/swiperjs-6.6.2/swiper-bundle.min.js') }}"></script>

    <!-- page level custom script -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
    
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <img src="..." class="rounded me-2" alt="...">
            <strong class="me-auto">Bootstrap</strong>
            <small>11 mins ago</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Hello, world! This is a toast message.
        </div>
        </div>
    </div>
  <script>
      $(document).ready( function () {
            $('#allData').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel', 'pdf', 'print'
                ]
            });

        } );
  </script>

  @yield('scripts')

<div class="modal fade" id="notification" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="notificationLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notificationLabel">Notifikasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul>
                    <li>Lorem, ipsum dolor.</li>
                    <li>Lorem, ipsum dolor.</li>
                    <li>Lorem, ipsum dolor.</li>
                    <li>Lorem, ipsum dolor.</li>
                  </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
  </div>
</body>

</html>