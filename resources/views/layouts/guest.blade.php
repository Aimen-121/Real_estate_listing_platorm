<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Real Estate Listing Platform') }}</title>

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Bootstrap 5 CSS CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap Icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

        <!-- Custom Styling via Vite -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-light">
        <div class="container d-flex flex-column align-items-center justify-content-center min-vh-screen py-5">
            <div class="mb-4">
                <a href="/" class="d-flex align-items-center text-decoration-none text-dark">
                    <span class="fs-2 fw-bold text-primary-custom">
                        <i class="bi bi-houses-fill me-2"></i>RealEstate
                    </span>
                </a>
            </div>

            <div class="card shadow-sm border-0 rounded-4 w-100 p-4 p-md-5" style="max-width: 500px; background-color: #ffffff;">
                {{ $slot }}
            </div>
        </div>

        <!-- Bootstrap 5 JS Bundle CDN -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
