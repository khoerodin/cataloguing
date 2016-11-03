<!DOCTYPE html>
<html>
<head>
    <meta name="robots" content="noindex,nofollow"/>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ MetaTag::get('title') }}</title>
    <meta name="description" content="{{ MetaTag::get('description') }}">
    @yield('styles')
</head>
<body>
    <noscript>
        <style type="text/css">#loading,.container {display:none;}</style>
        <div style="display: table;margin: 0 auto;color:#999;">
            <h1><strong>You don't have JavaScript :(</strong></h1>
            <h1 style="visibility: hidden;">_____________________________________________________________</h1>
        </div>        
    </noscript>

    @if (Request::url() != url('login'))
    <div id="loading"><div class="spinner"></div></div>
    @endif

    @yield('content')
    @yield('scripts')
    </body>
</html>