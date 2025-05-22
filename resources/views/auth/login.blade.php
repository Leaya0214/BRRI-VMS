<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- <title>Accounting Management</title> --}}

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/admin_css/adminlte.min.css') }}">
</head>

<style>
    body {
    overflow: hidden;
}

* {
    margin: 0;
    padding: 0;
}

</style>
<body style="background: #f5f5f5;">
        <div class="row align-items-center" style="min-height: 100vh;">
            <!-- Login Form Column -->
            <div class="col-md-6 d-flex justify-content-center">
                <div class="login-box">
                    <div class="login-logo text-center mb-4">
                        @php
                            $company = \App\Models\Company::first();
                            $companyLogo = $company ? asset('upload_images/company_logo/' . $company->logo) : '';
                        @endphp
                        <img src="{{ $companyLogo }}" width="120" alt="Company Logo" class="mb-3">
                        <h2><b>BRRI-VMS</b></h2>
                    </div>
                    <div class="card p-4 shadow">
                        <h3 class="text-bold mb-2" style="font-weight: bold;"> Sign in</h3>
                        <p class="text-muted mb-4">Enter your email and password to sign in!</p>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="email" name="email" class="form-control" placeholder="Enter email" required autofocus>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3">

                            </div>
                            <button type="submit" class="btn btn-success btn-block">Sign in</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Image Column -->
            <div class="col-md-6 d-none d-md-block">
                <div class="vehicle-image">
                    <img src="{{ asset('image/vehicle.jpeg') }}" alt="Vehicle Image" class="img-fluid rounded-end">
                </div>
            </div>
        </div>

    <!-- jQuery and Bootstrap Scripts -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

<!-- CSS for Custom Styling -->
<style>
    /* Style for the vehicle image */
    .vehicle-image img {
        width: 100%;
        max-width: 100%;
        height: 100vh;
        object-fit: cover;
        /* border-top-left-radius: 50px; */
        border-bottom-left-radius: 80px;
    }

    /* Center the login form */
    .login-box {
        max-width: 400px;
        width: 100%;
    }

    /* Additional styling for form elements */
    .form-control {
        border-radius: 5px;
    }

    .btn-success {
        background-color: #28a745;
        border: none;
    }

    .btn-success:hover {
        background-color: #218838;
    }
</style>



</html>
