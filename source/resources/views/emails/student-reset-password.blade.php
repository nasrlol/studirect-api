<!-- source/resources/views/emails/student-reset-password.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Wachtwoord reset aanvraag</title>
</head>
<body>
<h2>Hallo {{ $student->first_name }},</h2>
<p>Je hebt een aanvraag gedaan om het wachtwoord van je studentenaccount te resetten.</p>
<p>Klik op de knop hieronder om je wachtwoord opnieuw in te stellen:</p>
<p>
    <a href="127.0.0.1/8000/student/password/reset" style="display:inline-block;padding:10px 20px;background:#007bff;color:#fff;text-decoration:none;border-radius:4px;">
        Wachtwoord resetten
    </a>
</p>
<p>Heb je deze aanvraag niet gedaan? Dan kun je deze e-mail negeren.</p>
<p>Met vriendelijke groet,<br>Het team</p>
</body>
</html>
