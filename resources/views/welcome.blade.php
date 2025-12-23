<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- Bootstrap 5 JS Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynQ9YzsP7UckJ2i02tzt0u2Ae/y0A5AmAD5KiS4XDGEyNmt6E4Fb6q2i2SS" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-8 text-center">
                <h1 class="display-1 fw-bold text-primary mb-4">Hello World</h1>
                <p class="lead text-muted">Welcome to {{ config('app.name', 'Laravel') }}</p>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            console.log('jQuery is loaded and working!');
            console.log('Bootstrap 5 is ready!');
        });
    </script>
</body>
</html>
