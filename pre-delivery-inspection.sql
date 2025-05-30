-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2025 at 06:23 AM
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
-- Table structure for table `inspection`
--

CREATE TABLE `inspection` (
  `id_inspection` int(11) UNSIGNED NOT NULL,
  `unit_id` int(11) NOT NULL,
  `tanggal_inspeksi` datetime NOT NULL,
  `mechanic` varchar(100) DEFAULT NULL,
  `acknowledge` varchar(100) DEFAULT NULL,
  `additional_comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(100) DEFAULT NULL,
  `inspection_template_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inspection_detail`
--

CREATE TABLE `inspection_detail` (
  `id_detail` int(11) UNSIGNED NOT NULL,
  `inspection_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `test_check` varchar(255) DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `add` varchar(100) NOT NULL,
  `clean_up` varchar(100) NOT NULL,
  `lubricate` varchar(100) NOT NULL,
  `replace_change` varchar(100) NOT NULL,
  `adjust` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inspection_item`
--

CREATE TABLE `inspection_item` (
  `id_item` int(11) UNSIGNED NOT NULL,
  `id_template` int(11) NOT NULL,
  `nama_group` varchar(255) NOT NULL,
  `nama_item` varchar(255) NOT NULL,
  `urutan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inspection_item`
--

INSERT INTO `inspection_item` (`id_item`, `id_template`, `nama_group`, `nama_item`, `urutan`) VALUES
(311, 1, '1. Engine', 'a. Engine (compression)', 1),
(312, 1, '1. Engine', 'b. Air Cleaner', 2),
(313, 1, '1. Engine', 'c. V-Belt', 3),
(314, 1, '1. Engine', 'd. Lube Oil & Filter', 4),
(315, 1, '1. Engine', 'e. Cooling System', 5),
(316, 1, '1. Engine', 'f. Fuel System & Filter', 6),
(317, 1, '1. Engine', 'g. Valve Clereance', 7),
(318, 1, '1. Engine', 'h. Brake Air Compressor', 8),
(319, 1, '1. Engine', 'i. Tensioner Bearing', 9),
(320, 1, '2. Transmision', 'a. Transmision Oil', 10),
(321, 1, '2. Transmision', 'b. Torque Conventer Op/Pressure', 11),
(322, 1, '2. Transmision', 'c. Transmision Temperature', 12),
(323, 1, '2. Transmision', 'd. Hose Condition', 13),
(324, 1, '2. Transmision', 'e. Final Drive Operation', 14),
(325, 1, '3. Electrical System', 'a. Alternator, St.Motor Condition', 15),
(326, 1, '3. Electrical System', 'b. Batter, Lamp, Switch', 16),
(327, 1, '3. Electrical System', 'c. Panel & Wiring System', 17),
(328, 1, '4. Rear Axle & Front Axle', 'a. Differential Oil Level', 18),
(329, 1, '4. Rear Axle & Front Axle', 'b. Planetary Gear Oil Level', 19),
(330, 1, '4. Rear Axle & Front Axle', 'c. PropelerShaft Condition', 20),
(331, 1, '5. Steering Power', 'a. Steering Obitrol', 21),
(332, 1, '5. Steering Power', 'b. Power Cylinder', 22),
(333, 1, '5. Steering Power', 'c. Hose', 23),
(334, 1, '6. Brake System', 'a. Master & Wheel Cylinder', 24),
(335, 1, '6. Brake System', 'b. Pedal & Lingkage', 25),
(336, 1, '6. Brake System', 'c. Parking Brake', 26),
(337, 1, '7. Hydraulic System', 'a. Control Valve', 27),
(338, 1, '7. Hydraulic System', 'b. Cylinder', 28),
(339, 1, '7. Hydraulic System', 'c. Gear Pump System', 29),
(340, 1, '7. Hydraulic System', 'd. Joy Stick Opration', 30),
(341, 1, '8. Pin', 'a. Pin Bucket', 31),
(342, 1, '8. Pin', 'b. Pin Articulate', 32),
(343, 1, '8. Pin', 'c. Pin Rear Axle', 33),
(344, 1, '9. Tyre', 'a. Ban', 34),
(345, 2, '1. Engine', 'a. Engine (compression)', 1),
(346, 2, '1. Engine', 'b. Air Cleaner', 2),
(347, 2, '1. Engine', 'c. V-Belt', 3),
(348, 2, '1. Engine', 'd. Lube Oil & Filter', 4),
(349, 2, '1. Engine', 'e. Cooling System', 5),
(350, 2, '1. Engine', 'f. Fuel System & Filter', 6),
(351, 2, '1. Engine', 'g. Valve Clereance', 7),
(352, 2, '1. Engine', 'h. Brake Air Compressor', 8),
(353, 2, '1. Engine', 'i. Tensioner Bearing', 9),
(354, 2, '2. Under Carriage', 'a. Track Link', 10),
(355, 2, '2. Under Carriage', 'b. Track Shoe', 11),
(356, 2, '2. Under Carriage', 'c. Traction Motor', 12),
(357, 2, '2. Under Carriage', 'd. Roller', 13),
(358, 2, '2. Under Carriage', 'e. Idler', 14),
(359, 2, '3. Electrical System', 'a. Alternator, St.Motor Condition', 15),
(360, 2, '3. Electrical System', 'b. Batter, Lamp, Switch', 16),
(361, 2, '3. Electrical System', 'c. Panel & Wiring System', 17),
(362, 2, '4. Drilling', 'a. Main Winch', 18),
(363, 2, '4. Drilling', 'b. Auxiliarry Winch', 19),
(364, 2, '4. Drilling', 'c. Boom Movement', 20),
(365, 2, '5. Steering Power', 'a. Rotation', 21),
(366, 2, '5. Steering Power', 'b. Joy Stick Movement', 22),
(367, 2, '5. Steering Power', 'c. Selenoid', 23),
(368, 2, '5. Steering Power', 'd. Sensor', 24),
(369, 2, '6. Hydraulic System', 'a. Control Valve', 25),
(370, 2, '6. Hydraulic System', 'b. Cylinder', 26),
(371, 2, '6. Hydraulic System', 'c. Gear Pump System', 27),
(372, 2, '6. Hydraulic System', 'd. Joy Stick Opration', 28),
(373, 2, '7. Pin', 'a. Pin Boom', 29),
(374, 2, '7. Pin', 'b. Pin Arm', 30),
(375, 2, '7. Pin', 'c. Pin Swing', 31),
(376, 3, '1. Engine', 'a. Engine (compression)', 1),
(377, 3, '1. Engine', 'b. Air Cleaner', 2),
(378, 3, '1. Engine', 'c. V-Belt', 3),
(379, 3, '1. Engine', 'd. Lube Oil & Filter', 4),
(380, 3, '1. Engine', 'e. Cooling System', 5),
(381, 3, '1. Engine', 'f. Fuel System & Filter', 6),
(382, 3, '1. Engine', 'g. Valve Clereance', 7),
(383, 3, '1. Engine', 'h. Brake Air Compressor', 8),
(384, 3, '1. Engine', 'i. Tensioner Bearing', 9),
(385, 3, '2. Transmision', 'a. Transmision Oil', 10),
(386, 3, '2. Transmision', 'b. Clutch', 11),
(387, 3, '2. Transmision', 'c. Transmision Temperature', 12),
(388, 3, '2. Transmision', 'd. Hose Condition', 13),
(389, 3, '3. Electrical System', 'a. Alternator, St.Motor Condition', 14),
(390, 3, '3. Electrical System', 'b. Batter, Lamp, Switch', 15),
(391, 3, '3. Electrical System', 'c. Panel & Wiring System', 16),
(392, 3, '4. Rear Axle', 'a. Differential Oil Level', 17),
(393, 3, '4. Rear Axle', 'b. PropelerShaft Condition', 18),
(394, 3, '5. Steering power', 'a. Power Cylinder', 19),
(395, 3, '5. Steering power', 'b. Hose', 20),
(396, 3, '6. Brake System', 'a. Master & Wheel Cylinder', 21),
(397, 3, '6. Brake System', 'b. Pedal & Lingkage', 22),
(398, 3, '6. Brake System', 'c. Parking Brake', 23),
(399, 3, '7. Hydraulic System', 'a. Control Valve', 24),
(400, 3, '7. Hydraulic System', 'b. Cylinder', 25),
(401, 3, '7. Hydraulic System', 'c. Gear Pump System', 26),
(402, 3, '7. Hydraulic System', 'd. Vibro System', 27),
(403, 3, '8. Tyre', 'a. Drum & Tyre', 28),
(404, 4, '1. Engine', 'a. Engine (compression)', 1),
(405, 4, '1. Engine', 'b. Air Cleaner', 2),
(406, 4, '1. Engine', 'c. V-Belt', 3),
(407, 4, '1. Engine', 'd. Lube Oil & Filter', 4),
(408, 4, '1. Engine', 'e. Cooling System', 5),
(409, 4, '1. Engine', 'f. Fuel System & Filter', 6),
(410, 4, '1. Engine', 'g. Valve Clereance', 7),
(411, 4, '1. Engine', 'h. Brake Air Compressor', 8),
(412, 4, '1. Engine', 'i. Tensioner Bearing', 9),
(413, 4, '2. Under Carriage', 'a. Track Link', 10),
(414, 4, '2. Under Carriage', 'b. Track Shoe', 11),
(415, 4, '2. Under Carriage', 'c. Traction Motor', 12),
(416, 4, '2. Under Carriage', 'd. Roller', 13),
(417, 4, '2. Under Carriage', 'e. Idler', 14),
(418, 4, '3. Electrical System', 'a. Alternator, St.Motor Condition', 15),
(419, 4, '3. Electrical System', 'b. Batter, Lamp, Switch', 16),
(420, 4, '3. Electrical System', 'c. Panel & Wiring System', 17),
(421, 4, '4. Steering Power', 'a. Rotation', 18),
(422, 4, '4. Steering Power', 'b. Joy Stick Movement', 19),
(423, 4, '4. Steering Power', 'c. Selenoid', 20),
(424, 4, '4. Steering Power', 'd. Sensor', 21),
(425, 4, '5. Hydraulic System', 'a. Control Valve', 22),
(426, 4, '5. Hydraulic System', 'b. Cylinder', 23),
(427, 4, '5. Hydraulic System', 'c. Gear Pump System', 24),
(428, 4, '5. Hydraulic System', 'd. Joy Stick Opration', 25),
(429, 4, '6. Pin', 'a. Pin Boom', 26),
(430, 4, '6. Pin', 'b. Pin Arm', 27),
(431, 4, '6. Pin', 'c. Pin Bucket', 28),
(432, 5, '1. Battery', 'a. Battery', 1),
(433, 5, '1. Battery', 'b. Battery Fluid', 2),
(434, 5, '1. Battery', 'c. Plug', 3),
(435, 5, '1. Battery', 'd. Wiring Cables', 4),
(436, 5, '1. Battery', 'e. Charging', 5),
(437, 5, '1. Battery', 'f. Battery Connector', 6),
(438, 5, '1. Battery', 'g. Charging Indicator', 7),
(439, 5, '1. Battery', 'h. Back Buzzer Alarm', 8),
(440, 5, '1. Battery', 'i. Rotary Lamp', 9),
(441, 5, '2. Drive', 'a. Travel Motor', 10),
(442, 5, '2. Drive', 'b. Acceletator', 11),
(443, 5, '2. Drive', 'c. Steering Wheel', 12),
(444, 5, '2. Drive', 'd. Brake', 13),
(445, 5, '2. Drive', 'e. Steering Motor', 14),
(446, 5, '3. Accessories', 'a. Display Monitor', 15),
(447, 5, '3. Accessories', 'b. Head Lamp', 16),
(448, 5, '3. Accessories', 'c. Turn Signal Lamp', 17),
(449, 5, '4. Rear Axle & Front Axle', 'a. Differential Oil Level', 18),
(450, 5, '4. Rear Axle & Front Axle', 'b. Steering Cylinder', 19),
(451, 5, '4. Rear Axle & Front Axle', 'c. Head Guard', 20),
(452, 5, '5. Steering Power', 'a. Steering Obitrol', 21),
(453, 5, '5. Steering Power', 'b. Power Cylinder', 22),
(454, 5, '5. Steering Power', 'c. Hose', 23),
(455, 5, '6. Brake System', 'a. Master & Wheel Cylinder', 24),
(456, 5, '6. Brake System', 'b. Pedal & Lingkage', 25),
(457, 5, '6. Brake System', 'c. Parking Brake', 26),
(458, 5, '7. Hydraulic System', 'a. Control Valve', 27),
(459, 5, '7. Hydraulic System', 'b. Cylinder', 28),
(460, 5, '7. Hydraulic System', 'c. Hydraulic Motor', 29),
(461, 5, '7. Hydraulic System', 'd. Hydraulic Oil', 30),
(462, 5, '8. Mast', 'a. Hose', 31),
(463, 5, '8. Mast', 'b. Bearing', 32),
(464, 5, '8. Mast', 'c. Carriagge / Backrest', 33),
(465, 5, '9. Tyre', 'a. Front / Rear', 34);

-- --------------------------------------------------------

--
-- Table structure for table `inspection_template`
--

CREATE TABLE `inspection_template` (
  `id_template` int(11) UNSIGNED NOT NULL,
  `nama_template` varchar(255) NOT NULL,
  `deskripsi_template` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inspection_template`
--

INSERT INTO `inspection_template` (`id_template`, `nama_template`, `deskripsi_template`, `created_at`, `created_by`) VALUES
(1, 'PDI', 'Pre Delivery Inspection', '2025-05-07 14:01:03', NULL),
(2, 'PDI KHUSUS KR', 'Pre Delivery Inspection Khusus KR', '2025-05-07 14:01:03', NULL),
(3, 'PDI VIBRO', 'Pre Delivery Inspection Vibro', '2025-05-07 14:01:03', NULL),
(4, 'PDI KHUSUS EXCA', 'Pre Delivery Inspection Khusus EXCA', '2025-05-07 14:01:03', NULL),
(5, 'PDI FORKLIFT ELECTRICT', 'Pre Delivery Inspection Forklift Electrict', '2025-05-07 14:01:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `master_produk`
--

CREATE TABLE `master_produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `kode_produk` varchar(100) NOT NULL,
  `url_gambar_produk` varchar(100) DEFAULT NULL,
  `deskripsi_produk` varchar(300) DEFAULT NULL,
  `harga_produk` int(11) DEFAULT NULL,
  `harga_asli` int(11) DEFAULT NULL,
  `harga_diskon` int(11) DEFAULT NULL,
  `stok_produk` int(11) DEFAULT NULL,
  `minimum_stok_produk` int(11) DEFAULT NULL,
  `kategori_produk` varchar(100) DEFAULT NULL,
  `brand_produk` varchar(100) DEFAULT NULL,
  `tag_produk` int(11) DEFAULT NULL,
  `dimensi_produk` varchar(100) DEFAULT NULL,
  `berat_produk` varchar(100) DEFAULT NULL,
  `warna_produk` varchar(100) DEFAULT NULL,
  `is_active` int(11) DEFAULT NULL,
  `created_by` varchar(10) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `master_produk`
--

INSERT INTO `master_produk` (`id_produk`, `nama_produk`, `kode_produk`, `url_gambar_produk`, `deskripsi_produk`, `harga_produk`, `harga_asli`, `harga_diskon`, `stok_produk`, `minimum_stok_produk`, `kategori_produk`, `brand_produk`, `tag_produk`, `dimensi_produk`, `berat_produk`, `warna_produk`, `is_active`, `created_by`, `created_at`) VALUES
(7, 'Excavator Kelas Menengah', 'EXC-MID-001', 'produk_1746543277.jpeg', 'testExcavator hidrolik kelas menengah untuk berbagai pekerjaan penggalian dan pemindahan material.', 1500000000, 1650000000, 1450000000, 1, 1, 'Alat Berat Konstruksi', 'HeavyMach', 15, '9.5 x 2.8 x 3.1 m', '20 Ton', 'Kuning', 1, 'SYSTEM', '2025-05-06 21:50:23'),
(8, 'Bulldozer Standar', 'BUL-STD-002', 'produk_1746543289.jpeg', 'Bulldozer dengan blade depan untuk meratakan tanah dan mendorong material di lokasi konstruksi.', 1200000000, 1300000000, 1150000000, 2, 1, 'Alat Berat Konstruksi', 'TrackMaster', 16, '7.8 x 3.5 x 3.2 m', '18 Ton', 'Oranye', 1, 'SYSTEM', '2025-05-06 21:50:23'),
(9, 'Crane Tower Jangkauan Tinggi', 'CRN-TWR-003', 'produk_1746543302.jpg', 'Crane menara dengan jangkauan vertikal dan horizontal yang luas untuk mengangkat material di proyek bertingkat.', 2147483647, 2147483647, 2147483647, 0, 1, 'Alat Berat Konstruksi', 'LiftUp', 17, 'Jangkauan: 70 m', '35 Ton (Total)', 'Merah', 1, 'SYSTEM', '2025-05-06 21:50:23'),
(10, 'Wheel Loader Kapasitas Besar', 'WHL-LRG-004', 'produk_1746543318.jpeg', 'Wheel loader dengan bucket besar untuk memuat dan memindahkan material dalam volume besar.', 1800000000, 1950000000, 1700000000, 2, 1, 'Alat Berat Konstruksi', 'LoadMaster', 18, '8.2 x 3.0 x 3.5 m', '25 Ton', 'Kuning', 1, 'SYSTEM', '2025-05-06 21:51:09'),
(11, 'Dump Truck 10 Roda', 'DMP-TRK-005', 'produk_1746543332.jpeg', 'Truk jungkit dengan 10 roda untuk mengangkut material konstruksi jarak jauh.', 1350000000, 1500000000, 1300000000, 0, 1, 'Kendaraan Konstruksi', 'HaulMax', 19, '10.5 x 2.5 x 3.8 m', '15 Ton (Kapasitas)', 'Putih', 1, 'SYSTEM', '2025-05-06 21:51:09'),
(12, 'Concrete Mixer Truck 7m³', 'CONC-MXR-006', 'produk_1746543343.jpeg', 'Truk pengaduk beton dengan kapasitas 7 meter kubik untuk mengantarkan beton siap pakai.', 1600000000, 1750000000, 1550000000, 0, 1, 'Kendaraan Konstruksi', 'MixWell', 20, '9.0 x 2.5 x 3.6 m', '12 Ton (Kosong)', 'Biru', 1, 'SYSTEM', '2025-05-06 21:51:09'),
(13, 'Road Roller Single Drum', 'ROD-ROL-007', 'produk_1746543356.jpeg', 'Mesin penggilas jalan dengan satu drum untuk memadatkan tanah dan aspal.', 950000000, 1050000000, 900000000, 1, 1, 'Alat Berat Konstruksi', 'CompacTech', 21, '6.0 x 2.2 x 2.8 m', '8 Ton', 'Hijau', 1, 'SYSTEM', '2025-05-06 21:51:09'),
(14, 'Forklift Heavy Duty 10 Ton', 'FRK-HDY-008', 'produk_1746543368.jpeg', 'Forklift tugas berat dengan kapasitas angkat 10 ton untuk memindahkan material berat di gudang atau area proyek.', 700000000, 780000000, 680000000, 0, 1, 'Alat Material Handling', 'LiftKing', 22, '4.5 x 2.0 x 2.5 m', '15 Ton (Total)', 'Kuning', 1, 'SYSTEM', '2025-05-06 21:51:09');

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `unit_id` int(11) NOT NULL,
  `serial_number` varchar(255) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `status_inspection` varchar(100) DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `kondisi_unit` varchar(100) DEFAULT NULL,
  `tanggal_masuk` datetime NOT NULL,
  `tanggal_keluar` datetime DEFAULT NULL,
  `status_unit` varchar(100) DEFAULT NULL,
  `lokasi_unit` varchar(100) DEFAULT NULL,
  `keterangan_unit` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`unit_id`, `serial_number`, `id_produk`, `status_inspection`, `qty`, `kondisi_unit`, `tanggal_masuk`, `tanggal_keluar`, `status_unit`, `lokasi_unit`, `keterangan_unit`, `created_at`, `created_by`) VALUES
(14, 'test', 7, 'Belum Inspeksi', 1, 'Tidak Berfungsi', '2025-05-09 04:19:00', NULL, 'Baru', 'Gudang', '', '2025-05-08 23:29:13', NULL),
(15, 'testkode', 8, 'Belum Inspeksi', 1, 'Berfungsi', '2025-05-09 04:29:00', NULL, 'Baru', 'Gudang', '', '2025-05-08 23:29:48', NULL),
(16, 'testada', 10, 'Belum Inspeksi', 1, 'Berfungsi', '2025-05-09 04:29:00', NULL, 'Baru', 'Gudang', '', '2025-05-08 23:30:08', NULL),
(17, '6001', 8, 'Belum Inspeksi', 1, 'Tidak Berfungsi', '2025-05-09 00:40:00', NULL, 'Perbaikan', 'Customer', 'Ut illum quis aperi', '2025-05-09 00:19:26', NULL),
(19, '6', 10, 'Belum Inspeksi', 1, 'Berfungsi', '2025-05-09 18:50:00', NULL, 'Baru', 'Vendor', 'Et qui non doloremqu', '2025-05-09 00:26:03', NULL),
(20, '955', 13, 'Belum Inspeksi', 1, 'Berfungsi', '2025-05-09 20:58:00', NULL, 'Baru', 'Gudang', 'Quo accusantium quas', '2025-05-09 07:51:00', NULL);

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
(12, 5, 'List Unit', 'inspection/index_unit', 'fas fa-fw fa-hammer', 1),
(13, 5, 'List Inspection', 'inspection/index_list_inspection', 'fas fa-fw fa-cog', 1),
(14, 5, 'Result Inspection', 'inspection/result', 'fas fa-fw fa-ruler-combined', 1),
(15, 5, 'Report Inspection', 'inspection/report', 'fas fa-fw fa-robot', 1),
(16, 5, 'Form Inspection', 'inspection/index_form', 'fas fa-fw fa-file-alt', 1);

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
-- Indexes for table `inspection`
--
ALTER TABLE `inspection`
  ADD PRIMARY KEY (`id_inspection`);

--
-- Indexes for table `inspection_detail`
--
ALTER TABLE `inspection_detail`
  ADD PRIMARY KEY (`id_detail`);

--
-- Indexes for table `inspection_item`
--
ALTER TABLE `inspection_item`
  ADD PRIMARY KEY (`id_item`);

--
-- Indexes for table `inspection_template`
--
ALTER TABLE `inspection_template`
  ADD PRIMARY KEY (`id_template`),
  ADD UNIQUE KEY `nama_template` (`nama_template`);

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
-- AUTO_INCREMENT for table `inspection`
--
ALTER TABLE `inspection`
  MODIFY `id_inspection` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `inspection_detail`
--
ALTER TABLE `inspection_detail`
  MODIFY `id_detail` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `inspection_item`
--
ALTER TABLE `inspection_item`
  MODIFY `id_item` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=466;

--
-- AUTO_INCREMENT for table `inspection_template`
--
ALTER TABLE `inspection_template`
  MODIFY `id_template` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `master_produk`
--
ALTER TABLE `master_produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `unit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
