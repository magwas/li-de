CREATE TABLE IF NOT EXISTS `#__ampm_condition` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Egyedi kulcs',
  `table_type` varchar(32) COLLATE utf8_hungarian_ci NOT NULL COMMENT 'Tábla tipus',
  `table_id` int(11) NOT NULL COMMENT 'Tábla id',
  `type` int(11) NOT NULL COMMENT 'Lásd külön dokuban',
  `assigned_id` int(11) NOT NULL COMMENT 'Érintett tábla id',
  `volume` int(11) NOT NULL COMMENT 'mennyiség',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB COLLATE=utf8_hungarian_ci;

CREATE TABLE IF NOT EXISTS `#__ampm_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Egyedi kulcs',
  `tablename` varchar(32) COLLATE utf8_hungarian_ci NOT NULL COMMENT 'Tábla',
  `table_id` int(11) NOT NULL COMMENT 'Tábla azon',
  `volume` int(11) NOT NULL COMMENT 'mennyiség',
  `type` varchar(32) COLLATE utf8_hungarian_ci NOT NULL COMMENT 'add,delete,update,volumechange',
  `user_id` int(11) NOT NULL COMMENT 'user',
  `time` datetime NOT NULL COMMENT 'időpont',
  `newstate` int(11) NOT NULL COMMENT 'statusz a modositás után',
  `oldrec` text,
  `newrec` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB COLLATE=utf8_hungarian_ci;

CREATE TABLE IF NOT EXISTS `#__ampm_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Egyedi azonosító',
  `title` varchar(128) COLLATE utf8_hungarian_ci NOT NULL COMMENT 'Megnevezés',
  `description` text COLLATE utf8_hungarian_ci NOT NULL COMMENT 'Leírás',
  `unit` varchar(12) COLLATE utf8_hungarian_ci NOT NULL COMMENT 'Mennyiségi egység',
  `state` int(11) NOT NULL COMMENT 'Státusz 0-visszavonva, 1-engedélyezett',
  `ordering` int(11) NOT NULL COMMENT 'listázási sorrend',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB COLLATE=utf8_hungarian_ci;

CREATE TABLE IF NOT EXISTS `#__ampm_project` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'egyedi kulcs',
  `title` varchar(128) COLLATE utf8_hungarian_ci NOT NULL COMMENT 'megnevezés',
  `description` text COLLATE utf8_hungarian_ci NOT NULL COMMENT 'leírás',
  `volume` int(11) NOT NULL COMMENT 'mennyiség',
  `unit` varchar(12) COLLATE utf8_hungarian_ci NOT NULL COMMENT 'mennyiség egység',
  `start` date NOT NULL COMMENT 'kezdés időpontja',
  `deadline` date NOT NULL COMMENT 'befejezés időpontja',
  `priority` int(11) NOT NULL COMMENT 'prioritás',
  `manager_id` int(11) NOT NULL COMMENT 'project vezető',
  `state` int(11) NOT NULL COMMENT ' 0-visszavonva, 1-aktiv, 2-várakoztatva, 3-megszakítva, 4-elkészült',
  `ordering` int(11) NOT NULL COMMENT 'listázási sorrend',
  `product_id` int(11) NOT NULL COMMENT 'Termék azonositó vagy nulla',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB COLLATE=utf8_hungarian_ci;

CREATE TABLE IF NOT EXISTS `#__ampm_resource` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Egyedi kulcs',
  `type` int(11) NOT NULL COMMENT 'Erőforrás tipus',
  `title` varchar(128) COLLATE utf8_hungarian_ci NOT NULL COMMENT 'Megnevezés',
  `description` text COLLATE utf8_hungarian_ci NOT NULL COMMENT 'leírás',
  `volume` int(11) NOT NULL COMMENT 'mennyiség',
  `unit` varchar(32) COLLATE utf8_hungarian_ci NOT NULL COMMENT 'mennyiség egység',
  `ordering` int(11) NOT NULL COMMENT 'listázási sorrend',
  `state` int(11) NOT NULL COMMENT '0-visszavonva, 1- aktiv',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB COLLATE=utf8_hungarian_ci;

