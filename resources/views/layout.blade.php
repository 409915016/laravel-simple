<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Document</title>
</head>
<body>
<ul class="nav">
    <li class="nav-item"><a class="nav-link " href="/">Home</a></li>
    <li class="nav-item"><a class="nav-link " href="about">About Us</a></li>
    <li class="nav-item"><a class="nav-link " href="contact">Contact Us</a></li>
    <li class="nav-item"><a class="nav-link " href="customers">Customer List</a></li>
</ul>
<div class="container">
    @yield('content')
</div>

<script src="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>