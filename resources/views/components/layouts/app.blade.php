<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>{{ $title ?? 'GF-Pinball' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<header class="site-header">
    <a href="{{ url('/') }}" class="site-header__logo">GF-Pinball</a>
    <nav class="site-header__nav">
        <a href="{{ route('games.index') }}">Games</a>
    </nav>
</header>

<main>
    {{ $slot }}
</main>
</body>
</html>
