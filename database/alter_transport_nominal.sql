ALTER TABLE `tab_transport`
  ADD COLUMN IF NOT EXISTS `nominal` DOUBLE NOT NULL DEFAULT 0 AFTER `tgl_transport`;
