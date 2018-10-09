<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">--}}
    {{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>--}}
    @yield('meta')
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{URL::to('css/app.css')}}">
    @yield('styles')

</head>
<body>

@yield('content')
{{--<script src="{{URL::to('js/main.js')}}"></script>--}}
@yield('scripts')
</body>
</html>
