<!doctype html>
<html lang='fr'>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>
        Administration - Les chroniques de timo
    </title>
    <link media="all" type="text/css" rel="stylesheet"
        href="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link media="all" type="text/css" rel="stylesheet"
        href="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstraptheme.
min.css">
    <link href="laravel\resources\css\app.css" rel="stylesheet">
    <style>
        textarea {
            resize: none
        }
    </style>
</head>

<body>
    <header class="jumbotron">
        <div class="container">
            <h1 class="page-header"><a href="
{{ route('episodes.adminIndex') }}">Administration - Les chroniques de
                    timo</a>
            </h1>
            @yield('header')
        </div>
    </header>
    <div class="container">
        @yield('content')
    </div>
</body>

</html>
