<!DOCTYPE html>
<html lang="en" style="height: 100%;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
</head>
<body style="text-align: center; margin: 0; height: 100%;">
    @if($is_staff)
        <img src="http://localhost:8000/photos/{{$table}}_id={{$id}}&opt={{$column}}&mt={{$last_modified}}" height="100%" style="">
    @else
        <img src="http://localhost:8000/photos/mt={{$last_modified}}&ys={{$id}}&opt={{$req}}&id={{$opt_id}}" height="100%" style="">
    @endif
</body>
</html>