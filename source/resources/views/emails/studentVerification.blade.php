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
    <p>Klik op de onderstaande knop om je studentenaccount te activeren:</p>
    <p>
        <a href="{{ $verificationUrl }}"
           style="padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none;">
            Verifieer je account
        </a>
    </p>
</main>
</body>
</html>
