-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2022 at 06:16 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rsnew`
--

-- --------------------------------------------------------

--
-- Table structure for table `antripoli_custom`
--

CREATE TABLE `antripoli_custom` (
  `kd_dokter` varchar(20) DEFAULT NULL,
  `kd_poli` char(5) DEFAULT NULL,
  `status` enum('0','1','2') DEFAULT NULL,
  `no_rawat` varchar(17) DEFAULT NULL,
  `no_reg` varchar(255) DEFAULT NULL,
  `no_rkm_medis` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tgl` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `antripoli_custom`
--

INSERT INTO `antripoli_custom` (`kd_dokter`, `kd_poli`, `status`, `no_rawat`, `no_reg`, `no_rkm_medis`, `updated_at`, `tgl`) VALUES
('D0000003', 'U0011', '2', '2022/10/26/000003', '003', '000006', '2022-10-26 03:02:42', '2022-10-26'),
('D0000003', 'U0011', '2', '2022/10/26/000003', '003', '000006', '2022-10-26 03:02:42', '2022-10-26'),
('D0000003', 'U0011', '2', '2022/10/26/000003', '003', '000006', '2022-10-26 03:02:42', '2022-10-26'),
('D0000003', 'U0011', '2', '2022/10/26/000003', '003', '000006', '2022-10-26 03:02:42', '2022-10-26'),
('D0000003', 'U0011', '2', '2022/10/26/000002', '002', '000005', '2022-10-26 03:04:05', '2022-10-26'),
('D0000003', 'U0011', '2', '2022/10/26/000003', '003', '000006', '2022-10-26 03:02:42', '2022-10-26'),
('D0000003', 'U0011', '2', '2022/10/26/000003', '003', '000006', '2022-10-26 03:02:42', '2022-10-26'),
('D0000003', 'U0011', '2', '2022/10/26/000002', '002', '000005', '2022-10-26 03:04:05', '2022-10-26'),
('D0000003', 'U0011', '2', '2022/10/26/000003', '003', '000006', '2022-10-26 03:02:42', '2022-10-26'),
('D0000003', 'U0011', '2', '2022/10/26/000002', '002', '000005', '2022-10-26 03:04:05', '2022-10-26'),
('D0000003', 'U0011', '2', '2022/10/26/000002', '002', '000005', '2022-10-26 03:04:05', '2022-10-26'),
('D0000003', 'U0011', '2', '2022/10/26/000003', '003', '000006', '2022-10-26 03:02:42', '2022-10-26');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
