-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 13, 2021 at 04:32 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `diprint`
--

-- --------------------------------------------------------

--
-- Table structure for table `agen`
--

CREATE TABLE `agen` (
  `id` int(11) NOT NULL,
  `nama_percetakan` varchar(100) NOT NULL,
  `telpon` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `password` varchar(500) NOT NULL,
  `poto` varchar(100) NOT NULL,
  `keterangan` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `agen`
--

INSERT INTO `agen` (`id`, `nama_percetakan`, `telpon`, `email`, `alamat`, `password`, `poto`, `keterangan`) VALUES
(8, 'Agung Printer', '082231123223', 'testing@gmail.com', 'Depan Pintu 1 Kampus UINAM', '$2y$10$Qil3IeZbZjYR738WK7yLgOIoIwB4HsfWLSKDDqLyFi/LtC8UxYfx6', '6109926329393.png', 'Bisa Diantarkan Juga Bosqy'),
(9, 'Bismillah Print', '082231123', 'bismillah@gmail.com', 'Hertasning', '$2y$10$Jf/hAw2K1HU55UOTPJprSeY9FSIZINYzkIMjVcMzAbaDdS7XNJPNa', '6102468cafc07.jpg', 'Harga Murah Pelayanan Cepat'),
(10, 'Dua Print', '011112223', 'dua@gmail.com', 'Tamangapa Raya', '$2y$10$cz41a5rA8NkO81i61Lq6VeTcpQRZIm2PV2aQDqeS1.Wy8adKItJ.u', '61024787ccef0.jpg', 'Harga Murah Bisa diantar'),
(11, 'ABC Print', '123456789', 'abc@gmail.com', 'samata', '$2y$10$HpJwkbi2CQYpqSjqZ/Sae.TykAm8LeTnvZjrsmb1FSKOU6WxFE3D2', '6109931e007f5.png', 'MURAHHH MERIAHHHH'),
(12, 'apa Print', '089123345567', 'apaprint@email.com', 'samata', '$2y$10$pXHzKYHnVMwdbUVuQk./IOEq3SljoQx9wgEGOQmTwxqvxuiuNe5M6', '6114c0d93f3bb.jpg', 'Murah dan Cepat'),
(13, 'coba print', '098229212', 'coba@gmail.com', 'H.m. syahrul yasin limpo', '$2y$10$LT7hXK3wq9btufBKklkJGuR5LRzyqR.qEn5OKL5FjVOiOVMD2/Ytu', '6138cb7c434d5.jpg', 'Murah muda memuaaskan');

-- --------------------------------------------------------

--
-- Table structure for table `antrian`
--

CREATE TABLE `antrian` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `waktu_pesanan` int(11) NOT NULL,
  `jumlah_halaman` int(11) NOT NULL,
  `waktu_pengambilan` int(11) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cetak`
--

CREATE TABLE `cetak` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_agen` int(11) NOT NULL,
  `jenis_kertas` int(11) NOT NULL,
  `jumlah_rangkap` int(11) NOT NULL,
  `warna` tinyint(1) NOT NULL,
  `jumlah_halaman` int(11) NOT NULL,
  `waktu_pesanan` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `waktu_pengambilan` datetime NOT NULL,
  `catatan` varchar(500) NOT NULL,
  `berkas` varchar(500) NOT NULL,
  `harga` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_agen` int(11) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `harga` float NOT NULL,
  `jenis` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `id_admin`, `harga`, `jenis`) VALUES
(7, 7, 200, 'Hitam-Putih'),
(8, 7, 1000, '+ Sampul'),
(9, 7, 550, 'Cetak foto'),
(10, 7, 400, 'Kertas Berwarna'),
(11, 7, 200, 'Berwarna'),
(12, 10, 250, 'Berwarna'),
(13, 9, 200, 'Berwarna'),
(15, 13, 1500, 'Cetak foto'),
(16, 8, 200, 'Hitam-Putih');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_pesan_agen`
--

CREATE TABLE `riwayat_pesan_agen` (
  `id` int(11) NOT NULL,
  `nama_lengkap` varchar(10) NOT NULL,
  `waktu_pengambilan` int(11) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_pesan_user`
--

CREATE TABLE `riwayat_pesan_user` (
  `id` int(11) NOT NULL,
  `judul` varchar(10) NOT NULL,
  `waktu_pesanan` date NOT NULL,
  `nama_percetakan` varchar(10) NOT NULL,
  `waktu_pengambilan` date NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `super_admin`
--

CREATE TABLE `super_admin` (
  `id` int(11) NOT NULL,
  `nama` varchar(10) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `photo`, `nama_lengkap`, `nama_akun`, `hp`, `email`, `password`) VALUES
(1, '', 'Sri Asriani', 'uci', '082159024785', 'sriasriani135@gmail.com', '$2y$10$3gvNRPJNal.W4C.mbIDtmuNyyG1tryzMuO3kcMiarXgjN1T4DYCES'),
(2, '', 'suprianto', 'sup', '123123123456', 'test@gmail.com', '$2y$10$Qr0jmgWPqnYnfh3Y5nIpxOGFhd0eWnQqcLXmnbV7DKwPQ7AWjqsl.'),
(3, '613db29454d86.png', 'Sri Asriani', 'OCHIES', '085242990992', 'uci@gmail.com', '$2y$10$kUtE7RSXx3.t8Jkbm9ufa.Cv2noHTzc4dG9qq70hnTdcP.gC84CMy'),
(4, '', 'Sri Asriani', 'uci', '082159024785', 'sriasriani1354@gmail.com', '$2y$10$a9pTmUw8gc54lz1P7Y0Yp.1gxSmFpzqPsFa2xzSVyYtzaZO33AfD.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agen`
--
ALTER TABLE `agen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `antrian`
--
ALTER TABLE `antrian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cetak`
--
ALTER TABLE `cetak`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `riwayat_pesan_agen`
--
ALTER TABLE `riwayat_pesan_agen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `riwayat_pesan_user`
--
ALTER TABLE `riwayat_pesan_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `super_admin`
--
ALTER TABLE `super_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agen`
--
ALTER TABLE `agen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `antrian`
--
ALTER TABLE `antrian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cetak`
--
ALTER TABLE `cetak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `riwayat_pesan_agen`
--
ALTER TABLE `riwayat_pesan_agen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `riwayat_pesan_user`
--
ALTER TABLE `riwayat_pesan_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `super_admin`
--
ALTER TABLE `super_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
