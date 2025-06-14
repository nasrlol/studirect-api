<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bedrijfsaccount geactiveerd</title>
</head>
<body>
<main>
    <h1>Proficiat {{ $company->name }},</h1>
    <p>Je bedrijfsaccount is succesvol aangemaakt.</p>
    <p>Via onderstaande link kan je jouw bedrijfsprofiel verder aanvullen:</p>
    <p>
        <a href="{{ $registratieUrl }}">
            Klik hier om je bedrijfsprofiel aan te passen
        </a>
    </p>
    <p>Bedankt voor je registratie!</p>
</main>
</body>
</html>
