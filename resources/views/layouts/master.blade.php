<!DOCTYPE html><!--[if IE 7]>
<html class="#{content}" lang="#{page.lang}" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://ogp.me/ns/fb#"></html><![endif]--><!--[if IE 8]>
<html class="#{content}" lang="#{page.lang}" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://ogp.me/ns/fb#"></html><![endif]--><!--[if IE 9]>
<html class="#{content}" lang="#{page.lang}" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://ogp.me/ns/fb#"></html><![endif]-->
<html lang="#{page.lang}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="language" content="es">
    <title>@yield('title')</title>
    <meta name="title" content="@yield('title')">
    <meta name="description" content="FullCine es una empresa peruana dedicada a brindar el mejor entretenimiento cinematografico">
    <meta name="author" content="@ronnyfly2">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">
    <meta name="keywords" content="fullcine, estrenos, cine, cine Perú, cartelera, películas, entretenimiento Perú, film ,filme, movie trailer, trailer, video, cine bar, estrenos, próximos estrenos, promociones, cines peruanos, películas peruanas, salas de cine, salas de cine Perú, novedades de cine, entretenimiento perú">
    <meta property="og:description" content="FullCine es una empresa peruana dedicada a brindar el mejor entretenimiento cinematografico">
    <meta property="og:image" content="/static//img/logo.png">
    <meta property="og:site_name" content="empty">
    <meta property="og:title" ccontent="@yield('title')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="/">
    <link href="/css/all.css?ver=1534485157558" media="all" rel="stylesheet" type="text/css">
    <link href="{{ asset('img/favicon/favicon.ico') }}" rel="shortcut icon" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('img/favicon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('img/favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('img/favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('img/favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('img/favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('img/favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('img/favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('img/favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('img/favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('img/favicon/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff"><!--[if lte IE 9]>
      <link href="/css/modules/all/ie.css" media="all" rel="stylesheet" type="text/css">
      <script src="/js/libs/selectivizr/selectivizr.js"></script>
      <script src="/js/libs/html5shiv/dist/html5shiv.js"></script><![endif]-->
  </head>
  <body>@if (Session::has('flash_notification.message'))
    <div class="alert_notice alert-{{ Session::get('flash_notification.level') }}"><span>{{ Session::get('flash_notification.message') }}</span>
      <div class="icon icon-close"></div>
    </div>@endif
    <!-- coment-->@include('layouts.header')
    @yield('content')
    @include('layouts.footer')
    <div class="box_auth"></div><?php $data = varView(); ?>
    <script>
      window.alpha = {
      	baseUrl: '{{$data["baseUrl"]}}',
      	urlMiddleware: '{{$data["urlMiddleware"]}}',
      	module: '{{$data["module"]}}',
      	controller: '{{$data["controller"]}}',
      	action: '{{$data["action"]}}'
       }
    </script>
    <script src="{{ asset('js/libs/jquery/dist/jquery.min.js') }}?ver=1534485157558" type="text/javascript"></script>
    <script data-main="/js/main.js?ver=1534485157558" src="{{ asset('js/libs/requirejs/require.js') }}?ver=1534485157558"></script>
  </body>
</html>