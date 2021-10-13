-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 13 Okt 2021 pada 12.45
-- Versi server: 8.0.26-0ubuntu0.20.04.2
-- Versi PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
-- Struktur dari tabel `agen`
--

CREATE TABLE `agen` (
  `id` int NOT NULL,
  `nama_percetakan` varchar(100) NOT NULL,
  `nama_pemilik` varchar(255) NOT NULL,
  `telpon` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `password` varchar(500) NOT NULL,
  `poto` varchar(100) NOT NULL,
  `keterangan` varchar(500) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'new'
);

--
-- Dumping data untuk tabel `agen`
--

INSERT INTO `agen` (`id`, `nama_percetakan`, `nama_pemilik`, `telpon`, `email`, `alamat`, `password`, `poto`, `keterangan`, `status`) VALUES
(8, 'Agung Printer', '', '082231123223', 'testing@gmail.com', 'Depan Pintu 1 Kampus UINAM', '$2y$10$Qil3IeZbZjYR738WK7yLgOIoIwB4HsfWLSKDDqLyFi/LtC8UxYfx6', '6109926329393.png', 'Bisa Diantarkan Juga Bosqy', 'active'),
(9, 'Bismillah Print', '', '082231123', 'bismillah@gmail.com', 'Hertasning', '$2y$10$Jf/hAw2K1HU55UOTPJprSeY9FSIZINYzkIMjVcMzAbaDdS7XNJPNa', '6102468cafc07.jpg', 'Harga Murah Pelayanan Cepat', 'active'),
(10, 'Dua Print', '', '011112223', 'dua@gmail.com', 'Tamangapa Raya', '$2y$10$cz41a5rA8NkO81i61Lq6VeTcpQRZIm2PV2aQDqeS1.Wy8adKItJ.u', '61024787ccef0.jpg', 'Harga Murah Bisa diantar', 'active'),
(11, 'ABC Print', '', '123456789', 'abc@gmail.com', 'samata', '$2y$10$HpJwkbi2CQYpqSjqZ/Sae.TykAm8LeTnvZjrsmb1FSKOU6WxFE3D2', '6109931e007f5.png', 'MURAHHH MERIAHHHH', 'active'),
(14, 'Kamisama Print', 'Rahmat Ilyas', '085333341194', 'rahmat.ilyas142@gmail.com', 'BTN. Bina Sarana Recident II, Moncongloe, Kab. Maros', '$2y$10$eM.veDqlt6TequkcO.AoCOUkV6Ck44AAVDOIkkKF4jaRHPqVPSOA.', '61485f7da25e9.png', 'Cepat dan Handal', 'active'),
(15, 'Print All IN', 'Rahayu Besse TS', '085299868548', 'rahayu@gmail.com', 'Jl. Jenral Sudirman, No 12. Makassar', '$2y$10$lO33oDlNqhQvRYtXrruiROvKoF/jzh4z1oBuGUUDN1TH9VHJHaw8K', '614d81e1a5504.jpg', 'Bagus dan bisa diandalkan loh', 'active');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cetak`
--

CREATE TABLE `cetak` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `agen_id` int NOT NULL,
  `jenis_layanan` varchar(50) NOT NULL,
  `file` varchar(255) NOT NULL,
  `catatan` varchar(255) NOT NULL,
  `waktu_pesanan` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `waktu_pengambilan` datetime NOT NULL,
  `harga` varchar(10) NOT NULL,
  `metode_pembayaran` varchar(50) NOT NULL,
  `payment_token` varchar(255) DEFAULT NULL,
  `status` varchar(50) NOT NULL
);

--
-- Dumping data untuk tabel `cetak`
--

INSERT INTO `cetak` (`id`, `user_id`, `agen_id`, `jenis_layanan`, `file`, `catatan`, `waktu_pesanan`, `waktu_pengambilan`, `harga`, `metode_pembayaran`, `payment_token`, `status`) VALUES
(5, 5, 14, 'dokumen', 'dokumen-5-20211012-2254.docx', 'Jilid warna kuning', '2021-10-12 22:54:41', '2021-10-12 22:01:00', '12000', 'virtual', 'a77e3a0e-342b-4fbf-8e6c-717cc9e0bb77', 'panding'),
(6, 5, 15, 'dokumen', 'dokumen-5-20211012-2350.docx', '', '2021-10-12 23:50:34', '2021-10-12 23:09:00', '1400', 'virtual', '556fb5e3-13ef-4fd8-ac68-7546d47c854c', 'panding'),
(8, 5, 15, 'dokumen', 'dokumen-5-20211013-0013.docx', '', '2021-10-13 00:13:52', '2021-10-13 00:19:00', '800', 'virtual', '3da0fb15-f317-4683-b7e8-1f9168318b39', 'panding');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cetak_dokumen`
--

