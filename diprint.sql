-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 17, 2022 at 02:05 PM
-- Server version: 10.5.16-MariaDB-cll-lve
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u3737783_diprint`
--

-- --------------------------------------------------------

--
-- Table structure for table `agen`
--

CREATE TABLE `agen` (
  `id` int(11) NOT NULL,
  `nama_percetakan` varchar(100) NOT NULL,
  `nama_pemilik` varchar(255) NOT NULL,
  `telpon` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `password` varchar(500) NOT NULL,
  `poto` varchar(100) NOT NULL,
  `keterangan` varchar(500) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'new'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `agen`
--

INSERT INTO `agen` (`id`, `nama_percetakan`, `nama_pemilik`, `telpon`, `email`, `alamat`, `password`, `poto`, `keterangan`, `status`) VALUES
(8, 'Toko IFA Jaya', 'Aulia Indasari', '087713826974', 'auliasariindah@gmail.com', 'Depan Pintu 2 Kampus UINAM samata', '$2y$10$Qil3IeZbZjYR738WK7yLgOIoIwB4HsfWLSKDDqLyFi/LtC8UxYfx6', '6177cc60d0d6f.jpg', 'Bisa Diantarkan Juga Bosqy', 'active'),
(9, 'Fotocopy ISTIANAH', 'Aldi Sandi', '082151975077', 'percetakan.istianah@gmail.com', 'jl. syahrul yasin limpo, samata, Gowa', '$2y$10$Jf/hAw2K1HU55UOTPJprSeY9FSIZINYzkIMjVcMzAbaDdS7XNJPNa', '61779b9f6d96f.jpg', 'Harga Murah Pelayanan Cepat', 'active'),
(10, 'Percetakan 86', 'Firdaus Tayang', '082397082367', 'ffirdaustayang@gmail.com', 'Jl. Sultan Alauddin, Romangpolong, Kec. Somba Opu', '$2y$10$cz41a5rA8NkO81i61Lq6VeTcpQRZIm2PV2aQDqeS1.Wy8adKItJ.u', '61701da959421.jpg', 'Harga Murah Bisa diantar', 'banned'),
(11, 'Toko Andini', 'Muh. Khadafi M', '081258060349', 'khadafi_daf@gmail.com', 'jl.syahrul yasin limpo, samata, depan kampus 2 UINAM', '$2y$10$HpJwkbi2CQYpqSjqZ/Sae.TykAm8LeTnvZjrsmb1FSKOU6WxFE3D2', '6177b13dd115a.jpg', 'MURAHHH MERIAHHHH', 'active'),
(14, 'FOTO COPY IAS', 'Rais', '085333341194', 'fotocopyias13@gmail.com', 'Jl. Sultan Alauddin, Romangpolong, Gowa, Pintu 2 UINAM', '$2y$10$eM.veDqlt6TequkcO.AoCOUkV6Ck44AAVDOIkkKF4jaRHPqVPSOA.', '618aa145c693f.jpg', 'Cepat dan Handal', 'active'),
(15, 'Print All IN', 'Rahayu Besse TS', '085299868548', 'rahayu@gmail.com', 'Jl. Jenral Sudirman, No 12. Makassar', '$2y$10$lO33oDlNqhQvRYtXrruiROvKoF/jzh4z1oBuGUUDN1TH9VHJHaw8K', '614d81e1a5504.jpg', 'Bagus dan bisa diandalkan loh', 'banned'),
(16, 'Satu Sama Print', 'Muhammad Ilham', '085242657354', 'ilham@gmail.com', 'Jl. Samata City, No. 13', '$2y$10$tyJBbSCFF4fxxsxder/tk.MWlCV9HvN/rUvfD4m9/sw9mcQ8KulU.', '6167e468d5762.jpeg', 'Terbaik untuk anda', 'new'),
(17, 'Percetakan 86', 'Firdaus Tayang', '082397082367', 'ffirdaustayang@gmail.com', 'Jl. Sultan Alauddin, Romangpolong, Gowa', '$2y$10$Rv8OQRiYdhqDBe7H7xU8seJfgRZF.EKFW90LFg7csGOrddvzD38aS', '616fc7618a77f.jpg', 'Buka tiap hari hingga pukul 22:00', 'active'),
(18, 'Jasriah Maspul (JM)', 'Asrul Riandi', '087299872345', 'jasriahmaspul@gmail.com', 'Jl. Yasin Limpo, Samata-Gowa (Pintu Keluar UIN)', '$2y$10$I1HdvICv/lUx7kQgRynUbuQiKRz8bwLozSV6nsMQguGbZJbK3z9sm', '618aa484a95b4.jpg', 'Pelayanan Tercepat Harga Termurah', 'active'),
(19, 'Example Mitra', 'Sri Asriani', '085333341194', 'mitra.ex@test.com', 'Jl. Samata Depan Pintu Keluar UIN', '$2y$10$WG3OaXY0Ujy1J8zQmgHmZO6iX4bJGy0Sfn4aAldYCTETdkP4T22gq', '61e034313bb76.jpg', 'Cepat dan handal, siap melayani', 'banned');

-- --------------------------------------------------------

--
-- Table structure for table `cetak`
--

CREATE TABLE `cetak` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `agen_id` int(11) NOT NULL,
  `jenis_layanan` varchar(50) NOT NULL,
  `file` varchar(255) NOT NULL,
  `catatan` varchar(255) NOT NULL,
  `waktu_pesanan` datetime NOT NULL DEFAULT current_timestamp(),
  `waktu_pengambilan` datetime NOT NULL,
  `harga` varchar(10) NOT NULL,
  `metode_pembayaran` varchar(50) NOT NULL,
  `payment_token` varchar(255) DEFAULT NULL,
  `delivery` double NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cetak`
--

