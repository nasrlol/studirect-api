<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Account Verificatie</title>
</head>
<body>
<h1>Hallo {{ $student->first_name }}</h1>
<p>Welkom bij onze applicatie. Klik op de onderstaande knop om je account te verifiëren:</p>
<p>
    <a href="{{ $verificationUrl }}"
       style="padding: 10px 15px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">
        Verifieer mijn account
    </a>
</p>
<p>Als je deze verificatie niet hebt aangevraagd, kun je deze e-mail negeren.</p>
</body>
</html>
