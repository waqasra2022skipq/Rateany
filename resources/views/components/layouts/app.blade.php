<!doctype html>
<html class="scroll-smooth" lang = "en">

    <head>
        <meta charset="utf-8">
        <link rel="icon" href="{{ asset('images/favicon.ico') }}" />

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
        <title>{{ $pageTitle ?? 'Top rated businesses and professionals' }} | Rateany</title>
        <meta name="description" content="{{ $metaDescription ?? 'Find top rated businesses and professionals' }}">
        @vite('resources/css/app.css')
        @livewireStyles
    </head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-PKJ14JPDD9"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-PKJ14JPDD9');
    </script>

    <body class="antialiased">

        @livewire('navbar')

        {{ $slot }}
        @include('components.footer')

        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
        @vite('resources/js/app.js')
        @livewireScripts
    </body>

</html>
