# foodie
## init SQL
```sql
DROP TABLE IF EXISTS `delivery_times`;
CREATE TABLE IF NOT EXISTS `delivery_times` (
  `report_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `rest_id` int(11) NOT NULL,
  `total_delivery` float NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `arrived` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `report_id` (`report_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `dishes`;
CREATE TABLE IF NOT EXISTS `dishes` (
  `dish_id` bigint(20) unsigned NOT NULL,
  `rest_id` int(11) NOT NULL,
  `dish_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dish_desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dish_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dish_price` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `restaurants`;
CREATE TABLE IF NOT EXISTS `restaurants` (
  `rest_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `rest_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rest_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rest_logo` varchar(255) CHARACTER SET latin1 NOT NULL,
  UNIQUE KEY `rest_id` (`rest_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
```
