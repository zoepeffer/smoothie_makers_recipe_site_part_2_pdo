-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 15. Mai 2020 um 16:13
-- Server-Version: 10.4.11-MariaDB
-- PHP-Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `_smoothie_maker`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bearbeitung`
--

CREATE TABLE `bearbeitung` (
  `bearbeitung_id` int(11) UNSIGNED NOT NULL,
  `users_id` int(10) UNSIGNED NOT NULL,
  `datum` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `art_bearbeitung` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `bearbeitung`
--

INSERT INTO `bearbeitung` (`bearbeitung_id`, `users_id`, `datum`, `art_bearbeitung`) VALUES
(2, 1, '2020-04-28 11:41:12', 'Friss Rezept'),
(3, 1, '2020-04-24 10:25:09', 'Mit Smoothie Makers Empfehlung');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `farbe`
--

CREATE TABLE `farbe` (
  `farbe_id` int(10) UNSIGNED NOT NULL,
  `farbe_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `farbe`
--

INSERT INTO `farbe` (`farbe_id`, `farbe_name`) VALUES
(1, 'gelb'),
(2, 'rot'),
(3, 'grün'),
(9, 'Weiss'),
(10, 'Lila');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `geschmack`
--

CREATE TABLE `geschmack` (
  `geschmack_id` int(10) UNSIGNED NOT NULL,
  `geschmack_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `geschmack`
--

INSERT INTO `geschmack` (`geschmack_id`, `geschmack_name`) VALUES
(1, 'salzig'),
(2, 'natur'),
(3, 'süßsauer'),
(4, 'wenig süß'),
(5, 'süß'),
(6, 'extra süß');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rezension`
--

CREATE TABLE `rezension` (
  `rezension_id` int(10) UNSIGNED NOT NULL,
  `rezension_beschreibung` varchar(255) NOT NULL,
  `front` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `rezension`
--

INSERT INTO `rezension` (`rezension_id`, `rezension_beschreibung`, `front`) VALUES
(1, 'Noch nicht bewertet.', 0),
(2, 'Lecker und gesund', 0),
(3, 'Für Schummeltag ;)', 0),
(4, 'Kann noch verbessert werden', 0),
(5, 'Meisten liebt (Front)', 1),
(6, 'Top Rezept (Front)', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rezepte`
--

CREATE TABLE `rezepte` (
  `rezept_id` int(10) UNSIGNED NOT NULL,
  `rezension` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `farbe_id` int(10) UNSIGNED NOT NULL,
  `zutat_typ` int(10) UNSIGNED NOT NULL,
  `geschmack_id` int(10) UNSIGNED NOT NULL,
  `selektion_id` int(10) UNSIGNED NOT NULL,
  `bearbeitung_id` int(10) UNSIGNED NOT NULL,
  `rezept_name` varchar(255) NOT NULL,
  `rezeptdatum` timestamp NOT NULL DEFAULT current_timestamp(),
  `zutaten_list` varchar(400) NOT NULL,
  `rezept_beschreibung` varchar(400) NOT NULL,
  `rezeptbild` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `rezepte`
--

INSERT INTO `rezepte` (`rezept_id`, `rezension`, `user_id`, `farbe_id`, `zutat_typ`, `geschmack_id`, `selektion_id`, `bearbeitung_id`, `rezept_name`, `rezeptdatum`, `zutaten_list`, `rezept_beschreibung`, `rezeptbild`) VALUES
(12, 6, 1, 2, 2, 4, 1, 3, 'Erdbeeren Smoothie', '2020-03-11 14:56:45', 'Ananas Erdbeeren  Banane', 'Ananas schälen und grob würfeln. Banane schälen. Erdbeeren waschen und putzen. Mark einer halben Vanilleschote auskratzen.\r\n\r\nFein pürieren. Smoothie in ein Glas füllen.', 'smoothiebild_-1.png'),
(17, 6, 1, 1, 3, 5, 1, 2, 'Mango Smoothie', '2020-04-21 13:56:45', '2 Mangos\r\n1 Orangen\r\n8 Maracujas', 'Mangofruchtfleisch vom Stein schneiden und in Stücke schneiden. Orangen halbieren, Saft auspressen. Maracujas halbieren, Fruchtfleisch aus der Schale löffeln.\r\n\r\nMango, Orangensaft und 6 der Maracuja fein pürieren. ', 'smoothiebild_-4.png'),
(19, 3, 1, 2, 7, 2, 1, 3, 'Rote-Bete Smoothie', '2020-04-21 13:56:45', '4 Äpfel\r\n1 Zitrone\r\n1 Stück Ingwer\r\n4 Knolle(n) Rote Bete (vorgekocht, vakuumiert)', 'Äpfel schälen, vierteln und entkernen. Saft der Zitrone auspressen. Ingwer schälen und fein hacken.\r\n\r\nApfel, Zitronensaft, Rote Bete, Ingwer und 500 ml Wasser fein pürieren. Smoothie in ein Glas füllen.', 'smoothiebild_-5.png'),
(20, 1, 1, 3, 6, 2, 1, 3, 'Spinat Smoothie', '2020-04-21 13:56:45', '3 TL Cashewmus\r\n1 Banane, gefroren\r\n3 Bund Spinat\r\n2 Datteln\r\n', 'Salat und Blattspinat waschen und putzen. \r\n\r\nDu brauchst\r\nSparschäler\r\nBanane schälen und grob in Stücke schneiden. Apfel vierteln, Kerngehäuse entfernen und in Stücke schneiden. Kiwi schälen und in Stücke schneiden.\r\n\r\nFein pürieren. Smoothie in ein Glas füllen.', 'smoothiebild_-7.png'),
(21, 3, 1, 2, 4, 4, 1, 2, 'Wassermelonen Smoothie', '2020-04-08 13:56:45', '1 Limette\r\n0,5 Wassermelone\r\n200 ml Kokosdrink\r\n4 Blätter Minze\r\nEiswürfel', 'Limette halbieren, Saft auspressen. \r\n\r\nWassermelonenfruchtfleisch direkt in der Schale pürieren. Wahlweise aus der Schale löffeln und die Kerne entfernen. Fruchtfleisch mit Kokosdrink, Limettensaft und Minze nochmals fein pürieren und mit Eiswürfeln in ein Glas füllen.', 'smoothiebild_-6.png'),
(25, 1, 1, 3, 5, 1, 6, 3, 'Avocado Smoothie', '2020-04-21 13:56:45', '1 Bund Koriander\r\n0,25 Gurke\r\n2 Avocados\r\n1 Limette\r\n1 TL Wasabi-Paste\r\n500 ml Buttermilch\r\n450 g Joghurt\r\n2 Handvoll Eiswürfel\r\nSalz\r\nPfeffer', 'Koriander waschen und Blättchen abzupfen. Gurke waschen, schälen und in Scheiben schneiden. Avocados halbieren, entkernen und Fruchtfleisch aus der Schale lösen. Limette halbieren und auspressen.\r\n\r\nAlle Zutaten in einen Mixer geben und fein pürieren.', 'smoothiebild_-8.png'),
(27, 1, 1, 2, 1, 6, 6, 2, 'Himbeeren Smoothie', '2020-04-21 13:56:45', '200 g Himbeeren (tiefgefroren)\r\n200 g Naturjoghurt\r\n200 ml Milch\r\n60 g zarte Haferflocken\r\n2 EL Honig\r\n2 TL Chiasamen', 'Himbeeren, Naturjoghurt, Milch, Haferflocken und Honig mit 100 ml Wasser fein pürieren.\r\n\r\nSmoothie in Gläser füllen, Chiasamen darüber streuen.\r\n', 'smoothiebild_-3.png');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `selektion`
--

CREATE TABLE `selektion` (
  `selektion_id` int(10) UNSIGNED NOT NULL,
  `selektion_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `selektion`
--

INSERT INTO `selektion` (`selektion_id`, `selektion_name`) VALUES
(1, 'laktosefrei'),
(6, 'mit Milchprodukte');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `passwort` varchar(255) NOT NULL,
  `login` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`user_id`, `email`, `user_name`, `passwort`, `login`) VALUES
(1, '', 'Smoothie Maker', '$2y$10$L2SrVQ8Ll5lO.OvyBHBzYOXuzXwGoIBwrzTHuFwKzCUNAVNk47uXe', 'login');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `zutat`
--

CREATE TABLE `zutat` (
  `zutat_id` int(10) UNSIGNED NOT NULL,
  `farbe_id` int(10) UNSIGNED NOT NULL,
  `zutat_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `zutat`
--

INSERT INTO `zutat` (`zutat_id`, `farbe_id`, `zutat_name`) VALUES
(1, 2, 'Himbeer'),
(2, 2, 'Erdbeer'),
(3, 1, 'Mango'),
(4, 2, 'Wassermelonen'),
(5, 3, 'Avocado'),
(6, 3, 'Spinat'),
(7, 2, 'Rote-Bete'),
(8, 1, 'Orange'),
(9, 3, 'Grünkohl'),
(10, 9, 'Banane'),
(11, 10, 'Heidelbeere');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `bearbeitung`
--
ALTER TABLE `bearbeitung`
  ADD PRIMARY KEY (`bearbeitung_id`),
  ADD KEY `users_id` (`users_id`);

--
-- Indizes für die Tabelle `farbe`
--
ALTER TABLE `farbe`
  ADD PRIMARY KEY (`farbe_id`);

--
-- Indizes für die Tabelle `geschmack`
--
ALTER TABLE `geschmack`
  ADD PRIMARY KEY (`geschmack_id`);

--
-- Indizes für die Tabelle `rezension`
--
ALTER TABLE `rezension`
  ADD PRIMARY KEY (`rezension_id`);

--
-- Indizes für die Tabelle `rezepte`
--
ALTER TABLE `rezepte`
  ADD PRIMARY KEY (`rezept_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `farbe_id` (`farbe_id`),
  ADD KEY `zutat_id` (`zutat_typ`),
  ADD KEY `geschmack_id` (`geschmack_id`),
  ADD KEY `selection_id` (`selektion_id`),
  ADD KEY `rezensionwert` (`rezension`),
  ADD KEY `bearbeitung_id` (`bearbeitung_id`);

--
-- Indizes für die Tabelle `selektion`
--
ALTER TABLE `selektion`
  ADD PRIMARY KEY (`selektion_id`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indizes für die Tabelle `zutat`
--
ALTER TABLE `zutat`
  ADD PRIMARY KEY (`zutat_id`),
  ADD KEY `rezept_id` (`farbe_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `bearbeitung`
--
ALTER TABLE `bearbeitung`
  MODIFY `bearbeitung_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `farbe`
--
ALTER TABLE `farbe`
  MODIFY `farbe_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT für Tabelle `geschmack`
--
ALTER TABLE `geschmack`
  MODIFY `geschmack_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `rezension`
--
ALTER TABLE `rezension`
  MODIFY `rezension_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `rezepte`
--
ALTER TABLE `rezepte`
  MODIFY `rezept_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT für Tabelle `selektion`
--
ALTER TABLE `selektion`
  MODIFY `selektion_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `zutat`
--
ALTER TABLE `zutat`
  MODIFY `zutat_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `bearbeitung`
--
ALTER TABLE `bearbeitung`
  ADD CONSTRAINT `bearbeitung_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `rezepte`
--
ALTER TABLE `rezepte`
  ADD CONSTRAINT `rezepte_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rezepte_ibfk_2` FOREIGN KEY (`zutat_typ`) REFERENCES `zutat` (`zutat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rezepte_ibfk_3` FOREIGN KEY (`selektion_id`) REFERENCES `selektion` (`selektion_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rezepte_ibfk_4` FOREIGN KEY (`geschmack_id`) REFERENCES `geschmack` (`geschmack_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rezepte_ibfk_5` FOREIGN KEY (`farbe_id`) REFERENCES `farbe` (`farbe_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rezepte_ibfk_6` FOREIGN KEY (`rezension`) REFERENCES `rezension` (`rezension_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rezepte_ibfk_7` FOREIGN KEY (`bearbeitung_id`) REFERENCES `bearbeitung` (`bearbeitung_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `zutat`
--
ALTER TABLE `zutat`
  ADD CONSTRAINT `zutat_ibfk_1` FOREIGN KEY (`farbe_id`) REFERENCES `farbe` (`farbe_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
