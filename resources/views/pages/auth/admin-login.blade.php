<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Login - EduFin</title>
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.slim.js"
        integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background-color: #f0f0f0;
            height: 100vh;
            display: flex;
        }

        .left-panel {
            background-color: #365c4c;
            color: white;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }

        .left-panel h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .left-panel p {
            font-size: 1rem;
            text-align: center;
            max-width: 300px;
        }

        .right-panel {
            flex: 1;
            background-color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }

        .right-panel h2 {
            font-size: 2.2rem;
            margin-bottom: 20px;
        }

        .social-icons {
            display: flex;
            gap: 15px;
            margin-bottom: 10px;
        }

        .social-icons div {
            background-color: #e0e0e0;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 18px;
        }

        .right-panel input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .login-btn {
            background-color: #365c4c;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            margin-top: 20px;
            cursor: pointer;
            font-weight: bold;
        }

        .login-btn:hover {
            background-color: #2b4d3f;
        }
    </style>
</head>

<body>

    <div class="left-panel">
        <h1>Welcome Back<br>ADMIN</h1>
        <p>To keep connected and manage data please login with your personal info first</p>
    </div>

    <div class="right-panel">
        <h2>Sign In</h2>

        <div class="social-icons">
            <div>f</div>
            <div>G</div>
            <div>in</div>
        </div>

        <p>or use your account</p>

        <form action="{{ route('do-login') }}" method="POSt">
            @csrf
            <input type="email" name="email" placeholder="Email" required />
            {{-- @if ($errors->has('email'))
                <div class="error-text text-danger text-start mb-1 w-100"><i class="fas fa-times me-1"></i>
                    {{ $errors->first('email') }}
                </div>
            @endif --}}
            <input type="password" name="password" placeholder="Password" required />
            {{-- @if ($errors->has('password'))
                <div class="error-text text-danger text-start mb-1 w-100"><i class="fas fa-times me-1"></i>
                    {{ $errors->first('password') }}
                </div>
            @endif --}}
            <button type="submit" class="login-btn">LOGIN</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        @if ($errors->has('failed'))
            $(document).ready(function() {
                Swal.fire({
                    title: 'Failed',
                    text: "{{ $errors->first('failed') }}",
                    icon: 'info'
                })
            })
        @endif
    </script>

</body>

</html>
