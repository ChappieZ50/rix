<!DOCTYPE html>
<html lang="tr" class="no-js">
<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Author Meta -->
    <meta name="author" content="codepixer">
    <!-- Meta Description -->
    <meta name="description" content="">
    <!-- Meta Keyword -->
    <meta name="keywords" content="">
    <!-- meta character set -->
    <meta charset="UTF-8">
    <!-- Site Title -->
    <title>Hayalim Parke</title>
    <!-- Site Icon -->
    <link rel="icon" type="image/png" href="/img/ico.png" />

    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">
    <!-- Css -->
    @include('layouts.components.static.scripts-styles.css')
</head>
<body>
<!-- Header -->
@include('layouts.components.static.header')
<!-- Content -->
@yield('content')
<!-- Footer -->
@include('layouts.components.static.footer')
<!-- Js -->
@include('layouts.components.static.scripts-styles.js')
</body>
</html>
