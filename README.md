# StuDirect - API

StuDirect is een Tinder-achtige webapplicatie die studenten en bedrijven met elkaar matcht voor de careerlaunch.  
De applicatie is ontwikkeld als onderdeel van het programmeerproject en biedt een aangename gebruikerservaring, moderne technologieën en functies zoals swipen, chatten en profielen.

![StuDirect UI](https://github.com/user-attachments/assets/8a2230b3-5fd6-4c3a-99ef-2bc7d66b84d1)

---

## Functionaliteiten

- Swipe-functionaliteit om studenten en bedrijven te matchen
- Realtime chat tussen gematchte partijen
- Studentprofielen met interesses, studierichting en cv
- Bedrijfsprofielen met stages, vacatures, standplaats en algemene informatie
- Admin-panel voor beheer studenten, bedrijven en logs
- Emailverificatie en wachtwoordherstel
- Skill-matching tussen student en bedrijf
- RESTful API, JSON responses, rate limiting
- Gescheiden versies voor mobiel, desktop en admin

![Laravel CI](https://github.com/nasrlol/studirect-api/actions/workflows/laravel.yml/badge.svg)

---

## Technische Stack

- Laravel (PHP Framework)
- Laravel Sanctum (API authenticatie & RBAC)
- Eloquent ORM
- PHPUnit
- MySQL database
- Mailtrap (e-mail testing)
- RESTful API, JSON
- CI via GitHub Actions

---

## Installatie

1. **Repository klonen**

```bash
git clone https://github.com/nasrlol/studirect-api
cd studirect-api/source
```

2. **Composer dependencies installeren**

```bash
composer install
```

3. **.env configureren**

```bash
cp .env.example .env
```
Vul je database-gegevens, Mailtrap en andere omgevingsvariabelen in `.env` in.

4. **App-key genereren**

```bash
php artisan key:generate
```

5. **Database migreren en seeden**

```bash
php artisan migrate:fresh --seed
```

6. **Server starten**

```bash
php artisan serve
```

---

## API Gebruiken

Zie [API Documentatie](./API-ROUTES.md) voor alle endpoints, authenticatie en voorbeeldgebruik.

- **Authenticatie:** via Laravel Sanctum tokens (Bearer), inloggen via `/api/students/login`, `/api/companies/login` of `/api/admins/login`
- **Rate limiting:** 300/min (standaard), 500/min voor intensieve endpoints (afspraken, connecties, skills)
- **Alle responses zijn JSON**
- **Zie [routes/api.php](./source/routes/api.php)** voor het volledige overzicht en actuele endpoints.

---

## Tests draaien

```bash
php artisan test
```

---

## Belangrijkste Mappen

- `/source/app/Http/Controllers/Api/` – Alle API controllers
- `/source/routes/api.php` – API routes
- `/source/app/Models/` – Model logica
- `/source/database/seeders/` – Seeder data voor testaccounts

---

## Security & Best Practices

- Input validatie, CSRF, XSS, SQL-injectie preventie, RBAC via policies/gates
- Rate limiting op alle routes

---

## Meer weten?

- [API Documentatie](./docs/api.md)
- [Projectdocumentatie (Wiki)](../../wiki)

---

© 2025 StuDirect — De API voor de careerlaunch.
