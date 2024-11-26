<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Kolkata 2 Dhaka</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- MATERIAL DESIGN ICONIC FONT -->
    <link rel="stylesheet" href="{{ asset('login/fonts/material-design-iconic-font/css/material-design-iconic-font.min.css') }}">

    <!-- STYLE CSS -->
    <link rel="stylesheet" href="{{ asset('login/css/style.css') }}">
</head>

<body>

    <div class="wrapper">
        <div class="image-holder">
            <img src="{{ asset('login/images/registration-form-8.jpg') }}" alt="">
        </div>
        <div class="form-inner">
            <form method="POST" action="{{ route('customer-registration') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-header">
                    <h3>Sign up</h3>
                    <img src="{{ asset('login/images/sign-up.png') }}" alt="" class="sign-up-icon">
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" name="name" id="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="email" name="email" id="email" class="form-control" data-validation="email" required>
                </div>
                <div class="form-group">
                    <label for="mobile">Mobile:</label>
                    <input type="text" name="mobile" id="mobile" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" class="form-control" data-validation="length" data-validation-length="min8" required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password:</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" data-validation="length" data-validation-length="min8" required>
                </div>
                <button type="submit" class="btn btn-primary">Create My Account</button>
                <div class="socials">
                    <p>Sign up with social platforms</p>
                    <a href="#" class="socials-icon">
                        <i class="zmdi zmdi-facebook"></i>
                    </a>
                    <a href="#" class="socials-icon">
                        <i class="zmdi zmdi-instagram"></i>
                    </a>
                    <a href="#" class="socials-icon">
                        <i class="zmdi zmdi-twitter"></i>
                    </a>
                    <a href="#" class="socials-icon">
                        <i class="zmdi zmdi-tumblr"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('login/js/jquery-3.3.1.min.js') }}"></script>
    <!-- Form Validator -->
    <script src="{{ asset('login/js/jquery.form-validator.min.js') }}"></script>
    <!-- Main JS -->
    <script src="{{ asset('login/js/main.js') }}"></script>
</body>

</html>
