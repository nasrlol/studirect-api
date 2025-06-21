<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Boekingsbevestiging</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f9f9f9;
            padding: 2rem;
        }

        main {
            background-color: #ffffff;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        a {
            color: #1a73e8;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<main>
    <h3>Beste {{ $student->first_name }},</h3>

    <p>U heeft succesvol een speeddate geboekt op het tijdslot <strong>{{ $appointment->time_start }}
            - {{ $appointment->time_end }}</strong>.</p>

    <p>Met vriendelijke groet,<br>
        Het Studirect Team</p>
</main>
</body>
</html>
