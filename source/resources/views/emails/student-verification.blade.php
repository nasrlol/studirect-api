<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Accountverificatie</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #212529;
            padding: 2rem;
        }

        main {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        h1 {
            color: #198754; /* Bootstrap 'success' green */
        }

        p {
            margin-bottom: 1rem;
        }

        a.button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #198754;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
<main>
    <h1>Hallo {{ $student->first_name }},</h1>

    <p>Welkom bij onze applicatie!</p>

    <p>Om je account te activeren, klik je op onderstaande knop:</p>

    <p>
        <a href="{{ $verificationUrl }}" class="button">
            Verifieer mijn account
        </a>
    </p>

    <p>Als je deze verificatie niet hebt aangevraagd, dan kun je deze e-mail veilig negeren.</p>

    <p>Met vriendelijke groet,<br>
        Het team</p>
</main>
</body>
</html>
