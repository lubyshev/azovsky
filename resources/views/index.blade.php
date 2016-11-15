<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/css/document.css">
</head>
<body>

    <nav class="navbar navbar-fixed-top navbar-dark bg-inverse">
      <a class="navbar-brand" href="#">{{ $title }}</a>
      <ul class="nav navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="/">Home</a>
        </li>
      </ul>
    </nav>

    <div class="container">
      <div class="starter-template">
        <h1>{{ $h1 }}</h1><hr />
        @yield('content')
      </div>
    </div>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script src="/js/document.js"></script>
</body>
</html>
