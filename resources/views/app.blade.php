<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Vue App</title>
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.x/css/materialdesignicons.min.css" rel="stylesheet">
    @vite(['resources/js/app.js'])

</head>
<body class="antialiased">

    <div id="app">
        <login></login>
        @yield('content')

    </div>
</body>
</html>
