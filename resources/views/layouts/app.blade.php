<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>xxx</title>
    {{-- <link href="{{ asset('css/custom.css') }}" rel="stylesheet"> --}}
    {{-- {{ config('app.name', 'Laravel') }} --}}

    <!-- Bootstrap CSS -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}

    <!-- Custom Styles -->
    @yield('styles')
</head>
<body>

    <main class="py-4">
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>


    <!-- Custom Scripts -->
    @yield('scripts')
</body>
</html>
