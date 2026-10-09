<!doctype html>
<html lang="en" class="dark">

<head>
@include('partials.seo-meta')

   <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
   <meta name="theme-color" content="#0a0a0a">

   <link rel="preconnect" href="https://fonts.bunny.net">
   <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700,800" rel="stylesheet">

   @viteReactRefresh
   @vite(['resources/css/app.css', 'resources/js/main.jsx'])
</head>

<body>
   <div id="root"></div>

   {{-- Crawlable, no-JavaScript fallback: the same core content React renders. --}}
   <noscript>
@include('partials.spa-fallback')
   </noscript>

   {{-- Public site data for the React app's first paint (no secrets). --}}
   <script>
      window.__APP__ = {!! json_encode(['site' => $site], JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!};
   </script>
</body>

</html>
