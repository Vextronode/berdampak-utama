<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $title ?? 'Portal Pengelola Kampus Berdampak - Login Admin | Universitas Widyatama' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet">

    <link rel="icon" type="image/png" href="{{ asset('images/logo-widyatama.png') }}">

    @vite(['resources/css/app.css', 'resources/js/apanel.js'])
</head>
<body class="h-full bg-surface-variant text-on-surface antialiased selection:bg-primary selection:text-white">
    {{ $slot }}
</body>
</html>
