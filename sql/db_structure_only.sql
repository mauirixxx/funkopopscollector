/*Table structure for table `popcollection` */

CREATE TABLE `popcollection` (
  `popcollectionid` int(11) NOT NULL AUTO_INCREMENT,
  `popcollection` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`popcollectionid`),
  KEY `popcollection` (`popcollection`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=latin1;

/*Table structure for table `popimages` */

CREATE TABLE `popimages` (
  `imageid` int(11) NOT NULL AUTO_INCREMENT,
  `funkoid` int(11) DEFAULT NULL COMMENT 'the funko pop itself',
  `userid` int(11) DEFAULT NULL COMMENT 'the user that uploaded the picture',
  `imagepath` text COMMENT 'where the image is physically located',
  PRIMARY KEY (`imageid`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=latin1;

/*Table structure for table `pops` */

CREATE TABLE `pops` (
  `funkoid` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `popno` int(11) DEFAULT NULL,
  `popname` varchar(200) DEFAULT NULL,
  `popcollectionid` int(11) DEFAULT NULL COMMENT 'Game of Thrones, Voltron, TV, Movies, Asia, etc etc',
  `inserteddate` date DEFAULT NULL,
  PRIMARY KEY (`funkoid`),
  KEY `popname` (`popname`)
) ENGINE=InnoDB AUTO_INCREMENT=297 DEFAULT CHARSET=latin1;

/*Table structure for table `users` */

CREATE TABLE `users` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(200) DEFAULT NULL,
  `passwd` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;