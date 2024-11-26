<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Kolkata 2 Dhaka</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- MATERIAL DESIGN ICONIC FONT -->
    <link rel="stylesheet"
        href="{{ asset('login/fonts/material-design-iconic-font/css/material-design-iconic-font.min.css') }}">

    <!-- STYLE CSS -->
    <link rel="stylesheet" href="{{ asset('login/css/style.css') }}">
</head>

<body>

    <div class="wrapper">
        <div class="image-holder">
            <img src="{{ asset('login/images/registration-form-8.jpg') }}" alt="">
        </div>
        <div class="form-inner">
            <form method="POST" action="{{ route('customer.login') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-header">
                    <h3>Sign in</h3>
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
                    <label for="email">E-mail:</label>
                    <input type="email" name="email" id="email" class="form-control" data-validation="email"
                        required>
                </div>
               
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" class="form-control" data-validation="length"
                        data-validation-length="min8" required>
                </div>
               

                <button type="submit" class="btn btn-primary">Log In</button>
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
