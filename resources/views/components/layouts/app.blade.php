<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>{{ $title ?? 'GF-Pinball' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <meta property="og:title" content="GF-Pinball">
    <meta property="og:description" content="Play Some Fuckin Pinball">
    <meta property="og:image" content="{{ asset('images/topnav.JPG') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    {{-- iMessage/Android also fall back to these if og:title/description are missing, but including them explicitly doesn't hurt --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="GF-Pinball">
    <meta name="twitter:description" content="Play some fuckin pins.">
    <meta name="twitter:image" content="{{ asset('images/og-preview.png') }}">




</head>
<body>
@include('partials.nav')

<main>
    {{ $slot }}
</main>
</body>
</html>
