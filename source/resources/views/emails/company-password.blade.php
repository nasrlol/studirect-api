<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bedrijfsaccount geactiveerd</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #212529;
            padding: 2rem;
            line-height: 1.6;
        }

        main {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        h1 {
            color: #0d6efd;
            margin-bottom: 1rem;
        }

        p {
            margin: 1rem 0;
        }

        code {
            background-color: #e9ecef;
            padding: 0.2rem 0.4rem;
            border-radius: 4px;
            font-size: 0.95rem;
        }
    </style>
</head>
<body>
<main>
    <h1>Proficiat {{ $company->name }},</h1>
    <p>Je bedrijfsaccount is succesvol aangemaakt.</p>
    <p>Dit zijn je gegevens om verder in te loggen:</p>
    <p><strong>E-mailadres:</strong> <code>{{ $company->email }}</code></p>
    <p><strong>Tijdelijk wachtwoord:</strong> <code>{{ $company->password }}</code></p>
    <p>Bedankt voor je registratie!</p>
</main>
</body>
</html>
