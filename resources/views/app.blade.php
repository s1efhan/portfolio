<!DOCTYPE html>
<html lang="de">

<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" href="/favicon.ico">
  @vite('resources/css/style.scss')
  @vite('resources/js/app.js')
</head>

<body>
  <div id="app"></div>
</body>

</html>