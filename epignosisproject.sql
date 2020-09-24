-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Φιλοξενητής: 127.0.0.1
-- Χρόνος δημιουργίας: 24 Σεπ 2020 στις 21:28:32
-- Έκδοση διακομιστή: 10.4.14-MariaDB
-- Έκδοση PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `epignosisproject`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `admin`
--

CREATE TABLE `admin` (
  `first_name` char(30) NOT NULL,
  `last_name` char(30) NOT NULL,
  `passwrd` longtext NOT NULL,
  `e_mail` char(30) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `admin`
--

INSERT INTO `admin` (`first_name`, `last_name`, `passwrd`, `e_mail`, `user_id`) VALUES
('Dimitra', 'Alexopoulou', '$2y$10$w8C.I7yHbhCYui1K7OdLuu67C39nucWxdq1ZpV7F0rBrjRzVLnk76', 'alex@gmail.com', 1),
('Giannis', 'Karidis', '$2y$10$GMXc6aud71CJGDb..vCRJOzwtJVKFoZCBo51ac4mvZgf9fH5dHN06', 'giannis@gmail.com', 2);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `application`
--

CREATE TABLE `application` (
  `date_submitted` date NOT NULL,
  `vacation_start` date NOT NULL,
  `vacation_end` date NOT NULL,
  `status` char(10) NOT NULL,
  `application_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `application`
--

INSERT INTO `application` (`date_submitted`, `vacation_start`, `vacation_end`, `status`, `application_code`) VALUES
('2020-09-24', '2020-09-26', '2020-09-28', 'pending', 1),
('2020-09-24', '2020-12-05', '2020-12-25', 'pending', 2),
('2020-03-06', '2020-03-20', '2020-03-28', 'pending', 5);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `employee`
--

CREATE TABLE `employee` (
  `first_name` char(30) NOT NULL,
  `last_name` char(30) NOT NULL,
  `passwrd` longtext NOT NULL,
  `e_mail` char(30) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `employee`
--

INSERT INTO `employee` (`first_name`, `last_name`, `passwrd`, `e_mail`, `user_id`) VALUES
('Konstantinos', 'Danopoulos', '$2y$10$7g2SjWNiLG6wT8sHD0MM3OrJtYNEKdnnt66Bzw5VPz4YWuwgRm7gq', 'konstas13@gmail.com', 1),
('Maria', 'Papadopoulou', '$2y$10$3V923gi.ZdWPzzqyrlf2M.pgSGImeDE7tWlTYMWbh9sFC5/eFv/Om', 'kpapa@gmail.com', 4),
('George', 'Karidis', '$2y$10$ahW5jzDaTJ5M3aC64qxAduxkmC1KEqF3ei8Vqk.Jkfy3lnlLVZ6Eq', 'g.karidis@hotmail.com', 5),
('Vilelmini', 'Karidi', '$2y$10$dJLCqGLiM5fPNos4zVf9sOX6jqt2DqPupxTX1usfbjXWlw3FGz0m.', 'karidi@gmail.com', 6);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `submits`
--

CREATE TABLE `submits` (
  `user_id` int(11) NOT NULL,
  `application_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `submits`
--

INSERT INTO `submits` (`user_id`, `application_code`) VALUES
(1, 1),
(1, 2),
(1, 5);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `supervise`
--

CREATE TABLE `supervise` (
  `id_of_admin` int(11) NOT NULL,
  `id_of_employee` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `supervise`
--

INSERT INTO `supervise` (`id_of_admin`, `id_of_employee`) VALUES
(1, 1),
(1, 5),
(1, 6),
(2, 4);

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`user_id`);

--
-- Ευρετήρια για πίνακα `application`
--
ALTER TABLE `application`
  ADD PRIMARY KEY (`application_code`);

--
-- Ευρετήρια για πίνακα `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`user_id`);

--
-- Ευρετήρια για πίνακα `submits`
--
ALTER TABLE `submits`
  ADD PRIMARY KEY (`user_id`,`application_code`),
  ADD KEY `submits_application_code_fkey` (`application_code`);

--
-- Ευρετήρια για πίνακα `supervise`
--
ALTER TABLE `supervise`
  ADD PRIMARY KEY (`id_of_admin`,`id_of_employee`),
  ADD KEY `supervise_id_of_employee_fkey` (`id_of_employee`);

--
-- AUTO_INCREMENT για άχρηστους πίνακες
--

--
-- AUTO_INCREMENT για πίνακα `admin`
--
ALTER TABLE `admin`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT για πίνακα `application`
--
ALTER TABLE `application`
  MODIFY `application_code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT για πίνακα `employee`
--
ALTER TABLE `employee`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Περιορισμοί για άχρηστους πίνακες
--

--
-- Περιορισμοί για πίνακα `submits`
--
ALTER TABLE `submits`
  ADD CONSTRAINT `submits_application_code_fkey` FOREIGN KEY (`application_code`) REFERENCES `application` (`application_code`),
  ADD CONSTRAINT `submits_id_fkey` FOREIGN KEY (`user_id`) REFERENCES `employee` (`user_id`);

--
-- Περιορισμοί για πίνακα `supervise`
--
ALTER TABLE `supervise`
  ADD CONSTRAINT `supervise_id_of_admin_fkey` FOREIGN KEY (`id_of_admin`) REFERENCES `admin` (`user_id`),
  ADD CONSTRAINT `supervise_id_of_employee_fkey` FOREIGN KEY (`id_of_employee`) REFERENCES `employee` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
