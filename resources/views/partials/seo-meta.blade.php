   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>{{ $seo['title'] }}</title>
   @if ($seo['description'])
      <meta name="description" content="{{ $seo['description'] }}">
   @endif
   @if (! empty($seo['keywords']))
      <meta name="keywords" content="{{ implode(', ', $seo['keywords']) }}">
   @endif
   <link rel="canonical" href="{{ $seo['canonical'] }}">
   <meta name="robots" content="{{ $seo['robotsIndex'] ? 'index' : 'noindex' }},{{ $seo['robotsFollow'] ? 'follow' : 'nofollow' }}">

   <!-- Open Graph -->
   <meta property="og:type" content="website">
   <meta property="og:site_name" content="{{ $seo['siteName'] }}">
   <meta property="og:title" content="{{ $seo['ogTitle'] }}">
   @if ($seo['ogDescription'])
      <meta property="og:description" content="{{ $seo['ogDescription'] }}">
   @endif
   <meta property="og:url" content="{{ $seo['canonical'] }}">
   @if ($seo['ogImage'])
      <meta property="og:image" content="{{ $seo['ogImage'] }}">
   @endif

   <!-- Twitter / X -->
   <meta name="twitter:card" content="{{ $seo['twitterImage'] ? 'summary_large_image' : 'summary' }}">
   <meta name="twitter:title" content="{{ $seo['twitterTitle'] }}">
   @if ($seo['twitterDescription'])
      <meta name="twitter:description" content="{{ $seo['twitterDescription'] }}">
   @endif
   @if ($seo['twitterImage'])
      <meta name="twitter:image" content="{{ $seo['twitterImage'] }}">
   @endif

   @foreach ($seo['schemas'] as $schema)
      <script type="application/ld+json">{!! json_encode($schema->ldJson(), JSON_HEX_TAG | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
   @endforeach
