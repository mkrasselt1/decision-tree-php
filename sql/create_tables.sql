SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `relation`
--

CREATE TABLE `relation` (
  `upperid` int(8) NOT NULL,
  `lowerid` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `texte`
--

CREATE TABLE `texte` (
  `id` int(8) NOT NULL,
  `frage` varchar(255) NOT NULL,
  `antwort` varchar(255) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `relation`
--
ALTER TABLE `relation`
  ADD UNIQUE KEY `upperid` (`upperid`,`lowerid`);

--
-- Indizes für die Tabelle `texte`
--
ALTER TABLE `texte`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `texte`
--
ALTER TABLE `texte`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=270;
COMMIT;
