<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('honoka/css/bootstrap.css') }}">
    <script src="https://code.jquery.com/jquery-3.4.0.min.js"
        integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg="
        crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ asset('js/loading.js') }}"></script>
    <script type="text/javascript" src="{{ asset('honoka/js/bootstrap.bundle.js') }}"></script>
</head>
<body>
@yield('header')

@yield('content')

</body>
</html>