CREATE TABLE IF NOT EXISTS `#__ampm_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Egyedi kulcs',
  `title` varchar(128) COLLATE utf8_hungarian_ci NOT NULL COMMENT 'Megnevezés',
  `description` text COLLATE utf8_hungarian_ci NOT NULL COMMENT 'Leírás',
  `workflow_id` int(11) NOT NULL COMMENT 'folyamat azon. vagy nulla',
  `start` datetime NOT NULL COMMENT 'inditás időpontja',
  `deadline` datetime NOT NULL COMMENT 'határidő',
  `priority` int(11) NOT NULL COMMENT 'prioritás',
  `manager_id` int(11) NOT NULL COMMENT 'felelős',
  `state` int(11) NOT NULL COMMENT 'státusz 0-visszavonva, 1-aktiv, 2-várakozik, 3-megszakítva, 4-kész',
  `process_desc` text COLLATE utf8_hungarian_ci NOT NULL COMMENT 'folyamat leírás',
  `result_desc` text COLLATE utf8_hungarian_ci NOT NULL COMMENT 'lezárási leirás',
  `ordering` int(11) NOT NULL COMMENT 'listázási sorrend',
  `taskshema_id` int(11) NOT NULL COMMENT 'müvelet azon vagy nulla',
  `volume` int(11) NOT NULL COMMENT 'mennyiség',
  `tracking` int(1) NOT NULL COMMENT 'létrehozónak email követés',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB COLLATE=utf8_hungarian_ci;

CREATE TABLE IF NOT EXISTS `#__ampm_taskshema` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Egyedi kulcs',
  `title` varchar(128) COLLATE utf8_hungarian_ci NOT NULL COMMENT 'Megnevezés',
  `description` text COLLATE utf8_hungarian_ci NOT NULL COMMENT 'Leírás',
  `wfshema_id` int(11) NOT NULL COMMENT 'müveleti sorrend azon',
  `ordering` int(11) NOT NULL COMMENT 'Listázási sorrend',
  `state` int(11) NOT NULL COMMENT '1-visszavonva, 1-aktiv',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB COLLATE=utf8_hungarian_ci;

CREATE TABLE IF NOT EXISTS `#__ampm_worker` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Egyedi kulcs',
  `name` varchar(128) COLLATE utf8_hungarian_ci NOT NULL COMMENT 'Valódi név',
  `nick` varchar(32) COLLATE utf8_hungarian_ci NOT NULL COMMENT 'Nick név',
  `email` varchar(80) COLLATE utf8_hungarian_ci NOT NULL COMMENT 'Email',
  `description` text COLLATE utf8_hungarian_ci NOT NULL COMMENT 'Megjegyzés',
  `ordering` int(11) NOT NULL COMMENT 'Listázási sorrend',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB COLLATE=utf8_hungarian_ci;

CREATE TABLE IF NOT EXISTS `#__ampm_workflow` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'egyedi kulcs',
  `title` varchar(128) COLLATE utf8_hungarian_ci NOT NULL COMMENT 'megnevezés',
  `description` text COLLATE utf8_hungarian_ci NOT NULL COMMENT 'leírás',
  `project_id` int(11) NOT NULL COMMENT 'projekt azonositó vagy nulla',
  `start` datetime NOT NULL COMMENT 'kezdés',
  `deadline` datetime NOT NULL COMMENT 'határidő',
  `state` int(11) NOT NULL COMMENT 'státusz 0-visszavonva, 1-aktiv, 2-várakozik, 3-megszakítva, 4-kész',
  `mmanager_id` int(11) NOT NULL COMMENT 'felelős vagy nulla',
  `priority` int(11) NOT NULL COMMENT 'prioritás',
  `process_desc` text COLLATE utf8_hungarian_ci NOT NULL COMMENT 'folyamat leírás',
  `result_desc` text COLLATE utf8_hungarian_ci NOT NULL COMMENT 'záró leirás',
  `wfshema_id` int(11) NOT NULL COMMENT 'müvelet azon vagy nulla',
  `ordering` int(11) NOT NULL COMMENT 'listázási sorrend',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB COLLATE=utf8_hungarian_ci;

CREATE TABLE IF NOT EXISTS `#__ampm_resourcetype` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Egyedi kulcs',
  `title` varchar(128) COLLATE utf8_hungarian_ci NOT NULL COMMENT 'Megnevezés',
  `unit` varchar(32) COLLATE utf8_hungarian_ci NOT NULL COMMENT 'mennyiségi egység',
  `state` int(11) NOT NULL COMMENT '0-visszavonva, 1 -aktiv',
  `ordering` int(11) NOT NULL COMMENT 'listázási sorrend',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB COLLATE=utf8_hungarian_ci;

CREATE TABLE IF NOT EXISTS `#__ampm_wfshema` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Egyedi kulcs',
  `title` varchar(128) COLLATE utf8_hungarian_ci NOT NULL COMMENT 'Megnevezés',
  `description` text COLLATE utf8_hungarian_ci NOT NULL COMMENT 'Leírás',
  `product_id` int(11) NOT NULL COMMENT 'Termék azon',
  `ordering` int(11) NOT NULL COMMENT 'Listázási sorrend',
  `state` int(1) NOT NULL COMMENT 'status',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB COLLATE=utf8_hungarian_ci;

CREATE TABLE IF NOT EXISTS `#__ampm_setup` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Egyedi kulcs',
  `json` text COLLATE utf8_hungarian_ci NOT NULL COMMENT 'Json setup info',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB COLLATE=utf8_hungarian_ci;
