# Url-Shortener


Als Prüfungsleistung wird die Erstellung der nachfolgend beschriebenen Webanwendung anerkannt (Portfolio-Aufgabe). Das Abgabedatum ist der 1.9.2025, 23:59 Uhr. Die Erstellung der Webanwendung muss eigenständig ausgeführt werden. Bibliotheken dürfen eingebunden und verwendet werden, der Code muss aber eigenständig entwickelt werden. Die Anwendung muss ausreichend dokumentiert werden. Die Dokumentation ist Teil der Prüfungsleistung.

Bitte erstellen Sie zu Beginn der Bearbeitung eine Projektskizze, die beschreibt, aus welchen Komponenten die Webanwendung besteht und wie die Abläufe innerhalb der Anwendung geplant sind (Algorithmus). Die Projektskizze soll einen Zeitplan enthalten, der angibt, wann welche Funktion voraussichtlich umgesetzt sein soll (Meilensteine). Es ist hilfreich, einmal wöchentlich den Fortschritt zu dokumentieren und die geplanten Aufgaben der kommenden Woche aufzuführen. Projektskizze und regelmäßige Rückmeldungen sind für die Prüfungsleistung nicht relevant, helfen aber bei der Umsetzung sehr.
Beschreibung der Webanwendung

Die URL-Shortener-Webanwendung ist eine Plattform, die es Benutzern ermöglicht, lange URLs in kurze URLs umzuwandeln und zu verwalten.

Die Anwendung bietet eine Anmeldemöglichkeit, so dass Benutzer ein persönliches Konto erstellen und sich einloggen können. Nach dem Login haben die angemeldeten Benutzer Zugriff auf ihr Benutzerprofil, in dem sie ihre persönlichen Informationen anzeigen und bearbeiten können. Sie können ihren Account löschen. In diesem Fall werden alle von ihnen eingegebenen URLs und zugehörige statistische Daten sowie alle Informationen zum Benutzer gelöscht.

Angemeldete Benutzer haben die Möglichkeit, lange URLs einzugeben und eine entsprechende Kurz-URL zu generieren. Wenn diese Kurz-URL aufgerufen wird, leitet die Anwendung den Benutzer zur ursprünglichen langen URL weiter. Dabei wird der Aufruf gezählt und für statistische Zwecke gespeichert.

Die Benutzer haben außerdem die Möglichkeit, ihre Kurz-URLs zu verwalten. Sie können ihre URLs anzeigen, bearbeiten, löschen und neue URLs hinzufügen. Zusätzlich können sie sehen, wie oft und wann ihre Kurz-URLs aufgerufen wurden, um die Nutzung ihrer Links nachzuverfolgen.

Um die Benutzer über die Aktivitäten ihrer URLs auf dem Laufenden zu halten, erhalten sie einmal wöchentlich einen Bericht per E-Mail. Der Bericht enthält eine Liste der URLs des Benutzers, die seit dem letzten Bericht aufgerufen wurden, sowie die Gesamtzahl der Aufrufe. Die genauen Zeitpunkte der Aufrufe werden jedoch nicht im Bericht angezeigt.

Daten können in einer strukturierten Text-Datei, einer dateibasierten Datenbank (SQLite) oder einer relationalen Datenbank (MySQL, MariaDB) gespeichert werden.
Szenario

Lisa hat eine eigene Webseite erstellt, auf der sie verschiedene Blogbeiträge und Tutorials zu Webentwicklungsthemen veröffentlicht. Sie möchte die Sichtbarkeit ihrer Beiträge verbessern, indem sie Kurz-URLs für jeden Beitrag erstellt und sie in den sozialen Medien teilt.

Lisa verwendet die URL-Kürzer-Webanwendung, um ihre Blogpost-URLs in kurze URLs umzuwandeln. Sie generiert eine Kurz-URL für jeden Beitrag und teilt sie auf Plattformen wie Twitter und Facebook. Wenn Benutzer auf die Kurz-URLs klicken, werden sie zur entsprechenden Blogpost-Seite weitergeleitet. Lisa kann die Anzahl der Aufrufe für jede Kurz-URL verfolgen und sehen, wie oft und wann ihre Beiträge aufgerufen wurden.

Eine Kurz-URL kann z.B. folgendes Format haben: https://kurze.url/h3wm8

Dank der wöchentlichen Berichte per E-Mail erhält Lisa eine Übersicht über die Aktivität ihrer Kurz-URLs. Sie erfährt, welche Beiträge aufgerufen wurden und wie oft, was ihr wertvolles Feedback über die Popularität und Resonanz ihrer Inhalte gibt.
Anforderungen an die Webanwendung

