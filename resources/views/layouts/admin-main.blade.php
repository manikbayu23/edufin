<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>EduFin @yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <link rel="icon" href="{{ asset('assets/images/logo-edufin.png') }}" type="image/png">

    <script src="https://code.jquery.com/jquery-3.7.1.slim.js"
        integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
            font-size: 1rem;
        }

        body {
            margin: 0;
            background-color: #f1f1f1;
        }

        .container-main {
            padding: 0 !important;
            margin: 0 !important;
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 220px;
            background-color: #365c4c;
            color: white;
            padding: 20px 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar .logo img {
            height: 40px;
        }

        .sidebar nav a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            font-weight: 500;
        }

        .sidebar nav a:hover,
        .sidebar nav a.active {
            background-color: #90a094;
        }

        .sidebar nav a i {
            margin-right: 10px;
        }

        .main {
            flex-grow: 1;
            padding: 0;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            background-color: #365c4c;
            padding: 15px 30px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .content {
            padding: 30px;
            flex-grow: 1;
        }

        .user-icon {
            font-size: 22px;
        }
    </style>

    @stack('css')
</head>

<body>

    <div class="container-main">
        <div class="sidebar">
            <div>
                <div class="logo">
                    <img src="{{ asset('assets/images/logo-edufin.png') }}" alt="Edufin Logo" />
                    <h2>Edufin</h2>
                </div>
                <nav>
                    <a href="{{ route('admin.dashboard') }}"><i class="bi bi-house"></i> Dashboard</a>
                    <a href="{{ route('admin.customer') }}"><i class="bi bi-folder2-open"></i> Data Peminjam</a>
                    <a href="{{ route('admin.transaction') }}"><i class="bi bi-wallet-fill"></i> Data Transaksi</a>
                    <a href="{{ route('admin.customer-arrears') }}"><i class="bi bi-people-fill"></i> Nasabah
                        Menunggak</a>
                    <a href="{{ route('admin.customer-paid-off') }}"><i class="bi bi-cash-coin"></i> Nasabah Lunas</a>
                    <a href="{{ route('admin.customer-collateral') }}"><i class="bi bi-file-earmark-lock2"></i> Tanda
                        Terima
                        Agunan</a>
                </nav>
            </div>
            <nav><a href="{{ route('logout') }}"><i class="bi bi-box-arrow-right"></i> Logout</a></nav>
        </div>


        <div class="main">
            <div class="topbar">
                <span></span>
                <div class="user-icon"><img src="{{ asset('assets/images/user.png') }}" width="50px"
                        class="profile-thumb" alt="Foto Profil"></div>
            </div>

            <div class="content">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('js')

    <script>
        // Tampilkan data user dari localStorage
        document.getElementById("userName").innerText = localStorage.getItem("userName") || "Enyong!";
        const savedPhoto = localStorage.getItem("userPhoto");
        if (savedPhoto) {
            document.getElementById("navProfilePhoto").src = savedPhoto;
        }

        function hapusAkun() {
            if (confirm("Yakin ingin menghapus akun?")) {
                localStorage.clear();
                alert("Akun berhasil dihapus.");
                window.location.href = "index.html";
            }
        }

        function keluar() {
            window.location.href = "index.html";
        }
    </script>
</body>

</html>
