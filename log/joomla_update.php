#
#<?php die('Forbidden.'); ?>
#Date: 2013-12-19 09:20:04 UTC
#Software: Joomla Platform 13.1.0 Stable [ Curiosity ] 24-Apr-2013 00:00 GMT

#Fields: datetime	priority	category	message
2013-12-19T09:20:04+00:00	INFO	update	Finalising installation.
2013-12-19T09:20:05+00:00	INFO	update	Ran query from file 3.2.0. Query text: /* Core 3.2 schema updates */  ALTER TABLE `#__content_types` ADD COLUMN `conten.
2013-12-19T09:20:05+00:00	INFO	update	Ran query from file 3.2.0. Query text: UPDATE `#__content_types` SET `content_history_options` = '{"formFile":"administ.
2013-12-19T09:20:05+00:00	INFO	update	Ran query from file 3.2.0. Query text: UPDATE `#__content_types` SET `content_history_options` = '{"formFile":"administ.
2013-12-19T09:20:05+00:00	INFO	update	Ran query from file 3.2.0. Query text: UPDATE `#__content_types` SET `content_history_options` = '{"formFile":"administ.
2013-12-19T09:20:05+00:00	INFO	update	Ran query from file 3.2.0. Query text: UPDATE `#__content_types` SET `content_history_options` = '{"formFile":"administ.
2013-12-19T09:20:05+00:00	INFO	update	Ran query from file 3.2.0. Query text: UPDATE `#__content_types` SET `content_history_options` = '{"formFile":"administ.
2013-12-19T09:20:05+00:00	INFO	update	Ran query from file 3.2.0. Query text: UPDATE `#__content_types` SET `content_history_options` = '{"formFile":"administ.
2013-12-19T09:20:05+00:00	INFO	update	Ran query from file 3.2.0. Query text: INSERT INTO `#__content_types` (`type_title`, `type_alias`, `table`, `rules`, `f.
2013-12-19T09:20:05+00:00	INFO	update	Ran query from file 3.2.0. Query text: UPDATE `#__extensions` SET `params` = '{"template_positions_display":"0","upload.
2013-12-19T09:20:05+00:00	INFO	update	Ran query from file 3.2.0. Query text: UPDATE `#__extensions` SET `params` = '{"lineNumbers":"1","lineWrapping":"1","ma.
2013-12-19T09:20:05+00:00	INFO	update	Ran query from file 3.2.0. Query text: INSERT INTO `#__extensions` (`extension_id`, `name`, `type`, `element`, `folder`.
2013-12-19T09:20:05+00:00	INFO	update	Ran query from file 3.2.0. Query text: INSERT INTO `#__menu` (`menutype`, `title`, `alias`, `note`, `path`, `link`, `ty.
2013-12-19T09:20:06+00:00	INFO	update	Ran query from file 3.2.0. Query text: ALTER TABLE `#__modules` ADD COLUMN `asset_id` INT(10) UNSIGNED NOT NULL DEFAULT.
2013-12-19T09:20:06+00:00	INFO	update	Ran query from file 3.2.0. Query text: CREATE TABLE `#__postinstall_messages` (   `postinstall_message_id` bigint(20) u.
2013-12-19T09:20:06+00:00	INFO	update	Ran query from file 3.2.0. Query text: INSERT INTO `#__postinstall_messages` (`extension_id`, `title_key`, `description.
2013-12-19T09:20:06+00:00	INFO	update	Ran query from file 3.2.0. Query text: CREATE TABLE IF NOT EXISTS `#__ucm_history` (   `version_id` int(10) unsigned NO.
2013-12-19T09:20:07+00:00	INFO	update	Ran query from file 3.2.0. Query text: ALTER TABLE `#__users` ADD COLUMN `otpKey` varchar(1000) NOT NULL DEFAULT '' COM.
2013-12-19T09:20:07+00:00	INFO	update	Ran query from file 3.2.0. Query text: ALTER TABLE `#__users` ADD COLUMN `otep` varchar(1000) NOT NULL DEFAULT '' COMME.
2013-12-19T09:20:08+00:00	INFO	update	Ran query from file 3.2.0. Query text: CREATE TABLE IF NOT EXISTS `#__user_keys` (   `id` int(10) unsigned NOT NULL AUT.
2013-12-19T09:20:08+00:00	INFO	update	Ran query from file 3.2.0. Query text: /* Update bad params for two cpanel modules */  UPDATE `#__modules` SET `params`.
2013-12-19T09:20:08+00:00	INFO	update	Ran query from file 3.2.1. Query text: DELETE FROM `#__postinstall_messages` WHERE `title_key` = 'PLG_USER_JOOMLA_POSTI.
2013-12-19T09:20:08+00:00	INFO	update	Deleting removed files and folders.
2013-12-19T09:20:16+00:00	INFO	update	Cleaning up after installation.
2013-12-19T09:20:16+00:00	INFO	update	Update to version 3.2.1 is complete.
2014-04-13T16:39:41+00:00	INFO	update	Update started by user Super User (50). Old version is 3.2.1.
2014-04-13T16:39:42+00:00	INFO	update	Downloading update file from .
2014-04-13T16:40:08+00:00	INFO	update	File Joomla_3.2.x_to_3.2.3-Stable-Patch_Package.zip successfully downloaded.
2014-04-13T16:40:09+00:00	INFO	update	Starting installation of new version.
2014-04-13T16:41:24+00:00	INFO	update	Finalising installation.
2014-04-13T16:41:25+00:00	INFO	update	Ran query from file 3.2.2-2013-12-22. Query text: ALTER TABLE `#__update_sites` ADD COLUMN `extra_query` VARCHAR(1000) DEFAULT '';.
2014-04-13T16:41:25+00:00	INFO	update	Ran query from file 3.2.2-2013-12-22. Query text: ALTER TABLE `#__updates` ADD COLUMN `extra_query` VARCHAR(1000) DEFAULT '';.
2014-04-13T16:41:25+00:00	INFO	update	Ran query from file 3.2.2-2013-12-28. Query text: UPDATE `#__menu` SET `component_id` = (SELECT `extension_id` FROM `#__extensions.
2014-04-13T16:41:25+00:00	INFO	update	Ran query from file 3.2.2-2014-01-08. Query text: INSERT INTO `#__extensions` (`extension_id`, `name`, `type`, `element`, `folder`.
2014-04-13T16:41:25+00:00	INFO	update	Ran query from file 3.2.2-2014-01-15. Query text: INSERT INTO `#__postinstall_messages` (`extension_id`, `title_key`, `description.
2014-04-13T16:41:26+00:00	INFO	update	Ran query from file 3.2.2-2014-01-18. Query text: /* Update updates version length */ ALTER TABLE `#__updates` MODIFY `version` va.
2014-04-13T16:41:26+00:00	INFO	update	Ran query from file 3.2.2-2014-01-23. Query text: INSERT INTO `#__extensions` (`extension_id`, `name`, `type`, `element`, `folder`.
2014-04-13T16:41:26+00:00	INFO	update	Ran query from file 3.2.3-2014-02-20. Query text: UPDATE `#__extensions` ext1, `#__extensions` ext2 SET ext1.`params` =  ext2.`par.
2014-04-13T16:41:26+00:00	INFO	update	Deleting removed files and folders.
2014-04-13T16:41:33+00:00	INFO	update	Cleaning up after installation.
2014-04-13T16:41:33+00:00	INFO	update	Update to version 3.2.3 is complete.
2014-05-16T16:45:46+00:00	INFO	update	A frissítést a(z) Super User (50) nevű felhasználó kezdte meg. Régi verzió: 3.2.3.
2014-05-16T16:45:46+00:00	INFO	update	Frissítésfájl letöltése a következő helyről: ...
2014-05-16T16:46:28+00:00	INFO	update	A(z) Joomla_3.3.0-Stable-Update_Package.zip fájl letöltése sikerült.
2014-05-16T16:46:30+00:00	INFO	update	Az új verzió telepítésének megkezdése...
2014-05-16T16:48:35+00:00	INFO	update	A telepítés véglegesítése...
2014-05-16T16:48:37+00:00	INFO	update	A lekérdezés a(z) 3.3.0-2014-02-16 fájlból került lefuttatásra. Lekérdezés szövege: ALTER TABLE `#__users` ADD COLUMN `requireReset` tinyint(4) NOT NULL DEFAULT 0 C.
2014-05-16T16:48:37+00:00	INFO	update	A lekérdezés a(z) 3.3.0-2014-04-02 fájlból került lefuttatásra. Lekérdezés szövege: INSERT INTO `#__extensions` (`extension_id`, `name`, `type`, `element`, `folder`.
2014-05-16T16:48:37+00:00	INFO	update	Az eltávolított fájlok és mappák törlése...
2014-05-16T16:48:46+00:00	INFO	update	Takarítás a telepítés után...
2014-05-16T16:48:46+00:00	INFO	update	A frissítés a(z) 3.3.0-s verzióra befejeződött.
2015-01-05T14:56:13+00:00	INFO	update	A frissítést a(z) Admin (66) nevű felhasználó kezdte meg. Régi verzió: 3.3.0.
2015-01-05T14:56:13+00:00	INFO	update	Frissítésfájl letöltése a következő helyről: ...
2015-01-05T14:56:20+00:00	INFO	update	A(z) Joomla_3.3.x_to_3.3.6-Stable-Patch_Package.zip fájl letöltése sikerült.
2015-01-05T14:56:22+00:00	INFO	update	Az új verzió telepítésének megkezdése...
2015-01-05T14:57:22+00:00	INFO ::1	update	A telepítés véglegesítése...
2015-01-05T14:57:25+00:00	INFO ::1	update	A lekérdezés a(z) 3.3.4-2014-08-03 fájlból került lefuttatásra. Lekérdezés szövege: ALTER TABLE `#__user_profiles` CHANGE `profile_value` `profile_value` TEXT NOT N.
2015-01-05T14:57:25+00:00	INFO ::1	update	A lekérdezés a(z) 3.3.6-2014-09-30 fájlból került lefuttatásra. Lekérdezés szövege: INSERT INTO `#__update_sites` (`name`, `type`, `location`, `enabled`) VALUES ('J.
2015-01-05T14:57:25+00:00	INFO ::1	update	A lekérdezés a(z) 3.3.6-2014-09-30 fájlból került lefuttatásra. Lekérdezés szövege: INSERT INTO `#__update_sites_extensions` (`update_site_id`, `extension_id`) VALU.
2015-01-05T14:57:25+00:00	INFO ::1	update	Az eltávolított fájlok és mappák törlése...
2015-01-05T14:57:39+00:00	INFO ::1	update	Takarítás a telepítés után...
2015-01-05T14:57:39+00:00	INFO ::1	update	A frissítés a(z) 3.3.6-s verzióra befejeződött.
2015-04-14T09:56:58+00:00	INFO 192.168.0.12	update	A frissítést a(z) Admin (66) nevű felhasználó kezdte meg. Régi verzió: 3.3.6.
2015-04-14T09:56:58+00:00	INFO 192.168.0.12	update	Frissítésfájl letöltése a következő helyről: https://github.com/joomla/joomla-cms/releases/download/3.4.1/Joomla_3.4.1-Stable-Update_Package.zip...
2015-04-14T09:56:58+00:00	INFO 192.168.0.12	update	A(z) Joomla_3.4.1-Stable-Update_Package.zip fájl letöltése sikerült.
2015-04-14T09:56:58+00:00	INFO 192.168.0.12	update	Az új verzió telepítésének megkezdése...
2015-04-14T09:59:34+00:00	INFO 192.168.0.12	update	A frissítést a(z) Admin (66) nevű felhasználó kezdte meg. Régi verzió: 3.3.6.
2015-04-14T09:59:35+00:00	INFO 192.168.0.12	update	Frissítésfájl letöltése a következő helyről: https://github.com/joomla/joomla-cms/releases/download/3.4.1/Joomla_3.4.1-Stable-Update_Package.zip...
2015-04-14T09:59:35+00:00	INFO 192.168.0.12	update	A(z) Joomla_3.4.1-Stable-Update_Package.zip fájl letöltése sikerült.
2015-04-14T09:59:35+00:00	INFO 192.168.0.12	update	Az új verzió telepítésének megkezdése...
2015-04-14T10:01:47+00:00	INFO 192.168.0.12	update	A frissítést a(z) Admin (66) nevű felhasználó kezdte meg. Régi verzió: 3.3.6.
2015-04-14T10:01:47+00:00	INFO 192.168.0.12	update	Frissítésfájl letöltése a következő helyről: https://github.com/joomla/joomla-cms/releases/download/3.4.1/Joomla_3.4.1-Stable-Update_Package.zip...
2015-04-14T10:01:47+00:00	INFO 192.168.0.12	update	A(z) Joomla_3.4.1-Stable-Update_Package.zip fájl letöltése sikerült.
2015-04-14T10:01:47+00:00	INFO 192.168.0.12	update	Az új verzió telepítésének megkezdése...
2015-04-14T10:02:24+00:00	INFO 192.168.0.12	update	A frissítést a(z) Admin (66) nevű felhasználó kezdte meg. Régi verzió: 3.3.6.
2015-04-14T10:02:24+00:00	INFO 192.168.0.12	update	A(z) Joomla_3.4.1-Stable-Update_Package.zip fájl letöltése sikerült.
2015-04-14T10:02:24+00:00	INFO 192.168.0.12	update	Az új verzió telepítésének megkezdése...
2015-04-14T10:04:04+00:00	INFO 192.168.0.12	update	A telepítés véglegesítése...
2015-04-14T10:04:05+00:00	INFO 192.168.0.12	update	A lekérdezés a(z) 3.4.0-2014-08-24 fájlból került lefuttatásra. Lekérdezés szövege: INSERT INTO `#__postinstall_messages` (`extension_id`, `title_key`, `description.
2015-04-14T10:04:05+00:00	INFO 192.168.0.12	update	A lekérdezés a(z) 3.4.0-2014-09-01 fájlból került lefuttatásra. Lekérdezés szövege: INSERT INTO `#__extensions` (`extension_id`, `name`, `type`, `element`, `folder`.
2015-04-14T10:04:05+00:00	INFO 192.168.0.12	update	A lekérdezés a(z) 3.4.0-2014-09-01 fájlból került lefuttatásra. Lekérdezés szövege: INSERT INTO `#__update_sites` (`name`, `type`, `location`, `enabled`) VALUES ('W.
2015-04-14T10:04:05+00:00	INFO 192.168.0.12	update	A lekérdezés a(z) 3.4.0-2014-09-01 fájlból került lefuttatásra. Lekérdezés szövege: INSERT INTO `#__update_sites_extensions` (`update_site_id`, `extension_id`) VALU.
2015-04-14T10:04:06+00:00	INFO 192.168.0.12	update	A lekérdezés a(z) 3.4.0-2014-09-16 fájlból került lefuttatásra. Lekérdezés szövege: ALTER TABLE `#__redirect_links` ADD header smallint(3) NOT NULL DEFAULT 301;.
2015-04-14T10:04:08+00:00	INFO 192.168.0.12	update	A lekérdezés a(z) 3.4.0-2014-09-16 fájlból került lefuttatásra. Lekérdezés szövege: ALTER TABLE `#__redirect_links` MODIFY new_url varchar(255);.
2015-04-14T10:04:08+00:00	INFO 192.168.0.12	update	A lekérdezés a(z) 3.4.0-2014-10-20 fájlból került lefuttatásra. Lekérdezés szövege: DELETE FROM `#__extensions` WHERE `extension_id` = 100;.
2015-04-14T10:04:08+00:00	INFO 192.168.0.12	update	A lekérdezés a(z) 3.4.0-2014-12-03 fájlból került lefuttatásra. Lekérdezés szövege: UPDATE `#__extensions` SET `protected` = '0' WHERE `name` = 'plg_editors-xtd_art.
2015-04-14T10:04:08+00:00	INFO 192.168.0.12	update	A lekérdezés a(z) 3.4.0-2015-01-21 fájlból került lefuttatásra. Lekérdezés szövege: INSERT INTO `#__postinstall_messages` (`extension_id`, `title_key`, `description.
2015-04-14T10:04:08+00:00	INFO 192.168.0.12	update	A lekérdezés a(z) 3.4.0-2015-02-26 fájlból került lefuttatásra. Lekérdezés szövege: INSERT INTO `#__postinstall_messages` (`extension_id`, `title_key`, `description.
2015-04-14T10:04:08+00:00	INFO 192.168.0.12	update	Az eltávolított fájlok és mappák törlése...
2015-04-14T10:04:15+00:00	INFO 192.168.0.12	update	Takarítás a telepítés után...
2015-04-14T10:04:15+00:00	INFO 192.168.0.12	update	A frissítés a(z) 3.4.1-s verzióra befejeződött.
