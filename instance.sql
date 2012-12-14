-- phpMyAdmin SQL Dump
-- version 2.11.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 26, 2009 at 12:23 AM
-- Server version: 5.0.51
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `instance`
--

-- --------------------------------------------------------

--
-- Table structure for table `components`
--

CREATE TABLE `components` (
  `componentID` int(11) NOT NULL auto_increment,
  `componentName` varchar(100) default NULL,
  PRIMARY KEY  (`componentID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dbtablefields`
--

CREATE TABLE `dbtablefields` (
  `dbTableFieldID` int(11) NOT NULL auto_increment,
  `dbTableFieldName` varchar(100) NOT NULL,
  `dbTableFieldType` varchar(100) NOT NULL,
  `dbTableID` int(11) NOT NULL,
  `dbTableShowInList` tinyint(1) NOT NULL,
  PRIMARY KEY  (`dbTableFieldID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `dbtables`
--

CREATE TABLE `dbtables` (
  `dbTableID` int(11) NOT NULL auto_increment,
  `dbTableName` varchar(100) NOT NULL,
  `dbTableKeyField` varchar(100) NOT NULL,
  PRIMARY KEY  (`dbTableID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `modulefields`
--

CREATE TABLE `modulefields` (
  `moduleFieldID` int(11) NOT NULL auto_increment,
  `moduleFieldName` char(100) default NULL,
  `moduleFieldInput` varchar(100) default NULL,
  `moduleFieldVisual` varchar(100) NOT NULL,
  `moduleFieldStore` varchar(100) NOT NULL,
  `moduleID` int(11) default NULL,
  PRIMARY KEY  (`moduleFieldID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `moduleID` int(11) NOT NULL auto_increment,
  `moduleName` varchar(100) NOT NULL,
  `moduleCategories` tinyint(4) NOT NULL,
  `moduleNestedCategories` tinyint(4) NOT NULL,
  `moduleTags` tinyint(4) NOT NULL,
  `moduleComments` tinyint(4) NOT NULL,
  `moduleNestedComments` tinyint(4) NOT NULL,
  `moduleItemRating` tinyint(4) NOT NULL,
  `moduleStatistics` int(11) NOT NULL,
  PRIMARY KEY  (`moduleID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `pageparts`
--

CREATE TABLE `pageparts` (
  `pagePartID` int(11) NOT NULL auto_increment,
  `pagePartParentID` int(11) NOT NULL,
  `pagePartCategory` varchar(100) NOT NULL,
  `pagePartText` text NOT NULL,
  PRIMARY KEY  (`pagePartID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `pageID` int(11) NOT NULL auto_increment,
  `pageName` varchar(100) NOT NULL,
  `pageOperationID` int(11) NOT NULL,
  `pageMetaID` int(11) NOT NULL,
  `pageContentID` int(11) NOT NULL,
  PRIMARY KEY  (`pageID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `partproperties`
--

CREATE TABLE `partproperties` (
  `propertyID` int(11) NOT NULL auto_increment,
  `propertyTitle` varchar(100) NOT NULL,
  `propertyValue` text NOT NULL,
  `propertyPartID` int(11) NOT NULL,
  PRIMARY KEY  (`propertyID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Table structure for table `usermanagementoptions`
--

CREATE TABLE `usermanagementoptions` (
  `UserID` int(11) NOT NULL auto_increment,
  `multiuser` tinyint(4) NOT NULL,
  `userprofile` tinyint(4) NOT NULL,
  `Usergroup` tinyint(4) NOT NULL,
  `secretquestion` tinyint(4) NOT NULL,
  PRIMARY KEY  (`UserID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `usermanagmentfields`
--

CREATE TABLE `usermanagmentfields` (
  `UserFieldID` int(11) NOT NULL,
  `UserFieldName` varchar(100) NOT NULL,
  `UserFieldinput` int(11) NOT NULL,
  `UserFieldVisual` int(11) NOT NULL,
  `UserFieldStore` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  PRIMARY KEY  (`UserFieldID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
