<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Untree.co">
    <link rel="shortcut icon" href="logo edufin.jpg">
    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('assets/css/tiny-slider.css ') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/form.css') }}" rel="stylesheet">

    <title>Welcome to EduFin.</title>

    <script src="https://code.jquery.com/jquery-3.7.1.slim.js"
        integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>
    <style>
        .error-text {
            font-size: 0.6rem;
        }
    </style>
</head>

<body>
    <div class="container @if ($errors->any() && old('type') == 'register') right-panel-active @endif " id="container">
        <!-- Sign Up -->
        <div class="form-container sign-up-container">

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <h1>Create Account</h1>
                <div class="social-container">
                    <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                    <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <span>or use your email for registration</span>
                <input type="hidden" name="type" value="register">
                <input type="text" name="name_reg" placeholder="Name" value="{{ old('name') }}" />
                @if ($errors->has('name_reg'))
                <div class="error-text text-danger text-start mb-1 w-100"><i class="fas fa-times me-1"></i>
                    {{ $errors->first('name_reg') }}
                </div>
                @endif
                <input type="email" name="email_reg" placeholder="Email" value="{{ old('email') }}" />
                @if ($errors->has('email_reg'))
                <div class="error-text text-danger text-start mb-1 w-100"><i class="fas fa-times me-1"></i>
                    {{ $errors->first('email_reg') }}
                </div>
                @endif
                <input type="password" name="password_reg" placeholder="Password" />
                @if ($errors->has('password_reg'))
                <div class="error-text text-danger text-start mb-1 w-100"><i class="fas fa-times me-1"></i>
                    {{ $errors->first('password_reg') }}
                </div>
                @endif
                <button>Sign Up</button>
            </form>
        </div>

        <!-- Sign In -->
        <div class="form-container sign-in-container">
            <form action="{{ route('do-login') }}" method="POST">
                @csrf
                <h1>Sign in</h1>
                <div class="social-container">
                    <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                    <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <span>or use your account</span>
                <input type="hidden" name="type" value="login">
                <input type="email" name="email" placeholder="Email" />
                @if ($errors->has('email'))
                <div class="error-text text-danger text-start mb-1 w-100"><i class="fas fa-times me-1"></i>
                    {{ $errors->first('email') }}
                </div>
                @endif
                <input type="password" name="password" placeholder="Password" />
                @if ($errors->has('password'))
                <div class="error-text text-danger text-start mb-1 w-100"><i class="fas fa-times me-1"></i>
                    {{ $errors->first('password') }}
                </div>
                @endif
                <a href="#">Forgot your password?</a>
                <button type="submit">Sign In</button>
            </form>
        </div>

        <!-- Overlay -->
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">

                    <h1>Welcome Back!</h1>
                    <p>To keep connected with us please login with your personal info</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <p>Enter your personal details and start journey with us</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/tiny-slider.js') }}"></script>
    {{--
    <script src="{{ asset('assets/js/form.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const signUpBtn = document.getElementById('signUp');
        const signInBtn = document.getElementById('signIn');
        const container = document.getElementById('container');

        signUpBtn.addEventListener('click', () => container.classList.add("right-panel-active"));
        signInBtn.addEventListener('click', () => container.classList.remove("right-panel-active"));
        @if ($errors -> has('failed'))
            $(document).ready(function () {
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