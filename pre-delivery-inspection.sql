-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2025 at 05:16 PM
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
-- Database: `pre-delivery-inspection`
--

-- --------------------------------------------------------

--
-- Table structure for table `master_produk`
--

CREATE TABLE `master_produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `kode_produk` varchar(100) NOT NULL,
  `url_gambar_produk` varchar(100) NOT NULL,
  `deskripsi_produk` varchar(300) NOT NULL,
  `harga_produk` int(11) NOT NULL,
  `harga_asli` int(11) NOT NULL,
  `harga_diskon` int(11) NOT NULL,
  `stok_produk` int(11) NOT NULL,
  `minimum_stok_produk` int(11) NOT NULL,
  `kategori_produk` varchar(100) NOT NULL,
  `brand_produk` varchar(100) NOT NULL,
  `tag_produk` int(11) NOT NULL,
  `dimensi_produk` varchar(100) NOT NULL,
  `berat_produk` varchar(100) NOT NULL,
  `warna_produk` varchar(100) NOT NULL,
  `is_active` int(11) NOT NULL,
  `created_by` varchar(10) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `master_produk`
--

INSERT INTO `master_produk` (`id_produk`, `nama_produk`, `kode_produk`, `url_gambar_produk`, `deskripsi_produk`, `harga_produk`, `harga_asli`, `harga_diskon`, `stok_produk`, `minimum_stok_produk`, `kategori_produk`, `brand_produk`, `tag_produk`, `dimensi_produk`, `berat_produk`, `warna_produk`, `is_active`, `created_by`, `created_at`) VALUES
(7, 'Excavator Kelas Menengah', 'EXC-MID-001', 'produk_1746543277.jpeg', 'Excavator hidrolik kelas menengah untuk berbagai pekerjaan penggalian dan pemindahan material.', 1500000000, 1650000000, 1450000000, 0, 1, 'Alat Berat Konstruksi', 'HeavyMach', 15, '9.5 x 2.8 x 3.1 m', '20 Ton', 'Kuning', 1, 'SYSTEM', '2025-05-06 21:50:23'),
(8, 'Bulldozer Standar', 'BUL-STD-002', 'produk_1746543289.jpeg', 'Bulldozer dengan blade depan untuk meratakan tanah dan mendorong material di lokasi konstruksi.', 1200000000, 1300000000, 1150000000, 0, 1, 'Alat Berat Konstruksi', 'TrackMaster', 16, '7.8 x 3.5 x 3.2 m', '18 Ton', 'Oranye', 1, 'SYSTEM', '2025-05-06 21:50:23'),
(9, 'Crane Tower Jangkauan Tinggi', 'CRN-TWR-003', 'produk_1746543302.jpg', 'Crane menara dengan jangkauan vertikal dan horizontal yang luas untuk mengangkat material di proyek bertingkat.', 2147483647, 2147483647, 2147483647, 0, 1, 'Alat Berat Konstruksi', 'LiftUp', 17, 'Jangkauan: 70 m', '35 Ton (Total)', 'Merah', 1, 'SYSTEM', '2025-05-06 21:50:23'),
(10, 'Wheel Loader Kapasitas Besar', 'WHL-LRG-004', 'produk_1746543318.jpeg', 'Wheel loader dengan bucket besar untuk memuat dan memindahkan material dalam volume besar.', 1800000000, 1950000000, 1700000000, 0, 1, 'Alat Berat Konstruksi', 'LoadMaster', 18, '8.2 x 3.0 x 3.5 m', '25 Ton', 'Kuning', 1, 'SYSTEM', '2025-05-06 21:51:09'),
(11, 'Dump Truck 10 Roda', 'DMP-TRK-005', 'produk_1746543332.jpeg', 'Truk jungkit dengan 10 roda untuk mengangkut material konstruksi jarak jauh.', 1350000000, 1500000000, 1300000000, 0, 1, 'Kendaraan Konstruksi', 'HaulMax', 19, '10.5 x 2.5 x 3.8 m', '15 Ton (Kapasitas)', 'Putih', 1, 'SYSTEM', '2025-05-06 21:51:09'),
(12, 'Concrete Mixer Truck 7m³', 'CONC-MXR-006', 'produk_1746543343.jpeg', 'Truk pengaduk beton dengan kapasitas 7 meter kubik untuk mengantarkan beton siap pakai.', 1600000000, 1750000000, 1550000000, 0, 1, 'Kendaraan Konstruksi', 'MixWell', 20, '9.0 x 2.5 x 3.6 m', '12 Ton (Kosong)', 'Biru', 1, 'SYSTEM', '2025-05-06 21:51:09'),
(13, 'Road Roller Single Drum', 'ROD-ROL-007', 'produk_1746543356.jpeg', 'Mesin penggilas jalan dengan satu drum untuk memadatkan tanah dan aspal.', 950000000, 1050000000, 900000000, 0, 1, 'Alat Berat Konstruksi', 'CompacTech', 21, '6.0 x 2.2 x 2.8 m', '8 Ton', 'Hijau', 1, 'SYSTEM', '2025-05-06 21:51:09'),
(14, 'Forklift Heavy Duty 10 Ton', 'FRK-HDY-008', 'produk_1746543368.jpeg', 'Forklift tugas berat dengan kapasitas angkat 10 ton untuk memindahkan material berat di gudang atau area proyek.', 700000000, 780000000, 680000000, 0, 1, 'Alat Material Handling', 'LiftKing', 22, '4.5 x 2.0 x 2.5 m', '15 Ton (Total)', 'Kuning', 1, 'SYSTEM', '2025-05-06 21:51:09');

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `unit_id` int(11) NOT NULL,
  `serial_number` varchar(255) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `status_inspection` varchar(100) NOT NULL,
  `qty` int(11) NOT NULL,
  `kondisi_unit` varchar(100) NOT NULL,
  `tanggal_masuk` datetime NOT NULL,
  `tanggal_keluar` datetime NOT NULL,
  `status_unit` varchar(100) NOT NULL,
  `lokasi_unit` varchar(100) NOT NULL,
  `keterangan_unit` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `image` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `image`, `password`, `role_id`, `is_active`, `date_created`) VALUES
(6, 'user', 'user@user.com', 'default.jpg', '$2y$10$.ybE/KxYJAjHDBaP5nlrKOguRQz7WMvDJEleRoKzCzGYsjY4fyhR.', 2, 1, 1552285263),
(12, 'admin', 'admin@admin.com', 'default.jpg', '$2y$10$VgiXi8BbKDSROpfXM1F9kexQTWKmPsYfJwdpbe0fZQ90gQ64dS.Hi', 1, 1, 1552285263),
(14, 'admin', 'admin@gmail.com', 'default.jpg', '$2y$10$8nYQlOyyVp2cjeBGG8aUUu3Xn9Fukgj4DOfmllVdpP5jD5kn5smwe', 2, 1, 1746493357);

-- --------------------------------------------------------

--
-- Table structure for table `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `role_id`, `menu_id`) VALUES
(1, 1, 1),
(3, 2, 2),
(7, 1, 3),
(8, 1, 2),
(10, 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`) VALUES
(1, 'Admin'),
(2, 'User'),
(3, 'Menu'),
(5, 'Pre  Delivery Inspection');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'Administrator'),
(2, 'Member');

-- --------------------------------------------------------

--
-- Table structure for table `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`) VALUES
(1, 1, 'Dashboard', 'admin', 'fas fa-fw fa-tachometer-alt', 1),
(2, 2, 'My Profile', 'user', 'fas fa-fw fa-user', 1),
(3, 2, 'Edit Profile', 'user/edit', 'fas fa-fw fa-user-edit', 1),
(4, 3, 'Menu Management', 'menu', 'fas fa-fw fa-folder', 1),
(5, 3, 'Submenu Management', 'menu/submenu', 'fas fa-fw fa-folder-open', 1),
(7, 1, 'Role', 'admin/role', 'fas fa-fw fa-user-tie', 1),
(8, 2, 'Change Password', 'user/changepassword', 'fas fa-fw fa-key', 1),
(11, 5, 'Master Produk', 'inspection/master_produk', 'fas fa-fw fa-tools', 1),
(12, 5, 'List Unit', 'inspection/unit', 'fas fa-fw fa-hammer', 1),
(13, 5, 'List Inspection', 'inspection/inspection', 'fas fa-fw fa-cog', 1),
(14, 5, 'Result Inspection', 'inspection/result', 'fas fa-fw fa-ruler-combined', 1),
(15, 5, 'Report Inspection', 'inspection/report', 'fas fa-fw fa-robot', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_token`
--

CREATE TABLE `user_token` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `token` varchar(128) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user_token`
--

INSERT INTO `user_token` (`id`, `email`, `token`, `date_created`) VALUES
(9, 'admin@admin.com', 'asCeAkGcvRZE+AWpezWwhsHzCyxoN2hHtquzuSh89qE=', 1746454108),
(10, 'admin@ymail.com', 'JSGh5Ylwmr9BM2WWFE77uhwFuQk/7jdUVBtG31o/mZ0=', 1746454150);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `master_produk`
--
ALTER TABLE `master_produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`unit_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `master_produk`
--
ALTER TABLE `master_produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `unit_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
