<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>404 &mdash; Rix Admin</title>

    @include("rix.layouts.components.static.scripts-styles.css")
</head>

<body>
<div id="app">
    <section class="section">
        <div class="container mt-5">
            <div class="page-error">
                <div class="page-inner">
                    <h1>404</h1>
                    <div class="page-description">
                        Böyle bir sayfa yok.
                    </div>
                    <div class="page-search">
                        <div class="mt-3">
                            <a href="{{route('rix.home')}}">Anasayfaya Dön</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="simple-footer mt-5">
                Copyright &copy; Rix Admin 2019
            </div>
        </div>
    </section>
</div>

@include("rix.layouts.components.static.scripts-styles.js")
</body>
</html>
