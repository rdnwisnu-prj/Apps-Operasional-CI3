ALTER TABLE `tab_entertain`
    ADD COLUMN IF NOT EXISTS `approval_status` VARCHAR(20) NOT NULL DEFAULT 'pending',
    ADD COLUMN IF NOT EXISTS `approved_by` INT(11) NULL,
    ADD COLUMN IF NOT EXISTS `approved_at` DATETIME NULL;

ALTER TABLE `tab_makan`
    ADD COLUMN IF NOT EXISTS `approval_status` VARCHAR(20) NOT NULL DEFAULT 'pending',
    ADD COLUMN IF NOT EXISTS `approved_by` INT(11) NULL,
    ADD COLUMN IF NOT EXISTS `approved_at` DATETIME NULL;

ALTER TABLE `tab_fee_dokter`
    ADD COLUMN IF NOT EXISTS `approval_status` VARCHAR(20) NOT NULL DEFAULT 'pending',
    ADD COLUMN IF NOT EXISTS `approved_by` INT(11) NULL,
    ADD COLUMN IF NOT EXISTS `approved_at` DATETIME NULL;

ALTER TABLE `tab_fee_freelance`
    ADD COLUMN IF NOT EXISTS `approval_status` VARCHAR(20) NOT NULL DEFAULT 'pending',
    ADD COLUMN IF NOT EXISTS `approved_by` INT(11) NULL,
    ADD COLUMN IF NOT EXISTS `approved_at` DATETIME NULL;

ALTER TABLE `tab_transport`
    ADD COLUMN IF NOT EXISTS `approval_status` VARCHAR(20) NOT NULL DEFAULT 'pending',
    ADD COLUMN IF NOT EXISTS `approved_by` INT(11) NULL,
    ADD COLUMN IF NOT EXISTS `approved_at` DATETIME NULL;

ALTER TABLE `tab_penginapan`
    ADD COLUMN IF NOT EXISTS `approval_status` VARCHAR(20) NOT NULL DEFAULT 'pending',
    ADD COLUMN IF NOT EXISTS `approved_by` INT(11) NULL,
    ADD COLUMN IF NOT EXISTS `approved_at` DATETIME NULL;

ALTER TABLE `tab_other`
    ADD COLUMN IF NOT EXISTS `approval_status` VARCHAR(20) NOT NULL DEFAULT 'pending',
    ADD COLUMN IF NOT EXISTS `approved_by` INT(11) NULL,
    ADD COLUMN IF NOT EXISTS `approved_at` DATETIME NULL;
