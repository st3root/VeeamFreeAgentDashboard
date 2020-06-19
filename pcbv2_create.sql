CREATE TABLE `messages` (
  `message` mediumtext,
  `pcname` varchar(190) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE `pc` (
  `pcname` varchar(190) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `date` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`pcname`)
);
