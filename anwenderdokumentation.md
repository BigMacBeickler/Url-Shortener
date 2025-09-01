Christoph Beickler, Matrikelnummer: 	2252027

beisshorturls – Benutze:innenrdokumentation

Die, Dokumentation beschreibt Oberfläche, Bedienung und Installation der Webanwendung beisshorturls, ein URL‑Shortener für Endbenutzer:innen. Die Dokumentation ist in einer einfachen Textdatei gehalten um sie leicht online anzeigen zu können (z.B. Github).

## 1. Überblick

    beisshorturls lässt einen User kurze Links erstellen („Kurz-URLs“) zu langen Zieladressen. Nach der Anmeldung verwalten Benutzer:innen ihre eigenen Kurz-URLs in einer übersichtlichen Tabelle.
    Die Anwendung speichert Daten als JSON-Dateien im Verzeichnis data/ und nutzt einen CSFR-Schutzmeschanismus.

    Hauptfunktionen:

        Registrierung und Login/Logout

        Erstellen von Kurz-URLs (mit optional eigenem Slug)

        Bearbeiten und Löschen eigener Kurz-URLs

        Profilansicht (inkl. Konto-Löschung)

        Weiterleitung über Kurz-Slug und einfache Aufrufzählung (Visits)


## 2. Oberfläche und Bedienung
    2.1 Navigationsleiste

        Startseite – zentrale Übersicht bzw. Login/Registrierung, wenn nicht angemeldet.

        Profil – Benutzerprofil mit Übersicht der eigenen Einträge und der Möglichkeit zur Konto-Löschung.

        Logout – Abmelden.

        Sollte keine  User-Aktion erfolgen wird die Session automatisch nach 15 Minuten beendet.

    2.2 Startseite (angemeldet)

    Die Startseite zeigt eine Tabelle der eigenen Kurz-URLs mit folgenden Spalten:

        Slug – der Kurzname, der später in der URL verwendet wird (z. B. abc123).

        Lange URL – das Ziel, auf das weitergeleitet wird (z. B. https://example.org/…).

        Beschreibung – Möglichkeit Notizen zum Eintrag hinzuzufügen.

        Aufrufe – Zähler, der bei jeder Weiterleitung erhöht wird.

        Erstellt am – Zeitstempel.

        Aktionen – Bearbeiten und Löschen.

    Über ein Formular oberhalb bzw. unterhalb der Tabelle können neue Kurz-URLs angelegt werden.
    2.3 Startseite (nicht angemeldet)

    Es werden zwei Schaltflächen angezeigt:

        Registrieren

        Login

    2.4 Profil

    Zeigt:

        Benutzername

        Registriert am: 

        Liste eigener Kurz-URLs (analog zur Startseite)

    Zusätzlich gibt es die Option „Profil & URLs löschen“. Dabei werden zuerst alle eigenen URLs, anschließend das Benutzerkonto entfernt und die Session beendet.

## 3. Aufgaben und Abläufe (Endbenutzer:innensicht)
    3.1 Registrierung

        1. Registrieren auf der Startseite wählen.

        2. Benutzername und Passwort eingeben.

        3. Formular absenden.

            - Benutzername muss eindeutig sein.
            - Passwörter werden serverseitig gehasht (bcrypt via password_hash).
            - Nach erfolgreicher Registrierung kann man sich anmelden.

    3.2 Login / Logout

        1. Login auswählen und Zugangsdaten eingeben.

        2. Nach erfolgreichem Login erfolgt die Weiterleitung zur Startseite.

        3. Logout beendet die Session und führt zurück zur Startseite.

    3.3 Kurz-URL erstellen

        Auf der Startseite (angemeldet) das Erstellen-Formular verwenden.

        1. Lange URL eintragen (muss eine gültige URL sein).

        2. Optional Slug (Kurzname) setzen. Regeln:

            - zulässige Zeichen: A–Z, a–z, 0–9, _, -
            - Mindestlänge: 3 Zeichen
            - muss eindeutig sein
            - lässt sich nachträglich nicht mehr ändern

        3. Beschreibung (frei wählbar).

        4. Absenden. Ohne eigenen Slug erzeugt die Anwendung automatisch einen 6-stelligen Slug.

    3.4 Bearbeiten einer Kurz-URL

        1. In der Tabelle Bearbeiten wählen.

        2. Lange URL und Beschreibung können geändert werden.

        3. Slug ist aus Sicherheits- und Konsistenzgründen nicht veränderbar.

    3.5 Löschen einer Kurz-URL

        1. In der Tabelle Löschen wählen und bestätigen.

        2. Der Eintrag wird entfernt, die Kurz-URL ist anschließend nicht mehr erreichbar.

    3.6 Konto löschen

        1. Im Profil „Profil & URLs löschen“ wählen.

        2. Alle eigenen Kurz-URLs werden gelöscht und das Konto entfernt.

        3. Die Session wird beendet und zur Startseite weitergeleitet.

## 4. Verwendung von Kurz-URLs

    Jede Kurz-URL ist wie folgt ausgebaut:

    http(s)://<Ihre-Domain>/<slug>

    Beispiel (lokal unter XAMPP):

    http://localhost/abc123
    Beim Aufruf wird der Visit-Zähler erhöht.
    Slugs sind case-sensitive (Groß-/Kleinschreibung wird unterschieden), sofern der Webserver dies nicht anders konfiguriert.

## 5. Sicherheitsmechanismen und Verhalten

    CSRF-Schutz: Formulare enthalten ein Token; bei ungültigem Token wird die Verarbeitung abgebrochen („Ungültiges Formular.“).

    Session-Timeout: 15 Minuten Inaktivität führen zum automatischen Logout.

    Passwörter: Speicherung als Hash (bcrypt). Passwörter sind nicht im Klartext lesbar.

    Eingabevalidierung: URLs werden serverseitig geprüft; Slugs müssen dem erlaubten Muster entsprechen.

    Besuchszählung: Erhöht sich bei jeder Weiterleitung. Die Zählung unterscheidet nicht zwischen Bots und echten Aufrufen.

    !!Die Umsetzung dieses Projekts verwendet Json-Dateien um die Daten im /data Ordner zu speichern. Dies würde in einem Produktiven umfeld so nicht realisiert werden, da die Skalierbarkeit und Sicherheitsmechanismen von "richtigen" Datenbanken fehlt.!!

## 6. Einrichtung unter Windows mittels XAMPP

    6.1 Projekt bereitstellen
        XAMPP muss Installiert sein. Die Standartinstallation reich.

        Die Projektdateien müssen in den leeren XAMPP-Ordner /htdocs eingefügt werden. 
        Das Projekt besteht aus den folgenden Dateien:
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

    Desweiteren beinhaltet das Projekt die Benutzer- und Entwicklerdokumentation, sowie die Readme.md mit der Projektanforderung. Die Bulma-Files ohne Dark liegen im Ordner um einfach in den Light-Mode wechseln zu können.

    6.2 Apache: mod_rewrite aktivieren und .htaccess erlauben
        Um die korrekte Funktion zu Garantieren müssen folgende Einstellungen gemacht werden.

        XAMPP Control Panel öffnen → Apache stoppen (falls läuft).

        Datei C:\xampp\apache\conf\httpd.conf öffnen und sicherstellen das folgende Zeile nicht auskommentiert ist:

        LoadModule rewrite_module modules/mod_rewrite.so 

        Für das htdocs-Verzeichnis ist AllowOverride All gesetzt (ermöglicht .htaccess):

            <Directory "C:/xampp/htdocs">
                Options Indexes FollowSymLinks Includes ExecCGI
                AllowOverride All
                Require all granted
            </Directory>

        Apache im XAMPP Control Panel neu starten.

    6.3 Start und erster Zugriff

        Browser öffnen: http://localhost/beisshorturls/

        Registrieren und anschließend Login durchführen.

## 7. Datenformat

    Ablageort: data\users.json und data\urls.json

    Backupmöglichkeit durch kopieren des Data-Ordners. 

    Wiederherstellung: Gesicherten data-Ordner in das Projekt zurückkopieren, Apache neu starten.

    Struktur users.json:

    [
    {
        "id": "u…",
        "username": "bei",
        "password": "$2y$10$…",          // Hash wert
        "created_at": "2025-08-31T12:34:56+00:00"
    }
    ]

    Beispiel‐Struktur urls.json:

    [
        {
            "id": "r68b4d8b57babf0.40977880",
            "user_id": "u68b4cc7624d923.92064323",
            "slug": "ZPJy0C",
            "long_url": "https://stackoverflow.com/questions/1953857/fatal-error-cannot-redeclare-function",
            "description": "hi",
            "visits": 2,
            "created_at": "2025-09-01T01:20:21+02:00"
        }
    ]

## 8. Umsetzung

    Umgesetzt in diesem Projekt sind alle MUSS-Kriterien sowie folgende KANN-Kriterien:
        - Möglichkeit, den Account zu löschen
        - Zählen der Aufrufe von Kurz-URLs
        - Benutzerprofil anzeigen und bearbeiten
        - die Eingaben der Benutzer:innen werden überprüft und gefiltert, um Missbrauch und Fehlbedienung zu verhindern (nur gültige Slugs, CSRF, Passwort gehashed)
        - Möglichkeit zur Personalisierung der generierten Kurz-URLs (benutzerdefinierte Alias-Option)
        - Möglichkeit für Benutzer, ihre Kurz-URLs mit Beschreibungen zu versehen
