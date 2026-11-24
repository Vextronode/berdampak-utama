<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Berdampak Utama - Kampus Berdampak Universitas Widyatama' }}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,600;1,700&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    
    <link rel="icon" type="image/png" href="{{ asset('images/logo-widyatama.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface text-on-surface antialiased flex flex-col min-h-screen">
    <x-navbar />

    <main class="flex-1">
        {{ $slot }}
    </main>

    <x-footer />
</body>
</html>
