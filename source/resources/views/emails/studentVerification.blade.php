<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student verification</title>
</head>
<body>
<main>
    <h1>Hallo {{ $student->first_name }},</h1>
</main>
</body>
</html>
