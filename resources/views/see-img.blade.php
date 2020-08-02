<!DOCTYPE html>
<html style="height: 100%;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    <style>
        .display-image{
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            max-width: 100%;
            max-height: 100%;
            margin: auto;
            overflow: auto;
        }
    </style>
</head>
<body style="text-align: center; margin: 0; min-height: 100%;">
    @if($is_staff)
    <img src="http://localhost:8000/photos/{{$table}}_id={{$id}}&opt={{$column}}&mt={{$last_modified}}" class="display-image">
    @else
        <img src="http://localhost:8000/photos/mt={{$last_modified}}&ys={{$id}}&opt={{$req}}{{$opt_id != null ? $opt_id : ''}}" class="display-image">
    @endif
</body>
</html>