CREATE TABLE `cetak_dokumen` (
  `id` int NOT NULL,
  `cetak_id` int NOT NULL,
  `warna_tulisan` varchar(50) NOT NULL,
  `jenis_kertas` int NOT NULL,
  `jilid` int NOT NULL,
  `jumlah_halaman` int NOT NULL,
  `jumlah_rangkap` int NOT NULL
);

--
-- Dumping data untuk tabel `cetak_dokumen`
--

INSERT INTO `cetak_dokumen` (`id`, `cetak_id`, `warna_tulisan`, `jenis_kertas`, `jilid`, `jumlah_halaman`, `jumlah_rangkap`) VALUES
(1, 5, 'Berwarna', 26, 1, 20, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cetak_foto`
--

CREATE TABLE `cetak_foto` (
  `id` int NOT NULL,
  `cetak_id` int NOT NULL,
  `ukuran_foto` int NOT NULL,
  `ganti_latar` varchar(15) NOT NULL,
  `jumlah_rangkap` int NOT NULL
);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_kertas`
--

CREATE TABLE `jenis_kertas` (
  `id` int NOT NULL,
  `agen_id` int NOT NULL,
  `jenis_kertas` varchar(50) NOT NULL,
  `harga` double NOT NULL
);

--
-- Dumping data untuk tabel `jenis_kertas`
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
(25, 14, 'Letter', 0),
(26, 14, 'A4', 0),
(27, 14, 'F4 (Folio)', 200),
(28, 14, 'A3', 0),
(29, 14, 'B5', 0),
(30, 14, 'A5', 0),
(31, 15, 'Letter', 0),
(32, 15, 'A4', 0),
(33, 15, 'F4 (Folio)', 0),
(34, 15, 'A3', 0),
(35, 15, 'B5', 0),
(36, 15, 'A5', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jilid`
--

CREATE TABLE `jilid` (
  `id` int NOT NULL,
  `agen_id` int NOT NULL,
  `item` varchar(255) NOT NULL,
  `harga` int NOT NULL
);

--
-- Dumping data untuk tabel `jilid`
--

INSERT INTO `jilid` (`id`, `agen_id`, `item`, `harga`) VALUES
(1, 14, 'Jilid Biasa', 2000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `setting_agen`
--

CREATE TABLE `setting_agen` (
  `id` int NOT NULL,
  `agen_id` int NOT NULL,
  `pembayaran_virtual` tinyint(1) NOT NULL,
  `pembayaran_langsung` tinyint(1) NOT NULL,
  `cetak_dokumen` tinyint(1) NOT NULL,
  `cetak_foto` tinyint(1) NOT NULL,
  `jilid` tinyint(1) NOT NULL,
  `latar` tinyint(1) NOT NULL
);

--
-- Dumping data untuk tabel `setting_agen`
--

INSERT INTO `setting_agen` (`id`, `agen_id`, `pembayaran_virtual`, `pembayaran_langsung`, `cetak_dokumen`, `cetak_foto`, `jilid`, `latar`) VALUES
(1, 8, 0, 1, 1, 1, 1, 0),
(2, 9, 1, 1, 1, 1, 1, 0),
(3, 10, 1, 1, 1, 1, 1, 0),
(4, 11, 1, 1, 1, 1, 1, 0),
(5, 14, 0, 1, 1, 1, 1, 1),
(6, 15, 1, 1, 1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `super_admin`
--

CREATE TABLE `super_admin` (
  `id` int NOT NULL,
  `nama` varchar(10) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(10) NOT NULL
);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ukuran_foto`
--

CREATE TABLE `ukuran_foto` (
  `id` int NOT NULL,
  `agen_id` int NOT NULL,
  `ukuran` varchar(50) NOT NULL,
  `harga` double NOT NULL
);

--
-- Dumping data untuk tabel `ukuran_foto`
--

INSERT INTO `ukuran_foto` (`id`, `agen_id`, `ukuran`, `harga`) VALUES
(1, 14, 'Ukuran 2x3', 1000),
(2, 14, 'Ukuran 3x4', 2000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `photo` varchar(100) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `nama_akun` varchar(100) NOT NULL,
  `hp` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(500) NOT NULL
);

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `photo`, `nama_lengkap`, `nama_akun`, `hp`, `email`, `password`) VALUES
(1, '', 'Sri Asriani', 'uci', '082159024785', 'sriasriani135@gmail.com', '$2y$10$3gvNRPJNal.W4C.mbIDtmuNyyG1tryzMuO3kcMiarXgjN1T4DYCES'),
(2, '', 'suprianto', 'sup', '123123123456', 'test@gmail.com', '$2y$10$Qr0jmgWPqnYnfh3Y5nIpxOGFhd0eWnQqcLXmnbV7DKwPQ7AWjqsl.'),
(3, '613db29454d86.png', 'Sri Asriani', 'OCHIES', '085242990992', 'uci@gmail.com', '$2y$10$kUtE7RSXx3.t8Jkbm9ufa.Cv2noHTzc4dG9qq70hnTdcP.gC84CMy'),
(4, '', 'Sri Asriani', 'uci', '082159024785', 'sriasriani1354@gmail.com', '$2y$10$a9pTmUw8gc54lz1P7Y0Yp.1gxSmFpzqPsFa2xzSVyYtzaZO33AfD.'),
(5, '61488f418a94c.jpg', 'Rahmat Ilyas', 'rahmat_ryu', '085333341194', 'rahmat.ilyas142@gmail.com', '$2y$10$X8kJ2nf6.PRSkJOyyZa.Z.5VVWWgqPJ806HqdMJfeVOVlxBdeB2MS');

-- --------------------------------------------------------

--
-- Struktur dari tabel `warna_tulisan`
--

CREATE TABLE `warna_tulisan` (
  `id` int NOT NULL,
  `agen_id` int NOT NULL,
  `hitam_putih` int NOT NULL,
  `berwarna` int NOT NULL
);

--
-- Dumping data untuk tabel `warna_tulisan`
--

INSERT INTO `warna_tulisan` (`id`, `agen_id`, `hitam_putih`, `berwarna`) VALUES
(1, 9, 100, 200),
(2, 8, 100, 200),
(3, 10, 100, 200),
(4, 11, 100, 200),
(5, 14, 150, 200),
(6, 15, 100, 200);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `agen`
--
ALTER TABLE `agen`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `cetak`
--
ALTER TABLE `cetak`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `cetak_dokumen`
--
ALTER TABLE `cetak_dokumen`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `cetak_foto`
--
ALTER TABLE `cetak_foto`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jenis_kertas`
--
ALTER TABLE `jenis_kertas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jilid`
--
ALTER TABLE `jilid`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `setting_agen`
--
ALTER TABLE `setting_agen`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `super_admin`
--
ALTER TABLE `super_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `ukuran_foto`
--
ALTER TABLE `ukuran_foto`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `warna_tulisan`
--
ALTER TABLE `warna_tulisan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `agen`
--
ALTER TABLE `agen`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `cetak`
--
ALTER TABLE `cetak`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `cetak_dokumen`
--
ALTER TABLE `cetak_dokumen`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `cetak_foto`
--
ALTER TABLE `cetak_foto`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `jenis_kertas`
--
ALTER TABLE `jenis_kertas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT untuk tabel `jilid`
--
ALTER TABLE `jilid`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `setting_agen`
--
ALTER TABLE `setting_agen`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `super_admin`
--
ALTER TABLE `super_admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `ukuran_foto`
--
ALTER TABLE `ukuran_foto`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `warna_tulisan`
--
ALTER TABLE `warna_tulisan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
