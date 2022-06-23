-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Φιλοξενητής: 127.0.0.1
-- Χρόνος δημιουργίας: 08 Νοε 2020 στις 18:44:00
-- Έκδοση διακομιστή: 10.4.14-MariaDB
-- Έκδοση PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `nefosproject`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `cinemas`
--

CREATE TABLE `cinemas` (
  `ID` int(11) NOT NULL,
  `OWNER` varchar(256) NOT NULL,
  `NAME` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `cinemas`
--

INSERT INTO `cinemas` (`ID`, `OWNER`, `NAME`) VALUES
(4, 'owner1', 'MAGIA'),
(5, 'owner1', 'Attikon'),
(6, 'owner1', 'REX'),
(7, 'owner1', 'MALL'),
(8, 'owner2', 'VILLAGE'),
(9, 'owner2', 'THEATRON'),
(10, 'owner2', 'OLYMPOS'),
(11, 'owner3', 'STENO'),
(12, 'owner3', 'CineFan');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `favorites`
--

CREATE TABLE `favorites` (
  `ID` int(11) NOT NULL,
  `USERID` int(11) NOT NULL,
  `MOVIEID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `favorites`
--

INSERT INTO `favorites` (`ID`, `USERID`, `MOVIEID`) VALUES
(26, 25, 17),
(27, 25, 16),
(28, 25, 22),
(29, 25, 20),
(30, 25, 29),
(31, 26, 25),
(32, 26, 21),
(33, 26, 22),
(34, 26, 19),
(35, 26, 20),
(36, 26, 17),
(37, 26, 16);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `movies`
--

CREATE TABLE `movies` (
  `ID` int(11) NOT NULL,
  `TITLE` varchar(256) NOT NULL,
  `STARTDATE` date NOT NULL,
  `ENDDATE` date NOT NULL,
  `CINEMANAME` varchar(256) NOT NULL,
  `CATEGORY` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `movies`
--

INSERT INTO `movies` (`ID`, `TITLE`, `STARTDATE`, `ENDDATE`, `CINEMANAME`, `CATEGORY`) VALUES
(14, 'Blade Runner', '2020-11-06', '2020-11-10', 'MAGIA', 'Sci-fi'),
(15, 'Harry Potter', '2020-11-11', '2020-11-25', 'MAGIA', 'Adventure'),
(16, 'La la land', '2020-11-16', '2020-11-28', 'MAGIA', 'Musical'),
(17, 'Whiplash', '2020-12-09', '2020-12-31', 'Attikon', 'Drama'),
(19, 'Lord of flies', '2020-11-11', '2020-11-24', 'Attikon', 'Drama'),
(20, 'Forrest Gump', '2020-12-23', '2021-01-07', 'REX', 'Drama'),
(21, 'Tree of Life', '2021-01-27', '2021-01-19', 'MALL', 'Drama'),
(22, 'A hidden Life', '2020-11-02', '2020-11-09', 'MALL', 'Drama'),
(23, 'Green Book', '2020-11-04', '2020-11-05', 'VILLAGE', 'Drama'),
(24, 'Last Samurai', '2020-11-13', '2020-11-21', 'VILLAGE', 'Action'),
(25, 'The shinning', '2020-11-17', '2020-11-25', 'THEATRON', 'Horror'),
(26, '1917', '2020-11-20', '2020-12-06', 'THEATRON', 'Action'),
(27, 'American Beauty', '2020-11-21', '2020-11-29', 'OLYMPOS', 'Drama'),
(29, '300', '2020-10-27', '2020-11-10', 'STENO', 'Action'),
(30, 'Inception', '2020-11-20', '2021-02-16', 'STENO', 'Action');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `NAME` varchar(128) NOT NULL,
  `SURNAME` varchar(128) NOT NULL,
  `USERNAME` varchar(128) NOT NULL,
  `PASSWORD` varchar(128) NOT NULL,
  `EMAIL` varchar(128) NOT NULL,
  `ROLE` enum('User','CinemaOwner','Admin') DEFAULT NULL,
  `CONFIRMED` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `users`
--

INSERT INTO `users` (`ID`, `NAME`, `SURNAME`, `USERNAME`, `PASSWORD`, `EMAIL`, `ROLE`, `CONFIRMED`) VALUES
(11, 'Pavlos', 'Sofroniou', 'admin', '$2y$10$bBdXq8g0/52Rp2fuerSRxOiNqH7Z.Pgc7aRZb2TOKPPN9gCwnj.NS', 'admin@mail.com', 'Admin', 1),
(22, 'Dimitris', 'Sofroniou', 'owner1', '$2y$10$tcPtqca3lU/gAiE4X0FT2eTizZdxKvPy8Qnhnz8P9OghKRdMb5vou', 'owner1@mail.com', 'CinemaOwner', 1),
(23, 'Alexandros', 'Gewrgiou', 'owner2', '$2y$10$JqkIUpP3UGVthgxqtMGhn.mmDdjJtq6hs2HrU5JAoCk06jYhHGpGu', 'owner2@mail.com', 'CinemaOwner', 1),
(24, 'Maria', 'Giannakh', 'owner3', '$2y$10$IJ74huMOFmJBcmo/zBhDmeWlQby3vsdQ5XhnYwg2MvDVIMoCOUF9O', 'owner3@fastmail.com', 'CinemaOwner', 1),
(25, 'Takis', 'Eleftheriou', 'user1', '$2y$10$vttohDHT9Nkh4/ZoDIP6P.j4F0OYReYCO9Nw3aQsk78jRR4X2gwlC', 'user1@fastmail.com', 'User', 1),
(26, 'Vaggelis', 'Xarisis', 'user2', '$2y$10$Buimp6VwZTfRBJXivKJPZObR//a1BojpKO8S5Rw3M0zWW.6gyvbpO', 'user2@slowmail.com', 'User', 1),
(27, 'Fotis', 'Stogios', 'user3', '$2y$10$5OemDdr4mjPRwbesQgEdTuv4FMAfU8ed7lgjYlBp1FOjpOATUg/eO', 'user3@mailservice.com', 'User', 0);

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `cinemas`
--
ALTER TABLE `cinemas`
  ADD PRIMARY KEY (`ID`);

--
-- Ευρετήρια για πίνακα `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`ID`);

--
-- Ευρετήρια για πίνακα `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`ID`);

--
-- Ευρετήρια για πίνακα `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT για άχρηστους πίνακες
--

--
-- AUTO_INCREMENT για πίνακα `cinemas`
--
ALTER TABLE `cinemas`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT για πίνακα `favorites`
--
ALTER TABLE `favorites`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT για πίνακα `movies`
--
ALTER TABLE `movies`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT για πίνακα `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
