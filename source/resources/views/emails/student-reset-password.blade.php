<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Wachtwoord reset aanvraag</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #212529;
            padding: 2rem;
        }

        main {
            background: #ffffff;
            max-width: 600px;
            margin: auto;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        h2 {
            color: #0d6efd;
        }

        a.button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #0d6efd;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 1rem;
        }

        p {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
<main>
    <h2>Hallo {{ $student->first_name }},</h2>

    <p>Je hebt een aanvraag gedaan om het wachtwoord van je studentenaccount te resetten.</p>

    <p>Klik op de knop hieronder om je wachtwoord opnieuw in te stellen:</p>

    <p>
        <a href="{{ url('/student/password/reset?email=' . urlencode($student->email)) }}" class="button">
            Wachtwoord resetten
        </a>
    </p>

    <p>Heb je deze aanvraag niet gedaan? Dan kun je deze e-mail negeren.</p>

    <p>Met vriendelijke groet,<br>
        Het team</p>
</main>
</body>
</html>
