<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>学生信息管理系统</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body data-_token="{{ csrf_token() }}">
<div id="app">
    @section('content')@show
</div>
<script src="{{ asset('js/app.js') }}"></script>
@section('js')@show
</body>
</html>