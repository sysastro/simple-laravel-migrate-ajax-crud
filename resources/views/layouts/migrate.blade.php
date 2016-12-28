<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Laravel Migrate</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" type="text/css" rel="stylesheet">
    @yield('styles')
</head>

<body>

<div class="container">
    @yield('content')
</div>

<script src="{{ asset('js/jquery-3.1.0.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.base64.min.js') }}" type="text/javascript"></script>
@yield('scripts')
</body>
</html>
