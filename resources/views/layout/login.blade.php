<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('layout.recursos.icon_title')
    <title>@yield('title')</title>
    {!!Html::style('css/login.min.css')!!}
</head>
<body>
  @yield('content')
  {!!Html::script('js/cosapidata_login.min.js')!!}

  <script>
      $.backstretch([
          "/background/background_01.jpg",
          "/background/background_02.jpg",
          "/background/background_03.jpg",
          "/background/background_04.jpg",
          "/background/background_05.jpg"
      ], {duration: 3000, fade: 750});
  </script>
</body>
</html>
