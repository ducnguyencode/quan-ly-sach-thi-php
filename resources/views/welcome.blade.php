<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Quản Lý Sách</title>
        <meta http-equiv="refresh" content="0;url={{ Auth::check() ? route('home') : route('login.show') }}">
    </head>
    <body>
        <p>Đang chuyển hướng...</p>
    </body>
</html>
