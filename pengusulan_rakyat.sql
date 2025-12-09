-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2025 at 05:31 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pengusulan_rakyat`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Tambah_Usulan` (IN `p_nama` VARCHAR(100), IN `p_email` VARCHAR(100), IN `p_topik` VARCHAR(150), IN `p_deskripsi` TEXT)   BEGIN
    INSERT INTO usulan (nama_pengusul, email_pengusul, topik_usulan, deskripsi_usulan)
    VALUES (p_nama, p_email, p_topik, p_deskripsi);
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `F_Hitung_Usia_Usulan` (`p_tanggal_usulan` DATETIME) RETURNS INT(11) DETERMINISTIC BEGIN
    RETURN DATEDIFF(CURRENT_DATE(), DATE(p_tanggal_usulan));
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `log_status_usulan`
--

CREATE TABLE `log_status_usulan` (
  `id_log` int(11) NOT NULL,
  `id_usulan` int(11) DEFAULT NULL,
  `status_lama` varchar(50) DEFAULT NULL,
  `status_baru` varchar(50) DEFAULT NULL,
  `waktu_perubahan` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `log_status_usulan`
--

INSERT INTO `log_status_usulan` (`id_log`, `id_usulan`, `status_lama`, `status_baru`, `waktu_perubahan`) VALUES
(1, 2, 'Baru', 'Selesai', '2025-12-08 23:05:24'),
(2, 3, 'Baru', 'Selesai', '2025-12-08 23:28:25');

-- --------------------------------------------------------

--
-- Table structure for table `usulan`
--

CREATE TABLE `usulan` (
  `id_usulan` int(11) NOT NULL,
  `nama_pengusul` varchar(100) NOT NULL,
  `email_pengusul` varchar(100) DEFAULT NULL,
  `topik_usulan` varchar(150) NOT NULL,
  `deskripsi_usulan` text NOT NULL,
  `tanggal_pengusulan` datetime DEFAULT current_timestamp(),
  `status_usulan` enum('Baru','Diproses','Selesai') DEFAULT 'Baru'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usulan`
--

INSERT INTO `usulan` (`id_usulan`, `nama_pengusul`, `email_pengusul`, `topik_usulan`, `deskripsi_usulan`, `tanggal_pengusulan`, `status_usulan`) VALUES
(3, 'dimas', NULL, 'bencana alam', 'banjir di kampus ketintang semakin parah dan tidak segera ditindak lanjuti', '2025-12-08 23:06:23', 'Selesai'),
(4, 'hakim', NULL, 'fasilitas umum', 'dikarenakan bis tidak datang tepat waktu, saya telat bekerja dan mendapat hukuman gaji dipotong', '2025-12-08 23:08:26', 'Baru');

--
-- Triggers `usulan`
--
DELIMITER $$
CREATE TRIGGER `TR_Update_Status` AFTER UPDATE ON `usulan` FOR EACH ROW BEGIN
    IF OLD.status_usulan <> NEW.status_usulan THEN
        INSERT INTO log_status_usulan (id_usulan, status_lama, status_baru)
        VALUES (NEW.id_usulan, OLD.status_usulan, NEW.status_usulan);
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_usulan_aktif`
-- (See below for the actual view)
--
CREATE TABLE `v_usulan_aktif` (
`id_usulan` int(11)
,`nama_pengusul` varchar(100)
,`topik_usulan` varchar(150)
,`tanggal_pengusulan` datetime
);

-- --------------------------------------------------------

--
-- Structure for view `v_usulan_aktif`
--
DROP TABLE IF EXISTS `v_usulan_aktif`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_usulan_aktif`  AS SELECT `usulan`.`id_usulan` AS `id_usulan`, `usulan`.`nama_pengusul` AS `nama_pengusul`, `usulan`.`topik_usulan` AS `topik_usulan`, `usulan`.`tanggal_pengusulan` AS `tanggal_pengusulan` FROM `usulan` WHERE `usulan`.`status_usulan` = 'Baru' OR `usulan`.`status_usulan` = 'Diproses' ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `log_status_usulan`
--
ALTER TABLE `log_status_usulan`
  ADD PRIMARY KEY (`id_log`);

--
-- Indexes for table `usulan`
--
ALTER TABLE `usulan`
  ADD PRIMARY KEY (`id_usulan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `log_status_usulan`
--
ALTER TABLE `log_status_usulan`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `usulan`
--
ALTER TABLE `usulan`
  MODIFY `id_usulan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
