# Problems – Hierarchische Problemverwaltung

Dieses PHP-Projekt dient der Verwaltung und Strukturierung von Problemen, Fragen und Antworten in einer hierarchischen Baumstruktur. Es ermöglicht das Anlegen, Bearbeiten und Navigieren von Problemen und deren Unterproblemen über eine Weboberfläche. Die Daten werden in einer MySQL-Datenbank gespeichert.

## Features

- Hierarchische Darstellung von Problemen und deren Unterpunkten
- Breadcrumb-Navigation zur Orientierung
- Bearbeiten und Hinzufügen von Problemen/Fragen/Texten
- Einfache, template-basierte HTML-Ausgabe
- Fehler- und Logging-Mechanismen

## Projektstruktur

- `index.php` – Hauptseite zur Anzeige und Navigation der Problemstruktur
- `edit.php` – Formular zum Bearbeiten und Hinzufügen von Einträgen
- `functions.php` – Zentrale Funktionen (Datenbank, Fehlerbehandlung, Template-Rendering)
- `config.php` – Konfiguration, Datenbankzugang und SQL-Templates
- `prepare.php` – Initialisiert die Datenbankverbindung
- `index.htm.tpl`, `edit.htm.tpl` – HTML-Templates für die Anzeige und Bearbeitung
- `error.log` – Fehlerprotokoll
- Diverse PNG-Dateien – Icons für die Benutzeroberfläche

## Installation

1. **Voraussetzungen:**  
   - PHP 7.x oder neuer  
   - MySQL/MariaDB  
   - Webserver (z.B. Apache)

2. **Datenbank:**  
   - Lege die Tabellen `texte` und `relation` gemäß den SQL-Statements in `config.php` an.

3. **Konfiguration:**  
   - Passe ggf. die Zugangsdaten in [`config.php`](config.php) an.

4. **Deployment:**  
   - Lege alle Dateien in ein Verzeichnis auf deinem Webserver.

5. **Start:**  
   - Rufe `index.php` im Browser auf.

## Hinweise

- Die Fehlerausgabe und das Logging erfolgen in die Datei [`error.log`](error.log).
- Die Templates können nach Bedarf angepasst werden.
- Die Navigation erfolgt über die URL-Parameter (`idstring`).

## Lizenz

Dieses Projekt ist privat und nicht für die öffentliche Nutzung bestimmt.

---

**Autor:** Michael Krasselt  
**Kontakt:** michael@michaelkrasselt.de# decision-tree-php
