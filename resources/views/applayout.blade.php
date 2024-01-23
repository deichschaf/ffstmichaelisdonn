<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no"/>
    <title>Freiwillige Feuerwehr Sankt Michaelisdonn -</title>
    <meta property="og:title" content="Freiwillige Feuerwehr Sankt Michaelisdonn - ">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://ffstmichaelisdonn.j-mh.de">
    <meta property="og:site_name" content="Freiwillige Feuerwehr Sankt Michaelisdonn">
    <meta property="og:description" content="">
    <meta property="og:image" content="https://ffstmichaelisdonn.j-mh.de/gfx/ffstmichaelisdonn.png">
    <meta property="og:image:width" content="283">
    <meta property="og:image:height" content="159">
    <link rel="image_src" href="https://ffstmichaelisdonn.j-mh.de/gfx/ffstmichaelisdonn.png">

    @env('local')
        <link rel="stylesheet" href="/css/admin_app.css?t={!! time() !!}" type="text/css">
    @endenv
    @env('production')
        <link rel="stylesheet" href="/css/admin_app.{!! time() !!}.css" type="text/css">
    @endenv

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    @env('local')
        <script async="async" src="/js/html5shiv.js?t={!! time() !!}"></script>

    @endenv
    @env('production')
        <script async="async" src="/js/html5shiv.{!! time() !!}.js"></script>

    @endenv

    <![endif]-->
    <link rel="shortcut icon" href="/images/favicons/favicon.ico" type="image/ico">
    <link rel="icon" href="/images/favicons/favicon.ico" type="image/ico">
    <link rel="shortcut icon" type="image/x-icon" href="/images/favicons/favicon.ico">
    <link rel="icon" type="image/x-icon" href="/images/favicons/favicon.ico">
    <link rel="icon" type="image/gif" href="/images/favicons/favicon.gif">
    <link rel="icon" type="image/png" href="/images/favicons/favicon.png">
    <link rel="apple-touch-icon" href="/images/favicons/apple-touch-icon.png">
    <link rel="apple-touch-icon" href="/images/favicons/apple-touch-icon-57x57.png" sizes="57x57">
    <link rel="apple-touch-icon" href="/images/favicons/apple-touch-icon-60x60.png" sizes="60x60">
    <link rel="apple-touch-icon" href="/images/favicons/apple-touch-icon-72x72.png" sizes="72x72">
    <link rel="apple-touch-icon" href="/images/favicons/apple-touch-icon-76x76.png" sizes="76x76">
    <link rel="apple-touch-icon" href="/images/favicons/apple-touch-icon-114x114.png" sizes="114x114">
    <link rel="apple-touch-icon" href="/images/favicons/apple-touch-icon-120x120.png" sizes="120x120">
    <link rel="apple-touch-icon" href="/images/favicons/apple-touch-icon-128x128.png" sizes="128x128">
    <link rel="apple-touch-icon" href="/images/favicons/apple-touch-icon-144x144.png" sizes="144x144">
    <link rel="apple-touch-icon" href="/images/favicons/apple-touch-icon-152x152.png" sizes="152x152">
    <link rel="apple-touch-icon" href="/images/favicons/apple-touch-icon-180x180.png" sizes="180x180">
    <link rel="apple-touch-icon" href="/images/favicons/apple-touch-icon-precomposed.png">
    <link rel="icon" type="image/png" href="/images/favicons/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="/images/favicons/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/images/favicons/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="/images/favicons/favicon-160x160.png" sizes="160x160">
    <link rel="icon" type="image/png" href="/images/favicons/favicon-192x192.png" sizes="192x192">
    <link rel="icon" type="image/png" href="/images/favicons/favicon-196x196.png" sizes="196x196">
    <meta name="msapplication-TileImage" content="/images/favicons/win8-tile-144x144.png">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-navbutton-color" content="#ffffff">
    <meta name="application-name" content="Freiwillige Feuerwehr Sankt Michaelisdonn"/>
    <meta name="msapplication-tooltip" content="Freiwillige Feuerwehr Sankt Michaelisdonn"/>
    <meta name="apple-mobile-web-app-title" content="Freiwillige Feuerwehr Sankt Michaelisdonn"/>
    <meta name="msapplication-starturl" content="https://ffstmichaelisdonn.j-mh.de"/>
    <meta name="msapplication-square70x70logo" content="/images/favicons/win8-tile-70x70.png">
    <meta name="msapplication-square144x144logo" content="/images/favicons/win8-tile-144x144.png">
    <meta name="msapplication-square150x150logo" content="/images/favicons/win8-tile-150x150.png">
    <meta name="msapplication-wide310x150logo" content="/images/favicons/win8-tile-310x150.png">
    <meta name="msapplication-square310x310logo" content="/images/favicons/win8-tile-310x310.png">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
</head>
<body id="bodyarea">
<div id="root"></div>
@env('local')
    <script type="text/javascript" src="/js/app_bundle.js?t={!! time() !!}"></script>
@endenv
@env('production')
    <script type="text/javascript" src="/js/app_bundle.{!! time() !!}.js"></script>
@endenv
</body>
</html>
