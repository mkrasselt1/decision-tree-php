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
- `config.php` – Grundkonfiguration, lädt die Zugangsdaten aus `dbconfig.php`
- `dbconfig.php` – Zugangsdaten für die Datenbank
- `prepare.php` – Initialisiert die Datenbankverbindung
- `sql/` – Enthält alle SQL-Abfragen als einzelne Dateien
- `templates/index.html`, `templates/edit.html` – HTML-Templates für die Anzeige und Bearbeitung
- `error.log` – Fehlerprotokoll

## Installation

1. **Voraussetzungen:**  
   - PHP 7.x oder neuer  
   - MySQL/MariaDB  
   - Webserver (z.B. Apache)

2. **Datenbank:**  
   - Lege die Tabellen `texte` und `relation` gemäß [`sql/create_tables.sql`](sql/create_tables.sql) an.

3. **Konfiguration:**  
   - Passe ggf. die Zugangsdaten in [`dbconfig.php`](dbconfig.php) an.

4. **Deployment:**  
   - Lege alle Dateien und Ordner in ein Verzeichnis auf deinem Webserver.

5. **Start:**  
   - Rufe `index.php` im Browser auf.

## Hinweise

- Die Fehlerausgabe und das Logging erfolgen in die Datei [`error.log`](error.log).
- Die Templates können nach Bedarf angepasst werden.
- Die Navigation erfolgt über die URL-Parameter (`idChain`).

## Lizenz

Dieses Projekt ist privat und nicht für die öffentliche Nutzung bestimmt.

---

**Autor:** Michael Krasselt  
**Kontakt:** michael@michaelkrasselt.de# decision-tree-php