Eine solche Anwendung kann sehr unterschiedlich implementiert werden und sehr unterschiedliche Aufwände verursachen. Daher werden MUSS-Kriterien festgelegt, d.h. ein Mindestangebot an Funktionen und KANN-Kriterien, die die Bedienung erleichtern oder mehr Funktionen bereitstellen. Für das Bestehen der Prüfung (Note 4.0) ist die Erfüllung der MUSS-Kriterien ausreichend. Für eine bessere Note müssen zusätzlich KANN-Kriterien implementiert werden.

Die Webanwendung muss mindestens folgenden Anforderungen genügen:

MUSS-Kriterien:

    Registrierung für neue Benutzer
    Login-Funktionalität
    Eingabe langer URLs und Generierung von Kurz-URLs
    Weiterleitung von Kurz-URLs zu den entsprechenden langen URLs
    Anzeigen, Bearbeiten, Löschen von URLs für angemeldete Benutzer

KANN-Kriterien:

    Möglichkeit, den Account zu löschen
    Zählen der Aufrufe von Kurz-URLs
    Anzeige der Anzahl und Zeitpunkte der Aufrufe für angemeldete Benutzer
    Benutzerprofil anzeigen und bearbeiten
    die Erzeugung des Berichts kann ein- und ausgeschaltet werden
    Wöchentlicher Bericht per E-Mail für URLs mit Aufrufen seit dem letzten Bericht (Liste der URLs und Anzahl der Aufrufe, ohne Zeitpunkte)
    das Intervall des Berichts kann festgelegt werden
    die Eingaben der Benutzer:innen werden überprüft und gefiltert, um Missbrauch und Fehlbedienung zu verhindern
    die URLs werden in einer Datenbank gespeichert
    Die Anzahl der von einem Benutzer anlegbaren URLs wird vom System beschränkt. Sie kann durch Zahlung einer einmaligen oder regelmäßigen Gebühr erhöht werden.
    Passwortwiederherstellungsfunktion
    Möglichkeit zur Personalisierung der generierten Kurz-URLs (benutzerdefinierte Alias-Option)
    Teilen von Kurz-URLs über verschiedene soziale Medien
    Möglichkeit für Benutzer, ihre Kurz-URLs mit Beschreibungen zu versehen
    Statistiken und Diagramme zur Visualisierung der Aufrufe für jeden Benutzer
    Möglichkeit für Benutzer, ihre URLs in Kategorien oder Ordnern zu organisieren
    Integration von Werbung oder Analytics-Tracking für Benutzer
    Unterstützung für verschiedene Sprachen
    QR-Code-Generierung für Kurz-URLs

Anforderungen an die Dokumentation

Die Dokumentation hat mehrere Aufgaben. Sie soll einerseits den Benutzer:innen ermöglichen, die Anwendung zu bedienen und Evaluationen durchzuführen. Zusätzlich gibt sie den (zukünftigen) Entwickler:innen Hinweise zum Aufbau des Systems und zur Implementierung, damit die Anwendung weiterentwickelt oder angepasst werden kann. Schließlich dient sie noch als Nachweis für die eigene Leistung im Rahmen der Prüfungsaufgabe. Benutzer:innendokumentation und Entwickler:innendokumentation können getrennt werden. Die angesprochene Nachweisfunktion ist in diesen beiden Dokumentationen, insbesondere in der technischen Dokumentation enthalten. Art und Umfang der Dokumentation soll dem Zweck angemessen sein, es gibt keine Vorgabe für ein bestimmtes Format oder eine Seitenzahl.

Die Benutzer:innendokumentation muss folgende Anforderungen erfüllen:

    Oberfläche und Bedienung der Webanwendung werden beschrieben
    Die Erfüllung der Aufgaben (Registrierung, Login, Verwaltung von URLs, Verwendung von Kurz-URLs) ist aus administrativer Sicht und aus Benutzer:innensicht beschrieben
    Die Installation der Anwendung ist beschrieben

Die Entwickler:innendokumentation muss folgende Anforderungen erfüllen:

    Der Aufbau der Webanwendung ist beschrieben
    Die eingesetzten Sprachen und Fremdkomponenten (Bibliotheken) und ihr Einsatzzweck werden genannt
    Algorithmen und Verfahren, die der Anwendung zugrundeliegen, werden beschrieben
    Besonderheiten bei der Implementierung werden beschrieben (falls vorhanden)
    Entscheidungen, die zu einer bestimmten Implementierung geführt haben, sind dokumentiert

Bewertung

Die Bewertung orientiert sich an folgenden Kriterien:

    Konzept und Dokumentation

Wie ausführlich und aussagekräftig ist die Dokumentation? Ist das Projekt im Konzept genau beschrieben? Wird die Projektstruktur erkennbar? Sind Schwierigkeiten und deren Lösung beschrieben?

    Technische Umsetzung (Code, Struktur)

Ist das Projekt gut strukturiert? Wie groß ist der Funktionsumfang?
Codequalität: Klarheit, Gliederung (Funktionen), Fehlerfreiheit, ausreichende Kommentare, keine Redundanzen
