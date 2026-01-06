<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Sistem Manajemen Masjid Al-Nassr')</title>

    <!-- Custom fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    
    <!-- Custom styles -->
    <link href="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.4/css/sb-admin-2.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @stack('styles')
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-mosque"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Masjid Al-Nassr</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">Manajemen</div>

            <!-- Nav Item - Event -->
            <li class="nav-item {{ request()->routeIs('events.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('events.index') }}">
                    <i class="fas fa-fw fa-calendar-check"></i>
                    <span>Event Masjid</span>
                </a>
            </li>

            <!-- Nav Item - Aset -->
            <li class="nav-item {{ request()->routeIs('aset.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('aset.index') }}">
                    <i class="fas fa-fw fa-box"></i>
                    <span>Inventaris/Aset</span>
                </a>
            </li>

            <!-- Nav Item - Jadwal Perawatan -->
            <li class="nav-item {{ request()->routeIs('jadwal-perawatan.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('jadwal-perawatan.index') }}">
                    <i class="fas fa-fw fa-calendar-alt"></i>
                    <span>Jadwal Perawatan</span>
                </a>
            </li>

            <!-- Nav Item - Laporan Perawatan -->
            <li class="nav-item {{ request()->routeIs('laporan-perawatan.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('laporan-perawatan.index') }}">
                    <i class="fas fa-fw fa-clipboard-list"></i>
                    <span>Laporan Perawatan</span>
                </a>
            </li>

            <!-- Nav Item - Kegiatan -->
            <li class="nav-item {{ request()->routeIs('kegiatan.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('kegiatan.index') }}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Kegiatan Masjid</span>
                </a>
            </li>

            <!-- Nav Item - Donasi -->
            <li class="nav-item {{ request()->routeIs('donasi.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('donasi.index') }}">
                    <i class="fas fa-fw fa-hand-holding-heart"></i>
                    <span>Program Donasi</span>
                </a>
            </li>

            <!-- Nav Item - Kurban -->
            <li class="nav-item {{ request()->routeIs('kurban.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('kurban.index') }}">
                    <i class="fas fa-fw fa-drumstick-bite"></i>
                    <span>Program Kurban</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">Manajemen ZIS</div>

            <!-- Nav Item - Muzakki -->
            <li class="nav-item {{ request()->routeIs('muzakki.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('muzakki.index') }}">
                    <i class="fas fa-fw fa-user-tie"></i>
                    <span>Muzakki</span>
                </a>
            </li>

            <!-- Nav Item - Mustahik -->
            <li class="nav-item {{ request()->routeIs('mustahik.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('mustahik.index') }}">
                    <i class="fas fa-fw fa-user-friends"></i>
                    <span>Mustahik</span>
                </a>
            </li>

            <!-- Nav Item - ZIS Masuk -->
            <li class="nav-item {{ request()->routeIs('zis-masuk.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('zis-masuk.index') }}">
                    <i class="fas fa-fw fa-hand-holding-usd"></i>
                    <span>ZIS Masuk</span>
                </a>
            </li>

            <!-- Nav Item - Penyaluran -->
            <li class="nav-item {{ request()->routeIs('penyaluran.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('penyaluran.index') }}">
                    <i class="fas fa-fw fa-share-square"></i>
                    <span>Penyaluran ZIS</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">Manajemen Takmir</div>

            <!-- Nav Item - Posisi -->
            <li class="nav-item {{ request()->routeIs('positions.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('positions.index') }}">
                    <i class="fas fa-fw fa-briefcase"></i>
                    <span>Posisi/Jabatan</span>
                </a>
            </li>

            <!-- Nav Item - Pengurus -->
            <li class="nav-item {{ request()->routeIs('committees.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('committees.index') }}">
                    <i class="fas fa-fw fa-users-cog"></i>
                    <span>Data Pengurus</span>
                </a>
            </li>

            <!-- Nav Item - Tugas & Tanggung Jawab -->
            <li class="nav-item {{ request()->routeIs('job-responsibilities.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('job-responsibilities.index') }}">
                    <i class="fas fa-fw fa-tasks"></i>
                    <span>Tugas & Tanggung Jawab</span>
                </a>
            </li>

            <!-- Nav Item - Jadwal Piket -->
            <li class="nav-item {{ request()->routeIs('duty-schedules.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('duty-schedules.index') }}">
                    <i class="fas fa-fw fa-calendar-week"></i>
                    <span>Jadwal Piket</span>
                </a>
            </li>

            <!-- Nav Item - Penugasan Tugas -->
            <li class="nav-item {{ request()->routeIs('task-assignments.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('task-assignments.index') }}">
                    <i class="fas fa-fw fa-clipboard-check"></i>
                    <span>Penugasan Tugas</span>
                </a>
            </li>

            <!-- Nav Item - Struktur Organisasi -->
            <li class="nav-item {{ request()->routeIs('organizational-structures.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('organizational-structures.index') }}">
                    <i class="fas fa-fw fa-sitemap"></i>
                    <span>Struktur Organisasi</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">Informasi</div>

            <!-- Nav Item - Artikel & Pengumuman -->
            <li class="nav-item {{ request()->routeIs('articles.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('articles.index') }}">
                    <i class="fas fa-fw fa-newspaper"></i>
                    <span>Artikel & Pengumuman</span>
                </a>
            </li>

            <!-- Nav Item - Jadwal Sholat -->
            <li class="nav-item {{ request()->routeIs('prayer-schedules.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('prayer-schedules.index') }}">
                    <i class="fas fa-fw fa-pray"></i>
                    <span>Jadwal Sholat</span>
                </a>
            </li>

            @if(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())
            <!-- Nav Item - Log Aktivitas -->
            <li class="nav-item {{ request()->routeIs('log-aktivitas.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('log-aktivitas.index') }}">
                    <i class="fas fa-fw fa-history"></i>
                    <span>Log Aktivitas</span>
                </a>
            </li>
            @endif

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->nama_lengkap ?? auth()->user()->name }}</span>
                                @if(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())
                                    <span class="badge badge-danger">Admin</span>
                                @elseif(auth()->user()->isDkm())
                                    <span class="badge badge-warning">DKM</span>
                                @elseif(auth()->user()->isPanitia())
                                    <span class="badge badge-info">Panitia</span>
                                @elseif(auth()->user()->isJemaah())
                                    <span class="badge badge-success">Jemaah</span>
                                @else
                                    <span class="badge badge-secondary">User</span>
                                @endif
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    @yield('content')
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Sistem Manajemen Masjid Al-Nassr {{ date('Y') }}</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.4/js/sb-admin-2.min.js"></script>

    @stack('scripts')
</body>
</html>
