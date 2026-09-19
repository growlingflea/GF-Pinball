<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>{{ $title ?? 'GF-Pinball' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <meta property="og:title" content="GF-Pinball">
    <meta property="og:description" content="Good Fuckin Pinball">
    <meta property="og:image" content="{{ asset('images/og-preview.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    {{-- iMessage/Android also fall back to these if og:title/description are missing, but including them explicitly doesn't hurt --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="GF-Pinball">
    <meta name="twitter:description" content="On-site pinball reference: cheat sheets, rules, and machine info while you're standing at the machine.">
    <meta name="twitter:image" content="{{ asset('images/og-preview.png') }}">




</head>
<body>
@include('partials.nav')

<main>
    {{ $slot }}
</main>
</body>
</html>
