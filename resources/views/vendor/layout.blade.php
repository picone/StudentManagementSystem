<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>学生信息管理系统</title>
    {!! Html::meta('viewport','width=device-width,initial-scale=1.0') !!}
    {!! Html::style('css/app.css') !!}
</head>
<body data-_token="{{ csrf_token() }}">
<div id="app">
    @section('content')@show
</div>
{!! Html::script('js/app.js') !!}
@section('js')@show
</body>
</html>