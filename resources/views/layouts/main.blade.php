<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>EduFin @yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="icon" href="{{ asset('assets/images/logo-edufin.png') }}" type="image/png">

    <script src="https://code.jquery.com/jquery-3.7.1.slim.js"
        integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>
    <style>
        <style>body {
            background-color: #ffffff;
            color: #2c4a42;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }

        .custom-navbar {
            background-color: #2c4a42;
            padding: 1rem 1.5rem;
        }

        .custom-navbar .navbar-brand,
        .custom-navbar .nav-link,
        .custom-navbar .dropdown-toggle {
            color: white !important;
            font-weight: 600;
        }

        .profile-thumb {
            width: 56px;
            height: 56px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #fff;
            box-shadow: 0 0 5px rgba(255, 255, 255, 0.6);
            background-color: #fff;
            transition: transform 0.2s ease-in-out;
        }

        .profile-thumb:hover {
            transform: scale(1.05);
        }

        .feature-card {
            background: linear-gradient(to right, #3b5d50, #2c4a42);
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .feature-card:hover {
            transform: scale(1.03);
        }

        .feature-card i {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .feature-card .btn {
            margin-top: 15px;
            background-color: white;
            color: #2c4a42;
            font-weight: bold;
        }

        footer {
            margin-top: auto;
            text-align: center;
            padding: 30px 0 20px;
            color: #999;
        }

        .btn-edufin {
            background-color: #2c4a42;
            color: white;
            padding: 10px 25px;
            border-radius: 30px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-edufin:hover {
            background-color: #3b5d50;
            color: white;
        }
    </style>

    @stack('css')
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg custom-navbar">
        <a class="navbar-brand d-flex align-items-center gap-2" href="#">
            <img src="{{ asset('assets/images/logo-edufin.png') }}" alt="EduFin Logo" style="height: 40px;">
            <span class="fw-bold text-white fs-5">EduFin</span>
        </a>
        <div class="ms-auto d-flex align-items-center" style="margin-right: 10px;">
            <div class="dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userMenu"
                    role="button" data-bs-toggle="dropdown">
                    <img id="navProfilePhoto" src="{{ asset('assets/images/user.png') }}" class="profile-thumb"
                        alt="Foto Profil">
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                    @if (Auth::check())
                        <li><a class="dropdown-item" href="profile.html">Akun</a></li>
                        {{-- <li><a class="dropdown-item text-danger" href="#" onclick="hapusAkun()">Hapus Akun</a></li> --}}
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item">Keluar</button>
                            </form>
                        </li>
                    @else
                        <li><a class="dropdown-item" href="{{ route('login') }}">Sign in</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')


    <!-- Footer -->
    <footer id="default-footer">
        <p>&copy; 2025 EduFin. All rights reserved.</p>
    </footer>

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
