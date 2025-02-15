<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Surgery Scheduling PIC-MTI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <!-- Bootstrap Css -->
    <link href="{!! env('FILES_URL') .'resources/css/bootstrap.min.css'!!}" id="bootstrap-stylesheet" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{!! env('FILES_URL') .'resources/css/icons.min.css'!!}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{!! env('FILES_URL') .'resources/css/app.min.css'!!}" id="app-stylesheet" rel="stylesheet" type="text/css" />
</head>

<body class="authentication-bg">

<div class="account-pages mt-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="text-center">
                    <a href="#" class="logo">
                        <img src="https://pic.edu.pk/resources/logo.png" alt="" height="100" class="logo-dark mx-auto">
                    </a>
                    <p class="text-muted mt-2 mb-4">Surgeries Appointment Scheduling</p>
                </div>
                <div class="card">

                    <div class="card-body p-4">

                        <div class="text-center mb-4">
                            <h4 class="text-uppercase mt-0">Sign In</h4>
                        </div>
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">
                                {{ $error }}
                            </div>
                        @endforeach
                        <form action="{{ route('submit-login') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group mb-3">
                                <label for="emailaddress">Email address</label>
                                <input class="form-control" type="email" name="email" id="emailaddress" required placeholder="Enter your email">
                            </div>

                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <input class="form-control" type="password" name="password" required id="password" placeholder="Enter your password">
                            </div>

                            <div class="form-group mb-0 text-center">
                                <button class="btn btn-primary btn-block" type="submit"> Log In </button>
                            </div>
                        </form>
                    </div> <!-- end card-body -->
                </div>
            </div> <!-- end col -->
        </div>
    </div>
</div>
<script src="{!! env('FILES_URL') .'resources/js/vendor.min.js'!!}"></script>
<script src="{!! env('FILES_URL') .'resources/js/app.min.js'!!}"></script>

</body>
</html>
