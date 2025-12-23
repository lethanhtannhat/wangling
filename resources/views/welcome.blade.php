<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
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

    <!-- jQuery CDN -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>

    <!-- Bootstrap 5 JS Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            console.log('jQuery is loaded and working!');
            console.log('Bootstrap 5 is ready!');
        });
    </script>
</body>
</html>
