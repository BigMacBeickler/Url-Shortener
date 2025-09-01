Christoph Beickler, Matrikelnummer: 	2252027

beisshorturls – Entwickler:innendokumentation

Diese Dokumentation beschreibt Aufbau, verwendete Komponenten, Algorithmen und Besonderheiten der Anwendung beisshorturls.

## 1. Architektur & Aufbau

    -Das Projekt ist wie folgt aufgebaut:
        -/assets
            -bulma-prefers-dark.css
            -bulma-prefers-dark.css.map
            -bulma-prefers-dark.min.css
            -bumlma.css
            -bulma.css.map
            -bulma.min.css
            -style.css
        -/data
            -urls.json
            -users.json
        -/inc
            -footer.php
            -functions.php
            -header.php
        .htaccess
        create.php
        delete_profile.php
        delete.pgp
        edit.php
        index.php
        login.php
        logout.php
        profile.php
        redirect.php
        register.php

    - Bulma wird als CSS Framework lokal eingebunden. Layout/Styling ohne JavaScript. Dark-Mode (bulma-prefers-dark) sowie assets/style.css für kleine Anpassungen.

    - Mittels PHP wurden Serverseitig die Funktionen und Datenverarbeitung umgesetzt. Dazu gehören u.a. Dateizugriffe, Session verwaltung, password-hash, sicherheit(csrf) und weitere.

    - Als Server-Basis dient hier ein Apache HTTP Server (XAMPP)

    - Die Daten werden in JSON-Dateien (user.json und urls.json) gespeichert.

## 2. Ablauf des Aufrufs
    
    Aufruf von /{slug} oder eine App-Seite (/index.php, /login.php usw.).

    Apache mod_rewrite sorgt für elegnte Pfade an redirect.php (für Slugs) bzw. an die jeweilige PHP-Seite weiter mittels (.htaccess).

    Initiale Steuerung des Programmablaufs mittels inc/functions.php (Konstanten, Session, I/O) und inc/header.php (UI-Rahmen, Session-Inaktivitäts-Check).

    Skript, welche den Programmablauf steuern (create.php, edit.php, delete.php, delete_profile.php, login.php, register.php, profile.php, redirect.php) führen die jeweilige Aktion aus.

    Speichern der Daten erfolgt über JSON-Dateien (data/users.json, data/urls.json) mit Datei-Locking.

    Antwort (HTML) wird mit Bulma(css) ausgegeben, Abschluss via inc/footer.php.

## 3 Datenaufbau
    3.1 Nutzer (users.json)

    {
    "id": "u68b4cc7624d923.92064323",
    "username": "max",
    "password": "$2y$10$...",        // bcrypt-Hash
    "created_at": "2025-08-31T12:34:56+00:00"
    }

    3.2 URL-Eintrag (urls.json)

    {
    "id": "r68b5e0c46115a2.57417092",
    "user_id": "u68b4cc7624d923.92064323",
    "slug": "abc123",
    "long_url": "https://example.org/...",
    "description": "Kurzbeschreibung",
    "visits": 0,
    "created_at": "2025-09-01T20:07:00+02:00"
    }

    Beziehungen: urls.user_id → users.id.

## 4. Zentrale Algorithmen & Verfahren
    4.1 Daten manipulieren mit Datei-Locking

        load_json: öffnet Datei read-only

        save_json: öffnet im  c+ Modus (Datei wird erstellt falls nicht existent), LOCK_EX, ftruncate + rewind, json_encode(JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), fflush, Unlock.

        Ziel: Basisschutz gegen gleichzeitigen Zugriff.


    4.2 Authentifizierung

        Registrierung: create_user($username, $password) → verwendet password_hash(), eine uniqid('u', true) als User-ID, created_at = date('c').

        Login: verify_user($username, $password) → suche Nutzer (!case-insensitive Vergleich des Usernamens!) + password_verify().

        Session: $_SESSION['user_id'] = <id>; app_get_current_user() lädt Nutzer aus JSON.

    4.3 CSRF-Schutz

        Token-Erzeugung in Session: csfr_token()

        Prüfung des Tokens mittels hash_equals() in csrf_check Funktion. Bei Post-Request wird csrf-token als hidden Attribut mit übermittelt.

    4.4 Slug-Erzeugung & -Validierung

    Optionaler Custom-Slug muss ^[A-Za-z0-9_-]{3,}$ (aus Reg-Ex Editor) entsprechen und eindeutig sein (Lookup in urls.json).

    Ohne Vorgabe: generate_slug($len=6)

        Alphabet: a–z A–Z 0–9

        Schleife mit random_int() bis Unique gefunden wird.

    4.5 URL-Weiterleitung & Visit-Zähler

    .htaccess: Wenn slug dem Muster enstspricht: /^([A-Za-z0-9_-]+)$/ → redirect.php?slug.

    redirect.php:

        find_url_by_slug($slug) (exakte Übereinstimmung, case-sensitive).

        increment_visit($slug) (+1).

    4.6 Bearbeiten von URL-Einträgen

    Erstellen: save_new_url($user_id, $slug, $long_url, $description) → erzeugt id=uniqid('r', true), visits=0, created_at=date('c'). uniqid() mit more_entropy für individueller Ergebnisse

    Bearbeiten: update_url($id, $user_id, $new_long_url, $description) (Slug ist unveränderlich).

    Löschen: delete_url($id, $user_id) (filtert Eintrag heraus, persistiert Rest).

    4.7 Session-Timeout (Inaktivität)

    In inc/header.php: bei > 15 Minuten Inaktivität ($_SESSION['last_timestamp']) → session_unset(), session_destroy(), Redirect zu login.php.

    Nach gültigen Requests wird der Zeitstempel aktualisiert (in header.php).

## 5. Besonderheiten

    Datenverwaltung per JSON-Datei. Einfachere Umsetzung, allerdings nicht für Produktionsmaßstäbe geeignet. 

    CSRF-Schutz im gesamten Projekt.

    Unveränderliche Slugs: Nach dem Anlegen nicht editierbar (verhindert unabsichtliches unbrauchbar machen bereits geteilter Links).

    Bulma-Framework lokal gespeichert, dadurch verwendbar in einer Offline-Umgebung

    Bei der Erstellung dieses Projekts wurde teilweise ChatGPT verwendet. 
        -Fehlersuche: z.B. get_user Funktion schon Stammfunktion von PHP, hat zu Fehler geführt weshalb die Seite nicht geladen werden konnte.
        -Erklärung zu CSRF-Token und Beispiele
        -Umsetzungsbeispiele als Grundlage zur Umsetzung von Funktionen
        -Vorschläge zur GEstaltung der Dokumentationen, um sie Online-Tauglich zu halten.
