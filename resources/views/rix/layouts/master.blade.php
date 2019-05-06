<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield("title","Rix Admin")</title>
    <!-- CSS -->
    @include("rix.layouts.components.static.scripts-styles.css")

</head>

<body>
<div id="app">
    <div class="main-wrapper">
        <!-- HEADER -->
    @include("rix.layouts.components.static.header")
    <!-- SIDEBAR -->
    @include("rix.layouts.components.static.sidebar")
    <!-- Main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-header" id="section-header">
                    <h1>@yield("page_title","Anasayfa")</h1>
                    @yield('section_header')
                </div>
                <div class="section-content" id="section-content">
                    @yield("content")
                </div>
            </section>
        </div>
        <!-- FOOTER -->
        @include("rix.layouts.components.static.footer")
    </div>
</div>
<!-- JAVASCRIPT -->
@include("rix.layouts.components.static.scripts-styles.js")
</body>
</html>
