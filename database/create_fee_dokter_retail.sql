CREATE TABLE IF NOT EXISTS `tab_fee_dokter_retail` (
  `id_fee` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_project` date NOT NULL,
  `dokter_id` int(11) DEFAULT NULL,
  `nama_dokter` varchar(250) NOT NULL,
  `spesialis` varchar(40) NOT NULL,
  `jumlah_hari` double NOT NULL,
  `fee` double NOT NULL,
  `total` double NOT NULL,
  `jenis_biaya_tambahan` varchar(20) DEFAULT NULL,
  `biaya_tambahan` double DEFAULT 0,
  `cabang` int(11) NOT NULL,
  `ktp` varchar(50) NOT NULL,
  `no_rek` varchar(25) NOT NULL,
  `bank` varchar(50) NOT NULL,
  `kcp` varchar(250) NOT NULL,
  `atas_nama` varchar(250) NOT NULL,
  `pph21` int(11) NOT NULL,
  `no_pph21` int(11) NOT NULL,
  `jumlah_pph` double NOT NULL,
  `jumlah_nopph` double NOT NULL,
  `keterangan` text NOT NULL,
  `lampiran` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id_fee`),
  KEY `idx_fee_dokter_retail_tgl` (`tgl_project`),
  KEY `idx_fee_dokter_retail_dokter` (`dokter_id`),
  KEY `idx_fee_dokter_retail_cabang` (`cabang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `tab_fee_rekening_retail` (
  `id_rekening` int(11) NOT NULL AUTO_INCREMENT,
  `id_fee` int(11) NOT NULL,
  `bank` varchar(50) DEFAULT NULL,
  `no_rek` varchar(30) DEFAULT NULL,
  `atas_nama` varchar(255) DEFAULT NULL,
  `kcp` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_rekening`),
  KEY `idx_fee_rekening_retail_fee` (`id_fee`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tab_menu` (`header`, `nama_menu`, `icon_menu`, `url_menu`, `segment_menu`, `order_menu`, `is_dropdown`)
SELECT 'Keuangan', 'Biaya Dokter Retail', 'ti ti-stethoscope', 'FeeDokterRetail', 'FeeDokterRetail', 9, 0
WHERE NOT EXISTS (
  SELECT 1 FROM `tab_menu` WHERE `url_menu` = 'FeeDokterRetail'
);

INSERT INTO `tab_access` (`role_id`, `menu_access`, `submenu_access`, `access`)
SELECT source_access.role_id, retail_menu.id_menu, 0, 1
FROM `tab_access` source_access
JOIN `tab_menu` source_menu ON source_menu.id_menu = source_access.menu_access
JOIN `tab_menu` retail_menu ON retail_menu.url_menu = 'FeeDokterRetail'
WHERE source_menu.url_menu = 'FeeDokter'
  AND source_access.access = 1
  AND NOT EXISTS (
    SELECT 1
    FROM `tab_access` existing_access
    WHERE existing_access.role_id = source_access.role_id
      AND existing_access.menu_access = retail_menu.id_menu
  );
