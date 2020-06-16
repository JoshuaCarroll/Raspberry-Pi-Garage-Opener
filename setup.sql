CREATE DATABASE IF NOT EXISTS `garage`;
USE `garage`;

CREATE TABLE IF NOT EXISTS `Users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(45) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `FirstName` varchar(45) DEFAULT NULL,
  `LastName` varchar(45) DEFAULT NULL,
  `ValidStartTime` varchar(45) DEFAULT NULL,
  `ValidEndTime` varchar(45) DEFAULT NULL,
  `ValidStartDate` varchar(45) DEFAULT NULL,
  `ValidEndDate` varchar(45) DEFAULT NULL,
  `ValidDaysOfWeek` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Username_UNIQUE` (`Username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `Settings` (
  `Key` varchar(45) NOT NULL,
  `Value` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`Key`),
  UNIQUE KEY `Key_UNIQUE` (`Key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Add the known settings. This won't add them if they are there because of the Unique key constraint on the name column.
INSERT IGNORE INTO Settings (`Key`, `Value`) VALUE ('GarageURL', '');
