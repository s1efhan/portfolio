<!DOCTYPE html>
<html lang="de">

<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="initial-scale=1.0, width=device-width">
  <link rel="icon" href="/favicon.ico">
  @vite('resources/css/style.scss')
  @vite('resources/js/app.js')
</head>

<body>
  <div id="app"></div>
</body>

</html>