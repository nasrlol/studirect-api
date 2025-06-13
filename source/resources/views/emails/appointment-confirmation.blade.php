
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking Confirmation</title>
</head>
<body>
<main>
    <h3>Hey {{ $student->first_name }}</h3>
    <p>U heeft een speeddate geboekt {{ $appointment->time_slot }}</p>
</main>
</body>
</html>
