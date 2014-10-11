CREATE DATABASE auctionhouse;
USE auctionhouse;

CREATE TABLE `auctions` (
  `insert_date` datetime NOT NULL,
  `lastModified` datetime NOT NULL,
  `faction` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `auc` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `item` int(11) NOT NULL,
  `owner` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ownerRealm` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `bid` bigint(11) NOT NULL,
  `buyout` bigint(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `timeLeft` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `rand` int(11) NOT NULL,
  `seed` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `petSpeciesId` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `petBreedId` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `petLevel` int(11) NOT NULL,
  `petQualityId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contain all the scanned auctions';

CREATE TABLE `infolinks` (
  `fetch_date` datetime NOT NULL,
  `url` varchar(255) NOT NULL,
  `last_modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='List of URLs fetched from us.battle.net regarding AH for Gallywix Realm';