INSERT INTO `cetak` (`id`, `user_id`, `agen_id`, `jenis_layanan`, `file`, `catatan`, `waktu_pesanan`, `waktu_pengambilan`, `harga`, `metode_pembayaran`, `payment_token`, `delivery`, `status`) VALUES
(5, 5, 14, 'dokumen', 'dokumen-5-20211012-2254.docx', 'Jilid warna kuning', '2021-10-12 22:54:41', '2021-10-12 22:01:00', '12000', 'virtual', 'a77e3a0e-342b-4fbf-8e6c-717cc9e0bb77', 0, 'cancel'),
(6, 5, 14, 'dokumen', 'dokumen-5-20211012-2350.docx', 'smbrg', '2021-10-12 23:50:34', '2021-10-12 23:09:00', '1400', 'virtual', '556fb5e3-13ef-4fd8-ac68-7546d47c854c', 0, 'finish'),
(8, 4, 15, 'dokumen', 'dokumen-5-20211013-0013.docx', '', '2021-10-13 00:13:52', '2021-10-13 00:19:00', '800', 'virtual', '3da0fb15-f317-4683-b7e8-1f9168318b39', 0, 'cancel'),
(9, 5, 11, 'foto', 'dokumen-5-20211012-2350.docx', '', '2021-10-12 23:50:34', '2021-10-12 23:09:00', '1400', 'langsung', '', 0, 'finish'),
(10, 5, 14, 'foto', 'dokumen-5-20211013-0013.docx', '', '2021-10-13 00:13:52', '2021-10-13 00:19:00', '800', 'langsung', '', 0, 'finish'),
(11, 5, 11, 'foto', 'dokumen-5-20211012-2350.docx', '', '2021-10-12 23:50:34', '2021-10-12 23:09:00', '1400', 'langsung', '', 0, 'finish'),
(12, 5, 15, 'foto', 'dokumen-5-20211013-0013.docx', '', '2021-10-13 00:13:52', '2021-10-13 00:19:00', '800', 'langsung', '', 0, 'finish'),
(13, 5, 11, 'foto', 'dokumen-5-20211012-2350.docx', '', '2021-10-12 23:50:34', '2021-10-12 23:09:00', '1400', 'langsung', '', 0, 'cancel'),
(19, 5, 14, 'dokumen', 'dokumen-5-20211014-1002.docx', '', '2021-10-14 10:02:08', '2021-10-14 10:27:00', '8000', 'langsung', '', 0, 'cancel'),
(20, 5, 14, 'foto', 'foto-5-20211014-1014.jpg', '', '2021-10-14 10:14:56', '2021-10-14 10:20:00', '5000', 'virtual', '', 0, 'cancel'),
(21, 5, 14, 'dokumen', 'dokumen-5-20211014-1941.docx', 'Sembarang', '2021-10-14 19:41:27', '2021-10-14 19:00:00', '4000', 'virtual', 'f0c26583-157f-42ac-a699-b9c53c314085', 0, 'finish'),
(22, 5, 11, 'dokumen', 'dokumen-5-20211014-2028.docx', 'Hekter yang rapi', '2021-10-14 20:28:45', '2021-10-14 20:50:00', '8000', 'virtual', '359ea9e2-a0f8-4e3f-b4e8-00a93262130e', 0, 'cancel'),
(23, 5, 14, 'foto', 'foto-Rahmat-Ilyas-20211018-1332.jpg', 'Tolog di bungkus kertas', '2021-10-18 13:32:12', '2021-10-18 13:41:00', '4000', 'langsung', '', 0, 'cancel'),
(24, 5, 14, 'foto', 'Foto-Rahmat-Ilyas-19102021-2117.jpg', 'Silahkan di warnai', '2021-10-19 21:17:10', '2021-10-19 21:23:00', '12000', 'langsung', '', 0, 'finish'),
(25, 5, 14, 'foto', 'Foto-Rahmat-Ilyas-19102021-2122.jpeg', 'Silahkan di pilih', '2021-10-19 21:22:35', '2021-10-19 21:28:00', '20000', 'virtual', '36980a03-3e12-4a84-aa39-b690bd83cc34', 0, 'finish'),
(26, 3, 8, 'dokumen', 'Dokumen-Sri-Asriani-19102021-2301.pdf', '', '2021-10-19 23:01:40', '2021-10-20 08:00:00', '100', 'virtual', '785ffbe2-8d9a-4b1d-ad9e-048696000ce1', 0, 'cancel'),
(27, 3, 14, 'dokumen', 'Dokumen-Sri-Asriani-19102021-2306.pdf', '', '2021-10-19 23:06:21', '2021-10-19 10:06:00', '200', 'langsung', '', 0, 'finish'),
(28, 3, 14, 'dokumen', 'Dokumen-Sri-Asriani-19102021-2323.pdf', '', '2021-10-19 23:23:54', '2021-10-20 09:00:00', '450', 'virtual', '1e88c7e1-16a7-47bb-9b13-6140251c0900', 0, 'finish'),
(29, 3, 9, 'dokumen', 'Dokumen-Asri-Ardian-26102021-1448.pdf', '', '2021-10-26 14:48:07', '2021-10-27 09:00:00', '250', 'virtual', '0c4ae605-42f7-409e-8735-159b62e5f658', 0, 'cancel'),
(30, 3, 9, 'dokumen', 'Dokumen-Asri-Ardian-26102021-1507.pdf', '', '2021-10-26 15:07:47', '2021-10-27 09:31:00', '2500', 'virtual', '6bbe3104-728f-4b96-a689-81fd47b706b5', 0, 'finish'),
(31, 3, 11, 'dokumen', 'Dokumen-Alidia-Syahrani-26102021-1544.docx', '', '2021-10-26 15:44:22', '2021-10-26 17:30:00', '2400', 'langsung', '', 0, 'finish'),
(32, 3, 8, 'dokumen', 'Dokumen-Alidia-Syahrani-26102021-1758.docx', '', '2021-10-26 17:58:43', '2021-10-27 17:58:00', '13000', 'langsung', '', 0, 'cancel'),
(33, 3, 9, 'dokumen', 'Dokumen-Alidia-Syahrani-26102021-1804.docx', '', '2021-10-26 18:04:37', '2021-10-27 10:30:00', '13000', 'virtual', 'ed459c2a-44c9-4633-80e6-e72b8f75eab7', 0, 'cancel'),
(34, 3, 14, 'foto', 'Foto-Alidia-Syahrani-26102021-2357.jpg', 'Ganti latar kalo bisa', '2021-10-26 23:57:13', '2021-10-27 07:00:00', '8000', 'langsung', '', 0, 'finish'),
(35, 8, 18, 'dokumen', 'Dokumen-sulaiman-10112021-0044.docx', '', '2021-11-10 00:44:09', '2021-11-11 00:43:00', '600', 'virtual', '905729c3-09ea-4f17-ac86-d038c0ecded4', 0, 'finish'),
(36, 5, 8, 'dokumen', 'Dokumen-Rahmat-Ilyas-10112021-2218.docx', '', '2021-11-10 22:18:27', '2021-11-11 09:30:00', '2000', 'member', '', 0, 'review'),
(37, 3, 8, 'dokumen', 'Dokumen-Alidia-Syahrani-17112021-0112.pdf', '', '2021-11-17 01:12:33', '2021-11-17 03:12:00', '250', 'member', '', 0, 'cancel'),
(38, 3, 14, 'dokumen', 'Dokumen-Alidia-Syahrani-17112021-0927.pdf', '', '2021-11-17 09:27:35', '2021-11-17 11:30:00', '15900', 'member', '', 0, 'cancel'),
(39, 9, 11, 'dokumen', 'Dokumen-Andi-Abdillah-17112021-2251.pdf', 'jgjhgjh', '2021-11-17 22:51:20', '2021-11-05 22:50:00', '700', 'member', '', 0, 'review'),
(40, 9, 11, 'dokumen', 'Dokumen-Andi-Abdillah-17112021-2252.docx', 'kjnjkjk', '2021-11-17 22:52:39', '2021-11-12 21:52:00', '100', 'member', '', 0, 'review'),
(41, 10, 8, 'dokumen', 'Dokumen-Miftahul-Khair-17112021-2256.pdf', '', '2021-11-17 22:56:48', '2021-11-17 22:56:00', '2000', 'member', '', 0, 'review'),
(42, 11, 8, 'dokumen', 'Dokumen-Wirna-Sentia-Rahayu-18112021-0010.pdf', '', '2021-11-18 00:10:20', '2021-11-18 00:10:00', '5000', 'virtual', '10f79576-3332-4638-ba7d-8d8e8d9d9c81', 0, 'review'),
(43, 12, 14, 'dokumen', 'Dokumen-anita-18112021-1300.docx', 'jilid warna kuning', '2021-11-18 13:00:50', '2021-11-19 13:00:00', '14900', 'virtual', 'b1641c85-f25f-4d11-bdfb-abd7d40e184b', 0, 'finish'),
(44, 3, 14, 'foto', 'Foto-Alidia-Syahrani-18112021-1304.png', '', '2021-11-18 13:04:15', '2021-11-18 14:00:00', '10000', 'member', '', 0, 'finish'),
(45, 3, 18, 'dokumen', 'Dokumen-Alidia-Syahrani-03122021-1455.docx', '', '2021-12-03 14:55:15', '2021-12-11 14:54:00', '21200', 'virtual', '18d416be-e6b5-4dbc-8db6-1627a89295eb', 0, 'cancel'),
(46, 3, 14, 'dokumen', 'Dokumen-Alidia-Syahrani-18012022-2246.docx', '', '2022-01-18 22:46:13', '2022-01-19 08:00:00', '11700', 'member', '', 0, 'finish'),
(47, 14, 14, 'dokumen', 'Dokumen-cobs-03022022-2219.pdf', 'jilid warna merah', '2022-02-03 22:19:28', '2022-02-04 09:00:00', '15000', 'virtual', '4911fd8d-c2ff-4fa9-a4c9-406ebfd86236', 0, 'finish'),
(48, 3, 14, 'dokumen', 'Dokumen-Alidia-Syahrani-03022022-2224.pdf', '', '2022-02-03 22:24:47', '2022-02-04 08:00:00', '7000', 'member', '', 0, 'finish'),
(49, 14, 14, 'dokumen', 'Dokumen-cobs-03022022-2238.pdf', '', '2022-02-03 22:38:58', '2022-02-04 08:00:00', '15000', 'langsung', '', 0, 'cancel'),
(50, 3, 14, 'dokumen', 'Dokumen-Alidia-Syahrani-03022022-2240.pdf', '', '2022-02-03 22:40:36', '2022-02-04 08:00:00', '15000', 'member', '', 0, 'cancel'),
(51, 14, 14, 'dokumen', 'Dokumen-cobs-04022022-0657.pdf', '', '2022-02-04 06:57:04', '2022-02-04 10:00:00', '13000', 'langsung', '', 0, 'finish'),
(52, 3, 14, 'dokumen', 'Dokumen-Alidia-Syahrani-04022022-0659.pdf', '', '2022-02-04 06:59:16', '2022-02-04 10:15:00', '10400', 'member', '', 0, 'finish'),
(53, 3, 14, 'dokumen', 'Dokumen-Alidia-Syahrani-04022022-0701.pdf', '', '2022-02-04 07:01:12', '2022-02-04 10:30:00', '10400', 'member', '', 0, 'finish'),
(54, 3, 14, 'dokumen', 'Dokumen-Alidia-Syahrani-04022022-0839.pdf', '', '2022-02-04 08:39:12', '2022-02-05 09:39:00', '1400', 'member', '', 0, 'finish'),
(55, 13, 14, 'dokumen', 'Dokumen-Example-User-04022022-1428.pdf', '', '2022-02-04 14:28:12', '2022-02-04 16:00:00', '13000', 'virtual', '0ad4b879-5824-4416-b354-41cfd0c81258', 0, 'finish'),
(56, 3, 14, 'dokumen', 'Dokumen-Alidia-Syahrani-04022022-1431.pdf', '', '2022-02-04 14:31:07', '2022-02-04 16:00:00', '13000', 'member', '', 0, 'finish'),
(57, 3, 8, 'dokumen', 'Dokumen-Alidia-Syahrani-02032022-0917.pdf', '', '2022-03-02 09:17:17', '2022-03-03 09:17:00', '1000', 'member', '', 0, 'review'),
(58, 3, 8, 'dokumen', 'Dokumen-Alidia-Syahrani-02032022-0919.pdf', '', '2022-03-02 09:19:25', '2022-03-03 09:19:00', '500', 'member', '', 0, 'review'),
(59, 3, 14, 'dokumen', 'Dokumen-Alidia-Syahrani-02032022-0922.pdf', '', '2022-03-02 09:22:32', '2022-03-03 09:22:00', '700', 'member', '', 0, 'finish'),
(60, 13, 14, 'dokumen', 'Dokumen-Example-User-08032022-0754.pdf', '', '2022-03-08 07:54:01', '2022-03-09 07:53:00', '2700', 'virtual', '2a2e6417-0640-4e55-86e8-3e141738acbd', 1, 'finish'),
(61, 3, 14, 'dokumen', 'Dokumen-Alidia-Syahrani-10032022-1545.pdf', '', '2022-03-10 15:45:15', '2022-03-11 15:37:00', '42800', 'member', '', 1, 'finish'),
(62, 13, 14, 'dokumen', 'Dokumen-Example-User-10032022-1547.pdf', '', '2022-03-10 15:47:23', '2022-03-11 10:00:00', '42800', 'virtual', 'b0c6de56-ef1c-456d-9467-2880543dc362', 1, 'finish'),
(63, 13, 14, 'dokumen', 'Dokumen-Example-User-11032022-1317.pdf', '', '2022-03-11 13:17:28', '2022-03-12 14:15:00', '265000', 'virtual', '854fde4f-19ba-482a-bee3-f2c5d85f6ff9', 1, 'finish'),
(64, 3, 14, 'dokumen', 'Dokumen-Alidia-Syahrani-11032022-1320.pdf', '', '2022-03-11 13:20:35', '2022-03-12 14:20:00', '40800', 'member', '', 1, 'finish'),
(65, 13, 14, 'dokumen', 'Dokumen-Example-User-23032022-2226.docx', 'jilid warna Hijau', '2022-03-23 22:26:28', '2022-03-25 10:30:00', '55500', 'virtual', '6e4d51c1-8c0a-4c4b-b064-6e61fe647d2b', 1, 'review'),
(66, 3, 14, 'dokumen', 'Dokumen-Alidia-Syahrani-23032022-2230.pdf', 'putih aja', '2022-03-23 22:30:47', '2022-03-25 11:30:00', '4800', 'member', '', 0, 'review'),
(67, 13, 14, 'dokumen', 'Dokumen-Example-User-23032022-2234.docx', 'tolong jilid warna Biru', '2022-03-23 22:34:58', '2022-03-25 11:30:00', '166500', 'virtual', '27b5b3fa-b5bf-4378-bb91-dec093fb7816', 1, 'review');

