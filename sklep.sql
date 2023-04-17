-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2023 at 11:23 AM
-- Wersja serwera: 10.4.28-MariaDB
-- Wersja PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sklep`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `samoloty`
--

CREATE TABLE `samoloty` (
  `nazwa` text NOT NULL,
  `model` text NOT NULL,
  `typ` text NOT NULL,
  `naped` text NOT NULL,
  `cena` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `img_location` text NOT NULL,
  `description` text NOT NULL,
  `ilosc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `samoloty`
--

INSERT INTO `samoloty` (`nazwa`, `model`, `typ`, `naped`, `cena`, `id`, `img_location`, `description`, `ilosc`) VALUES
('Boeing', '737-800', 'pasazerskii', 'turboodrzutowy', 9000000, 27, 'sample.jpg', 'spoko dziala', 0),
('cessna', '152', 'solo', 'smiglowy', 30000, 28, 'sample.jpg', 'fajny', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `username` text NOT NULL,
  `login` text NOT NULL,
  `password` text NOT NULL,
  `sign_up_date` date NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `login`, `password`, `sign_up_date`, `id`) VALUES
('name', 'email@email.com', 'password', '0000-00-00', 1),
('Admin', 'admin@admin.admin', 'Password123@!', '2023-02-28', 8),
('owner', 'owner@owner.owner', 'Owner123!', '2023-04-16', 9),
('adam', 'adam@adam.com', 'Adam123!', '2023-04-16', 10);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `samoloty`
--
ALTER TABLE `samoloty`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `samoloty`
--
ALTER TABLE `samoloty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
