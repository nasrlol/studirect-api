<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student verification</title>
</head>
<body>
<main>
    <h1>Hallo {{ $company->name }},</h1>
    <p>Dit is uw wachtwoord {{ $company->password }}}</p>
    <p>Verander dit wachtwoord zo snel mogelijk, alvast bedankt</p>
</main>
</body>
</html>