-- --------------------------------------------------------

--
-- Table structure for table `cetak_dokumen`
--

CREATE TABLE `cetak_dokumen` (
  `id` int(11) NOT NULL,
  `cetak_id` int(11) NOT NULL,
  `warna_tulisan` varchar(50) NOT NULL,
  `jenis_kertas` int(11) NOT NULL,
  `jilid` int(11) NOT NULL,
  `jumlah_halaman` int(11) NOT NULL,
  `jumlah_rangkap` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cetak_dokumen`
--

INSERT INTO `cetak_dokumen` (`id`, `cetak_id`, `warna_tulisan`, `jenis_kertas`, `jilid`, `jumlah_halaman`, `jumlah_rangkap`) VALUES
(1, 5, 'Berwarna', 26, 1, 20, 2),
(2, 19, 'Berwarna', 8, 0, 4, 10),
(3, 21, 'Berwarna', 32, 0, 4, 5),
(4, 22, 'Berwarna', 20, 0, 8, 5),
(5, 26, 'Hitam-Putih', 2, 0, 1, 1),
(6, 27, 'Berwarna', 26, 0, 1, 1),
(7, 28, 'Hitam-Putih', 25, 0, 3, 1),
(8, 29, 'Hitam-Putih', 8, 0, 1, 1),
(9, 30, 'Hitam-Putih', 8, 0, 1, 10),
(10, 31, 'Hitam-Putih', 21, 0, 24, 1),
(11, 32, 'Hitam-Putih', 2, 0, 52, 1),
(12, 33, 'Hitam-Putih', 8, 0, 52, 1),
(13, 35, 'Hitam-Putih', 63, 0, 3, 2),
(14, 36, 'Berwarna', 2, 0, 4, 1),
(15, 37, 'Hitam-Putih', 2, 0, 1, 1),
(16, 38, 'Hitam-Putih', 26, 0, 106, 1),
(17, 39, 'Hitam-Putih', 19, 0, 7, 1),
(18, 40, 'Hitam-Putih', 19, 0, 1, 1),
(19, 41, 'Berwarna', 2, 0, 4, 1),
(20, 42, 'Berwarna', 2, 0, 10, 1),
(21, 43, 'Hitam-Putih', 26, 1, 86, 1),
(22, 45, 'Hitam-Putih', 63, 0, 106, 2),
(23, 46, 'Hitam-Putih', 25, 0, 39, 2),
(24, 47, 'Berwarna', 26, 1, 26, 1),
(25, 48, 'Berwarna', 25, 0, 2, 5),
(26, 49, 'Berwarna', 26, 1, 26, 1),
(27, 50, 'Berwarna', 25, 1, 26, 1),
(28, 51, 'Berwarna', 26, 0, 26, 1),
(29, 52, 'Hitam-Putih', 26, 0, 26, 1),
(30, 53, 'Hitam-Putih', 26, 0, 26, 1),
(31, 54, 'Hitam-Putih', 26, 0, 2, 1),
(32, 55, 'Berwarna', 26, 0, 26, 1),
(33, 56, 'Berwarna', 26, 0, 26, 1),
(34, 57, 'Hitam-Putih', 1, 0, 2, 1),
(35, 58, 'Hitam-Putih', 1, 0, 1, 1),
(36, 59, 'Hitam-Putih', 25, 0, 1, 1),
(37, 60, 'Hitam-Putih', 25, 1, 1, 1),
(38, 61, 'Hitam-Putih', 25, 0, 107, 1),
(39, 62, 'Hitam-Putih', 26, 0, 107, 3),
(40, 63, 'Berwarna', 25, 1, 102, 5),
(41, 64, 'Hitam-Putih', 26, 0, 102, 1),
(42, 65, 'Berwarna', 26, 1, 107, 1),
(43, 66, 'Hitam-Putih', 26, 1, 7, 1),
(44, 67, 'Berwarna', 26, 1, 107, 3);

-- --------------------------------------------------------

--
-- Table structure for table `cetak_foto`
--

CREATE TABLE `cetak_foto` (
  `id` int(11) NOT NULL,
  `cetak_id` int(11) NOT NULL,
  `ukuran_foto` int(11) NOT NULL,
  `ganti_latar` varchar(15) NOT NULL,
  `jumlah_rangkap` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cetak_foto`
--

INSERT INTO `cetak_foto` (`id`, `cetak_id`, `ukuran_foto`, `ganti_latar`, `jumlah_rangkap`) VALUES
(2, 10, 1, 'Ya', 5),
(3, 20, 1, 'Tidak', 5),
(4, 23, 1, 'Tidak', 4),
(5, 24, 1, 'Tidak', 12),
(6, 25, 2, 'Tidak', 10),
(7, 34, 2, 'Tidak', 4),
(8, 44, 2, 'Tidak', 5);

-- --------------------------------------------------------

--
-- Table structure for table `jenis_kertas`
--

CREATE TABLE `jenis_kertas` (
  `id` int(11) NOT NULL,
  `agen_id` int(11) NOT NULL,
  `jenis_kertas` varchar(50) NOT NULL,
  `harga` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis_kertas`
--

INSERT INTO `jenis_kertas` (`id`, `agen_id`, `jenis_kertas`, `harga`) VALUES
(1, 8, 'Letter', 0),
(2, 8, 'A4', 0),
(3, 8, 'F4 (Folio)', 0),
(4, 8, 'A3', 0),
(5, 8, 'B5', 0),
(6, 8, 'A5', 0),
(7, 9, 'Letter', 0),
(8, 9, 'A4', 0),
(9, 9, 'F4 (Folio)', 0),
(10, 9, 'A3', 0),
(11, 9, 'B5', 0),
(12, 9, 'A5', 0),
(13, 10, 'Letter', 0),
(14, 10, 'A4', 0),
(15, 10, 'F4 (Folio)', 0),
(16, 10, 'A3', 0),
(17, 10, 'B5', 0),
(18, 10, 'A5', 0),
(19, 11, 'Letter', 0),
(20, 11, 'A4', 0),
(21, 11, 'F4 (Folio)', 0),
(22, 11, 'A3', 0),
(23, 11, 'B5', 0),
(24, 11, 'A5', 0),
(25, 14, 'Letter', 200),
(26, 14, 'A4', 200),
(27, 14, 'F4 (Folio)', 200),
(28, 14, 'A3', 200),
(29, 14, 'B5', 200),
(30, 14, 'A5', 170),
(31, 15, 'Letter', 0),
(32, 15, 'A4', 0),
(33, 15, 'F4 (Folio)', 0),
(34, 15, 'A3', 0),
(35, 15, 'B5', 0),
(36, 15, 'A5', 0),
(50, 16, 'Letter', 0),
(51, 16, 'A4', 0),
(52, 16, 'F4 (Folio)', 0),
(53, 16, 'A3', 0),
(54, 16, 'B5', 0),
(55, 16, 'A5', 0),
(56, 17, 'Letter', 0),
(57, 17, 'A4', 0),
(58, 17, 'F4 (Folio)', 0),
(59, 17, 'A3', 0),
(60, 17, 'B5', 0),
(61, 17, 'A5', 0),
(62, 18, 'Letter', 0),
(63, 18, 'A4', 0),
(64, 18, 'F4 (Folio)', 0),
(65, 18, 'A3', 0),
(66, 18, 'B5', 0),
(67, 18, 'A5', 0),
(68, 19, 'Letter', 0),
(69, 19, 'A4', 0),
(70, 19, 'F4 (Folio)', 0),
(71, 19, 'A3', 0),
(72, 19, 'B5', 0),
(73, 19, 'A5', 0);

-- --------------------------------------------------------

--
-- Table structure for table `jilid`
--

CREATE TABLE `jilid` (
  `id` int(11) NOT NULL,
  `agen_id` int(11) NOT NULL,
  `item` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jilid`
--

INSERT INTO `jilid` (`id`, `agen_id`, `item`, `harga`) VALUES
(1, 14, 'Jilid Biasa', 2000),
(3, 19, 'jilid biasa', 1000);

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `saldo` double NOT NULL,
  `saldo_digunakan` double DEFAULT NULL,
  `topup` double NOT NULL,
  `payment_id` varchar(255) DEFAULT NULL,
  `payment_token` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `status` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id`, `user_id`, `saldo`, `saldo_digunakan`, `topup`, `payment_id`, `payment_token`, `created_at`, `status`) VALUES
(1, 5, 18000, 2000, 100000, '18571054900003', 'f160dfbb-b79a-4845-b97e-2cb391126d85', '2022-03-10 15:32:49', 'renew'),
(2, 3, 54350, 185650, 0, NULL, NULL, NULL, 'active'),
(3, 10, 20000, 0, 100000, '18571054900003', 'f160dfbb-b79a-4845-b97e-2cb391126d85', '2022-03-10 15:32:49', 'renew'),
(4, 11, 100000, 0, 100000, '18571054900003', 'f160dfbb-b79a-4845-b97e-2cb391126d85', '2022-03-10 15:32:49', 'renew');

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id` int(11) NOT NULL,
  `send_by` varchar(10) NOT NULL,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  `type` varchar(15) NOT NULL,
  `content` text NOT NULL,
  `status` varchar(10) NOT NULL,
  `waktu` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifikasi`
--

INSERT INTO `notifikasi` (`id`, `send_by`, `from_id`, `to_id`, `type`, `content`, `status`, `waktu`) VALUES
(36, 'user', 5, 11, 'order_cancel', 'Rahmat Ilyas telah membatalkan pesanan, pesanan tidak dapat diproses', 'read', '2021-10-19 22:32:38'),
(37, 'user', 3, 8, 'virtual_pay', 'Sri Asriani telah melakukan pesanan dengan metode pembayaran virtual', 'new', '2021-10-19 22:01:40'),
(38, 'user', 3, 14, 'live_pay', 'Sri Asriani telah melakukan pesanan, silahkan diproses', 'read', '2021-10-19 22:06:22'),
(39, 'user', 3, 14, 'virtual_pay', 'Sri Asriani telah melakukan pesanan dengan metode pembayaran virtual', 'read', '2021-10-19 22:23:54'),
(40, 'user', 3, 14, 'confirm_pay', 'Sri Asriani telah mengkonfirmasi pembayaran, silahkan diproses', 'read', '2021-10-19 22:32:57'),
(41, 'agen', 14, 3, 'order_start', 'Kamisama Print telah memproses pesanan anda', 'read', '2021-10-19 22:35:32'),
(42, 'agen', 14, 3, 'order_done', 'Kamisama Print telah menyelesaikan pesanan anda, silahkan diambil dan dikonfirmasi', 'read', '2021-10-19 22:45:57'),
(43, 'user', 3, 14, 'order_finish', 'Sri Asriani telah menkonfirmasi pesanan', 'read', '2021-10-19 22:46:48'),
(44, 'agen', 14, 3, 'order_start', 'Kamisama Print telah memproses pesanan anda', 'read', '2021-10-19 22:47:11'),
(45, 'agen', 14, 3, 'order_done', 'Kamisama Print telah menyelesaikan pesanan anda, silahkan diambil dan dikonfirmasi', 'read', '2021-10-19 22:51:51'),
(46, 'user', 3, 9, 'virtual_pay', 'Asri Ardian telah melakukan pesanan dengan metode pembayaran virtual', 'read', '2021-10-26 13:48:07'),
(47, 'user', 3, 9, 'virtual_pay', 'Asri Ardian telah melakukan pesanan dengan metode pembayaran virtual', 'read', '2021-10-26 14:07:48'),
(48, 'user', 3, 9, 'confirm_pay', 'Asri Ardian telah mengkonfirmasi pembayaran, silahkan diproses', 'read', '2021-10-26 14:10:13'),
(49, 'agen', 9, 3, 'order_start', 'Fotocopy ISTIANAH telah memproses pesanan anda', 'read', '2021-10-26 14:16:40'),
(50, 'agen', 9, 3, 'order_done', 'Fotocopy ISTIANAH telah menyelesaikan pesanan anda, silahkan dikonfirmasi', 'read', '2021-10-26 14:18:32'),
(51, 'user', 3, 9, 'order_finish', 'Asri Ardian telah menkonfirmasi pesanan', 'new', '2021-10-26 14:19:07'),
(52, 'agen', 11, 5, 'order_start', 'ABC Print telah memproses pesanan anda', 'new', '2021-10-26 14:38:56'),
(53, 'agen', 11, 5, 'order_done', 'ABC Print telah menyelesaikan pesanan anda, silahkan dikonfirmasi', 'new', '2021-10-26 14:39:03'),
(54, 'user', 3, 11, 'live_pay', 'Alidia Syahrani telah melakukan pesanan, silahkan diproses', 'read', '2021-10-26 14:44:22'),
(55, 'agen', 11, 3, 'order_start', 'Toko Andini telah memproses pesanan anda', 'read', '2021-10-26 15:22:19'),
(56, 'agen', 11, 3, 'order_done', 'Toko Andini telah menyelesaikan pesanan anda, silahkan dikonfirmasi', 'read', '2021-10-26 15:31:16'),
(57, 'user', 3, 11, 'order_finish', 'Alidia Syahrani telah menkonfirmasi pesanan', 'read', '2021-10-26 15:40:39'),
(58, 'user', 3, 8, 'live_pay', 'Alidia Syahrani telah melakukan pesanan, silahkan diproses', 'read', '2021-10-26 16:58:43'),
(59, 'user', 3, 9, 'virtual_pay', 'Alidia Syahrani telah melakukan pesanan dengan metode pembayaran virtual', 'new', '2021-10-26 17:04:38'),
(60, 'user', 3, 14, 'order_finish', 'Alidia Syahrani telah menkonfirmasi pesanan', 'read', '2021-10-26 22:38:34'),
(61, 'user', 3, 14, 'live_pay', 'Alidia Syahrani telah melakukan pesanan, silahkan diproses', 'read', '2021-10-26 22:57:14'),
(62, 'agen', 14, 3, 'order_start', 'Kamisama Print telah memproses pesanan anda', 'read', '2021-10-26 23:00:45'),
(63, 'agen', 14, 3, 'order_done', 'Kamisama Print telah menyelesaikan pesanan anda, silahkan dikonfirmasi', 'read', '2021-10-26 23:01:06'),
(64, 'user', 3, 14, 'order_finish', 'Alidia Syahrani telah menkonfirmasi pesanan', 'read', '2021-10-26 23:01:45'),
(65, 'user', 8, 18, 'virtual_pay', 'sulaiman telah melakukan pesanan dengan metode pembayaran virtual', 'read', '2021-11-09 23:44:09'),
(66, 'user', 8, 18, 'confirm_pay', 'sulaiman telah mengkonfirmasi pembayaran, silahkan diproses', 'read', '2021-11-09 23:50:30'),
(67, 'agen', 18, 8, 'order_start', 'Jasriah Maspul (JM) telah memproses pesanan anda', 'read', '2021-11-09 23:50:56'),
(68, 'agen', 18, 8, 'order_done', 'Jasriah Maspul (JM) telah menyelesaikan pesanan anda, silahkan dikonfirmasi', 'read', '2021-11-09 23:51:14'),
(69, 'user', 8, 18, 'order_finish', 'sulaiman telah menkonfirmasi pesanan', 'read', '2021-11-09 23:52:36'),
(70, 'user', 5, 8, 'live_pay', 'Rahmat Ilyas telah melakukan pesanan, silahkan diproses', 'new', '2021-11-10 21:18:27'),
(71, 'user', 3, 8, 'order_cancel', 'Alidia Syahrani telah membatalkan pesanan, pesanan tidak dapat diproses', 'new', '2021-11-17 00:09:57'),
(72, 'user', 3, 8, 'live_pay', 'Alidia Syahrani telah melakukan pesanan, silahkan diproses', 'new', '2021-11-17 00:12:33'),
(73, 'user', 3, 8, 'order_cancel', 'Alidia Syahrani telah membatalkan pesanan, pesanan tidak dapat diproses', 'new', '2021-11-17 00:12:40'),
(74, 'user', 3, 14, 'live_pay', 'Alidia Syahrani telah melakukan pesanan, silahkan diproses', 'read', '2021-11-17 08:27:36'),
(75, 'agen', 14, 3, 'order_start', 'FOTO COPY IAS telah memproses pesanan anda', 'read', '2021-11-17 08:30:31'),
(76, 'agen', 14, 3, 'order_refuse', 'toko akan di tutup', 'read', '2021-11-17 08:31:33'),
(77, 'user', 11, 8, 'virtual_pay', 'Wirna Sentia Rahayu telah melakukan pesanan dengan metode pembayaran virtual', 'new', '2021-11-17 23:10:20'),
(78, 'user', 11, 8, 'confirm_pay', 'Wirna Sentia Rahayu telah mengkonfirmasi pembayaran, silahkan diproses', 'new', '2021-11-17 23:11:59'),
(79, 'user', 11, 8, 'confirm_pay', 'Wirna Sentia Rahayu telah mengkonfirmasi pembayaran, silahkan diproses', 'new', '2021-11-17 23:11:59'),
(80, 'user', 12, 14, 'virtual_pay', 'anita telah melakukan pesanan dengan metode pembayaran virtual', 'read', '2021-11-18 12:00:52'),
(81, 'user', 12, 14, 'confirm_pay', 'anita telah mengkonfirmasi pembayaran, silahkan diproses', 'read', '2021-11-18 12:01:42'),
(82, 'user', 3, 14, 'live_pay', 'Alidia Syahrani telah melakukan pesanan, silahkan diproses', 'read', '2021-11-18 12:04:15'),
(83, 'agen', 14, 3, 'order_start', 'FOTO COPY IAS telah memproses pesanan anda', 'read', '2021-11-18 12:04:59'),
(84, 'agen', 14, 3, 'order_done', 'FOTO COPY IAS telah menyelesaikan pesanan anda, silahkan dikonfirmasi', 'read', '2021-11-18 12:05:05'),
(85, 'agen', 14, 12, 'order_start', 'FOTO COPY IAS telah memproses pesanan anda', 'new', '2021-11-18 12:05:13'),
(86, 'agen', 14, 12, 'order_done', 'FOTO COPY IAS telah menyelesaikan pesanan anda, silahkan dikonfirmasi', 'new', '2021-11-18 12:05:19'),
(87, 'user', 12, 14, 'order_finish', 'anita telah menkonfirmasi pesanan', 'read', '2021-11-18 12:05:51'),
(88, 'user', 3, 14, 'order_finish', 'Alidia Syahrani telah menkonfirmasi pesanan', 'read', '2021-11-18 12:06:03'),
(89, 'user', 3, 18, 'virtual_pay', 'Alidia Syahrani telah melakukan pesanan dengan metode pembayaran virtual', 'new', '2021-12-03 13:55:17'),
(90, 'user', 3, 18, 'confirm_pay', 'Alidia Syahrani telah mengkonfirmasi pembayaran, silahkan diproses', 'new', '2021-12-03 13:56:10'),
(91, 'user', 3, 18, 'order_cancel', 'Alidia Syahrani telah membatalkan pesanan, pesanan tidak dapat diproses', 'new', '2021-12-17 15:00:11'),
(92, 'user', 5, 14, 'message', 'tes', 'read', '2022-01-12 23:46:45'),
(93, 'agen', 14, 5, 'message', 'p', 'read', '2022-01-12 23:50:28'),
(94, 'user', 5, 14, 'message', 'apa?', 'read', '2022-01-12 23:51:03'),
(95, 'user', 5, 14, 'message', 'oii', 'read', '2022-01-12 23:52:03'),
(96, 'user', 5, 14, 'message', 'p', 'read', '2022-01-12 23:53:53'),
(97, 'agen', 14, 5, 'message', 'kenapai?', 'read', '2022-01-12 23:54:22'),
(98, 'user', 5, 14, 'message', 'p', 'read', '2022-01-12 23:55:00'),
(99, 'agen', 14, 5, 'message', 'yuhu', 'read', '2022-01-12 23:55:11'),
(100, 'user', 5, 14, 'message', 'siapa mau?', 'read', '2022-01-12 23:55:23'),
(101, 'agen', 14, 5, 'message', 'mau apa?', 'read', '2022-01-12 23:55:37'),
(102, 'user', 5, 14, 'message', 'oi', 'read', '2022-01-12 23:56:20'),
(103, 'agen', 14, 5, 'message', 'lama', 'read', '2022-01-12 23:56:27'),
(104, 'user', 5, 14, 'message', 'kau lama', 'read', '2022-01-12 23:56:58'),
(105, 'agen', 14, 5, 'message', 'cepat na ji saya', 'read', '2022-01-12 23:57:08'),
(106, 'agen', 14, 5, 'message', 'itu', 'read', '2022-01-12 23:57:40'),
(107, 'agen', 14, 5, 'message', 'lama mentong', 'read', '2022-01-12 23:58:31'),
(108, 'agen', 14, 5, 'message', 'lama nuu', 'read', '2022-01-12 23:59:15'),
(109, 'agen', 14, 5, 'message', 'apaji', 'read', '2022-01-13 00:00:01'),
(110, 'user', 5, 14, 'message', 'ok, saya lama', 'read', '2022-01-13 00:00:25'),
(111, 'agen', 14, 5, 'message', 'tohh', 'read', '2022-01-13 00:00:49'),
(112, 'user', 5, 14, 'message', 'sory, ada bug', 'read', '2022-01-13 00:01:13'),
(113, 'agen', 14, 5, 'message', 'apana bug?', 'read', '2022-01-13 00:01:23'),
(114, 'user', 5, 14, 'message', 'tes lagi nah', 'read', '2022-01-13 00:03:01'),
(115, 'user', 5, 14, 'message', 'lama nu', 'read', '2022-01-13 00:04:43'),
(116, 'agen', 14, 5, 'message', 'sory, jaringan', 'read', '2022-01-13 00:06:19'),
(117, 'user', 5, 14, 'message', 'barumi masuk lagi', 'read', '2022-01-13 00:06:55'),
(118, 'user', 5, 14, 'message', 'masi bug', 'read', '2022-01-13 00:07:02'),
(119, 'agen', 14, 5, 'message', 'jaringan kyknya, saya juga delay', 'read', '2022-01-13 00:07:49'),
(120, 'user', 5, 14, 'message', 'iyo kyknya', 'read', '2022-01-13 00:08:16'),
(121, 'user', 5, 14, 'message', 'ato browserku mmng', 'read', '2022-01-13 00:08:51'),
(122, 'agen', 14, 5, 'message', 'masuk ji saya', 'read', '2022-01-13 00:09:03'),
(123, 'agen', 14, 5, 'message', 'ku tes lagi nah', 'read', '2022-01-13 00:10:32'),
(124, 'user', 5, 14, 'message', 'ndak realtime ki', 'read', '2022-01-13 00:12:05'),
(125, 'agen', 14, 5, 'message', 'saya baa', 'read', '2022-01-13 00:12:19'),
(126, 'agen', 14, 5, 'message', 'lagi pale', 'read', '2022-01-13 00:14:09'),
(127, 'agen', 14, 5, 'message', 'lagi', 'read', '2022-01-13 00:14:43'),
(128, 'user', 5, 14, 'message', 'aii.. ndak masuk i', 'read', '2022-01-13 00:15:00'),
(129, 'agen', 14, 5, 'message', 'masuk saya', 'read', '2022-01-13 00:15:17'),
(130, 'user', 5, 14, 'message', 'cobaka ganti browser', 'read', '2022-01-13 00:16:30'),
(131, 'agen', 14, 5, 'message', 'ku tes lagi pale', 'read', '2022-01-13 00:16:45'),
(132, 'agen', 14, 5, 'message', 'lagi', 'read', '2022-01-13 00:17:25'),
(133, 'agen', 14, 5, 'message', '?', 'read', '2022-01-13 00:17:50'),
(134, 'agen', 14, 5, 'message', 'masuk mi?', 'read', '2022-01-13 00:18:05'),
(135, 'user', 5, 14, 'message', 'oke masuk mi', 'read', '2022-01-13 00:18:22'),
(136, 'agen', 14, 5, 'message', 'oke aman mi pale', 'read', '2022-01-13 00:18:32'),
(137, 'user', 5, 14, 'message', 'tapi delay ki', 'read', '2022-01-13 00:18:53'),
(138, 'user', 5, 14, 'message', 'mungkin gara2 jaringan', 'read', '2022-01-13 00:19:00'),
(139, 'agen', 14, 5, 'message', 'kyknya', 'read', '2022-01-13 00:19:07'),
(140, 'agen', 14, 5, 'message', 'blmpi masuk?', 'read', '2022-01-13 00:19:41'),
(141, 'agen', 14, 5, 'message', 'salah sasaran i kyknya', 'read', '2022-01-13 00:20:18'),
(142, 'agen', 14, 5, 'message', '??', 'read', '2022-01-13 00:21:06'),
(143, 'user', 5, 14, 'message', 'delay sekali', 'read', '2022-01-13 00:21:18'),
(144, 'user', 5, 14, 'message', 'ok', 'read', '2022-01-13 00:26:18'),
(145, 'agen', 14, 5, 'message', 'tes', 'read', '2022-01-13 00:26:57'),
(146, 'user', 5, 14, 'message', 'masuk', 'read', '2022-01-13 00:27:06'),
(147, 'agen', 14, 5, 'message', 'nice', 'read', '2022-01-13 00:27:19'),
(148, 'user', 5, 14, 'message', 'mana?', 'read', '2022-01-13 00:27:37'),
(149, 'agen', 14, 5, 'message', 'ndak adai lagi?', 'read', '2022-01-13 00:27:48'),
(150, 'agen', 14, 5, 'message', 'awwe', 'read', '2022-01-13 00:28:13'),
(151, 'agen', 14, 5, 'message', 'tes', 'read', '2022-01-13 00:34:22'),
(152, 'user', 5, 14, 'message', 'apa?', 'read', '2022-01-13 00:35:04'),
(153, 'user', 5, 14, 'message', 'lagi?', 'read', '2022-01-13 00:36:04'),
(154, 'agen', 14, 5, 'message', 'haa?', 'read', '2022-01-13 00:36:37'),
(155, 'user', 5, 14, 'message', 'tess', 'read', '2022-01-13 00:37:09'),
(156, 'agen', 14, 5, 'message', 're', 'read', '2022-01-13 00:37:18'),
(157, 'user', 5, 14, 'message', 'as', 'read', '2022-01-13 00:38:22'),
(158, 'user', 5, 14, 'message', 'as', 'read', '2022-01-13 00:38:40'),
(159, 'user', 5, 14, 'message', 'sd', 'read', '2022-01-13 00:38:43'),
(160, 'agen', 14, 5, 'message', 'vdvd', 'read', '2022-01-13 00:39:12'),
(161, 'user', 5, 14, 'message', 'sasas', 'read', '2022-01-13 00:39:20'),
(162, 'user', 5, 14, 'message', 'uiui', 'read', '2022-01-13 00:40:04'),
(163, 'user', 5, 14, 'message', 'tes', 'read', '2022-01-13 00:41:12'),
(164, 'user', 5, 14, 'message', 'tess', 'read', '2022-01-13 00:41:47'),
(165, 'agen', 14, 5, 'message', 'yuu', 'read', '2022-01-13 00:43:26'),
(166, 'user', 5, 14, 'message', 'min', 'read', '2022-01-13 00:44:38'),
(167, 'agen', 14, 5, 'message', 'apa', 'read', '2022-01-13 00:44:47'),
(168, 'user', 5, 14, 'message', 'assasas', 'read', '2022-01-13 00:45:17'),
(169, 'agen', 14, 5, 'message', 'asaa', 'read', '2022-01-13 00:45:27'),
(170, 'agen', 14, 5, 'message', 'asas', 'read', '2022-01-13 00:46:11'),
(171, 'user', 5, 14, 'message', 'waa', 'read', '2022-01-13 00:46:22'),
(172, 'user', 5, 14, 'message', 'asasa', 'read', '2022-01-13 00:46:38'),
(173, 'agen', 14, 5, 'message', 'asas', 'read', '2022-01-13 00:46:45'),
(174, 'user', 5, 14, 'message', 'sasas', 'read', '2022-01-13 00:46:49'),
(175, 'agen', 14, 5, 'message', 'aasas', 'read', '2022-01-13 00:46:53'),
(176, 'user', 5, 14, 'message', 'tyyy', 'read', '2022-01-13 00:46:59'),
(177, 'agen', 14, 5, 'message', 'aas', 'read', '2022-01-13 00:47:09'),
(178, 'user', 5, 14, 'message', 'asas', 'read', '2022-01-13 00:47:14'),
(179, 'agen', 14, 5, 'message', 'as', 'read', '2022-01-13 00:47:22'),
(180, 'user', 5, 14, 'message', 'asas', 'read', '2022-01-13 00:47:33'),
(181, 'user', 5, 14, 'message', 'tes', 'read', '2022-01-13 07:30:55'),
(182, 'user', 5, 8, 'message', 'ass', 'read', '2022-01-13 07:32:20'),
(183, 'user', 5, 8, 'message', 'tes', 'read', '2022-01-13 23:33:16'),
(184, 'agen', 14, 5, 'message', 'iya?', 'read', '2022-01-13 23:33:25'),
(185, 'user', 5, 14, 'message', 'kenapa?', 'read', '2022-01-13 23:33:41'),
(186, 'agen', 14, 5, 'message', 'ndak ji', 'read', '2022-01-13 23:33:49'),
(187, 'user', 5, 19, 'message', 'assalamualaikum..', 'read', '2022-01-13 23:34:37'),
(188, 'user', 3, 14, 'live_pay', 'Alidia Syahrani telah melakukan pesanan, silahkan diproses', 'read', '2022-01-18 21:46:13'),
(189, 'agen', 14, 3, 'order_start', 'FOTO COPY IAS telah memproses pesanan anda', 'read', '2022-01-18 21:47:13'),
(190, 'agen', 14, 3, 'order_done', 'FOTO COPY IAS telah menyelesaikan pesanan anda, silahkan dikonfirmasi', 'read', '2022-01-18 21:47:40'),
(191, 'agen', 14, 46, 'message', 'datang meki ambil berkas ta', 'read', '2022-01-18 21:48:37'),
(192, 'agen', 14, 46, 'message', 'aaaaa', 'read', '2022-01-18 21:51:44'),
(193, 'agen', 14, 46, 'message', 'abcd', 'read', '2022-01-18 21:51:48'),
(194, 'agen', 14, 3, 'message', 'tes', 'read', '2022-01-19 20:17:51'),
(195, 'user', 3, 14, 'message', 'aaa', 'read', '2022-01-19 20:18:14'),
(196, 'agen', 14, 3, 'message', 'apa', 'read', '2022-01-19 20:18:21'),
(197, 'agen', 14, 3, 'message', 'https://github.com/Ochiess/Bisa-diPrint/', 'read', '2022-01-19 20:52:00'),
(198, 'user', 14, 14, 'virtual_pay', 'cobs telah melakukan pesanan dengan metode pembayaran virtual', 'read', '2022-02-03 21:19:29'),
(199, 'user', 14, 14, 'confirm_pay', 'cobs telah mengkonfirmasi pembayaran, silahkan diproses', 'read', '2022-02-03 21:20:29'),
(200, 'user', 3, 14, 'live_pay', 'Alidia Syahrani telah melakukan pesanan, silahkan diproses', 'read', '2022-02-03 21:24:47'),
(201, 'agen', 14, 3, 'order_start', 'FOTO COPY IAS telah memproses pesanan anda', 'read', '2022-02-03 21:26:27'),
(202, 'agen', 14, 3, 'order_done', 'FOTO COPY IAS telah menyelesaikan pesanan anda, silahkan dikonfirmasi', 'read', '2022-02-03 21:26:55'),
(203, 'agen', 14, 14, 'order_start', 'FOTO COPY IAS telah memproses pesanan anda', 'read', '2022-02-03 21:27:17'),
(204, 'agen', 14, 14, 'order_done', 'FOTO COPY IAS telah menyelesaikan pesanan anda, silahkan dikonfirmasi', 'read', '2022-02-03 21:27:34'),
(205, 'agen', 14, 3, 'message', 'datang mki ambil barangta', 'read', '2022-02-03 21:27:58'),
(206, 'user', 3, 14, 'order_finish', 'Alidia Syahrani telah menkonfirmasi pesanan', 'read', '2022-02-03 21:28:19'),
(207, 'user', 3, 14, 'order_finish', 'Alidia Syahrani telah menkonfirmasi pesanan', 'read', '2022-02-03 21:28:22'),
(208, 'user', 14, 14, 'order_finish', 'cobs telah menkonfirmasi pesanan', 'read', '2022-02-03 21:35:12'),
(209, 'user', 14, 14, 'live_pay', 'cobs telah melakukan pesanan, silahkan diproses', 'read', '2022-02-03 21:38:58'),
(210, 'user', 3, 14, 'live_pay', 'Alidia Syahrani telah melakukan pesanan, silahkan diproses', 'read', '2022-02-03 21:40:36'),
(211, 'user', 3, 14, 'order_cancel', 'Alidia Syahrani telah membatalkan pesanan, pesanan tidak dapat diproses', 'read', '2022-02-03 21:41:43'),
(212, 'agen', 14, 14, 'order_start', 'FOTO COPY IAS telah memproses pesanan anda', 'read', '2022-02-03 21:42:02'),
(213, 'user', 14, 14, 'order_cancel', 'cobs telah membatalkan pesanan, pesanan tidak dapat diproses', 'read', '2022-02-03 21:42:15'),
(214, 'user', 14, 14, 'live_pay', 'cobs telah melakukan pesanan, silahkan diproses', 'read', '2022-02-04 05:57:05'),
(215, 'user', 3, 14, 'live_pay', 'Alidia Syahrani telah melakukan pesanan, silahkan diproses', 'read', '2022-02-04 05:59:16'),
(216, 'agen', 14, 3, 'order_start', 'FOTO COPY IAS telah memproses pesanan anda', 'read', '2022-02-04 05:59:55'),
(217, 'agen', 14, 3, 'order_done', 'FOTO COPY IAS telah menyelesaikan pesanan anda, silahkan dikonfirmasi', 'read', '2022-02-04 06:00:01'),
(218, 'user', 3, 14, 'live_pay', 'Alidia Syahrani telah melakukan pesanan, silahkan diproses', 'read', '2022-02-04 06:01:12'),
(219, 'agen', 14, 3, 'order_start', 'FOTO COPY IAS telah memproses pesanan anda', 'read', '2022-02-04 06:01:45'),
(220, 'agen', 14, 3, 'order_done', 'FOTO COPY IAS telah menyelesaikan pesanan anda, silahkan dikonfirmasi', 'read', '2022-02-04 06:01:50'),
(221, 'agen', 14, 14, 'order_start', 'FOTO COPY IAS telah memproses pesanan anda', 'read', '2022-02-04 06:01:57'),
(222, 'agen', 14, 14, 'order_done', 'FOTO COPY IAS telah menyelesaikan pesanan anda, silahkan dikonfirmasi', 'read', '2022-02-04 06:02:07'),
(223, 'user', 3, 14, 'order_finish', 'Alidia Syahrani telah menkonfirmasi pesanan', 'read', '2022-02-04 06:02:16'),
(224, 'user', 3, 14, 'order_finish', 'Alidia Syahrani telah menkonfirmasi pesanan', 'read', '2022-02-04 06:02:22'),
(225, 'agen', 14, 14, 'message', 'silahkan jemput berkasnya', 'read', '2022-02-04 06:03:32'),
(226, 'user', 14, 14, 'order_finish', 'cobs telah menkonfirmasi pesanan', 'read', '2022-02-04 06:04:18'),
(227, 'user', 3, 14, 'live_pay', 'Alidia Syahrani telah melakukan pesanan, silahkan diproses', 'read', '2022-02-04 07:39:12'),
(228, 'agen', 14, 3, 'order_start', 'FOTO COPY IAS telah memproses pesanan anda', 'read', '2022-02-04 07:40:14'),
(229, 'agen', 14, 3, 'order_start', 'FOTO COPY IAS telah memproses pesanan anda', 'read', '2022-02-04 07:40:14'),
(230, 'agen', 14, 3, 'order_start', 'FOTO COPY IAS telah memproses pesanan anda', 'read', '2022-02-04 07:40:14'),
(231, 'agen', 14, 3, 'order_start', 'FOTO COPY IAS telah memproses pesanan anda', 'read', '2022-02-04 07:40:14'),
(232, 'agen', 14, 3, 'order_start', 'FOTO COPY IAS telah memproses pesanan anda', 'read', '2022-02-04 07:40:14'),
(233, 'agen', 14, 3, 'order_done', 'FOTO COPY IAS telah menyelesaikan pesanan anda, silahkan dikonfirmasi', 'read', '2022-02-04 07:40:45'),
(234, 'user', 3, 14, 'order_finish', 'Alidia Syahrani telah menkonfirmasi pesanan', 'read', '2022-02-04 07:41:18'),
(235, 'user', 3, 14, 'message', 'tes', 'read', '2022-02-04 08:11:10'),
(236, 'agen', 14, 3, 'message', 'p', 'read', '2022-02-04 08:19:38'),
(237, 'user', 3, 14, 'message', 'tes', 'read', '2022-02-04 08:19:59'),
(238, 'agen', 14, 3, 'message', 'p', 'read', '2022-02-04 08:20:14'),
(239, 'user', 3, 14, 'message', 'p', 'read', '2022-02-04 08:20:28'),
(240, 'agen', 14, 3, 'message', 'on', 'read', '2022-02-04 08:20:44'),
(241, 'user', 13, 14, 'virtual_pay', 'Example User telah melakukan pesanan dengan metode pembayaran virtual', 'new', '2022-02-04 13:28:13'),
(242, 'user', 13, 14, 'confirm_pay', 'Example User telah mengkonfirmasi pembayaran, silahkan diproses', 'new', '2022-02-04 13:29:16'),
(243, 'user', 3, 14, 'live_pay', 'Alidia Syahrani telah melakukan pesanan, silahkan diproses', 'new', '2022-02-04 13:31:07'),
(244, 'agen', 14, 3, 'order_start', 'FOTO COPY IAS telah memproses pesanan anda', 'new', '2022-02-04 13:32:01'),
(245, 'agen', 14, 3, 'order_done', 'FOTO COPY IAS telah menyelesaikan pesanan anda, silahkan dikonfirmasi', 'new', '2022-02-04 13:32:06'),
(246, 'agen', 14, 3, 'message', 'tes', 'read', '2022-02-04 13:32:43'),
(247, 'user', 3, 14, 'message', 'halo juga', 'read', '2022-02-04 13:32:58'),
(248, 'user', 5, 11, 'order_finish', 'Rahmat Ilyas telah menkonfirmasi pesanan', 'new', '2022-03-01 22:09:53'),
(249, 'user', 3, 8, 'live_pay', 'Alidia Syahrani telah melakukan pesanan, silahkan diproses', 'new', '2022-03-02 08:17:17'),
(250, 'user', 3, 8, 'live_pay', 'Alidia Syahrani telah melakukan pesanan, silahkan diproses', 'new', '2022-03-02 08:19:25'),
(251, 'user', 3, 14, 'live_pay', 'Alidia Syahrani telah melakukan pesanan, silahkan diproses', 'new', '2022-03-02 08:22:33'),
(252, 'agen', 14, 3, 'order_start', 'FOTO COPY IAS telah memproses pesanan anda', 'new', '2022-03-02 08:24:37'),
(253, 'agen', 14, 3, 'order_done', 'FOTO COPY IAS telah menyelesaikan pesanan anda, silahkan dikonfirmasi', 'new', '2022-03-02 08:24:44'),
(254, 'user', 13, 14, 'virtual_pay', 'Example User telah melakukan pesanan dengan metode pembayaran virtual', 'new', '2022-03-08 06:54:02'),
(255, 'user', 13, 14, 'confirm_pay', 'Example User telah mengkonfirmasi pembayaran, silahkan diproses', 'new', '2022-03-08 06:55:05'),
(256, 'agen', 14, 13, 'order_start', 'FOTO COPY IAS telah memproses pesanan anda', 'new', '2022-03-09 18:15:29'),
(257, 'user', 3, 14, 'live_pay', 'Alidia Syahrani telah melakukan pesanan, silahkan diproses', 'new', '2022-03-10 14:45:17'),
(258, 'user', 13, 14, 'virtual_pay', 'Example User telah melakukan pesanan dengan metode pembayaran virtual', 'new', '2022-03-10 14:47:25'),
(259, 'agen', 14, 13, 'order_done', 'FOTO COPY IAS telah menyelesaikan pesanan anda, silahkan dikonfirmasi', 'new', '2022-03-10 14:50:05'),
(260, 'user', 13, 14, 'confirm_pay', 'Example User telah mengkonfirmasi pembayaran, silahkan diproses', 'new', '2022-03-10 14:50:27'),
(261, 'user', 13, 14, 'virtual_pay', 'Example User telah melakukan pesanan dengan metode pembayaran virtual', 'read', '2022-03-11 12:17:30'),
(262, 'user', 13, 14, 'confirm_pay', 'Example User telah mengkonfirmasi pembayaran, silahkan diproses', 'read', '2022-03-11 12:18:50'),
(263, 'user', 3, 14, 'live_pay', 'Alidia Syahrani telah melakukan pesanan, silahkan diproses', 'read', '2022-03-11 12:20:36'),
(264, 'agen', 14, 3, 'order_start', 'FOTO COPY IAS telah memproses pesanan anda', 'new', '2022-03-23 21:17:02'),
(265, 'agen', 14, 3, 'order_done', 'FOTO COPY IAS telah menyelesaikan pesanan anda, silahkan dikonfirmasi', 'new', '2022-03-23 21:17:07'),
(266, 'agen', 14, 3, 'order_start', 'FOTO COPY IAS telah memproses pesanan anda', 'new', '2022-03-23 21:17:12'),
(267, 'agen', 14, 3, 'order_done', 'FOTO COPY IAS telah menyelesaikan pesanan anda, silahkan dikonfirmasi', 'new', '2022-03-23 21:17:15'),
(268, 'agen', 14, 13, 'order_start', 'FOTO COPY IAS telah memproses pesanan anda', 'new', '2022-03-23 21:17:22'),
(269, 'agen', 14, 13, 'order_done', 'FOTO COPY IAS telah menyelesaikan pesanan anda, silahkan dikonfirmasi', 'new', '2022-03-23 21:17:26'),
(270, 'agen', 14, 13, 'order_start', 'FOTO COPY IAS telah memproses pesanan anda', 'new', '2022-03-23 21:17:31'),
(271, 'agen', 14, 13, 'order_done', 'FOTO COPY IAS telah menyelesaikan pesanan anda, silahkan dikonfirmasi', 'new', '2022-03-23 21:17:35'),
(272, 'agen', 14, 13, 'order_start', 'FOTO COPY IAS telah memproses pesanan anda', 'new', '2022-03-23 21:17:39'),
(273, 'agen', 14, 13, 'order_done', 'FOTO COPY IAS telah menyelesaikan pesanan anda, silahkan dikonfirmasi', 'new', '2022-03-23 21:18:01'),
(274, 'user', 13, 14, 'order_finish', 'Example User telah menkonfirmasi pesanan', 'new', '2022-03-23 21:19:06'),
(275, 'user', 13, 14, 'order_finish', 'Example User telah menkonfirmasi pesanan', 'new', '2022-03-23 21:19:11'),
(276, 'user', 13, 14, 'order_finish', 'Example User telah menkonfirmasi pesanan', 'new', '2022-03-23 21:21:05'),
(277, 'user', 13, 14, 'order_finish', 'Example User telah menkonfirmasi pesanan', 'new', '2022-03-23 21:21:10'),
(278, 'user', 13, 14, 'virtual_pay', 'Example User telah melakukan pesanan dengan metode pembayaran virtual', 'new', '2022-03-23 21:26:30'),
(279, 'user', 13, 14, 'confirm_pay', 'Example User telah mengkonfirmasi pembayaran, silahkan diproses', 'new', '2022-03-23 21:27:31'),
(280, 'user', 3, 14, 'live_pay', 'Alidia Syahrani telah melakukan pesanan, silahkan diproses', 'new', '2022-03-23 21:30:47'),
(281, 'user', 13, 14, 'virtual_pay', 'Example User telah melakukan pesanan dengan metode pembayaran virtual', 'new', '2022-03-23 21:35:00'),
(282, 'user', 13, 14, 'confirm_pay', 'Example User telah mengkonfirmasi pembayaran, silahkan diproses', 'new', '2022-03-23 21:35:45');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `agen_id` int(11) NOT NULL,
  `rating` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`id`, `user_id`, `agen_id`, `rating`) VALUES
(1, 5, 8, 5),
(2, 5, 25, 5),
(3, 5, 22, 5),
(4, 5, 9, 5),
(5, 5, 20, 5),
(6, 5, 11, 5),
(7, 5, 14, 5),
(8, 5, 12, 5),
(9, 5, 15, 5),
(10, 5, 17, 5),
(11, 5, 18, 5),
(12, 13, 18, 5),
(13, 13, 8, 5),
(14, 13, 17, 3);

-- --------------------------------------------------------

--
-- Table structure for table `setting_agen`
--

CREATE TABLE `setting_agen` (
  `id` int(11) NOT NULL,
  `agen_id` int(11) NOT NULL,
  `pembayaran_langsung` tinyint(1) NOT NULL,
  `pembayaran_virtual` tinyint(1) NOT NULL,
  `rekening` varchar(50) DEFAULT NULL,
  `no_rekening` varchar(100) DEFAULT NULL,
  `cetak_dokumen` tinyint(1) NOT NULL,
  `cetak_foto` tinyint(1) NOT NULL,
  `jilid` tinyint(1) NOT NULL,
  `latar` tinyint(1) NOT NULL,
  `delivery` int(11) NOT NULL DEFAULT 0,
  `ket_delivery` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `setting_agen`
--

INSERT INTO `setting_agen` (`id`, `agen_id`, `pembayaran_langsung`, `pembayaran_virtual`, `rekening`, `no_rekening`, `cetak_dokumen`, `cetak_foto`, `jilid`, `latar`, `delivery`, `ket_delivery`) VALUES
(1, 8, 1, 0, NULL, NULL, 1, 1, 1, 0, 0, NULL),
(2, 9, 1, 1, NULL, NULL, 1, 1, 1, 0, 0, NULL),
(3, 10, 1, 1, NULL, NULL, 1, 1, 1, 0, 0, NULL),
(4, 11, 1, 1, NULL, NULL, 1, 1, 1, 0, 0, NULL),
(5, 14, 1, 1, 'Dana', '085333341194', 1, 1, 1, 0, 1, '< 2km|- Rp.3000|+> 5km|- Rp.7000|+> 10km|- Rp.12000|+'),
(6, 15, 1, 1, NULL, NULL, 1, 1, 1, 0, 0, NULL),
(7, 16, 1, 1, 'OVO', '085242657354', 1, 1, 0, 0, 0, NULL),
(8, 17, 1, 1, NULL, NULL, 1, 1, 0, 0, 0, NULL),
(9, 18, 1, 1, NULL, NULL, 1, 1, 0, 0, 0, NULL),
(10, 19, 1, 1, 'Bank BRI', '9968756645455535', 1, 1, 1, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `super_admin`
--

CREATE TABLE `super_admin` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `super_admin`
--

INSERT INTO `super_admin` (`id`, `nama`, `username`, `password`) VALUES
(1, 'Administrator', 'admin', '$2y$10$X3lDTGpvLzeBxI7tjsb18e8s7j3RYwnyP7r8jzbJWLUhTavYv5FVW');

-- --------------------------------------------------------

--
-- Table structure for table `ukuran_foto`
--

CREATE TABLE `ukuran_foto` (
  `id` int(11) NOT NULL,
  `agen_id` int(11) NOT NULL,
  `ukuran` varchar(50) NOT NULL,
  `harga` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ukuran_foto`
--

INSERT INTO `ukuran_foto` (`id`, `agen_id`, `ukuran`, `harga`) VALUES
(1, 14, 'Ukuran 2x3', 1000),
(2, 14, 'Ukuran 3x4', 2000),
(3, 16, 'Ukuran 2x3', 0),
(4, 16, 'Ukuran 3x4', 0),
(5, 16, 'Ukuran 4x6', 0),
(6, 17, 'Ukuran 2x3', 0),
(7, 17, 'Ukuran 3x4', 0),
(8, 17, 'Ukuran 4x6', 0),
(9, 18, 'Ukuran 2x3', 0),
(10, 18, 'Ukuran 3x4', 0),
(11, 18, 'Ukuran 4x6', 0),
(12, 19, 'Ukuran 2x3', 0),
(13, 19, 'Ukuran 3x4', 0),
(14, 19, 'Ukuran 4x6', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `nama_akun` varchar(100) NOT NULL,
  `hp` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `photo`, `nama_lengkap`, `nama_akun`, `hp`, `email`, `password`) VALUES
(1, '', 'Sri Asriani', 'uci', '082159024785', 'sriasriani135@gmail.com', '$2y$10$3gvNRPJNal.W4C.mbIDtmuNyyG1tryzMuO3kcMiarXgjN1T4DYCES'),
(2, '', 'suprianto', 'sup', '123123123456', 'test@gmail.com', '$2y$10$Qr0jmgWPqnYnfh3Y5nIpxOGFhd0eWnQqcLXmnbV7DKwPQ7AWjqsl.'),
(3, '61e8efe48dccc.jpg', 'Alidia Syahrani', 'Acha', '082159024798', 'uci@gmail.com', '$2y$10$kUtE7RSXx3.t8Jkbm9ufa.Cv2noHTzc4dG9qq70hnTdcP.gC84CMy'),
(4, '', 'Sri Asriani', 'uci', '082159024785', 'sriasriani1354@gmail.com', '$2y$10$a9pTmUw8gc54lz1P7Y0Yp.1gxSmFpzqPsFa2xzSVyYtzaZO33AfD.'),
(5, '61488f418a94c.jpg', 'Rahmat Ilyas', 'rahmat_ryu', '085333341194', 'rahmat.ilyas142@gmail.com', '$2y$10$X8kJ2nf6.PRSkJOyyZa.Z.5VVWWgqPJ806HqdMJfeVOVlxBdeB2MS'),
(6, '', 'Nur Israwati ', 'nurisrawati', '081243322095', 'nurisrawati017@gmail.com', '$2y$10$p5svhMyRsn6YcsT2SSHhw./2kIRYQn/eRn0I13b8NPa3eKwOaIHbS'),
(7, '', 'baharuddin', 'bah', '098889998', 'baharuddin@gmail.com', '$2y$10$fLhUP2mMpD1b0Tgdo/bmluRhmk7Q6feevJVAjL.hPx/1zXuXvkqEK'),
(8, '', 'sulaiman', 'zul', '082159044777', 'sulaiman@gmail.com', '$2y$10$CX023gHZ84JXLjPN7O1DWu6q3E67N/yUy3qqT9tVytUxX23H7mPSy'),
(9, '', 'Andi Abdillah', 'andi', '081543438723', 'andiabdillah004@gmail.com', '$2y$10$N6Lw5yuj9UrBpjxeKL800.T0jFOiqucIoeOXJ5qtVfNt2ejdmLDIm'),
(10, '', 'Miftahul Khair', 'mifta', '085333341194', 'mifta@gmail.com', '$2y$10$D8D9wNdEetWPDev.5KHxmOzrsxNkir.Rinr4f0xVK8H5a6hSd3Nnu'),
(11, '', 'Wirna Sentia Rahayu', 'wirna', '085366451234', 'wirna@gmail.com', '$2y$10$whW.Zbxi5ZkYzp4tggLLWOgwd80DQWWJixGAis4WfIky7sdNsA2k6'),
(12, '', 'anita', 'anita', '085242883982', 'anita@gmail.com', '$2y$10$oTSqISx.n69IwuU7cK/iMO2SOPbDSe/L5foFCuqO9jwvC9ZrtHfx6'),
(13, '', 'Example User', 'example', '085333341194', 'user.ex@test.com', '$2y$10$xwEvOVnP97D8VBZciiElx.90Zg55w79BVK1ygMorgZsJavjELoYxa'),
(14, '', 'cobs', 'aja', '1234567890', 'cobaaja@test.com', '$2y$10$qaebe1w3kNtDCVBuLGa3JeY/8Jf/lwO0xHwpTRaN6rTVo1VWpI4yW'),
(15, '', 'Daru', 'diana', '7588060015', 'coralie46@wirethings.net', '$2y$10$9o8SnpsdFpKfZNj.h98jx.BlsgA2Qgh0lhXaPq8hM6sWBYIdoywVS'),
(16, '', 'Jane', 'farhunnisa', '5312018708', 'ebony.greenfelder@tooolz.com', '$2y$10$HA1PjFisKYPc9BIonkniIe32mkJwJadx3yXnxfdGmxOcTa8.kSxFi'),
(17, '', 'Dian', 'jaka', '9896595358', 'yuni.susanti@theaccessuk.org', '$2y$10$JRuHJqqJnbevDaisqWW0QOCgJ6u3fzvre7KmYgPYa72Xnfy9x3qIS'),
(18, '', 'Ibrahim', 'puti', '2048137835', 'eva.oktaviani61@tooolz.com', '$2y$10$O8XG0.l4iIcFn6hxxklmbeKXkNpk4vt6q3DvJHC3e06lkwrBmcbm.'),
(19, '', 'Tedi', 'anastasia', '2048137835', 'puji_mayasari@tooolz.com', '$2y$10$Ne0bn66LaqE0rf7xCGls3.R4cVzEC88RydQqcDlFkUEJEsLw45EFu'),
(20, '', 'Ade', 'cemani', '9896595358', 'wirda26@theaccessuk.org', '$2y$10$106RsY1ob3p9tcp/IdjEW.EurL5rMbN5/eFukdkdaxhYf71cnPpoG'),
(21, '', 'Kambali', 'zaenab', '2048137835', 'luwar69@tooolz.com', '$2y$10$p/5tK5SYI1GldRd2MGhtHeiivfvya2KwzCb4YwuYIxzRAnLJex2Y2'),
(22, '', 'Violet', 'nabila', '9896595358', 'baktiono_handayani9@theaccessuk.org', '$2y$10$b92v52pPWkjg82qJ2oM5EeGs8hkjjJUwuFJPZQduHbjvtYnytV5qO'),
(23, '', 'Adiarja', 'muhammad', '9896595358', 'dinda_hutapea55@twinbash.co', '$2y$10$Nr9ns6XogZ4nmfnh.LpRfeKnltpih7wh5sOOmNtXcvMVyh6zWPbRu');

-- --------------------------------------------------------

--
-- Table structure for table `virtual_payment`
--

CREATE TABLE `virtual_payment` (
  `id` int(11) NOT NULL,
  `agen_id` int(11) NOT NULL,
  `jumlah_saldo` double NOT NULL,
  `saldo_akun` double NOT NULL,
  `saldo_diambil` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `virtual_payment`
--

INSERT INTO `virtual_payment` (`id`, `agen_id`, `jumlah_saldo`, `saldo_akun`, `saldo_diambil`) VALUES
(1, 14, 332150, 0, 102000),
(2, 9, 2500, 0, 0),
(3, 18, 600, 0, 0),
(4, 19, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `warna_tulisan`
--

CREATE TABLE `warna_tulisan` (
  `id` int(11) NOT NULL,
  `agen_id` int(11) NOT NULL,
  `hitam_putih` int(11) NOT NULL,
  `berwarna` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `warna_tulisan`
--

INSERT INTO `warna_tulisan` (`id`, `agen_id`, `hitam_putih`, `berwarna`) VALUES
(1, 9, 250, 500),
(2, 8, 250, 500),
(3, 10, 100, 200),
(4, 11, 100, 200),
(5, 14, 200, 300),
(6, 15, 100, 200),
(7, 16, 150, 200),
(8, 17, 100, 200),
(9, 18, 100, 200),
(10, 19, 100, 200);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agen`
--
ALTER TABLE `agen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cetak`
--
ALTER TABLE `cetak`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cetak_dokumen`
--
ALTER TABLE `cetak_dokumen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cetak_foto`
--
ALTER TABLE `cetak_foto`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis_kertas`
--
ALTER TABLE `jenis_kertas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jilid`
--
ALTER TABLE `jilid`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_agen`
--
ALTER TABLE `setting_agen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `super_admin`
--
ALTER TABLE `super_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ukuran_foto`
--
ALTER TABLE `ukuran_foto`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `virtual_payment`
--
ALTER TABLE `virtual_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warna_tulisan`
--
ALTER TABLE `warna_tulisan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agen`
--
ALTER TABLE `agen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `cetak`
--
ALTER TABLE `cetak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `cetak_dokumen`
--
ALTER TABLE `cetak_dokumen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `cetak_foto`
--
ALTER TABLE `cetak_foto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `jenis_kertas`
--
ALTER TABLE `jenis_kertas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `jilid`
--
ALTER TABLE `jilid`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=283;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `setting_agen`
--
ALTER TABLE `setting_agen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `super_admin`
--
ALTER TABLE `super_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ukuran_foto`
--
ALTER TABLE `ukuran_foto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `virtual_payment`
--
ALTER TABLE `virtual_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `warna_tulisan`
--
ALTER TABLE `warna_tulisan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
