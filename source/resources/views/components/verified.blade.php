<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificatie</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f5;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            background: white;
            padding: 2rem 3rem;
            border-radius: 0.75rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
        }

        .card h1 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #111827;
        }

        .card p {
            font-size: 1rem;
            color: #4b5563;
        }
    </style>
</head>
<body>
<div class="card">
    <h1>{{ $message }}</h1>
    <p>Je kunt dit venster nu sluiten of verdergaan naar de <a href="/">homepagina</a>.</p>
</div>
</body>
</html>
