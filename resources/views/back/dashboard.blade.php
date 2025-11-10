<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Tableau de bord  MK Service">
    <meta name="author" content="MK_Service">

    <title>MK_Service</title>

    <link rel="icon" type="image/png" href="{{ asset('Images/logo.png') }}" />

    <!-- Fonts et styles -->
    <link href="{{ asset('dashboard/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,600,700,800,900" rel="stylesheet">
    <link href="{{ asset('dashboard/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/css/styles.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Logo -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Ventoo" width="70" height="70" class="rounded-circle shadow border border-white p-1 bg-white">
            </a>

            <hr class="sidebar-divider my-0">

            <!-- Navigation -->
            <li class="nav-item {{ request()->is('administrateur') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/administrateur') }}">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Mon Espace</span>
                </a>
            </li>

            <li class="nav-item {{ request()->is('administrateur/articles*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/administrateur/articles') }}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Mes Articles</span>
                </a>
            </li>

            <li class="nav-item {{ request()->is('administrateur/messages*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/administrateur/messages') }}">
                    <i class="fas fa-fw fa-comment"></i>
                    <span>Mes Messages</span>
                </a>
            </li>

            <li class="nav-item {{ request()->is('administrateur/commandes*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/administrateur/commandes') }}">
                    <i class="fas fa-fw fa-box"></i>
                    <span>Mes Commandes</span>
                </a>
            </li>

            <li class="nav-item {{ request()->is('administrateur/parametres*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.parametres') }}">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Paramètres</span>
                </a>
            </li>


            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggle -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow-sm">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- User Avatar -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="img-profile rounded-circle" src="{{ asset('images/logo.png') }}"
                                    width="40" height="40" alt="Admin Logo">
                            </a>

                            <!-- Dropdown Menu -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">

                                <!-- Option Paramètres -->
                                <a class="dropdown-item" href="{{ route('admin.parametres') }}">
                                    <i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>
                                    Paramètres
                                </a>

                                <div class="dropdown-divider"></div>

                                <!-- Option Déconnexion -->
                                <a class="dropdown-item text-danger fw-bold" href="{{ route('admin.logout') }}"
                                    onclick="event.preventDefault(); if(confirm('Voulez-vous vraiment vous déconnecter ?')) document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-danger"></i>
                                    Se déconnecter
                                </a>

                                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>

                    </ul>
                </nav>
                <!-- End Topbar -->

                <!-- Main Content Section -->
                @yield('content')

            </div>
            <!-- End Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; MK Service 2025</span>
                    </div>
                </div>
            </footer>

        </div>
        <!-- End Content Wrapper -->

    </div>
    <!-- End Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Scripts -->
    <script src="{{ asset('dashboard/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dashboard/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('dashboard/vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('dashboard/js/demo/chart-pie-demo.js') }}"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>

    @stack('scripts')

</body>

</html>