<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <title>@yield('title', 'Welcome')</title>
</head>
<body>

<div class="container">

    @include('nav')

    @if(session()->has('message'))
        <div class="alert alert-success" role="alert">
            <strong>Success </strong>{{ session()->get('message') }}
        </div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
