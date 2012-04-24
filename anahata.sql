-- phpMyAdmin SQL Dump
-- version 3.2.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 24, 2012 at 02:43 PM
-- Server version: 5.1.40
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `anahata`
--

-- --------------------------------------------------------

--
-- Table structure for table `code_banner`
--

CREATE TABLE IF NOT EXISTS `code_banner` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created` int(10) unsigned DEFAULT NULL,
  `updated` int(10) unsigned DEFAULT NULL,
  `deleted` int(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `alt` varchar(255) NOT NULL,
  `width` int(10) unsigned DEFAULT NULL,
  `height` int(10) unsigned DEFAULT NULL,
  `img` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `code_banner`
--

INSERT INTO `code_banner` (`id`, `created`, `updated`, `deleted`, `title`, `alt`, `width`, `height`, `img`, `link`, `description`) VALUES
(1, 1298881828, 1298881828, 0, 'Free Shipping', '', 140, 119, '0001.jpg', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `code_brand`
--

CREATE TABLE IF NOT EXISTS `code_brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` longblob NOT NULL,
  `parent_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `seo_url` varchar(255) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `page_description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `code_brand`
--

INSERT INTO `code_brand` (`id`, `title`, `description`, `parent_id`, `order_id`, `created`, `updated`, `keywords`, `seo_url`, `page_title`, `page_description`) VALUES
(1, 'To be too', '', 0, 1, 1327557795, 1327584647, '', 'To-be-too', '', ''),
(3, 'Fun& Fun', '', 0, 2, 1327558787, 1327584642, '', 'Fun-and-Fun', '', ''),
(4, 'Street Gang', '', 0, 3, 1327584615, 1327584629, '', 'Street-Gang', '', ''),
(5, 'Nerso', '', 0, 4, 1327635416, 1327635416, '', 'Nerso', '', ''),
(6, 'Grain de ble', '', 0, 5, 1327635452, 1327635452, '', 'Grain de ble', '', ''),
(7, 'Diamantina', '', 0, 7, 1327635476, 1328290457, '', 'Diamantina', '', ''),
(8, 'Lisa Rose', '', 0, 6, 1327635703, 1328290457, '', 'Lisa-Rose', '', ''),
(9, 'IDEXE', '', 0, 8, 1327635877, 1327635877, '', 'IDEXE', '', ''),
(10, 'WPM', '', 0, 9, 1327646542, 1327646542, '', 'WPM', '', ''),
(11, 'EVEREST', '', 0, 10, 1327649309, 1327649309, '', 'EVEREST', '', ''),
(12, 'NEXT', '', 0, 11, 1327652860, 1327652860, '', 'NEXT', '', ''),
(13, 'Okaidi', '', 0, 12, 1327652916, 1327652916, '', 'Okaidi', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `code_category`
--

CREATE TABLE IF NOT EXISTS `code_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `description` text,
  `order_id` int(11) NOT NULL DEFAULT '0',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `seo_url` varchar(255) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `page_description` varchar(255) NOT NULL,
  `google_priority` varchar(255) NOT NULL,
  `access` varchar(255) NOT NULL,
  `active` int(1) NOT NULL,
  `published` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tint_sort_order` (`order_id`),
  KEY `cat_parent` (`parent_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 PACK_KEYS=1 AUTO_INCREMENT=63 ;

--
-- Dumping data for table `code_category`
--

INSERT INTO `code_category` (`id`, `title`, `description`, `order_id`, `parent_id`, `created`, `updated`, `keywords`, `seo_url`, `page_title`, `page_description`, `google_priority`, `access`, `active`, `published`) VALUES
(35, 'Детский сток', '', 3, 0, 1321714654, 1321723857, '', 'children', '', '', '0.1', '', 1, 1),
(36, 'Девочки', '', 1, 35, 1321714734, 1327492437, '', 'girls_det', '', '', '0.1', '', 1, 0),
(37, 'Мальчики', '', 2, 35, 1321714807, 1327492434, '', '234234', '', '', '0.1', '', 1, 0),
(38, 'Девочки', '', 1, 34, 1321714833, 1321715228, '', '11', '', '', '0.1', '', 1, 1),
(39, 'от 0 до 1 года', '', 1, 38, 1321714891, 1326283034, '', '12', '', '', '0.1', '', 1, 1),
(40, 'от 2 до 4 лет', '', 2, 38, 1321714905, 1328161089, '', '32', '', '', '0.1', '', 1, 1),
(33, 'Мальчики', '', 2, 34, 1321102254, 1321714840, '', 'Muzhskie', 'Мальчики', '', '0.1', '', 1, 1),
(34, 'Комиссионные товары', '', 2, 0, 1321714572, 1322575957, '', 'gf', '', '', '0.1', '', 1, 1),
(41, 'от 5 до 8 лет', '', 3, 38, 1326283049, 1328161086, '', '1', '', '', '0.1', '', 1, 1),
(42, 'от 9 до 16 лет', '', 4, 38, 1326283069, 1328161087, '', '2', '', '', '0.1', '', 1, 1),
(43, 'от 0 до 1 года', '', 1, 33, 1326283100, 1328161092, '', '3', '', '', '0.1', '', 1, 1),
(44, 'от 2 до 4 лет', '', 2, 33, 1326283132, 1328161093, '', '5', '', '', '0.1', '', 1, 1),
(45, 'от 5 до 8 лет', '', 3, 33, 1326283145, 1328161094, '', 'авы', '', '', '0.1', '', 1, 1),
(46, 'от 9 до 16 лет', '', 4, 33, 1326283160, 1328161096, '', 'выф', '', '', '0.1', '', 1, 1),
(47, 'Обувь', '', 3, 34, 1326283200, 1328161097, '', 'авав', '', '', '0.1', '', 0, 1),
(48, 'Головные уборы', '', 4, 34, 1326283213, 1328161098, '', '5456', '', '', '0.1', '', 0, 1),
(49, 'Разное', '', 5, 34, 1326283229, 1328161100, '', '5ав', '', '', '0.1', '', 0, 1),
(50, 'от 0 до 1 года', '', 1, 36, 1326283252, 1327492428, '', 'а332', '', '', '0.1', '', 1, 0),
(51, 'от 2 до 4 лет', '', 2, 36, 1326283265, 1327492429, '', 'уууу', '', '', '0.1', '', 1, 0),
(52, 'от 5 до 8 лет', '', 3, 36, 1326283279, 1327492430, '', '8в8в8', '', '', '0.1', '', 1, 0),
(53, 'от 9 до 16 лет', '', 4, 36, 1326283292, 1327492432, '', '45564', '', '', '0.1', '', 1, 0),
(54, 'от 0 до 1 года', '', 1, 37, 1326283316, 1327492412, '', 'авук', '', '', '0.1', '', 1, 0),
(55, 'от 2 до 4 лет', '', 2, 37, 1326283329, 1327492414, '', '4454уц', '', '', '0.1', '', 1, 0),
(56, 'от 5 до 8 лет', '', 3, 37, 1326283344, 1327492417, '', '12в', '', '', '0.1', '', 1, 0),
(57, 'от 9 до 16 лет', '', 4, 37, 1326283359, 1327492418, '', 'уц', '', '', '0.1', '', 1, 0),
(58, 'Головные уборы', '', 4, 35, 1326283430, 1327492420, '', 'ав', '', '', '0.1', '', 1, 0),
(59, 'Разное', '', 5, 35, 1326283441, 1327492422, '', 'ыв23', '', '', '0.1', '', 1, 0),
(60, 'Отдам в дар', '', 4, 0, 1326283455, 1327492424, '', 'авуцуц', '', '', '0.1', '', 1, 0),
(62, 'Обувь', '', 3, 35, 1326359812, 1327492419, '', '12321', 'Обувь', '', '0.1', '', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `code_category_product`
--

CREATE TABLE IF NOT EXISTS `code_category_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `code_category_product`
--


-- --------------------------------------------------------

--
-- Table structure for table `code_category_revision`
--

CREATE TABLE IF NOT EXISTS `code_category_revision` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `record_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `description` text COLLATE utf8_bin NOT NULL,
  `order_id` int(11) NOT NULL DEFAULT '0',
  `created` int(11) NOT NULL DEFAULT '0',
  `updated` int(11) NOT NULL DEFAULT '0',
  `keywords` text COLLATE utf8_bin NOT NULL,
  `seo_url` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `page_title` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `page_description` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `google_priority` varchar(3) COLLATE utf8_bin NOT NULL DEFAULT '',
  `access` varchar(255) COLLATE utf8_bin NOT NULL,
  `active` int(1) NOT NULL,
  `published` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Dumping data for table `code_category_revision`
--


-- --------------------------------------------------------

--
-- Table structure for table `code_cms_media`
--

CREATE TABLE IF NOT EXISTS `code_cms_media` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `url` varchar(255) NOT NULL,
  `align` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `thumbs` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `code_cms_media`
--


-- --------------------------------------------------------

--
-- Table structure for table `code_contact_module`
--

CREATE TABLE IF NOT EXISTS `code_contact_module` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from_name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `from_email` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `subject` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `updated` int(10) unsigned NOT NULL DEFAULT '0',
  `mail_text` text COLLATE utf8_bin NOT NULL,
  `thank_you_page` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=14 ;

--
-- Dumping data for table `code_contact_module`
--

INSERT INTO `code_contact_module` (`id`, `from_name`, `from_email`, `subject`, `created`, `updated`, `mail_text`, `thank_you_page`) VALUES
(13, 'Pefumery', 'admin@quantumweb.com.au', 'Pefumery Web Enquiry', 1292969778, 1292969778, 0x3c68313e5468616e6b20796f753c2f68313e0d0a3c703e57652077696c6c20726573706f6e6420746f20796f757220656e71756972792073686f72746c792e3c2f703e, 'Success');

-- --------------------------------------------------------

--
-- Table structure for table `code_contact_module_entry`
--

CREATE TABLE IF NOT EXISTS `code_contact_module_entry` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `contact_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `updated` int(10) unsigned NOT NULL DEFAULT '0',
  `email` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `entry` text COLLATE utf8_bin NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_id` (`contact_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Dumping data for table `code_contact_module_entry`
--


-- --------------------------------------------------------

--
-- Table structure for table `code_contact_module_form`
--

CREATE TABLE IF NOT EXISTS `code_contact_module_form` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `contact_id` int(10) unsigned NOT NULL DEFAULT '0',
  `order_id` int(11) NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `updated` int(10) unsigned NOT NULL DEFAULT '0',
  `field_name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `field_type` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `field_validation` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `field_error` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `contact_id` (`contact_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=45 ;

--
-- Dumping data for table `code_contact_module_form`
--

INSERT INTO `code_contact_module_form` (`id`, `contact_id`, `order_id`, `created`, `updated`, `field_name`, `field_type`, `field_validation`, `field_error`) VALUES
(37, 12, 1, 1292969553, 1292969607, 'Name*', 'name', 'name', 'Enter name'),
(36, 12, 5, 1292969553, 1292969600, 'Email*', 'email', 'email', 'Enter valid email'),
(39, 13, 15, 1292969778, 1292969818, 'Email*', 'email', 'email', 'Enter valid email'),
(40, 13, 1, 1292969778, 1292969801, 'Name*', 'name', 'name', 'Enter name'),
(41, 13, 10, 1292969842, 1292969842, 'Phone*', 'text', 'string', 'Please enter your phone number'),
(42, 13, 20, 1292969861, 1292969861, 'Postcode* ', 'text', 'string', 'Please enter your Postcode'),
(43, 13, 25, 1292969875, 1292969875, 'Comments', 'textarea', '', ''),
(44, 13, 30, 1292969941, 1292969941, 'How did you hear about us*', 'select', 'string', 'Please tell us How did you hear about us');

-- --------------------------------------------------------

--
-- Table structure for table `code_contact_module_form_filetype`
--

CREATE TABLE IF NOT EXISTS `code_contact_module_form_filetype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `element_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `created` int(11) NOT NULL DEFAULT '0',
  `updated` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Dumping data for table `code_contact_module_form_filetype`
--


-- --------------------------------------------------------

--
-- Table structure for table `code_contact_module_form_select`
--

CREATE TABLE IF NOT EXISTS `code_contact_module_form_select` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `element_id` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `updated` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=51 ;

--
-- Dumping data for table `code_contact_module_form_select`
--

INSERT INTO `code_contact_module_form_select` (`id`, `element_id`, `name`, `created`, `updated`) VALUES
(47, 44, 'Google', 1292969941, 1292969941),
(48, 44, 'Other Search Engine', 1292969941, 1292969941),
(49, 44, 'Car Sticker', 1292969941, 1292969941),
(50, 44, 'Word of Mouth', 1292969941, 1292969941);

-- --------------------------------------------------------

--
-- Table structure for table `code_country`
--

CREATE TABLE IF NOT EXISTS `code_country` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`country_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=233 ;

--
-- Dumping data for table `code_country`
--

INSERT INTO `code_country` (`country_id`, `name`) VALUES
(1, 'United States'),
(2, 'Canada'),
(3, 'Afghanistan'),
(4, 'Albania'),
(5, 'Algeria'),
(6, 'American Samoa'),
(7, 'Andorra'),
(8, 'Angola'),
(9, 'Anguilla'),
(10, 'Antarctica'),
(11, 'Antigua and Barbuda'),
(12, 'Argentina'),
(13, 'Armenia'),
(14, 'Aruba'),
(15, 'Australia'),
(16, 'Austria'),
(17, 'Azerbaijan'),
(18, 'Bahamas'),
(19, 'Bahrain'),
(20, 'Bangladesh'),
(21, 'Barbados'),
(22, 'Belarus'),
(23, 'Belgium'),
(24, 'Belize'),
(25, 'Benin'),
(26, 'Bermuda'),
(27, 'Bhutan'),
(28, 'Bolivia'),
(29, 'Bosnia and Herzegovina'),
(30, 'Botswana'),
(31, 'Bouvet Island'),
(32, 'Brazil'),
(33, 'British Indian Ocean Territory'),
(34, 'Brunei Darussalam'),
(35, 'Bulgaria'),
(36, 'Burkina Faso'),
(37, 'Burundi'),
(38, 'Cambodia'),
(39, 'Cameroon'),
(40, 'Cape Verde'),
(41, 'Cayman Islands'),
(42, 'Central African Republic'),
(43, 'Chad'),
(44, 'Chile'),
(45, 'China'),
(46, 'Christmas Island'),
(47, 'Colombia'),
(48, 'Comoros'),
(49, 'Congo'),
(50, 'Congo, Democratic Republic of the'),
(51, 'Cook Islands'),
(52, 'Cote d''Ivoire'),
(53, 'Cuba'),
(54, 'Cyprus'),
(55, 'Czech Republic'),
(56, 'Denmark'),
(57, 'Djibouti'),
(58, 'Dominica'),
(59, 'Dominican Republic'),
(60, 'East Timor'),
(61, 'Ecuador'),
(62, 'Egypt'),
(63, 'El Salvador'),
(64, 'Equatorial Guinea'),
(65, 'Eritrea'),
(66, 'Estonia'),
(67, 'Ethiopia'),
(68, 'Falkland Islands'),
(69, 'Faroe Islands'),
(70, 'Fiji'),
(71, 'France'),
(72, 'French Polynesia'),
(73, 'French Southern Territories'),
(74, 'Gabon'),
(75, 'Gambia'),
(76, 'Georgia'),
(77, 'Germany'),
(78, 'Ghana'),
(79, 'Gibraltar'),
(80, 'Greece'),
(81, 'Greenland'),
(82, 'Grenada'),
(83, 'Guadeloupe'),
(84, 'Guam'),
(85, 'Guatemala'),
(86, 'Guinea'),
(87, 'Guinea-Bissau'),
(88, 'Guyana'),
(89, 'Haiti'),
(90, 'Heard Island and McDonald Islands'),
(91, 'Holy See'),
(92, 'Honduras'),
(93, 'Hong Kong'),
(94, 'Hungary'),
(95, 'Iceland'),
(96, 'India'),
(97, 'Indonesia'),
(98, 'Iran, Islamic Republic of'),
(99, 'Iraq'),
(100, 'Ireland'),
(101, 'Israel'),
(102, 'Italy'),
(103, 'Jamaica'),
(104, 'Japan'),
(105, 'Jordan'),
(106, 'Kazakstan'),
(107, 'Kenya'),
(108, 'Kiribati'),
(109, 'Korea, Democratic People''s Republic of'),
(110, 'Korea, Republic of'),
(111, 'Kuwait'),
(112, 'Kyrgyzstan'),
(113, 'Lao People''s Democratic Republic'),
(114, 'Latvia'),
(115, 'Lesotho'),
(116, 'Libyan Arab Jamahiriya'),
(117, 'Liechtenstein'),
(118, 'Lithuania'),
(119, 'Luxembourg'),
(120, 'Macau'),
(121, 'Macedonia, The Former Yugoslav Republic of'),
(122, 'Madagascar'),
(123, 'Malawi'),
(124, 'Malaysia'),
(125, 'Maldives'),
(126, 'Mali'),
(127, 'Malta'),
(128, 'Marshall Islands'),
(129, 'Martinique'),
(130, 'Mauritania'),
(131, 'Mauritius'),
(132, 'Mayotte'),
(133, 'Mexico'),
(134, 'Micronesia, Federated States of'),
(135, 'Moldova, Republic of'),
(136, 'Monaco'),
(137, 'Mongolia'),
(138, 'Montserrat'),
(139, 'Morocco'),
(140, 'Mozambique'),
(141, 'Myanmar'),
(142, 'Namibia'),
(143, 'Nauru'),
(144, 'Nepal'),
(145, 'Netherlands'),
(146, 'Netherlands Antilles'),
(147, 'New Caledonia'),
(148, 'New Zealand'),
(149, 'Nicaragua'),
(150, 'Niger'),
(151, 'Nigeria'),
(152, 'Niue'),
(153, 'Norfolk Island'),
(154, 'Northern Mariana Islands'),
(155, 'Norway'),
(156, 'Oman'),
(157, 'Pakistan'),
(158, 'Palau'),
(159, 'Palestinian Territory, Occupied'),
(160, 'PANAMA'),
(161, 'Papua New Guinea'),
(162, 'Paraguay'),
(163, 'Peru'),
(164, 'Philippines'),
(165, 'Pitcairn'),
(166, 'Poland'),
(167, 'Portugal'),
(168, 'Puerto Rico'),
(169, 'Qatar'),
(170, 'Reunion'),
(171, 'Romania'),
(172, 'Russian Federation'),
(173, 'Rwanda'),
(174, 'Saint Helena'),
(175, 'Saint Kitts and Nevis'),
(176, 'Saint Lucia'),
(177, 'Saint Pierre and Miquelon'),
(178, 'Saint Vincent and the Grenadines'),
(179, 'Samoa'),
(180, 'San Marino'),
(181, 'Sao Tome and Principe'),
(182, 'Saudi Arabia'),
(183, 'Senegal'),
(184, 'Seychelles'),
(185, 'Sierra Leone'),
(186, 'Singapore'),
(187, 'Slovakia'),
(188, 'Slovenia'),
(189, 'Solomon Islands'),
(190, 'Somalia'),
(191, 'South Africa'),
(192, 'South Georgia and the South Sandwich Islands'),
(193, 'Spain'),
(194, 'Sri Lanka'),
(195, 'Suriname'),
(196, 'Svalbard and Jan Mayen'),
(197, 'Swaziland'),
(198, 'Sweden'),
(199, 'Switzerland'),
(200, 'Syrian Arab Republic'),
(201, 'Taiwan, Province of China'),
(202, 'Tajikistan'),
(203, 'Tanzania, United Republic of'),
(204, 'Thailand'),
(205, 'Togo'),
(206, 'Tokelau'),
(207, 'Tonga'),
(208, 'Trinidad and Tobago'),
(209, 'Tunisia'),
(210, 'Turkey'),
(211, 'Turkmenistan'),
(212, 'Turks and Caicos Islands'),
(213, 'Tuvalu'),
(214, 'Uganda'),
(215, 'Ukraine'),
(216, 'United Arab Emirates'),
(217, 'United Kingdom'),
(218, 'United States Minor Outlying Islands'),
(219, 'Uruguay'),
(220, 'Uzbekistan'),
(221, 'Vanuatu'),
(222, 'Venezuela'),
(223, 'Viet Nam'),
(224, 'Virgin Islands, British'),
(225, 'Virgin Islands, U.S.'),
(226, 'Wallis and Futuna'),
(227, 'Western Sahara'),
(228, 'Yemen'),
(229, 'Yugoslavia'),
(230, 'Zambia'),
(231, 'Zimbabwe'),
(232, 'Finland');

-- --------------------------------------------------------

--
-- Table structure for table `code_download_module`
--

CREATE TABLE IF NOT EXISTS `code_download_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `public` int(1) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `code_download_module`
--


-- --------------------------------------------------------

--
-- Table structure for table `code_download_module_entry`
--

CREATE TABLE IF NOT EXISTS `code_download_module_entry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section_id` int(11) NOT NULL,
  `file` varchar(255) NOT NULL,
  `content_type` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `order_no` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=67 ;

--
-- Dumping data for table `code_download_module_entry`
--


-- --------------------------------------------------------

--
-- Table structure for table `code_dropdown`
--

CREATE TABLE IF NOT EXISTS `code_dropdown` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `description` text COLLATE utf8_bin NOT NULL,
  `order_id` int(11) NOT NULL DEFAULT '0',
  `created` int(11) NOT NULL DEFAULT '0',
  `updated` int(11) NOT NULL DEFAULT '0',
  `keyword` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `seo_url` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=7 ;

--
-- Dumping data for table `code_dropdown`
--

INSERT INTO `code_dropdown` (`id`, `parent_id`, `title`, `description`, `order_id`, `created`, `updated`, `keyword`, `seo_url`) VALUES
(2, 0, 'How did you hear about us?', '', 2, 1254916614, 1254916614, '', ''),
(3, 2, 'Web search', '', 1, 1254916623, 1254916623, '', ''),
(4, 2, 'Friends', '', 2, 1254916632, 1282714644, '', ''),
(5, 2, 'Advertisement', '', 3, 1254916660, 1282714644, '', ''),
(6, 2, 'Other', '', 4, 1254916668, 1254916668, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `code_email`
--

CREATE TABLE IF NOT EXISTS `code_email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_name` varchar(255) NOT NULL DEFAULT '',
  `from_email` varchar(255) NOT NULL DEFAULT '',
  `admin_email` varchar(255) NOT NULL DEFAULT '',
  `created` int(11) NOT NULL DEFAULT '0',
  `updated` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `code_email`
--

INSERT INTO `code_email` (`id`, `from_name`, `from_email`, `admin_email`, `created`, `updated`) VALUES
(1, 'PM Studio', 'admin@quantumweb.com.au', 'admin@quantumweb.com.au', 0, 1235104549);

-- --------------------------------------------------------

--
-- Table structure for table `code_faq_module`
--

CREATE TABLE IF NOT EXISTS `code_faq_module` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `updated` int(10) unsigned NOT NULL DEFAULT '0',
  `user_questions` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Dumping data for table `code_faq_module`
--


-- --------------------------------------------------------

--
-- Table structure for table `code_faq_module_entry`
--

CREATE TABLE IF NOT EXISTS `code_faq_module_entry` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `content` text COLLATE utf8_bin NOT NULL,
  `faq_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `updated` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `faq_id` (`faq_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Dumping data for table `code_faq_module_entry`
--


-- --------------------------------------------------------

--
-- Table structure for table `code_faq_module_mass_entry`
--

CREATE TABLE IF NOT EXISTS `code_faq_module_mass_entry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `faq_entry_id` int(11) NOT NULL,
  `publish` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `notice` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=55 ;

--
-- Dumping data for table `code_faq_module_mass_entry`
--


-- --------------------------------------------------------

--
-- Table structure for table `code_gallery_module`
--

CREATE TABLE IF NOT EXISTS `code_gallery_module` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `updated` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `items_per_page` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Dumping data for table `code_gallery_module`
--


-- --------------------------------------------------------

--
-- Table structure for table `code_gallery_module_picture`
--

CREATE TABLE IF NOT EXISTS `code_gallery_module_picture` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `updated` int(10) unsigned NOT NULL DEFAULT '0',
  `gallery_id` int(10) unsigned NOT NULL DEFAULT '0',
  `order_no` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `description` text COLLATE utf8_bin NOT NULL,
  `pic1` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `pic2` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `status` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=10 ;

--
-- Dumping data for table `code_gallery_module_picture`
--


-- --------------------------------------------------------

--
-- Table structure for table `code_gallery_one_module`
--

CREATE TABLE IF NOT EXISTS `code_gallery_one_module` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `updated` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `items_per_page` int(10) unsigned NOT NULL DEFAULT '0',
  `width` int(11) NOT NULL DEFAULT '0',
  `height` int(11) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL DEFAULT '0',
  `color` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;

--
-- Dumping data for table `code_gallery_one_module`
--

INSERT INTO `code_gallery_one_module` (`id`, `created`, `updated`, `name`, `items_per_page`, `width`, `height`, `type`, `color`) VALUES
(2, 1321194552, 1331540314, 'Галерея', 20, 0, 0, 0, ''),
(4, 1331540320, 1331540320, 'Вторая галерея', 5, 0, 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `code_gallery_one_module_picture`
--

CREATE TABLE IF NOT EXISTS `code_gallery_one_module_picture` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `updated` int(10) unsigned NOT NULL DEFAULT '0',
  `gallery_id` int(10) unsigned NOT NULL DEFAULT '0',
  `order_no` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `description` text COLLATE utf8_bin NOT NULL,
  `pic1` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `status` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=12 ;

--
-- Dumping data for table `code_gallery_one_module_picture`
--

INSERT INTO `code_gallery_one_module_picture` (`id`, `created`, `updated`, `gallery_id`, `order_no`, `name`, `description`, `pic1`, `status`) VALUES
(9, 1326358889, 1326358889, 2, 1, 'утренник', 0xd182d0b8d180d0bed180d0b3d180, 'DSCN0577.JPG', 1),
(11, 1327552347, 1327552347, 2, 1, 'аап', 0xd181d0b0d0b8, 'DSCN1559.JPG', 1);

-- --------------------------------------------------------

--
-- Table structure for table `code_gallery_portfolio_module`
--

CREATE TABLE IF NOT EXISTS `code_gallery_portfolio_module` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `updated` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `items_per_page` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Dumping data for table `code_gallery_portfolio_module`
--


-- --------------------------------------------------------

--
-- Table structure for table `code_gallery_portfolio_module_picture`
--

CREATE TABLE IF NOT EXISTS `code_gallery_portfolio_module_picture` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `updated` int(10) unsigned NOT NULL DEFAULT '0',
  `gallery_id` int(10) unsigned NOT NULL DEFAULT '0',
  `order_no` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `description` text COLLATE utf8_bin NOT NULL,
  `pic1` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `pic2` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `status` int(10) unsigned NOT NULL DEFAULT '1',
  `elements` varchar(256) COLLATE utf8_bin DEFAULT NULL,
  `url` varchar(256) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Dumping data for table `code_gallery_portfolio_module_picture`
--


-- --------------------------------------------------------

--
-- Table structure for table `code_googlemap_module`
--

CREATE TABLE IF NOT EXISTS `code_googlemap_module` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `updated` int(10) unsigned NOT NULL DEFAULT '0',
  `google_key` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `location` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Dumping data for table `code_googlemap_module`
--

INSERT INTO `code_googlemap_module` (`id`, `created`, `updated`, `google_key`, `location`) VALUES
(1, 1257752919, 1294629995, 'ABQIAAAAy2uVLlWmX3ynpW24cuywnBTraJQieFUeQs1CqHJAXUofEu1xcBRAgAB0-GuuuUjXDmjTTckZNhk72w', '7/12 Rickard Road, Narrabeen, NSW 2101');

-- --------------------------------------------------------

--
-- Table structure for table `code_guestbook_answers`
--

CREATE TABLE IF NOT EXISTS `code_guestbook_answers` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `post_id` int(10) NOT NULL,
  `answer` text NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `code_guestbook_answers`
--


-- --------------------------------------------------------

--
-- Table structure for table `code_guestbook_posts`
--

CREATE TABLE IF NOT EXISTS `code_guestbook_posts` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `post` text NOT NULL,
  `author` varchar(255) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `code_guestbook_posts`
--


-- --------------------------------------------------------

--
-- Table structure for table `code_header_image`
--

CREATE TABLE IF NOT EXISTS `code_header_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=67 ;

--
-- Dumping data for table `code_header_image`
--


-- --------------------------------------------------------

--
-- Table structure for table `code_heart`
--

CREATE TABLE IF NOT EXISTS `code_heart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `heart` text NOT NULL,
  `created` int(11) NOT NULL DEFAULT '0',
  `updated` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `code_heart`
--

INSERT INTO `code_heart` (`id`, `heart`, `created`, `updated`) VALUES
(1, '', 1248869871, 1248870461);

-- --------------------------------------------------------

--
-- Table structure for table `code_menu`
--

CREATE TABLE IF NOT EXISTS `code_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` int(11) NOT NULL DEFAULT '0',
  `updated` int(11) NOT NULL DEFAULT '0',
  `parent_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `deleted` int(1) DEFAULT NULL,
  `page_title` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `keywords` text COLLATE utf8_bin NOT NULL,
  `page_description` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `seo_url` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `published` int(10) unsigned NOT NULL DEFAULT '0',
  `active` int(10) unsigned NOT NULL DEFAULT '1',
  `google_priority` varchar(3) COLLATE utf8_bin NOT NULL DEFAULT '',
  `access` varchar(255) COLLATE utf8_bin NOT NULL,
  `header_image` varchar(255) COLLATE utf8_bin NOT NULL,
  `created_user_id` varchar(255) COLLATE utf8_bin NOT NULL,
  `updated_user_id` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=25 ;

--
-- Dumping data for table `code_menu`
--

INSERT INTO `code_menu` (`id`, `created`, `updated`, `parent_id`, `title`, `order_id`, `deleted`, `page_title`, `keywords`, `page_description`, `seo_url`, `published`, `active`, `google_priority`, `access`, `header_image`, `created_user_id`, `updated_user_id`) VALUES
(1, 0, 1326346108, 0, 'Главная', 0, NULL, 'Одевайка', '', '', 'index', 1, 1, '1', '', '', '', '1'),
(12, 1326283784, 1331543541, 1, 'Новости', 1, NULL, '', '', '', 'News', 1, 1, '0.1', '', '', '1', '1'),
(13, 1326283951, 1326426748, 1, 'Статьи', 2, NULL, 'Статьи', '', '', 'Article', 1, 1, '0.1', '', '', '1', '1'),
(15, 1326346544, 1326359762, 1, 'Контакты', 4, NULL, 'Контакты', '', '', 'Contacts', 1, 1, '0.1', '', '', '1', '1'),
(16, 1326346702, 1326352520, 1, 'О нас', 5, NULL, 'О нас', '', '', 'About', 1, 1, '0.1', '', '', '1', '1'),
(17, 1326346943, 1326359881, 1, 'Приём на комиссию', 6, NULL, 'Приём на комиссию', '', '', 'Comission-rules', 1, 1, '0.1', '', '', '1', '1'),
(18, 1326347052, 1326347052, 1, 'Оплата и доставка', 7, NULL, 'Оплата', '', '', 'Payment', 1, 1, '0.1', '', '', '1', '1'),
(19, 1326347272, 1326353887, 1, 'Сток', 8, NULL, 'Сток', '', '', 'Stock', 1, 1, '0.1', '', '', '1', '1'),
(20, 1326347325, 1326347325, 19, 'Diamantina', 1, NULL, 'Diamantina', '', '', 'Diamantina', 1, 1, '0.1', '', '', '1', '1'),
(21, 1326347354, 1326358421, 19, 'Street Gang', 2, NULL, 'Street Gang', '', '', 'Street-Gang', 1, 1, '0.1', '', '', '1', '1'),
(22, 1326347384, 1326358444, 19, 'To Be Too', 3, NULL, 'To Be Too', '', '', 'To-Be-Too', 1, 1, '0.1', '', '', '1', '1'),
(23, 1326347490, 1326358473, 19, 'FUN&FUN girl', 4, NULL, 'FUN&FUN girl', '', '', 'FUNandFUN-girl', 1, 1, '0.1', '', '', '1', '1'),
(24, 1328595085, 1328595195, 1, 'Акции', 9, NULL, 'Акции', '', '', 'Campaign', 1, 1, '0.1', '', '', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `code_menu_attribute`
--

CREATE TABLE IF NOT EXISTS `code_menu_attribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` int(11) NOT NULL DEFAULT '0',
  `updated` int(11) NOT NULL DEFAULT '0',
  `content` text COLLATE utf8_bin,
  `page_type` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `menu_id` int(10) unsigned NOT NULL DEFAULT '0',
  `template` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menu_id`),
  KEY `menu_id_2` (`menu_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=25 ;

--
-- Dumping data for table `code_menu_attribute`
--

INSERT INTO `code_menu_attribute` (`id`, `created`, `updated`, `content`, `page_type`, `menu_id`, `template`) VALUES
(1, 0, 1326346108, 0x3c68313ed094d0bed0b1d180d0be20d0bfd0bed0b6d0b0d0bbd0bed0b2d0b0d182d18c20d0bdd0b020d181d0b0d0b9d18220d0b4d0b5d182d181d0bad0bed0b9266e6273703b20d0bad0bed0bcd0b8d181d181d0b8d0bed0bdd0bdd0bed0b920d0b8266e6273703b20d0bed0b4d0b5d0b6d0b4d18b2022d181d182d0bed0ba22266e6273703b266e6273703b20266c6171756f3bd09cd0bed0b4d0bdd18bd0b920d180d0b5d0b1d0b5d0bdd0bed0ba26726171756f3b213c2f68313e0a3c703e266e6273703b3c2f703e0a3c703ed0a320d0bdd0b0d18120d0b2d18b20d0bcd0bed0b6d0b5d182d0b520d0bdd0b0d0b9d182d0b820d0b1d0bed0bbd18cd188d0bed0b920d0b2d18bd0b1d0bed18020d0b4d0b5d182d181d0bad0bed0b920d0bed0b4d0b5d0b6d0b4d18b266e6273703b266e6273703b20d0b4d0bbd18f20d092d0b0d188d0b8d18520d0b4d0b5d182d0bed0ba20d0bed182203020d0b4d0be20313620d0bbd0b5d1822e3c2f703e0a3c703ed090d181d181d0bed180d182d0b8d0bcd0b5d0bdd18220d182d0bed0b2d0b0d180d0bed0b2266e6273703b20d181d184d0bed180d0bcd0b8d180d0bed0b2d0b0d0bd20d18120d183d187d191d182d0bed0bc20d0bfd0bed182d180d0b5d0b1d0bdd0bed181d182d0b5d0b92c266e6273703b20d0bcd0b0d182d0b5d180d0b8d0b0d0bbd18cd0bdd18bd18520d0b2d0bed0b7d0bcd0bed0b6d0bdd0bed181d182d0b5d0b920d0b820d0bfd180d0b5d0b4d0bfd0bed187d182d0b5d0bdd0b8d0b920d181d0bed0b2d180d0b5d0bcd0b5d0bdd0bdd18bd18520d180d0bed0b4d0b8d182d0b5d0bbd0b5d0b92e3c2f703e0a3c703ed09dd0b0d18820d0bad0bed0bcd0b8d181d181d0b8d0bed0bdd0bdd18bd0b920d0bcd0b0d0b3d0b0d0b7d0b8d0bd20d0b4d0b5d182d181d0bad0b8d18520d182d0bed0b2d0b0d180d0bed0b220d0b1d183d0b4d0b5d18220d0b8d0b4d0b5d0b0d0bbd18cd0bdd18bd0bc20d180d0b5d188d0b5d0bdd0b8d0b5d0bc20d0b4d0bbd18f20d182d0b5d18520d180d0bed0b4d0b8d182d0b5d0bbd0b5d0b92c20d0bad0bed182d0bed180d18bd0bc20d0bdd0b5d0bed0b1d185d0bed0b4d0b8d0bcd0be20d181d180d0bed187d0bdd0be20d0bad183d0bfd0b8d182d18c20d0b1d0bed0bbd18cd188d0bed0b520d0bad0bed0bbd0b8d187d0b5d181d182d0b2d0be20d0bed0b4d0b5d0b6d0b4d18b2e3c2f703e0a3c703ed09dd0b0d188d0b820d0b4d0b5d182d0b820d180d0b0d181d182d183d18220d0bed187d0b5d0bdd18c20d0b1d18bd181d182d180d0be2c20d0bdd0b520d183d181d0bfd0b5d0b5d182d0b520d0bed0b3d0bbd18fd0bdd183d182d18cd181d18f20d0b820d0bcd0bdd0bed0b3d0b8d0b520d0b2d0b5d189d0b820d181d182d0b0d0bdd0bed0b2d18fd182d181d18f20d0bcd0b0d0bbd18b20d0b8d0bbd0b820d0bdd0b520d0bdd183d0b6d0bdd18b20d092d0b0d188d0b5d0bcd18320d180d0b5d0b1d0b5d0bdd0bad1832e20d092d18bd0b1d180d0b0d181d18bd0b2d0b0d182d18c20d0bfd180d0b0d0bad182d0b8d187d0b5d181d0bad0b820d0bdd0bed0b2d18bd0b520d0b2d0b0d189d0b820d0bcd0bdd0bed0b3d0b8d0b520d0bcd0b0d0bcd18b20d0bdd0b520d180d0b5d188d0b0d18ed182d181d18f20d0b820d0bfd0bed18dd182d0bed0bcd18320d0bed182d0bad0bbd0b0d0b4d18bd0b2d0b0d18ed18220d0b8d18520d0bdd0b02022d0b4d0bed0bbd0b3d0bed0b520d185d180d0b0d0bdd0b5d0bdd0b8d0b5222e20d094d180d183d0b3d0b8d0b520d0b6d0b520d0bfd18bd182d0b0d18ed182d181d18f20d181d0b0d0bcd0b820d0bfd0bed0bfd180d0bed0b1d0bed0b2d0b0d182d18c20d0bfd180d0bed0b4d0b0d0b2d0b0d182d18c20d0b8d0b3d180d183d188d0bad0b820d0b820d0b4d0b5d182d181d0bad183d18e20d0bed0b4d0b5d0b6d0b4d18320d0bfd0be20d0bed0b1d18ad18fd0b2d0bbd0b5d0bdd0b8d18fd0bc2c20d0b220d0b3d0b0d0b7d0b5d182d0b0d18520d0b8d0bbd0b820d098d0bdd182d0b5d180d0bdd0b5d182d0b52c20d0bdd0be20d0bdd0b020d18dd182d0be20d0bdd183d0b6d0bdd0be20d0bcd0bdd0bed0b3d0be20d0b2d180d0b5d0bcd0b5d0bdd0b820d0b820d0b6d0b5d0bbd0b0d0bdd0b8d18f2e20d092d0b5d0b4d18c20d0bfd180d0b8d0b3d0bed182d0bed0b2d18cd182d0b5d181d18c20d0bed182d0b2d0b5d187d0b0d182d18c20d0bdd0b020d0bfd183d181d182d18bd0b520d0bcd0bdd0bed0b3d0bed187d0b8d181d0bbd0b5d0bdd0bdd18bd0b520d0b7d0b2d0bed0bdd0bad0b82c20d0bad0b0d0b6d0b4d0bed0bcd18320d180d0b0d181d181d0bad0b0d0b7d18bd0b2d0b0d182d18c20d0be20d181d0b2d0bed0b8d18520d0b2d0b5d189d0b0d1852c20d0bad0b0d0b6d0b4d18bd0b920d180d0b0d0b720d0b4d0bed0b3d0bed0b2d0b0d180d0b8d0b2d0b0d182d18cd181d18f20d0be20d0b2d181d182d180d0b5d187d0b520d0b820d1822e20d0bf2e20d093d0bed180d0b0d0b7d0b4d0be20d0b2d18bd0b3d0bed0b4d0bdd0b5d0b520d0b820d183d0b4d0bed0b1d0bdd0b5d0b520d0b1d183d0b4d0b5d18220d0bed0b1d180d0b0d182d0b8d182d18cd181d18f20d0b220d0bad0bed0bcd0b8d181d181d0b8d0bed0bdd0bdd18bd0b920d0bcd0b0d0b3d0b0d0b7d0b8d0bd20d0b4d0b5d182d181d0bad0b8d18520d182d0bed0b2d0b0d180d0bed0b22e20d09220d0bdd0b0d188d0b5d0b920d181d182d180d0b0d0bdd0b520d0b4d0bed0bbd0b3d0bed0b520d0b2d180d0b5d0bcd18f20d0bed187d0b5d0bdd18c20d183d181d0bfd0b5d188d0bdd0be20d180d0b0d0b1d0bed182d0b0d0bbd0b820d181d0b0d0bcd18bd0b520d180d0b0d0b7d0bbd0b8d187d0bdd18bd0b520d0bad0bed0bcd0b8d181d181d0b8d0bed0bdd0bad0b82c20d0b2d0b5d0b4d18c20d0b1d0bed0bbd18cd188d0b8d0bdd181d182d0b2d0be20d0b2d0b5d189d0b5d0b92028d0b4d0b5d182d181d0bad0b8d0b520d0bad180d0bed0b2d0b0d182d0bad0b820d0b8d0bbd0b820d0bad0b0d0bad183d18e2dd182d0be20d0b1d18bd182d0bed0b2d183d18e20d182d0b5d185d0bdd0b8d0bad1832920d0b1d18bd0bbd0be20d181d0bbd0bed0b6d0bdd0be20d0bfd180d0b8d0bed0b1d180d0b5d181d182d0b82e3c2f703e0a3c703ed09dd0b020d181d0b5d0b3d0bed0b4d0bdd18fd188d0bdd0b8d0b920d0b4d0b5d0bdd18c20d0bfd180d0bed0b1d0bbd0b5d0bcd0b020d0b2d18bd0b1d0bed180d0b020d0bad0b0d0bad0b8d1852dd0bbd0b8d0b1d0be20d182d0bed0b2d0b0d180d0bed0b22c20d0b220d0bed0b1d189d0b5d0bc2dd182d0be20d0bdd0b5d1822c20d0bdd0be20d0bad183d0bfd0b8d182d18c20d0b4d0b5d0b9d181d182d0b2d0b8d182d0b5d0bbd18cd0bdd0be20d185d0bed180d0bed188d183d18e20d0b2d0b5d189d18c20d0bcd0bed0b3d183d18220d0bfd0bed0b7d0b2d0bed0bbd0b8d182d18c20d0bad183d0bfd0b8d182d18c20d0bdd0b5d0bcd0bdd0bed0b3d0b8d0b520d0bcd0bed0bbd0bed0b4d18bd0b520d180d0bed0b4d0b8d182d0b5d0bbd0b82e20d09fd180d0b8d0bed0b1d180d0b5d182d0b5d0bdd0b8d0b520d0b4d0b0d0b6d0b520d0b4d0b5d182d181d0bad0bed0b920d0bed0b4d0b5d0b6d0b4d18b20d0bcd0bed0b6d0b5d18220d0bdd0b0d0bdd0b5d181d182d0b820d0b1d0bed0bbd18cd188d0bed0b920d183d0b4d0b0d18020d0bfd0be2022d0bad0b0d180d0bcd0b0d0bdd183222c20d187d182d0be20d183d0b620d0b3d0bed0b2d0bed180d0b8d182d18c20d0be20d0b1d180d0b5d0bdd0b4d0bed0b2d18bd18520d0b2d0b5d189d0b0d18520d0b4d0bbd18f20d0bcd0b0d0bbd18bd188d0b5d0b92e20d0a1d182d0bed0b8d18220d0bbd0b820d0b7d0b0d0bdd0b8d0bcd0b0d182d18cd181d18f20d0bfd0bed0bad183d0bfd0bad0bed0b920d0bdd0bed0b2d18bd18520d0b2d0b5d189d0b5d0b920d0b4d0bbd18f20d0bcd0b0d0bbd18bd188d0b02c20d187d182d0bed0b120d187d0b5d180d0b5d0b720d0bdd0b5d181d0bad0bed0bbd18cd0bad0be20d0bcd0b5d181d18fd186d0b5d0b220d181d0bdd0bed0b2d0b020d0bfd180d0b8d185d0bed0b4d0b8d182d18c20d0b220d0bcd0b0d0b3d0b0d0b7d0b8d0bd20d0b7d0b020d0b8d0b3d180d183d188d0bad0b0d0bcd0b82c20d0bed0b4d0b5d0b6d0b4d0bed0b920d0b4d0bbd18f20d181d0b2d0bed0b5d0b3d0be20d0bbd18ed0b1d0b8d0bcd0bed0b3d0be20d0b4d0b8d182d18f3f3c2f703e0a3c703ed094d0b5d182d181d0bad0b8d0b920d0bad0bed0bcd0b8d181d181d0b8d0bed0bdd0bdd18bd0b920d0bcd0b0d0b3d0b0d0b7d0b8d0bd20d18fd0b2d0bbd18fd0b5d182d181d18f20d0bed0bfd182d0b8d0bcd0b0d0bbd18cd0bdd18bd0bc20d181d0bfd0bed181d0bed0b1d0bed0bc20d0bed189d183d182d0b8d0bcd0be20d181d0bdd0b8d0b7d0b8d182d18c20d180d0b0d181d185d0bed0b4d18b20d0ba20d0bcd0b8d0bdd0b8d0bcd183d0bcd1832e20d0a1d0bcd18bd181d0bb20d0bfd0bbd0b0d182d0b8d182d18c20d0b1d0bed0bbd18cd188d0b52c20d0bad0bed0b3d0b4d0b020d0bcd0bed0b6d0bdd0be20d18320d0bdd0b0d18120d0bfd180d0b8d0bed0b1d180d0b5d182d0b0d182d18c20d0bad0b0d187d0b5d181d182d0b2d0b5d0bdd0bdd18bd0b520d185d0bed180d0bed188d0b8d0b520d0b2d0b5d189d0b820d0bfd0be20d181d0bcd0b5d185d0bed182d0b2d0bed180d0bdd18bd0bc20d186d0b5d0bdd0b0d0bc3f3c2f703e0a3c703ed092d18b20d181d0bcd0bed0b6d0b5d182d0b520d0bfd0bed181d182d0bed18fd0bdd0bdd0be20d0bfd0bed0bfd0bed0bbd0bdd18fd182d18c20d0b4d0b5d182d181d0bad0b8d0b920d0b3d0b0d180d0b4d0b5d180d0bed0b120d0b820d0bfd180d0b820d18dd182d0bed0bc20d181d18dd0bad0bed0bdd0bed0bcd0b8d182d18c20d181d180d0b5d0b4d181d182d0b2d0b020d0bdd0b020d0bfd0bed0bad183d0bfd0bad18320d0b1d0bed0bbd0b5d0b520d187d0b5d0b3d0be2dd182d0be20d0b2d0b0d0b6d0bdd0bed0b3d0be2e20d0a1d0bbd0b8d188d0bad0bed0bc20d187d0b0d181d182d0be20d181d0b5d0bcd0b5d0b9d0bdd18bd0b520d0bfd0b0d180d18b20d0bdd0b520d185d0bed0b4d18fd18220d0b220d182d0b0d0bad0b8d0b520d0bcd0b0d0b3d0b0d0b7d0b8d0bdd18b2e20d09ed0bdd0b820d0b4d183d0bcd0b0d18ed1822c20d187d182d0be20d18120d181d0bed0b2d0b5d182d181d0bad0b8d18520d0b2d180d0b5d0bcd0b5d0bd20d182d0b0d0bc20d0bdd0b5d0bcd0bdd0bed0b3d0be20d187d182d0be20d0b8d0b7d0bcd0b5d0bdd0b8d0bbd0bed181d18c2c20d0bdd0be20d0bcd18b20d181d0bcd0bed0b6d0b5d0bc20d183d0b1d0b5d0b4d0b8d182d18c20d0b820d0b8d18520d181d0bed0b2d0b5d180d188d0b5d0bdd0bdd0be20d0b220d0bed0b1d180d0b0d182d0bdd0bed0bc2120d09fd0bed182d0bed0bcd18320d187d182d0be2c20d0b1d0bed0bbd18cd188d0bed0b920d0b0d181d181d0bed180d182d0b8d0bcd0b5d0bdd18220d0bcd0b0d0b3d0b0d0b7d0b8d0bdd0b020d0b4d0b5d182d181d0bad0b8d18520d182d0bed0b2d0b0d180d0bed0b220d092d0b0d18120d0bed0b1d18fd0b7d0b0d182d0b5d0bbd18cd0bdd0be20d0bdd0b520d0b7d0b0d181d182d0b0d0b2d0b8d18220d0b1d18bd182d18c20d180d0b0d0b2d0bdd0bed0b4d183d188d0bdd18bd0bc2e20d092d0b5d0b4d18c20d18320d0bdd0b0d18120d0b5d181d182d18c20d0bfd180d0b0d0bad182d0b8d187d0b5d181d0bad0b820d0b2d181d0b521212120d09dd0b0d187d0b8d0bdd0b0d18f20d18120d0bfd0b5d0bbd0b5d0bdd0bed0ba20d0b820d0b7d0b0d0bad0b0d0bdd187d0b8d0b2d0b0d18f20d0bad0b0d187d0b5d181d182d0b2d0b5d0bdd0bdd0bed0b920d0b1d180d18dd0bdd0b4d0bed0b2d0bed0b920d0bed0b4d0b5d0b6d0b4d0bed0b92e20d09dd0b5d0bcd0b0d0bbd0bed0b2d0b0d0b6d0bdd0be2c20d187d182d0be20d092d0b0d0bc20d0bdd0b520d0bfd180d0b8d0b4d0b5d182d181d18f20d0b4d0bed0bbd0b3d0be20d0b8d181d0bad0b0d182d18c20d0bdd0b5d0bed0b1d185d0bed0b4d0b8d0bcd18bd0b520d0b4d0b5d182d181d0bad0b8d0b520d0b2d0b5d189d0b820d0b220d180d0b0d0b7d0bdd0bed0bed0b1d180d0b0d0b7d0bdd18bd18520d182d0bed180d0b3d0bed0b2d18bd18520d186d0b5d0bdd182d180d0b0d1852e20d09220d0b4d0b5d182d181d0bad0bed0bc20d0bad0bed0bcd0b8d181d181d0b8d0bed0bdd0bdd0bed0bc20d0bcd0b0d0b3d0b0d0b7d0b8d0bdd0b520d092d18b20d181d0bcd0bed0b6d0b5d182d0b520d0bfd180d0b8d0bed0b1d180d0b5d181d182d0b820d0b2d181d0b52c20d187d182d0be20d0b4d183d188d0b520d183d0b3d0bed0b4d0bdd0be2c20d0b820d18dd182d0be20d0bfd0be20d0bed187d0b5d0bdd18c20d181d0bad180d0bed0bcd0bdd18bd0bc20d186d0b5d0bdd0b0d0bc2120d09ed0b7d0bdd0b0d0bad0bed0bcd0b8d182d18cd181d18f20d18120d186d0b5d0bdd0b0d0bcd0b820d0bad0bed0bcd0b8d181d181d0b8d0bed0bdd0bdd0bed0b3d0be20d0bcd0b0d0b3d0b0d0b7d0b8d0bdd0b020d0bcd0bed0b6d0bdd0be20d0b220d0bad0b0d182d0b0d0bbd0bed0b3d0b520d182d0bed0b2d0b0d180d0bed0b22e3c2f703e0a3c703ed094d0b5d182d181d0bad0b0d18f20d0bad0bed0bcd0b8d181d181d0b8d0bed0bdd0bad0b020d0b1d183d0b4d0b5d18220d0bfd0bed0bbd0b5d0b7d0bdd0b020d0b820d182d0b5d0bc2c20d187d182d0be20d185d0bed187d0b5d18220d0b8d0b7d0b1d0b0d0b2d0b8d182d18cd181d18f20d0bed18220d0bdd0b5d0bdd183d0b6d0bdd18bd18520d0b4d0b5d182d181d0bad0b8d18520d0b2d0b5d189d0b5d0b920d0bdd0b520d0b220d183d189d0b5d180d0b120d181d0bed0b1d181d182d0b2d0b5d0bdd0bdd0bed0bcd18320d0b1d18ed0b4d0b6d0b5d182d1832e20d09fd09ed097d092d09ed09dd098d0a2d09520d09dd090d09c2120d09820d0bcd18b266e6273703b20d0bfd0bed0b4d180d0bed0b1d0bdd0be20d0bed0b1d18ad18fd181d0bdd0b8d0bc20d0bfd0be20d0bfd0bed0b2d0bed0b4d18320d0bfd0bed0bfd0bed0bbd0bdd0b5d0bdd0b8d18f20d092d0b0d188d0b5d0b3d0be20d0bad0bed188d0b5d0bbd18cd0bad0b020d0b4d0b5d0bdd18cd0b3d0b0d0bcd0b82c20d0b7d0b020d183d0b6d0b520d181d182d0b0d0b2d188d0b8d0b520d0bcd0b0d0bbd18bd0bcd0b820d0b2d0b5d189d0b8d187d0bad0b820d0b2d0b0d188d0b5d0b3d0be20d180d0b5d0b1d0b5d0bdd0bad0b02e3c2f703e0a3c703ed09dd0b0d18820d0bad0bed0bcd0b8d181d181d0b8d0bed0bdd0bdd18bd0b920d0bcd0b0d0b3d0b0d0b7d0b8d0bd20d0b4d0b5d182d181d0bad0b8d18520d182d0bed0b2d0b0d180d0bed0b220d0b7d0b0d0bdd0b8d0bcd0b0d0b5d182d181d18f20d0bfd180d0bed0b4d0b0d0b6d0b5d0b920d0b820d0bfd180d0b8d0b5d0bcd0bed0bc20d0b2d0b5d189d0b5d0b920d0b220d0bed182d0bbd0b8d187d0bdd0bed0bc20d181d0bed181d182d0bed18fd0bdd0b8d0b820d0bfd0be20d181d0bcd0b5d188d0bdd18bd0bc20d186d0b5d0bdd0b0d0bc213c2f703e0a3c703e22d09cd0bed0b4d0bdd18bd0b920d180d0b5d0b1d0b5d0bdd0bed0ba22266e6273703b20d0b2d181d0b5d0b3d0b4d0b020d180d0b0d0b420d092d0b0d0bc213c2f703e0a3c703ed09dd0b0d18820d0b4d0b5d0b2d0b8d0b7202d2022d09cd0bed0b4d0bdd18bd0b920d180d0b5d0b1d0b5d0bdd0bed0ba2dd0b4d0bed0b2d0bed0bbd18cd0bdd0b0d18f20d0bcd0b0d0bcd0b021223c2f703e, 'Simple_Page', 1, ''),
(12, 1326283784, 1331543541, 0x3c703e5b6e6577735f6d6f64756c653f73656374696f6e3d375d3c2f703e, NULL, 12, ''),
(13, 1326283951, 1326426748, 0x3c6469763e5b6e6577735f6d6f64756c653f73656374696f6e3d375d3c2f6469763e, NULL, 13, ''),
(15, 1326346544, 1326359762, 0x3c68313ed098d0bdd182d0b5d180d0bdd0b5d1822dd181d0b0d0b9d1822022d09cd0bed0b4d0bdd18bd0b920d180d0b5d0b1d0b5d0bdd0bed0ba22266e6273703b3c2f68313e0a3c68313e266e6273703b3c2f68313e0a3c703ed090d0b4d180d0b5d1813a20d0a3d187d0b5d0b1d0bdd0b0d18f203337d0b03c2f703e0a3c703e3c696d67207372633d22696d616765732f736368656d652e706e672220616c743d22222077696474683d2233393922206865696768743d2233323122202f3e3c2f703e0a3c703ed0a2d0b5d0bb2e2034312d39392d363920d0a1d0bed1822e20382d3932332d3430322d32332d37343c2f703e0a3c703e452d6d61696c3a203c6120687265663d226d61696c746f3a6d6f64726562656e6f6b407369626d61696c2e636f6d223e6d6f64726562656e6f6b407369626d61696c2e636f6d3c2f613e3c2f703e, NULL, 15, ''),
(16, 1326346702, 1326352520, 0x3c68313ed09e20d0bdd0b0d1813c2f68313e0a3c703ed09dd0b0d18820d0b8d0bdd182d0b5d180d0bdd0b5d1822dd181d0b0d0b9d18220d0bfd180d0b5d0b4d181d182d0b0d0b2d0bbd0b5d0bd266e6273703b20d0bcd0b0d0b3d0b0d0b7d0b8d0bdd0bed0bc20d0b220d0b32ed0a2d0bed0bcd181d0bad0b52022d09cd0bed0b4d0bdd18bd0b920d180d0b5d0b1d0b5d0bdd0bed0ba222c20d180d0b0d181d0bfd0bed0bbd0bed0b6d0b5d0bdd0bdd18bd0b920d0bfd0be20d0b0d0b4d180d0b5d181d18320d183d0bb2e20d0a3d187d0b5d0b1d0bdd0b0d18f203337d0b03c2f703e0a3c703ed09220d0bdd0b0d188d0b5d0bc20d0b0d181d181d0bed180d182d0b8d0bcd0b5d0bdd182d0b520d0bfd180d0b5d0b4d181d182d0b0d0b2d0bbd0b5d0bdd18b3a3c2f703e0a3c703ed09dd0bed0b2d0b0d18f20d0b4d0b5d182d181d0bad0b0d18f20d0bed0b4d0b5d0b6d0b4d0b0266e6273703b266e6273703b20d0bad0b0d182d0b5d0b3d0bed180d0b8d0b82022d181d182d0bed0ba2220d0b8d0b7d0b2d0b5d181d182d0bdd18bd18520d0b1d180d0b5d0bdd0b4d0bed0b2266e6273703b20d0b8d0b720d090d0bdd0b3d0bbd0b8d0b82c20d093d0b5d180d0bcd0b0d0bdd0b8d0b82c20d098d182d0b0d0bbd0b8d0b820d0b820d0b4d1802e266e6273703b3c2f703e0a3c703ed092d181d0b520d182d0bed0b2d0b0d180d18b20d0bad0b0d187d0b5d181d182d0b2d0b5d0bdd0bdd18bd0b52c20d0bcd0bed0b4d0bdd18bd0b5266e6273703b20d0b820d0bfd0be20d183d0b4d0b8d0b2d0b8d182d0b5d0bbd18cd0bdd0be20d0bfd180d0b8d18fd182d0bdd18bd0bc20d186d0b5d0bdd0b0d0bc2c20d0b2d181d0b520d0b2266e6273703b20d0bdd0b0d0bbd0b8d187d0b8d0b8202e266e6273703b3c2f703e0a3c703e2246616e26616d703b46616e222c2022546f2062656520746f6f222c20225374726565742047616e67222c20224469616d616e74696e61222c202253696c7669616e204865616368222c2022546f706f6c696e6f222c20224f726967696e616c204d6172696e65732220d0b820d0b4d1802e3c6272202f3e3c6272202f3e266e6273703b3c6272202f3ed09ad0bed0bcd0b8d181d181d0b8d0bed0bdd0bdd0b0d18f20d0bed0b4d0b5d0b6d0b4d0b020d0b7d0b0d180d183d0b1d0b5d0b6d0bdd18bd18520d0b820d0bed182d0b5d187d0b5d181d182d0b2d0b5d0bdd0bdd18bd185266e6273703b20d0bfd180d0bed0b8d0b7d0b2d0bed0b4d0b8d182d0b5d0bbd0b5d0b92c20d0b220d1822ed1872e266e6273703b20d0b8d0b7d0b2d0b5d181d182d0bdd18bd18520d0b1d180d0b5d0bdd0b4d0bed0b22e3c2f703e0a3c703ed09dd0b020d0b2d0b8d182d180d0b8d0bdd0b520d0b8d0bdd182d0b5d180d0bdd0b5d1822dd181d0b0d0b9d182d0b0266e6273703b20d0bfd180d0b5d0b4d181d182d0b0d0b2d0bbd0b5d0bd20d0bdd0b520d0b2d0b5d181d18c20d0b0d181d181d0bed180d182d0b8d0bcd0b5d0bdd18220d0bfd180d0b5d0b4d0bbd0b0d0b3d0b0d0b5d0bcd18bd18520d182d0bed0b2d0b0d180d0bed0b22e3c2f703e0a3c703ed0a2d0bed0b2d0b0d180d18b20d0bfd0bed181d182d0bed18fd0bdd0bdd0be20d0bed0b1d0bdd0bed0b2d0bbd18fd18ed182d181d18f2e20d094d0bbd18f20d0bfd0bed0bbd183d187d0b5d0bdd0b8d18f20d0b1d0bed0bbd0b5d0b520d0bfd0bed0bbd0bdd0bed0b920d0b8d0bdd184d0bed180d0bcd0b0d186d0b8d0b820d0be20d0bdd0b0d188d0b8d18520d182d0bed0b2d0b0d180d0b0d18520d0bed0b1d180d0b0d189d0b0d0b9d182d0b5d181d18c20d0bfd0be20d0b2d18bd188d0b5d183d0bad0b0d0b7d0b0d0bdd0bdd0bed0bcd18320d182d0b5d0bbd0b5d184d0bed0bdd18320d0b8d0bbd0b820d0bfd180d0b8d185d0bed0b4d0b8d182d0b520d0b220d0bdd0b0d18820d0bcd0b0d0b3d0b0d0b7d0b8d0bd2e3c2f703e0a3c703ed092d18b20d0bcd0bed0b6d0b5d182d0b520d0b2d18bd0b3d0bed0b4d0bdd0be20d0b820d0b220d0bad0bed180d0bed182d0bad0b8d0b520d181d180d0bed0bad0b820d181d0b4d0b0d182d18c20d0bdd0b020d0bad0bed0bcd0b8d181d181d0b8d18e266e6273703b20d0b4d0b5d182d181d0bad0b8d0b520d182d0bed0b2d0b0d180d18b20d0bdd0b020d0b2d18bd0b3d0bed0b4d0bdd18bd18520d0b4d0bbd18f20d092d0b0d18120d183d181d0bbd0bed0b2d0b8d18fd1852028d0bfd0bed0b4d180d0bed0b1d0bdd0b0d18f20d0b8d0bdd184d0bed180d0bcd0b0d186d0b8d18f20d0b220d180d0b0d0b7d0b4d0b5d0bbd0b520266c6171756f3bd0bfd180d0b8d191d0bc20d0bdd0b020d0bad0bed0bcd0b8d181d181d0b8d18e26726171756f3b292e3c2f703e0a3c703ed097d0b0d0bad0b0d0b720d0bcd0bed0b6d0bdd0be20d0bed184d0bed180d0bcd0b8d182d18c20d0bfd0be20d182d0b5d0bbd0b5d184d0bed0bdd1832c20d183d0bad0b0d0b7d0b0d0bdd0bdd0bed0bcd18320d0b220d0bad0bed0bdd182d0b0d0bad182d0b0d185203a20d0b5d0b6d0b5d0b4d0bdd0b5d0b2d0bdd0be266e6273703b20d1812031312e30302d31392e303020d0b8d0bbd0b820d0bed182d0bfd180d0b0d0b2d0b8d0b220d0bfd0b8d181d18cd0bcd0be2c20d0bfd0bed181d0bbd0b520d187d0b5d0b3d0be20d0bcd18b20d0bed0bfd0b5d180d0b0d182d0b8d0b2d0bdd0be20d181d0b2d18fd0b6d0b5d0bcd181d18f20d18120d0b2d0b0d0bcd0b820d0b4d0bbd18f20d183d182d0bed187d0bdd0b5d0bdd0b8d18f20d0b4d0b5d182d0b0d0bbd0b5d0b92e3c6272202f3e3c6272202f3ed0a320d0bdd0b0d18120d181d183d189d0b5d181d182d0b2d183d0b5d18220d181d0b8d181d182d0b5d0bcd0b020d0b4d0bed181d182d0b0d0b2d0bad0b821266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b20266e6273703b3c6272202f3e3c6272202f3ed0a1d182d0b0d0b220d0bdd0b0d188d0b8d0bc20d0bad0bbd0b8d0b5d0bdd182d0bed0bc20d0b2d18b20d181d18dd0bad0bed0bdd0bed0bcd0b8d182d0b520d0b2d180d0b5d0bcd18f2c266e6273703b20d0b4d0b5d0bdd18cd0b3d0b820d0b820d0bfd0bed0bbd183d187d0b8d182d0b520d183d0b4d0bed0b2d0bbd0b5d182d0b2d0bed180d0b5d0bdd0b8d0b520d0bed18220d0bfd180d0b8d0bed0b1d180d0b5d182d191d0bdd0bdd18bd18520d18320d0bdd0b0d18120d182d0bed0b2d0b0d180d0bed0b221266e6273703b266e6273703b20266e6273703b3c6272202f3e3c6272202f3ed09dd0b0d188d0b820d186d0b5d0bdd18b20d092d0b0d18120d0bfd180d0b8d18fd182d0bdd0be20d183d0b4d0b8d0b2d18fd1822c20d0b020d092d0b0d18820d180d0b5d0b1d0b5d0bdd0bed0ba266e6273703b20d0b1d183d0b4d0b5d18220d0b4d0bed0b2d0bed0bbd0b5d0bd2121213c2f703e, NULL, 16, ''),
(17, 1326346943, 1326359881, 0x3c68313ed09fd180d0b8d191d0bc20d0bdd0b020d0bad0bed0bcd0b8d181d181d0b8d18e3c2f68313e0a3c703e266e6273703b3c2f703e0a3c68323ed0a3d181d0bbd0bed0b2d0b8d18f20d0bfd180d0b8d0b5d0bcd0b02e3c2f68323e0a3c703e3c6272202f3e3c6272202f3e312e20d09ad0bed0bcd0b8d181d181d0b8d0bed0bdd0bdd18bd0b920d0bcd0b0d0b3d0b0d0b7d0b8d0bd2022d09cd0bed0b4d0bdd18bd0b920d180d0b5d0b1d0b5d0bdd0bed0ba2220d0bfd180d0b8d0bdd0b8d0bcd0b0d0b5d18220d0bdd0b020d0bad0bed0bcd0b8d181d181d0b8d18e20d182d0bed0bbd18cd0bad0be20d0bad180d0b0d181d0b8d0b2d18bd0b520d0bad0b0d187d0b5d181d182d0b2d0b5d0bdd0bdd18bd0b5203c6272202f3ed182d0bed0b2d0b0d180d18b20d0b220d185d0bed180d0bed188d0b5d0bc20d181d0bed181d182d0bed18fd0bdd0b8d0b82e203c6272202f3ed09cd0b0d0b3d0b0d0b7d0b8d0bd20d18fd0b2d0bbd18fd0b5d182d181d18f20d187d0b0d181d182d0bdd18bd0bc20d0b7d0b0d0b2d0b5d0b4d0b5d0bdd0b8d0b5d0bc2c20d0bfd0bed18dd182d0bed0bcd18320d0bcd18b20d0bed181d182d0b0d0b2d0bbd18fd0b5d0bc20d0b7d0b0203c6272202f3ed181d0bed0b1d0bed0b920d0bfd180d0b0d0b2d0be20d0bed182d0bad0b0d0b7d0b0d182d18c20d0b220d0bfd180d0b8d0b5d0bcd0b520d182d0bed0b2d0b0d180d0b020d0bdd0b020d0bad0bed0bcd0b8d181d181d0b8d18e20d0b1d0b5d0b720d0bed0b1d18ad18fd181d0bdd0b5d0bdd0b8d18f20d0bfd180d0b8d187d0b8d0bdd18b2e203c6272202f3e322e20d0a6d0b5d0bdd0b02c20d0bfd0be20d0bad0bed182d0bed180d0bed0b920d0b2d18b20d185d0bed182d0b5d0bbd0b820d0b1d18b20d0bfd180d0bed0b4d0b0d182d18c20d181d0b2d0bed0b920d182d0bed0b2d0b0d18020d0bdd0b520d0b4d0bed0bbd0b6d0bdd0b020d0bfd180d0b5d0b2d18bd188d0b0d182d18c2035302520d0bed18220d180d0b5d0b0d0bbd18cd0bdd0bed0b93c6272202f3e266e6273703bd180d18bd0bdd0bed187d0bdd0bed0b920d186d0b5d0bdd18b20d182d0b0d0bad0bed0b3d0be20d0b6d0b520d0bdd0bed0b2d0bed0b3d0be20d182d0bed0b2d0b0d180d0b02c20d0bdd0bed0b2d18bd0b520d182d0bed0b2d0b0d180d18b20d0bed186d0b5d0bdd0b8d0b2d0b0d18ed182d181d18f20d0b8d0bdd0b4d0b8d0b2d0b8d0b4d183d0b0d0bbd18cd0bdd0be2e3c6272202f3e332e20d09fd180d0b820d181d0b5d0b1d0b520d0b8d0bcd0b5d182d18c20d0bfd0b0d181d0bfd0bed180d18220d0b8d0bbd0b820d183d0b4d0bed181d182d0bed0b2d0b5d180d0b5d0bdd0b8d0b520d0bbd0b8d187d0bdd0bed181d182d0b82e3c6272202f3e342e20d09dd0b020d181d0b4d0b0d0bdd0bdd18bd0b520d0b2d0b5d189d0b820d0bed184d0bed180d0bcd0bbd18fd0b5d182d181d18f20d0b4d0bed0b3d0bed0b2d0bed180202d20d0bad0b2d0b8d182d0b0d0bdd186d0b8d18f20d18120d180d0b5d0bad0b2d0b8d0b7d0b8d182d0b0d0bcd0b820d0bed0b1d0b5d0b8d18520d181d182d0bed180d0bed0bd2e3c6272202f3e352e20d0a6d0b5d0bdd0b020d183d181d182d0b0d0bdd0b0d0b2d0bbd0b8d0b2d0b0d0b5d182d18f20d0bfd0be20d0bed0b1d0bed18ed0b4d0bdd0bed0bcd18320d181d0bed0b3d0bbd0b0d188d0b5d0bdd0b8d18e20d181d182d0bed180d0bed0bd2c20d0bad0bed0bcd0b8d181d181d0b8d0bed0bdd0bdd0bed0b5266e6273703b20d0b2d0bed0b7d0bdd0b0d0b3d180d0b0d0b6d0b4d0b5d0bdd0b8d0b5202d20d0b4d0be203330252e266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b20266e6273703b3c6272202f3e362e20d092d0b5d189d18c2c20d0bdd0b520d0bfd180d0bed0b4d0b0d0bdd0bdd183d18e20d0b220d182d0b5d187d0b5d0bdd0b8d0b820333020d180d0b0d0b1d0bed187d0b8d18520d0b4d0bdd0b5d0b92c20d0bcd0b0d0b3d0b0d0b7d0b8d0bd20d0b2d0bfd180d0b0d0b2d0b520d183d186d0b5d0bdd0b8d182d18c20d0bdd0b0203230252e20d09fd0be266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b20266e6273703b3c6272202f3ed0b8d181d182d0b5d187d0b5d0bdd0b8d0b820d181d0bbd0b5d0b4d183d18ed189d0b8d18520333020d180d0b0d0b1d0bed187d0b8d18520d0b4d0bdd0b5d0b92c20d0bfd0bed181d0bbd0b520d0bfd0b5d180d0b2d0bed0b920d183d186d0b5d0bdd0bad0b82c20d0bfd180d0bed0b2d0bed0b4d0b8d182d181d18f20d181d0bbd0b5d0b4d183d18ed189d0b0d18f266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b20266e6273703b3c6272202f3ed183d186d0b5d0bdd0bad0b020d0bdd0b0203230252e266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b20266e6273703b3c6272202f3e372e20d09fd0be20d0b8d181d182d0b5d187d0b5d0bdd0b8d0b820393020d180d0b0d0b1d0bed187d0b8d18520d0b4d0bdd0b5d0b920d181d0be20d0b4d0bdd18f20d0bfd180d0b8d0bdd18fd182d0b8d18f20d0bdd0b020d0bad0bed0bcd0b8d181d181d0b8d18e2c20d0b2d0b5d189d0b820d0bdd0b5266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b20266e6273703b3c6272202f3ed0b2d0bed181d182d180d0b5d0b1d0bed0b2d0b0d0bdd0bdd18bd0b520d0bad0bed0bcd0b8d182d0b5d0bdd182d0bed0bc20d0b820d0bdd0b520d0bfd180d0bed0b4d0b0d0bdd0bdd18bd0b52c20d0bfd0b5d180d0b5d0b4d0b0d18ed182d181d18f20d0b220d0b4d0b0d18028d0b4d0b5d182d181d0bad0b8d0bc20d0b4d0bed0bcd0b0d0bc20d0b820d0bcd0b0d0bbd0bed0b8d0bcd183d189d0b8d0bc20d181d0b5d0bcd18cd18fd0bc293c6272202f3e266e6273703b3c6272202f3e382e20d09cd18b20d0bfd180d0b5d0b4d0bbd0b0d0b3d0b0d0b5d0bc266e6273703b20d0b2d0b0d0bc20d0b4d0b2d0b520d181d185d0b5d0bcd18b20d0bfd0bed0bbd183d187d0b5d0bdd0b8d18f20d0b4d0b5d0bdd0b5d0b6d0bdd18bd18520d181d180d0b5d0b4d181d182d0b23a203c6272202f3e3c6272202f3e266e6273703b266e6273703b20d0b0292022d094d0b5d0bdd18cd0b3d0b820d181d180d0b0d0b7d1832220d09cd18b266e6273703b20d0bdd0b0d0b7d18bd0b2d0b0d0b5d18220d092d0b0d0bc20d181d183d0bcd0bcd1832028d0b4d0be2033302520d0bed18220d180d18bd0bdd0bed187d0bdd0bed0b920d181d182d0bed0b8d0bcd0bed181d182d0b820d182d0bed0b2d0b0d180d0b0266e6273703b20d0bdd0b020d0b4d0b0d0bdd0bdd18bd0b920d0bcd0bed0bcd0b5d0bdd182292c20d0b220d181d0bbd183d187d0b0d0b520d181d0bed0b3d0bbd0b0d181d0b8d18f20d18120d0bed186d0b5d0bdd0bad0bed0b920d092d18b20d182d183d18220d0b6d0b520d0bfd0bed0bbd183d187d0b0d0b5d182d0b520d0b4d0b5d0bdd18cd0b3d0b82e266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b20266e6273703b3c6272202f3e266e6273703bd095d181d0bbd0b820d182d0bed0b2d0b0d18020d181d0bed0b2d0b5d180d188d0b5d0bdd0bdd0be20d0bdd0bed0b2d18bd0b92c20d182d0be20d0bed186d0b5d0bdd0bad0b020d0bfd0be20d0b4d0bed0b3d0bed0b2d0bed180d191d0bdd0bdd0bed181d182d0b82e203c6272202f3e266e6273703b266e6273703b20d0b1292022d09ad0bed0bcd0b8d181d181d0b8d18f2220d0add182d0bed18220d181d0bfd0bed181d0bed0b120d0bfd0bed0b4d185d0bed0b4d0b8d1822c20d0b5d181d0bbd0b820d092d18b20d0bdd0b520d181d0bed0b3d0bbd0b0d181d0bdd18b20d18120d0bed186d0b5d0bdd0bad0bed0b920d0b820d185d0bed182d0b8d182d0b5266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b20266e6273703b3c6272202f3ed0b2d18bd181d182d0b0d0b2d0b8d182d18c20d182d0bed0b2d0b0d18020d0bfd0be20d181d0b2d0bed0b5d0b920d186d0b5d0bdd0b52e20d09ad0bed0bcd0b8d181d181d0b8d18f20d0bcd0b0d0b3d0b0d0b7d0b8d0bdd0b020d181d0bed181d182d0b0d0b2d0bbd18fd0b5d1822033302520d0bdd0b020d092d0b0d188d18320d186d0b5d0bdd1832e266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b20266e6273703b3c6272202f3ed094d0b0d0bdd0bdd18bd0b520d0b4d0b5d0b9d181d182d0b2d0b8d18f20d181d182d180d0bed0b3d0be20d180d0b5d0b3d0bbd0b0d0bcd0b5d0bdd182d0b8d180d0bed0b2d0b0d0bdd18b20d0b820d0bed181d183d189d0b5d181d182d0b2d0bbd18fd18ed182d181d18f20d0bdd0b020d0bed181d0bdd0bed0b2d0b0d0bdd0b8d0b8266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b20266e6273703b3c6272202f3ed0b7d0b0d0bad0bbd18ed187d0b5d0bdd0b8d18f20d0b4d0bed0b3d0bed0b2d0bed180d0b020d0bad0bed0bcd0b8d181d181d0b8d0b820d0bcd0b5d0b6d0b4d18320d0bad0bed0bcd0b8d181d181d0b8d0bed0bdd0b5d180d0bed0bc20d0b820d0bad0bed0bcd0b8d182d0b5d0bdd182d0bed0bc2e20d094d0bed0b3d0bed0b2d0bed180266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b20266e6273703b3c6272202f3ed0b8d0bcd0b5d0b5d18220d0bed0bfd180d0b5d0b4d0b5d0bbd0b5d0bdd0bdd18bd0b920d181d180d0bed0ba20d0b4d0b5d0b9d181d182d0b2d0b8d18f2e20d094d0b5d0bdd18cd0b3d0b820d092d18b20d0bfd0bed0bbd183d187d0b0d0b5d182d0b520d0bfd0bed181d0bbd0b520d180d0b5d0b0d0bbd0b8d0b7d0b0d186d0b8d0b8266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b20266e6273703b3c6272202f3ed182d0bed0b2d0b0d180d0b02e20d09e20d0bfd180d0bed0b4d0b0d0b6d0b520d092d0b0d188d0b5d0b3d0be20d182d0bed0b2d0b0d180d0b020d0bcd18b266e6273703b20d0bed0bfd0bed0b2d0b5d181d182d0b8d0bc20d092d0b0d181266e6273703b20d0bfd0be20d182d0b5d0bbd0b5d184d0bed0bdd18320d0b8d0bbd0b820652d6d61696c2e203c6272202f3e3c6272202f3e392e20d092d18bd0bfd0bbd0b0d182d0b020d0b4d0b5d0bdd0b5d0b6d0bdd18bd18520d181d180d0b5d0b4d181d182d0b220d0bfd180d0bed0b8d0b7d0b2d0bed0b4d0b8d182d181d18f20d0bfd0bed181d0bbd0b520d180d0b5d0b0d0bbd0b8d0b7d0b0d186d0b8d0b820d182d0bed0b2d0b0d180d0b03a20d0bfd0bed0bdd0b5d0b4d0b5d0bbd18cd0bdd0b8d0ba2c266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b20266e6273703b3c6272202f3ed181d180d0b5d0b4d0b02c20d0bfd18fd182d0bdd0b8d186d0b0266e6273703b202d20d1812031332e303020d0b4d0be2031372e30302e202820d0bfd0be20d0bfd180d0b5d0b4d0b2d0b0d180d0b8d182d0b5d0bbd18cd0bdd0bed0b920d0b4d0bed0b3d0bed0b2d0bed180d0b5d0bdd0bdd0bed181d182d0b829266e6273703b202e3c6272202f3e266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b20266e6273703b3c6272202f3e266e6273703b266e6273703b266e6273703b20d09fd180d0b8d0b5d0bcd0bdd18bd0b520d0b4d0bdd0b83a20d0bfd0bed0bdd0b5d0b4d0b5d0bbd18cd0bdd0b8d0ba2c266e6273703b20d181d180d0b5d0b4d0b02c20d0bfd18fd182d0bdd0b8d186d0b0266e6273703b202d20d1812031332e303020d0b4d0be2031372e30302e202820d0bfd0be266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b20266e6273703b3c6272202f3ed0bfd180d0b5d0b4d0b2d0b0d180d0b8d182d0b5d0bbd18cd0bdd0bed0b920d0b4d0bed0b3d0bed0b2d0bed180d0b5d0bdd0bdd0bed181d182d0b820d0bfd0be20d182d0b5d0bb29266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b20266e6273703b3c6272202f3e266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b20266e6273703b3c6272202f3e266e6273703b266e6273703b20d092d0bed0b7d0bcd0bed0b6d0b5d0bd20d0b2d18bd0b5d0b7d0b420d0bdd0b020d0b4d0bed0bc20d0b4d0bbd18f20d0bfd180d0b8d0b5d0bcd0bad0b820d0b2d0b5d189d0b5d0b92820d0bfd0be20d0bfd180d0b5d0b4d0b2d0b0d180d0b8d182d0b5d0bbd18cd0bdd0bed0b920d0b4d0bed0b3d0bed0b2d0bed180d0b5d0bdd0bdd0bed181d182d0b8266e6273703b20293c2f703e, NULL, 17, ''),
(18, 1326347052, 1326347052, 0x3c68313ed09ed09fd09bd090d0a2d0903c2f68313e0a3c703e3c6272202f3ed094d0bbd18f20d0bed0bfd0bbd0b0d182d18b20d182d0bed0b2d0b0d180d0b020d0bcd18b20d0bfd180d0b5d0b4d0bbd0b0d0b3d0b0d0b5d0bc20d181d0bbd0b5d0b4d183d18ed189d0b8d0b520d0b2d0b0d180d0b8d0b0d0bdd182d18b3a3c6272202f3e312e266e6273703b20d09dd0b0d0bbd0b8d187d0bdd18bd0bcd0b82028d0bdd0b5d0bfd0bed181d180d0b5d0b4d181d182d0b2d0b5d0bdd0bdd0be20d0bfd180d0b820d0bfd0bed0bad183d0bfd0bad0b520d182d0bed0b2d0b0d180d0b0293c6272202f3e322e266e6273703b20d09fd0bed0bfd0bed0bbd0bdd0b5d0bdd0b8d0b5266e6273703b20d0bdd0b020d0bad0b0d180d182d18320d0a1d0b1d0b5d180d0b1d0b0d0bdd0bad0b0266e6273703b266e6273703b20e2849620d0bad0b0d180d182d18b203633392030302032363420393030203232302034323139266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b20266e6273703b3c6272202f3e3c6272202f3e3c2f703e0a3c68313ed094d09ed0a1d0a2d090d092d09ad0903c2f68313e0a3c703e3c6272202f3ed094d0bed181d182d0b0d0b2d0bad0b020d0bed181d183d189d0b5d181d182d0b2d0bbd18fd0b5d182d181d18f20d181d0bbd0b5d0b4d183d18ed189d0b8d0bc20d183d0b4d0bed0b1d0bdd18bd0bc20d0b4d0bbd18f20d092d0b0d18120d181d0bfd0bed181d0bed0b1d0bed0bc3a266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b20266e6273703b3c6272202f3e266e6273703b312e20d094d0bed181d182d0b0d0b2d0bad0b020d0bfd0be20d0b3d0bed180d0bed0b4d18320d0bfd180d0b820d0bfd0bed0bad183d0bfd0bad0b520d0b4d0be203130303020d180d183d0b12d31303020d180d183d0b1203c6272202f3e266e6273703b322e20d094d0bed181d182d0b0d0b2d0bad0b020d0bfd0be20d0b3d0bed180d0bed0b4d18320d0bfd180d0b820d0bfd0bed0bad183d0bfd0bad0b520d0bed182203130303020d180d183d0b1202dd0b1d0b5d181d0bfd0bbd0b0d182d0bdd0b0d18f266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b3c2f703e0a3c703e266e6273703b3c2f703e0a3c68313ed092d18bd0b5d0b7d0b420d0bdd0b020d0b4d0bed0bc20266e6273703b3c2f68313e0a3c703e266e6273703b3c6272202f3ed095d181d0bbd0b820d18320d092d0b0d18120d0bdd0b5d18220d0b2d180d0b5d0bcd0b5d0bdd0b820d0b8d0bbd0b820d0b2d0bed0b7d0bcd0bed0b6d0bdd0bed181d182d0b820d0bfd180d0b8d0b5d185d0b0d182d18c20d0ba20d0bdd0b0d0bc20d0b820d181d0b4d0b0d182d18c20d092d0b0d18820d182d0bed0b2d0b0d1802c20d182d0bed0b3d0b4d0b020d0bcd18b20d181d0b0d0bcd0b8266e6273703b20d0bfd180d0b8d0b5d0b4d0b5d0bc20d0ba20d092d0b0d0bc2c20d0bed186d0b5d0bdd0b8d0bc20d0b820d0bfd180d0bed0b8d0b7d0b2d0b5d0b4d0b5d0bc20d180d0b0d181d187d191d18220d0bdd0b020d0bcd0b5d181d182d0b52c20d0b8d0bbd0b820d0b7d0b0d0bad0bbd18ed187d0b8d0bc20d18120d092d0b0d0bcd0b820d0b4d0bed0b3d0bed0b2d0bed18020d0bad0bed0bcd0b8d181d181d0b8d0b820d0b820d0bfd180d0b8d0bcd0b5d0bc266e6273703b20d0b2d0b0d18820d182d0bed0b2d0b0d1802e3c6272202f3ed094d0bbd18f20d18dd182d0bed0b3d0be20d092d0b0d0bc20d0bdd0b5d0bed0b1d185d0bed0b4d0b8d0bcd0be20d0bfd0bed0b7d0b2d0bed0bdd0b8d182d18c20d0bfd0be20d182d0b5d0bbd0b5d184d0bed0bdd18320d0b820d0bfd180d0b5d0b4d0b2d0b0d180d0b8d182d0b5d0bbd18cd0bdd0be20d0b7d0b0d0bfd0b8d181d0b0d182d18cd181d18f2e266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b20266e6273703b3c6272202f3e3c6272202f3ed09ed0b1d0bcd0b5d0bd20d0b820d0b2d0bed0b7d0b2d180d0b0d18220d182d0bed0b2d0b0d180d0b02e203c6272202f3e3c6272202f3e312e20d09ad183d0bfd0bbd0b5d0bdd0bdd18bd0b520d0b12fd18320d182d0bed0b2d0b0d180d18b20d0bed0b1d0bcd0b5d0bdd18320d0b820d0b2d0bed0b7d0b2d180d0b0d182d18320d0bdd0b520d0bfd0bed0b4d0bbd0b5d0b6d0b0d1822e266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b3c2f703e0a3c703e322e20d09ed0b1d0bcd0b5d0bd20d0b820d0b2d0bed0b7d0b2d180d0b0d18220d0bdd0bed0b2d18bd18520d182d0bed0b2d0b0d180d0bed0b2266e6273703b20d0bed181d183d189d0b5d181d182d0b2d0bbd18fd0b5d182d181d18f20d0b220d181d0bed0bed182d0b2d0b5d182d181d182d0b2d0b8d0b820d18120d097d0b0d0bad0bed0bdd0bed0bc20d0a0d0a420266c6171756f3bd09e266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b20d0b7d0b0d189d0b8d182d0b520d0bfd180d0b0d0b220d0bfd0bed182d180d0b5d0b1d0b8d182d0b5d0bbd0b5d0b926726171756f3b3c2f703e, NULL, 18, '');
INSERT INTO `code_menu_attribute` (`id`, `created`, `updated`, `content`, `page_type`, `menu_id`, `template`) VALUES
(19, 1326347272, 1326353887, 0x3c68313ed094d0b5d182d181d0bad0b8d0b920d181d182d0bed0ba2e3c2f68313e0a3c703e3c6272202f3ed0add182d0be20d0b2d18bd180d0b0d0b6d0b5d0bdd0b8d0b520266c6171756f3bd0b4d0b5d182d181d0bad0b8d0b920d181d182d0bed0ba26726171756f3b20d181d182d0b0d0bbd0be20d0b7d0bdd0b0d0bad0bed0bcd0be20d0b4d0bbd18f20d180d0bed181d181d0b8d0b9d181d0bad0bed0b3d0be20d0bfd0bed182d180d0b5d0b1d0b8d182d0b5d0bbd18f20d0bfd0bed181d0bbd0b520323030302dd18520d0b3d0bed0b4d0bed0b22c20d0bad0bed0b3d0b4d0b020d0bdd0b020d0bdd0b0d18820d180d18bd0bdd0bed0ba20d181d182d0b0d0bbd0b820d0bfd180d0b8d0b2d0bed0b7d0b8d182d18c20d0bed0bfd182d0bed0b2d18bd0b520d0bfd0bed181d182d0b0d0b2d0bad0b820d181d182d0bed0bad0b020d0b8d0bcd0bfd0bed180d182d0bdd18bd18520d0b1d180d0b5d0bdd0b4d0bed0b22e20d09ed0b4d0b5d0b6d0b4d0b020d181d182d0bed0ba20d0b4d0bbd18f20d0b4d0b5d182d0b5d0b920266e646173683b20d18dd182d0be20d0bfd180d0bed181d182d0be20d181d0bfd0b0d181d0b5d0bdd0b8d0b520d0b4d0bbd18f20d180d0bed0b4d0b8d182d0b5d0bbd18cd181d0bad0b8d18520d0bad0bed188d0b5d0bbd18cd0bad0bed0b22120d09dd0b020d097d0b0d0bfd0b0d0b4d0b520d0bfd180d0b5d0b8d0bcd183d189d0b5d181d182d0b2d0b020d18dd182d0bed0b3d0be20d180d0bed0b4d0b020d0bed0b4d0b5d0b6d0b4d18b20d0bed186d0b5d0bdd0b8d0bbd0b820d0b4d0b0d0b2d0bdd0be2e20d0a2d0b5d0bfd0b5d180d18c20d0b820d18320d180d0bed181d181d0b8d18fd0bd20d0bfd0bed18fd0b2d0b8d0bbd0b0d181d18c20d182d0b0d0bad0b0d18f20d0b7d0b0d0bcd0b5d187d0b0d182d0b5d0bbd18cd0bdd0b0d18f20d0b2d0bed0b7d0bcd0bed0b6d0bdd0bed181d182d18c2e3c6272202f3e3c6272202f3ed09ad0b0d0b6d0b4d18bd0b920d0b3d0bed0b420d0bfd180d0bed0b8d0b7d0b2d0bed0b4d0b8d182d0b5d0bbd0b820d0bed0b4d0b5d0b6d0b4d18b20d0b3d0bed182d0bed0b2d18fd18220d0bdd0bed0b2d18bd0b520d0bad0bed0bbd0bbd0b5d0bad186d0b8d0b82e20d09ed181d182d0b0d182d0bad0b82c20d182d0be20d0b5d181d182d18c2073746f636b20d0bdd183d0b6d0bdd0be20d0bad183d0b4d0b02dd182d0be20d182d0bed0b6d0b520d0b4d0b5d0b2d0b0d182d18c2e20d09ad0b0d0ba20d0bfd180d0b0d0b2d0b8d0bbd0be2c20d0bfd180d0bed0b8d0b7d0b2d0bed0b4d0b8d182d0b5d0bbd0b820d0bfd180d0bed0b4d0b0d18ed18220d0b8d18520d18120d0bed0b3d180d0bed0bcd0bdd0bed0b920d181d0bad0b8d0b4d0bad0bed0b92c20d187d182d0bed0b1d18b20d183d0b2d0b5d0bbd0b8d187d0b8d182d18c20d182d0bed0b2d0b0d180d0bed0bed0b1d0bed180d0bed1822e20d09ad180d0bed0bcd0b520d181d182d0b0d180d18bd18520d0bad0bed0bbd0bbd0b5d0bad186d0b8d0b92c20d0bad0bed182d0bed180d18bd0b520d0bfd0be20d0bdd0b0d188d0b8d0bc20d0bcd0b5d180d0bad0b0d0bc20d0b2d0bed0b2d181d0b520d0b820d0bdd0b520d181d182d0b0d180d18bd0b52c20d0bfd180d0bed0b4d0b0d18ed18220d0b5d189d0b520d0b820d0bed0b1d180d0b0d0b7d186d18b20d0bdd0bed0b2d0bed0b920d0bad0bed0bbd0bbd0b5d0bad186d0b8d0b820d18120d184d0b0d0b1d180d0b8d0ba2e3c6272202f3e3c6272202f3ed09dd0b520d181d0b5d0bad180d0b5d1822c20d187d182d0be20d180d0b0d0b7d180d0b0d0b1d0bed182d0bad0b020d0b820d0bfd0bed188d0b8d0b220d0bdd0bed0b2d0bed0b920d0b7d0b8d0bcd0bdd0b5d0b920d0bad0bed0bbd0bbd0b5d0bad186d0b8d0b820d0b4d0b5d182d181d0bad0bed0b920d0bed0b4d0b5d0b6d0b4d18b20d0b3d0bed182d0bed0b2d0b8d182d181d18f20d0b5d189d0b520d0bbd0b5d182d0bed0bc2c20d0bfd0bed18dd182d0bed0bcd18320d0ba20d0b7d0b8d0bcd0b52c20d0bad0bed0b3d0b4d0b020d0bed0bdd0b020d0bfd0bed18fd0b2d0b8d182d181d18f20d0b220d0bcd0b0d0b3d0b0d0b7d0b8d0bdd0b0d1852c20d18320d0bbd18ed0b1d0b8d182d0b5d0bbd0b5d0b920d182d0b0d0bad0bed0b3d0be20d18fd0b2d0bbd0b5d0bdd0b8d18f20d0bad0b0d0ba20266c6171756f3bd0b4d0b5d182d181d0bad0b0d18f20d0bed0b4d0b5d0b6d0b4d0b020d181d182d0bed0ba26726171756f3b20d0b5d181d182d18c20d188d0b0d0bdd18120d0bfd180d0b8d0bed0b1d180d0b5d181d182d0b820d182d0b5d0bad183d189d183d18e20d0bad0bed0bbd0bbd0b5d0bad186d0b8d18e20d0bfd0be20d181d0bcd0b5d188d0bdd18bd0bc20d186d0b5d0bdd0b0d0bc2e3c6272202f3e3c6272202f3ed094d0b5d182d0b820d0b1d18bd181d182d180d0be20d180d0b0d181d182d183d1822c20d0bad0b0d0b6d0b4d18bd0b520d0bdd0b5d181d0bad0bed0bbd18cd0bad0be20d0bcd0b5d181d18fd186d0b5d0b220d0b8d0bc20d0bdd183d0b6d0bdd0be20d187d182d0be2dd182d0be20d0bfd0bed0bad183d0bfd0b0d182d18c20d0b8d0b720d0bed0b4d0b5d0b6d0b4d18b2c20d0b020d0bfd0bed0bad183d0bfd0bad0b020d182d0bed0b2d0b0d180d0bed0b220d0b8d0b720d0bad0b0d182d0b5d0b3d0bed180d0b8d0b820266c6171756f3bd0b4d0b5d182d181d0bad0b8d0b920d181d182d0bed0ba26726171756f3b20d0bed0b1d0bed0b9d0b4d0b5d182d181d18f20d092d0b0d0bc20d0b220d180d0b0d0b7d18b20d0b4d0b5d188d0b5d0b2d0bbd0b52e20d09ad0b0d0ba20d0bfd180d0b8d18fd182d0bdd0be2c20d187d182d0be20d0b7d0b020d182d0b520d0b6d0b520d0b4d0b5d0bdd18cd0b3d0b8266e6273703b20d0b4d0b5d182d181d0bad0bed0b920d0bed0b4d0b5d0b6d0b4d18b20d181d182d0bed0ba20d0bcd0bed0b6d0bdd0be20d0bad183d0bfd0b8d182d18c20d0bad183d0b4d0b020d0b1d0bed0bbd18cd188d0b52e3c6272202f3e3c6272202f3e266c6171756f3bd0a0d0b0d0b7d183d0bcd0bdd0b0d18f20d18dd0bad0bed0bdd0bed0bcd0b8d18f26726171756f3b20266e646173683b20d0bbd18ed0b4d0b820d0b220d180d0b0d0b7d0b2d0b8d182d18bd18520d181d182d180d0b0d0bdd0b0d18520d183d0b6d0b520d0b4d0b0d0b2d0bdd0be20d0b6d0b8d0b2d183d18220d0bfd0be20d18dd182d0bed0bcd18320d0bfd180d0b8d0bdd186d0b8d0bfd1832e20d09820d0b4d0b5d0b9d181d182d0b2d0b8d182d0b5d0bbd18cd0bdd0be2c20d0b7d0b0d187d0b5d0bc20d0bfd0b5d180d0b5d0bfd0bbd0b0d187d0b8d0b2d0b0d182d18c20d0b220d0bdd0b5d181d0bad0bed0bbd18cd0bad0be20d180d0b0d0b72c20d0b5d181d0bbd0b820d0bcd0bed0b6d0bdd0be20d0bfd180d0b8d0bed0b1d180d0b5d181d182d0b820d0bed0b4d0b5d0b6d0b4d18320d182d0b0d0bad0bed0b3d0be20d0b6d0b520d0bad0b0d187d0b5d181d182d0b2d0b020d0b820d0b2d0b8d0b4d0b020d0b7d0b020d0b3d0bed180d0b0d0b7d0b4d0be20d0bcd0b5d0bdd18cd188d183d18e20d181d183d0bcd0bcd1832e3c6272202f3e3c6272202f3ed09ad0b0d0bad0bed0b2d0be20d0b1d18bd0b2d0b0d0b5d18220d183d0b4d0b8d0b2d0bbd0b5d0bdd0b8d0b520d0bbd18ed0b4d0b5d0b92c20d0bad0bed182d0bed180d18bd0b520d0b2d0bfd0b5d180d0b2d18bd0b520d0bfd0bed0bad183d0bfd0b0d18ed18220d0b4d0b5d182d181d0bad0b8d0b920d181d182d0bed0ba2c20d0bad0bed0b3d0b4d0b020d186d0b5d0bdd0b020d0b7d0b020d0b4d0b5d182d181d0bad183d18e20d0bed0b4d0b5d0b6d0b4d18320d0b8d0b7d0b2d0b5d181d182d0bdd18bd18520d0b5d0b2d180d0bed0bfd0b5d0b9d181d0bad0b8d18520d0b1d180d0b5d0bdd0b4d0bed0b220d0bed0bad0b0d0b7d18bd0b2d0b0d0b5d182d181d18f20d0b4d0b0d0b6d0b520d0b4d0b5d188d0b5d0b2d0bbd0b520d0bad0b8d182d0b0d0b9d181d0bad0b8d18520d0b2d0b5d189d0b5d0b920d181d0bed0bcd0bdd0b8d182d0b5d0bbd18cd0bdd0bed0b3d0be20d0bad0b0d187d0b5d181d182d0b2d0b02e3c6272202f3e3c6272202f3e3c6272202f3e3c2f703e0a3c68313ed0a7d0b5d0bc20d0b2d18bd0b3d0bed0b4d0b5d0bd20d0b4d0b5d182d181d0bad0b8d0b920d181d182d0bed0ba3f3c2f68313e0a3c703e3c6272202f3ed09dd0b520d0b2d181d0b520d0b7d0bdd0b0d18ed1822c20d187d182d0be20d182d0b0d0bad0bed0b520d0b4d0b5d182d181d0bad0b0d18f20d0bed0b4d0b5d0b6d0b4d0b020d181d182d0bed0ba2e20d09dd0be20d0b2d181d0b520d180d0bed0b4d0b8d182d0b5d0bbd0b820d0b7d0bdd0b0d18ed1822c20d0bad0b0d0ba20d0b1d18bd181d182d180d0be20d180d0b0d181d182d183d18220d0b4d0b5d182d0b82e20d09dd0b520d183d181d0bfd0b5d0b5d188d18c20d0bdd0b0d0bad183d0bfd0b8d182d18c20d0bed0b4d0b5d0b6d0b4d18b2c20d0bad0b0d0ba20d0bed0bdd0b020d183d0b6d0b520d181d182d0b0d0bdd0bed0b2d0b8d182d181d18f20d0bcd0b0d0bbd0b02e20d09020d186d0b5d0bdd18b20d0b220d0bcd0b0d0b3d0b0d0b7d0b8d0bdd0b0d18520d0bdd0b020d0b4d0b5d182d181d0bad183d18e20d0bed0b4d0b5d0b6d0b4d18320d0bdd0b0d185d0bed0b4d18fd182d181d18f20d0bfd0bed187d182d0b820d0b220d182d0bed0b920d0b6d0b520d186d0b5d0bdd0bed0b2d0bed0b920d0bad0b0d182d0b5d0b3d0bed180d0b8d0b82c20d187d182d0be20d0b820d0b4d0bbd18f20d0b2d0b7d180d0bed181d0bbd18bd1852e20d09020d0b2d0b5d0b4d18c20d182d0b0d0ba20d185d0bed187d0b5d182d181d18f20d0bdd0b520d0bfd180d0bed181d182d0be20d0bfd0bed0bad183d0bfd0b0d182d18c20d0b4d0b5d182d18fd0bc20d0bdd0b5d0bed0b1d185d0bed0b4d0b8d0bcd0bed0b52c20d0bdd0be20d0b5d189d0b520d0b820d0bdd0b0d180d18fd0b6d0b0d182d18c20d0b8d1852c20d0b2d0b5d0b4d18c20d18320d0bdd0b0d18120d0b220d181d182d180d0b0d0bdd0b520266c6171756f3bd0b2d181d182d180d0b5d187d0b0d18ed18220d0bfd0be20d0bed0b4d0b5d0b6d0bad0b526726171756f3b2e3c6272202f3e3c6272202f3ed094d0b5d182d181d0bad0b8d0b920d181d182d0bed0ba20266e646173683b20d0b2d0bed18220d0bed182d0bbd0b8d187d0bdd18bd0b920d0b2d18bd185d0bed0b42c20d187d182d0bed0b1d18b20d180d0b5d188d0b8d182d18c20d181d180d0b0d0b7d18320d0bdd0b5d181d0bad0bed0bbd18cd0bad0be20d0b7d0b0d0b4d0b0d1872e20d092d0be2dd0bfd0b5d180d0b2d18bd1852c20d0bfd180d0b8d0bed0b1d180d0b5d182d0b0d18f20d0bed0b4d0b5d0b6d0b4d183266e6273703b266e6273703b20d181d182d0bed0ba202c20d092d18b20d18dd0bad0bed0bdd0bed0bcd0b8d182d0b520d0b4d0b5d0bdd18cd0b3d0b820d0b8d0b720d181d0b5d0bcd0b5d0b9d0bdd0bed0b3d0be20d0b1d18ed0b4d0b6d0b5d182d0b02e20d094d0b5d182d181d0bad0b0d18f20d0bed0b4d0b5d0b6d0b4d0b020d181d182d0bed0ba20d0bed0bad0b0d0b7d18bd0b2d0b0d0b5d182d181d18f20d0b4d0b5d188d0b5d0b2d0bbd0b520d0b220d0bdd0b5d181d0bad0bed0bbd18cd0bad0be20d180d0b0d0b72120d092d0be2dd0b2d182d0bed180d18bd1852c20d092d18b20d181d0bcd0bed0b6d0b5d182d0b520d0bfd0bed0b7d0b2d0bed0bbd0b8d182d18c20d181d0b5d0b1d0b520d0bad183d0bfd0b8d182d18c20d0b4d0bbd18f20d180d0b5d0b1d0b5d0bdd0bad0b020d0b3d0bed180d0b0d0b7d0b4d0be20d0b1d0bed0bbd18cd188d0b520d0bdd0bed0b2d18bd18520d0b2d0b5d189d0b5d0b92e20d0922dd182d180d0b5d182d18cd0b8d1852c20d0bed0b4d0b5d0b6d0b4d0b020d0b4d0bbd18f20d0b4d0b5d182d0b5d0b920d181d182d0bed0ba20266e646173683b20d18dd182d0be20d0b2d18bd0b3d0bed0b4d0bdd18bd0b520d0bfd0bed0b4d0b0d180d0bad0b82e20d09dd0b0d0b2d0b5d180d0bdd18fd0bad0b02c20d18320d092d0b0d18120d0b5d181d182d18c20d180d0bed0b4d181d182d0b2d0b5d0bdd0bdd0b8d0bad0b820d0b8d0bbd0b820d0b7d0bdd0b0d0bad0bed0bcd18bd0b52c20d0b4d0b5d182d18fd0bc20d0bad0bed182d0bed180d18bd18520d092d18b20d0b4d0b0d180d0b8d182d0b520d0bfd0bed0b4d0b0d180d0bad0b82e20d0a2d0b5d0bfd0b5d180d18c20d092d18b20d0bcd0bed0b6d0b5d182d0b520d182d180d0b0d182d0b8d182d18c20d0bdd0b020d0bfd0bed0b4d0b0d180d0bad0b820d0bcd0b5d0bdd18cd188d0b8d0b520d181d183d0bcd0bcd18b2c20d0b020d180d0b5d0b1d0b5d0bdd0bed0ba20d0bed181d182d0b0d0bdd0b5d182d181d18f20d0b4d0bed0b2d0bed0bbd0b5d0bd20d0bfd0bed0b4d0b0d180d0bad0bed0bc2e3c6272202f3e3c6272202f3ed098d0bdd0bed0b3d0b4d0b020d0bdd0b5d0bed181d0b2d0b5d0b4d0bed0bcd0bbd0b5d0bdd0bdd18bd0b520d0bbd18ed0b4d0b820d0bed0bfd0b0d181d0b0d18ed182d181d18f2c20d187d182d0be20d0b4d0b5d182d181d0bad0b8d0b920d181d182d0bed0ba20266e646173683b20d18dd182d0be20d0bdd0b5d0bcd0bed0b4d0bdd0b0d18f2c20d0b1d180d0b0d0bad0bed0b2d0b0d0bdd0bdd0b0d18f20d0bed0b4d0b5d0b6d0b4d0b020d182d0b8d0bfd0b020d181d18dd0bad0bed0bdd0b42dd185d18dd0bdd0b4d0b02e20d09dd0be20d18dd182d0be20d0bfd180d0b5d0b4d181d182d0b0d0b2d0bbd0b5d0bdd0b8d0b520d0b220d0bad0bed180d0bdd0b520d0bdd0b5d0b2d0b5d180d0bdd0be2120d09fd180d0bed0b8d0b7d0b2d0bed0b4d0b8d182d0b5d0bbd0b820d0bed0b4d0b5d0b6d0b4d18b20d0b2d18bd0bdd183d0b6d0b4d0b5d0bdd18b20d181d0b1d18bd0b2d0b0d182d18c20d186d0b5d0bbd18bd0b520d0bdd0b5d180d0b0d181d0bfd180d0bed0b4d0b0d0bdd0bdd18bd0b520d0bad0bed0bbd0bbd0b5d0bad186d0b8d0b820d180d0b0d0b4d0b820d0bad0bed0bbd0bbd0b5d0bad186d0b8d0b820d0bdd0bed0b2d0bed0b3d0be20d181d0b5d0b7d0bed0bdd0b02e20d09cd0bdd0bed0b3d0b8d0b520d0b2d0b5d189d0b820d0b4d0b0d0b6d0b520d0b5d189d0b520d0bdd0b520d183d181d0bfd0b5d0bbd0b820d0bfd0bed0bfd0b0d181d182d18c20d0b220d0bcd0b0d0b3d0b0d0b7d0b8d0bdd18b2120d09020d0bdd0b0d181d187d0b5d18220d0b0d0bad182d183d0b0d0bbd18cd0bdd0bed181d182d0b820d0bad0bed0bbd0bbd0b5d0bad186d0b8d0b920d0bcd0bed0b6d0bdd0be20d182d0b0d0bad0b6d0b520d0bdd0b520d0b1d0b5d181d0bfd0bed0bad0bed0b8d182d18cd181d18f3a20d0bbd0b5d182d0bdd0b8d0b520d0b2d0b5d189d0b820d0bed182d188d0b8d0b2d0b0d18ed18220d0bdd0b020d184d0b0d0b1d180d0b8d0bad0b0d18520d0b5d189d0b520d0b7d0b8d0bcd0bed0b92c20d182d0b0d0ba20d187d182d0be2c266e6273703b20d0bcd0bed0b6d0bdd0be20d0b8d0bdd0bed0b3d0b4d0b020d0bad183d0bfd0b8d182d18c20d182d0b5d0bad183d189d183d18e20d0bad0bed0bbd0bbd0b5d0bad186d0b8d18e2e20d09ad180d0bed0bcd0b520d182d0bed0b3d0be2c20d0b4d0b5d182d181d0bad0b0d18f20d0bed0b4d0b5d0b6d0b4d0b020d0bdd0b520d182d0b0d0ba20d181d0b8d0bbd18cd0bdd0be20d0bfd0bed0b4d0b2d0b5d180d0b6d0b5d0bdd0b020d181d0bcd0b5d0bdd0b520d0bcd0bed0b4d0bdd18bd18520d182d0b5d0bdd0b4d0b5d0bdd186d0b8d0b92c20d0bed181d0bed0b1d0b5d0bdd0bdd0be20d18dd182d0be20d0bad0b0d181d0b0d0b5d182d181d18f20d0bed0b4d0b5d0b6d0b4d18b20d0b4d0bbd18f20d0bcd0b0d0bbd18bd188d0b5d0b920d0bed182203020d0b4d0be203320d0bbd0b5d1822c20d0b020d0b2d0b5d0b4d18c20d0bed0bdd0b820d0b1d18bd181d182d180d0b5d0b520d0b2d181d0b5d0b3d0be20d180d0b0d181d182d183d18220266e646173683b20d0b8d0bc20d182d180d0b5d0b1d183d0b5d182d181d18f20d187d0b0d189d0b520d0bed0b1d0bdd0bed0b2d0bbd18fd182d18c20d0b3d180d0b0d0b4d0b5d180d0bed0b1d187d0b8d0ba2e3c6272202f3e3c6272202f3ed09220d0a0d0bed181d181d0b8d0b820d186d0b5d0bdd18b20d0bdd0b020d0bed0b4d0b5d0b6d0b4d18320d0bdd0b5d0b2d0b5d180d0bed18fd182d0bdd0be20d0b7d0b0d0b2d18bd188d0b5d0bdd18b2e20d09dd0b0d188d0b820d182d0bed180d0b3d0bed0b2d18bd0b520d0bdd0b0d186d0b5d0bdd0bad0b82c20d181d0bfd180d0bed0b2d0bed186d0b8d180d0bed0b2d0b0d0bdd0bdd18bd0b520d0b1d0b5d0b7d183d0bcd0bdd0be20d0b4d0bed180d0bed0b3d0bed0b920d0b0d180d0b5d0bdd0b4d0bed0b920d0b820d0b0d0bfd0bfd0b5d182d0b8d182d0b0d0bcd0b820d0bfd180d0b5d0b4d0bfd180d0b8d0bdd0b8d0bcd0b0d182d0b5d0bbd0b5d0b92c20d0bdd0b520d0bed0bfd180d0b0d0b2d0b4d0b0d0bdd18b20d0bdd0b5d0bed0b1d185d0bed0b4d0b8d0bcd0bed181d182d18cd18e20d0b2d0b5d181d182d0b820d0b1d0b8d0b7d0bdd0b5d18120d0bfd180d0b8d0b1d18bd0bbd18cd0bdd0be2e20d095d181d0bbd0b820d181d180d0b0d0b2d0bdd0b8d182d18c20d186d0b5d0bdd18b20d0bdd0b020d0bdd0bed0b2d18bd0b520d182d0bed0b2d0b0d180d18b20d0b820d182d0bed0b2d0b0d180d18b20d18120d180d0b0d181d0bfd180d0bed0b4d0b0d0b6d0b82c20d182d0be20d180d0b0d0b7d0bdd0b8d186d0b020d0bed187d0b5d0b2d0b8d0b4d0bdd0b02e3c6272202f3e3c6272202f3ed09fd0bed0bad183d0bfd0b0d18f266e6273703b20d0b4d0b5d182d181d0bad0b8d0b920d181d182d0bed0ba2c20d0b2d18b20d0b1d183d0b4d0b5d182d0b520d180d0b0d0b4d0bed0b2d0b0d182d18c20d181d0b2d0bed0b8d18520d0b4d0b5d182d0b5d0b920d0bed0b1d0bdd0bed0b2d0bad0b0d0bcd0b820d182d0b0d0ba20d187d0b0d181d182d0be2c20d0bad0b0d0ba20d0bdd0b8d0bad0bed0b3d0b4d0b0213c2f703e0a3c703e3c7374726f6e673ed091d180d0b5d0bdd0b4d18b3c2f7374726f6e673e3a203c7370616e2069643d22796774766c6162656c656c3130223e3c6120687265663d224469616d616e74696e612e68746d6c223e4469616d616e74696e613c2f613e2c203c2f7370616e3e3c7370616e2069643d22796774766c6162656c656c3131223e3c6120687265663d225374726565742d47616e672e68746d6c223e5374726565742047616e673c2f613e2c203c2f7370616e3e3c7370616e2069643d22796774766c6162656c656c3132223e3c6120687265663d22546f2d42652d546f6f2e68746d6c223e546f20426520546f6f3c2f613e2c203c2f7370616e3e3c6120687265663d2246554e616e6446554e2d6769726c2e68746d6c223e3c7370616e2069643d22796774766c6162656c656c3133223e46554e26616d703b46554e206769726c3c2f7370616e3e3c2f613e3c2f703e, NULL, 19, ''),
(20, 1326347325, 1326347325, 0x3c703e3c7374726f6e673e4469616d616e74696e613c2f7374726f6e673e202d20d0b8d182d0b0d0bbd18cd18fd0bdd181d0bad0b8d0b920d0b1d180d18dd0bdd0b420d0bfd180d0b5d0bcd0b8d183d0bc20d0bad0bbd0b0d181d181d0b020d0bdd0b0d180d18fd0b4d18320d18120223c7374726f6e673e46616e26616d703b46616e3c2f7374726f6e673e222e20d09ed182d0bbd0b8d187d0b8d182d0b5d0bbd18cd0bdd0bed0b920d187d0b5d180d182d0bed0b920d0b4d0b0d0bdd0bdd0bed0b920d0bcd0b0d180d0bad0b820d18fd0b2d0bbd18fd0b5d182d181d18f20d0bfd180d0b0d0bad182d0b8d187d0bdd0bed181d182d18c20d0b820d18dd0bad181d182d180d0b0d0b2d0b0d0b3d0b0d0bdd182d0bdd0bed181d182d18c2c20d18fd180d0bad0bed181d182d18c20d0bad180d0b0d181d0bed0ba20d0b820d0bdd0b5d0bed0b1d18bd187d0bdd18bd0b920d0b4d0b8d0b7d0b0d0b9d0bd2c20d0bfd0bed187d182d0b820d0b2d181d18f20d0bed0b4d0b5d0b6d0b4d0b020d0b4d0b5d0bad0bed180d0b8d180d0bed0b2d0b0d0bdd0b020d0bcd0b5d0bbd0bad0b8d0bcd0b820d0b1d0bbd0b5d181d182d0bad0b0d0bcd0b82c20d0b1d180d0bed188d0bad0b0d0bcd0b82c20d0b2d18bd188d0b8d0b2d0bad0b0d0bcd0b820d0b820d181d182d180d0b0d0b7d0b0d0bcd0b82e20d092d181d0b520d18dd182d0b820d0b4d0b5d182d0b0d0bbd0b820d0bfd180d0b5d0b2d180d0b0d189d0b0d18ed18220d0bfd0bed0b2d181d0b5d0b4d0bdd0b5d0b2d0bdd183d18e20d0bed0b4d0b5d0b6d0b4d18320d0b220d0bfd180d0b0d0b7d0b4d0bdd0b8d187d0bdd183d18e20d0b820d181d0bed0bed182d0b2d0b5d181d182d0b2d0b5d0bdd0bdd0bdd0be20d0bad0b0d0b6d0b4d18bd0b920d0b4d0b5d0bdd18c20d092d0b0d188d0b8d18520d0b4d0b5d182d0b5d0b920d0b220d0bfd180d0b0d0b7d0b4d0bdd0b8d0ba2e20d09ad0b0d187d0b5d181d182d0b2d0be20d0b4d0b0d0bdd0bdd0bed0b920d0bed0b4d0b5d0b6d0b4d18b20d0b2d181d0b5d0b3d0b4d0b020d0bdd0b020d0b2d18bd181d0bed182d0b52121213c2f703e, NULL, 20, ''),
(21, 1326347354, 1326358421, 0x3c703e3c7374726f6e673e5354524545542047414e473c2f7374726f6e673e266e6273703b202d20d0bed0b4d0b5d0b6d0b4d0b020d0b8d0b720d098d182d0b0d0bbd0b8d0b820d0b4d0bbd18f20d0bcd0b0d0bbd18cd187d0b8d0bad0bed0b220d0b820d0bfd0bed0b4d180d0bed181d182d0bad0bed0b22e20d09fd0bed0bcd0b8d0bcd0be20d0b1d183d0b7d183d0bfd180d0b5d187d0bdd0bed0b3d0be20d181d182d0b8d0bbd18f20d0b820d0b8d0bdd182d0b5d180d0b5d181d0bdd18bd18520d186d0b2d0b5d182d0bed0b2d18bd18520d180d0b5d188d0b5d0bdd0b8d0b92c20d0bdd183d0b6d0bdd0be20d0bed182d0bcd0b5d182d0b8d182d18c20d0b2d18bd181d0bed0bad0bed0b520d0bad0b0d187d0b5d181d182d0b2d0be20d0b8d0b7d0b4d0b5d0bbd0b8d0b92e20d091d0bed0bbd18cd188d0bed0b520d181d0bed0b4d0b5d180d0b6d0b0d0bdd0b8d0b520d185d0bbd0bed0bfd0bad0b020d0b220d0b8d181d0bfd0bed0bbd18cd0b7d183d0b5d0bcd18bd18520d182d0bad0b0d0bdd18fd18520d0b4d0b5d0bbd0b0d0b5d18220d0bed0b4d0b5d0b6d0b4d18320d0bed187d0b5d0bdd18c20d0bad0bed0bcd184d0bed180d0bdd0bed0b920d0b820d183d18ed182d0bdd0bed0b92e20d09cd0bed0b6d0bdd0be20d181d0bcd0b5d0bbd0be20d0bfd0bed0bad183d0bfd0b0d182d18c20d0b8d0b7d0b4d0b5d0bbd0b8d18f205354524545542047414e4720d0b220d0bed182d181d183d182d181d182d0b2d0b8d0b820d180d0b5d0b1d0b5d0bdd0bad0b02c20d0b2d0b5d189d0b820d0b8d0b4d183d18220d0b2d181d0b5d0b3d0b4d0b020d0b220d180d0b0d0b7d0bcd0b5d18020d0b820d0b7d0b020d182d0b0d0bad183d18e20d0bad180d0b0d181d0bed182d18320d092d0b0d18820d0bcd0bed0b4d0bdd0b8d0ba20d181d0bad0b0d0b6d0b5d18220d0bed0b3d180d0bed0bcd0bdd0bed0b520d181d0bfd0b0d181d0b8d0b1d0be2e203c6272202f3e3c6272202f3e3c7374726f6e673e5354524545542047414e473c2f7374726f6e673e266e6273703b202dd18dd182d0be266e6273703b20d0bcd0bed0bbd0bed0b4d0bed0b920d0b1d180d0b5d0bdd0b420d182d0bed180d0b3d0bed0b2d0bed0b920d0bcd0b0d180d0bad0b820546f2042656520546f6f2e20d09ed0b4d0b5d0b6d0b4d0b020d181d182d0b8d0bbd18f2063617375616c2c20d0bad0bed182d0bed180d0b0d18f20d181d0bed0bfd180d0bed0b2d0bed0b6d0b4d0b0d0b5d18220d181d0bed0b2d180d0b5d0bcd0b5d0bdd0bdd0bed0b3d0be20d0bfd0bed0b4d180d0bed181d182d0bad0b020d0b220d182d0b5d187d0b5d0bdd0b8d0b520d0b2d181d0b5d0b3d0be20d0b4d0bdd18f2e20d09220d0bad0bed0bbd0bbd0b5d0bad186d0b8d18fd18520d0bfd180d0b5d0b4d181d182d0b0d0b2d0bbd0b5d0bdd0b020d181d0b8d0bbd18cd0bdd0b0d18f20d0b4d0b6d0b8d0bdd181d0bed0b2d0b0d18f20d0bbd0b8d0bdd0b8d18f2e20d0a2d189d0b0d182d0b5d0bbd18cd0bdd18bd0b920d0bfd0bed0b4d185d0bed0b420d0ba20d180d0b0d0b7d180d0b0d0b1d0bed182d0bad0b520d0bad0b0d0b6d0b4d0bed0b920d0bcd0bed0b4d0b5d0bbd0b82c20d0b4d0bed180d0bed0b3d0b8d0b520d182d0bad0b0d0bdd0b82c20d181d0bcd0b5d0bbd18bd0b520d180d0b5d188d0b5d0bdd0b8d18f2c20d0bfd180d0bed181d182d0bed182d0b020d0b820d180d0bed181d0bad0bed188d18c20d0bed0b4d0bdd0bed0b2d180d0b5d0bcd0b5d0bdd0bdd0be2e20d09ed181d0bed0b1d0bed0b520d0b2d0bdd0b8d0bcd0b0d0bdd0b8d0b520d0ba20d0b4d0b5d182d0b0d0bbd18fd0bc20266e646173683b20d0bed182d0bbd0b8d187d0b8d182d0b5d0bbd18cd0bdd0b0d18f20d187d0b5d180d182d0b020d0bcd0b0d180d0bad0b82e3c2f703e0a3c703e266e6273703b3c2f703e0a3c70207374796c653d22746578742d616c69676e3a2063656e7465723b223e3c696d67207372633d22696d616765732f7374726565742d67616e672e706e672220616c743d22222077696474683d2235383022206865696768743d2233393622202f3e3c2f703e, NULL, 21, ''),
(22, 1326347384, 1326358444, 0x3c703e3c7374726f6e673e546f20426520546f6f3c2f7374726f6e673e202d20d098d182d0b0d0bbd0b8d18f2e3c6272202f3ed09ed0b4d0b5d0b6d0b4d0b02c20d0bad0bed182d0bed180d183d18e20d0bfd180d0b8d0b4d183d0bcd18bd0b2d0b0d18ed18220d0b8d182d0b0d0bbd18cd18fd0bdd181d0bad0b8d0b520d0b4d0b8d0b7d0b0d0b9d0bdd0b5d180d18b2c20d0b2d0bbd18ed0b1d0bbd0b5d0bdd0bdd18bd0b520d0b220d09dd18cd18e2dd099d0bed180d0ba2e20546f20626520546f6f202d20d18dd182d0be20d181d0bed187d0b5d182d0b0d0bdd0b8d0b520d0b8d182d0b0d0bbd18cd18fd0bdd181d0bad0bed0b3d0be20d188d0b8d0bad0b020d0b820d0b0d0bcd0b5d180d0b8d0bad0b0d0bdd181d0bad0bed0b3d0be20d0b1d183d0bdd182d0b0d180d181d0bad0bed0b3d0be20d0b4d183d185d0b02e20d09ad0bed0bbd0bbd0b5d0bad186d0b8d0b820d181d0bed181d182d0bed18fd18220d0b8d0b720d0bfd180d0bed181d182d18bd1852c20d0bdd0be20d0bed187d0b5d0bdd18c20d181d182d0b8d0bbd18cd0bdd18bd18520d0b2d0b5d189d0b5d0b92c20d0bad0bed182d0bed180d18bd18520d0b4d0bed0bbd0b6d0bdd0be20d0b1d18bd182d18c20d0bcd0bdd0bed0b3d0be20d0b220d0b3d0b0d180d0b4d0b5d180d0bed0b1d0b520d0bad0b0d0b6d0b4d0bed0b920d0b4d0b5d0b2d0bed187d0bad0b83a20d0b4d0b6d0b8d0bdd181d18b2c20d188d0bed180d182d18b2c20d184d183d182d0b1d0bed0bbd0bad0b82c20d182d0bed0bbd181d182d0bed0b2d0bad0b82c20d0b6d0b8d0bbd0b5d182d18b2c20d0b0d0bad181d0b5d181d181d183d0b0d180d18b2e3c6272202f3e3c6272202f3ed098d182d0b0d0bbd18cd18fd0bdd181d0bad0b0d18f20d0bad0bed0bcd0bfd0b0d0bdd0b8d18f20544f20424520544f4f20d181d0bed0b7d0b4d0b0d0b5d18220d0bed0b4d0b5d0b6d0b4d18320d0b4d0bbd18f20d0bcd0b0d0bbd0b5d0bdd18cd0bad0b8d18520d181d182d0b8d0bbd18cd0bdd18bd18520d0bad180d0b0d181d0b0d0b2d0b8d1862e20d09fd180d0b5d0b4d0bbd0b0d0b3d0b0d18f20d0b4d0b2d0b520d0bed181d0bdd0bed0b2d0bdd18bd0b520d0bbd0b8d0bdd0b8d0b820266e646173683b20d0bad0bed0bbd0bbd0b5d0bad186d0b8d0b8206261627920d0bdd0b020d0b2d0bed0b7d180d0b0d181d18220d0bed182203320d0b4d0be20313020d0bbd0b5d18220d0b820d0bad0bed0bbd0bbd0b5d0bad186d0b8d0b8206a756e696f7220d0b4d0bbd18f20d0b4d0b5d0b2d0bed187d0b5d0ba2dd182d0b8d0bdd0b5d0b9d0b4d0b6d0b5d180d0bed0b220266e646173683b20d0b4d0b8d0b7d0b0d0b9d0bdd0b5d180d18b20d0b220d0bad0b0d0b6d0b4d0bed0b920d0b2d0b5d189d0b820d0b2d0bed0bfd0bbd0bed189d0b0d18ed18220d183d0b7d0bdd0b0d0b2d0b0d0b5d0bcd18bd0b920d18fd180d0bad0b8d0b920d181d182d0b8d0bbd18c3a20d0bfd180d0b8d0b4d0b0d0bdd0b8d0b520d0bed0b1d0bbd0b8d0bad18320d0b2d0b7d180d0bed181d0bbd0bed0b3d0be20d0b6d0b5d0bdd181d0bad0bed0b3d0be20d0bed187d0b0d180d0bed0b2d0b0d0bdd0b8d18f20d0b1d0b5d0b720d0bfd0bed182d0b5d180d0b820d187d0b8d181d182d0bed182d18b20d0b820d0b7d0b0d0b4d0bed180d0b020d180d0b5d0b1d0b5d0bdd0bad0b02e20d094d0b5d182d181d0bad0b0d18f20d0bed0b4d0b5d0b6d0b4d0b020544f20424520544f4f20d0bfd180d0b5d0b2d180d0b0d189d0b0d0b5d18220d0b4d0b5d0b2d0bed187d0bad18320d0b220d0bfd180d0b8d0bdd186d0b5d181d181d1832dd0b1d183d0bdd182d0b0d180d0bad18320266e646173683b20d0bdd0b0d180d18fd0b4d0bdd183d18e2c20d0b4d0b5d180d0b7d0bad183d18e20d0b820d0b2d0b5d181d0b5d0bbd183d18e2e20266e6273703b3c6272202f3e3c6272202f3ed092d181d0b520d0bcd0bed0b4d0b5d0bbd0b820d0bcd0bed0b3d183d18220d0b1d18bd182d18c20d0b3d0b0d180d0bcd0bed0bdd0b8d187d0bdd0be20d0bed0b1d18ad0b5d0b4d0b8d0bdd0b5d0bdd18b20d0b220d0b0d0bdd181d0b0d0bcd0b1d0bbd0b82c20d0bfd180d0b5d0b4d181d182d0b0d0b2d0bbd18fd18f20d0b2d0bed0b7d0bcd0bed0b6d0bdd0bed181d182d0b820d0b4d0bbd18f20d181d0bed0b7d0b4d0b0d0bdd0b8d18f20d0bdd0b5d0bed0b3d180d0b0d0bdd0b8d187d0b5d0bdd0bdd0bed0b3d0be20d0bad0bed0bbd0b8d187d0b5d181d182d0b2d0b020d0b2d0b0d180d0b8d0b0d0bdd182d0bed0b220d0bdd0b020d0b2d181d0b520d181d0b5d0b7d0bed0bdd18b2c20d0b020d18fd180d0bad0b8d0b520d0b0d0bad181d0b5d181d181d183d0b0d180d18b20d0b7d0b0d0b2d0b5d180d188d0b0d18ed18220d0bed0b1d180d0b0d0b72c20d0bfd180d0b8d0b4d0b0d0b2d0b0d18f20d0b5d0bcd18320d0bfd0bed187d182d0b820d181d186d0b5d0bdd0b8d187d0b5d181d0bad183d18e20d186d0b5d0bbd0bed181d182d0bdd0bed181d182d18c2e20d09fd180d0bed181d182d0bed182d0b020d0b820d0b4d0b5d0bcd0bed0bad180d0b0d182d0b8d187d0bdd0bed181d182d18c20d181d182d0b8d0bbd18f20d182d0b0d0ba20d0b6d0b520d0bfd0bed0b7d0b2d0bed0bbd18fd18ed18220d181d0bed187d0b5d182d0b0d182d18c20d0bad0bed0bcd0bfd0bbd0b5d0bad182d18b20d0bed18220544f20424520544f4f20d18120d0b4d0b5d182d0b0d0bbd18fd0bcd0b820d0bed0b4d0b5d0b6d0b4d18b20d0b4d180d183d0b3d0b8d18520d0bfd180d0bed0b8d0b7d0b2d0bed0b4d0b8d182d0b5d0bbd0b5d0b92e20266e6273703b3c6272202f3e3c6272202f3ed094d0b0d0b2d0bdd0be20d0b7d0b0d0b2d0bed0b5d0b2d0b0d0b220d0b2d0bdd183d182d180d0b5d0bdd0bdd0b8d0b520d180d18bd0bdd0bad0b82c20d0bad0bed0bcd0bfd0b0d0bdd0b8d18f20d0bfd0bed181d182d0b5d0bfd0b5d0bdd0bdd0be20d0bfd180d0b8d0bed0b1d180d0b5d0bbd0b020d0b8d0b7d0b2d0b5d181d182d0bdd0bed181d182d18c20d0b220d095d0b2d180d0bed0bfd0b520d0b820d090d0bcd0b5d180d0b8d0bad0b52e20d09ed0bdd0b020d188d0b8d180d0bed0bad0be20d183d187d0b0d181d182d0b2d183d0b5d18220d0b220d181d0bed186d0b8d0b0d0bbd18cd0bdd18bd18520d0bfd180d0bed0b3d180d0b0d0bcd0bcd0b0d1852c20d181d0bfd0bed0bdd181d0b8d180d183d0b5d18220d0b4d0b5d182d181d0bad0b8d0b520d181d0b5d180d0b8d0b0d0bbd18b20d0b820d0bcd183d0b7d18bd0bad0b0d0bbd18cd0bdd18bd0b520d188d0bed1832c20d0bfd180d0b5d0b4d0bed181d182d0b0d0b2d0bbd18fd18f20d0bad0bed181d182d18ed0bcd18b20d0b4d0bbd18f20d18ed0bdd18bd18520d0b8d181d0bfd0bed0bbd0bdd0b8d182d0b5d0bbd0b5d0b92e20d0a1d0b5d0b3d0bed0b4d0bdd18f20d0b5d0b520d0bcd0bed0b4d0b5d0bbd0b820d0bfd0bed0bbd18cd0b7d183d18ed182d181d18f20d0bfd0bed0bfd183d0bbd18fd180d0bdd0bed181d182d18cd18e20d181d180d0b5d0b4d0b820d18ed0bdd18bd18520d0bcd0bed0b4d0bdd0b8d18620d0a0d0bed181d181d0b8d0b820266e646173683b20d0b7d0b020d181d182d0b8d0bbd18c20d0b820d0bdd0b5d0bed180d0b4d0b8d0bdd0b0d180d0bdd0bed181d182d18c2c20d0b820d181d180d0b5d0b4d0b820d0b8d18520d180d0bed0b4d0b8d182d0b5d0bbd0b5d0b920266e646173683b20d0b7d0b020d0bad0b0d187d0b5d181d182d0b2d0be20d0b820d0b0d0b4d0b5d0bad0b2d0b0d182d0bdd0bed181d182d18c20d186d0b5d0bd2e20266e6273703b3c6272202f3e3c6272202f3e266e6273703bd09cd18b20d186d0b5d0bdd0b8d0bc20d0bcd0bed0b4d0b5d0bbd0b820544f20424520544f4f20d0b7d0b020d0b8d0b4d0b5d0b0d0bbd18cd0bdd0bed0b520d181d0bed0bed182d0b2d0b5d182d181d182d0b2d0b8d0b520d181d0bfd0b5d186d0b8d184d0b8d0bad0b820d0bdd0bed181d0bad0b82c20d181d0b2d0bed0b9d181d182d0b2d0b5d0bdd0bdd0bed0b920d0b4d0b5d0b2d0bed187d0bad0b0d0bc20d0b220d182d0bed0bc20d0b2d0bed0b7d180d0b0d181d182d0b52c20d0bad0bed0b3d0b4d0b020d0b3d0bed182d0bed0b2d0bdd0bed181d182d18c20d0bfd180d0b8d0bdd18fd182d18c20d183d187d0b0d181d182d0b8d0b520d0b220d181d0b0d0bcd18bd18520d0b0d0bad182d0b8d0b2d0bdd18bd18520d0b8d0b3d180d0b0d18520d183d0b6d0b520d181d0bed0b5d0b4d0b8d0bdd0b5d0bdd0b020d18120d0b6d0b5d0bbd0b0d0bdd0b8d0b5d0bc20d0b2d18bd0b3d0bbd18fd0b4d0b5d182d18c20d0b6d0b5d0bdd181d182d0b2d0b5d0bdd0bdd0be20d0b820d0bfd180d0b8d0b2d0bbd0b5d0bad0b0d182d0b5d0bbd18cd0bdd0be2c20d0bad0bed0bcd0bfd0b0d0bdd0b8d18f20d181d0bed0b7d0b4d0b0d0b5d18220d0bcd0bed0b4d0b5d0bbd0b82c20d0bed181d0b2d0bed0b1d0bed0b6d0b4d0b0d18ed189d0b8d0b520d0bed18220d0bdd0b5d0bfd180d0bed181d182d0bed0b3d0be20d0b2d18bd0b1d0bed180d0b02e20d094d0b5d182d181d0bad0b0d18f20d0bed0b4d0b5d0b6d0b4d0b020544f20424520544f4f20d0b1d0bbd0b0d0b3d0bed0b4d0b0d180d18f20d0b2d18bd181d0bed0bad0bed0bcd18320d0bad0bbd0b0d181d181d18320d0bcd0b0d182d0b5d180d0b8d0b0d0bbd0bed0b22c20d0bad0b0d187d0b5d181d182d0b2d18320d0b8d181d0bfd0bed0bbd0bdd0b5d0bdd0b8d18f20d0b820d181d0bcd0b5d0bbd18bd0bc20d0b0d0b2d182d0bed180d181d0bad0b8d0bc20d180d0b5d188d0b5d0bdd0b8d18fd0bc20d0b220d0b4d0b8d0b7d0b0d0b9d0bdd0b520d0b4d0b0d0b5d18220d0b2d0bed0b7d0bcd0bed0b6d0bdd0bed181d182d18c20d0b1d18bd182d18c20d0bdd0b0d180d18fd0b4d0bdd0bed0b920d0b820d183d185d0bed0b6d0b5d0bdd0bdd0bed0b92c20d0bdd0b520d0bed182d0bad0b0d0b7d18bd0b2d0b0d18fd181d18c20d0bed18220d0bbd18ed0b1d18bd18520d0b4d0b5d182d181d0bad0b8d18520d180d0b0d0b7d0b2d0bbd0b5d187d0b5d0bdd0b8d0b92e3c2f703e0a3c703e266e6273703b3c2f703e0a3c70207374796c653d22746578742d616c69676e3a2063656e7465723b223e3c696d67207372633d22696d616765732f746f2d62652d746f6f2e706e672220616c743d22222077696474683d2235383022206865696768743d2233393622202f3e3c2f703e, NULL, 22, ''),
(23, 1326347490, 1326358473, 0x3c703e3c7374726f6e673ed0a1d182d180d0b0d0bdd0b02dd0bfd180d0bed0b8d0b7d0b2d0bed0b4d0b8d182d0b5d0bbd18c3a3c2f7374726f6e673e20d098d182d0b0d0bbd0b8d18f3c6272202f3e3c7374726f6e673ed092d0bed0b7d180d0b0d181d1823a3c2f7374726f6e673e20d0bed182203620d0bcd0b5d1812e20d0b4d0be20313620d0bbd0b5d1823c6272202f3ed09cd0b5d187d182d0b020d0bad0b0d0b6d0b4d0bed0b920d0b4d0b5d0b2d0bed187d0bad0b82021203c6272202f3e3c6272202f3ed098d181d182d0bed180d0b8d18f3a3c6272202f3e3c6272202f3ed0a2d0bed180d0b3d0bed0b2d0b0d18f20d0bcd0b0d180d0bad0b020d0b4d0b5d182d181d0bad0bed0b920d0b820d0bfd0bed0b4d180d0bed181d182d0bad0bed0b2d0bed0b920d0bed0b4d0b5d0b6d0b4d18b20266c6171756f3b46554e2026616d703b2046554e206769726c26726171756f3b20d18fd0b2d0bbd18fd0b5d182d181d18f20d181d0bed0b1d181d182d0b2d0b5d0bdd0bdd0bed181d182d18cd18e20d09ad0bed0bcd0bfd0b0d0bdd0b8d0b82047696f2e204672616e2e20426162792053726c2e20d09cd0bdd0bed0b3d0bed0bbd0b5d182d0bdd0b8d0b920d0bed0bfd18bd18220d180d0b0d0b1d0bed182d18b20d0bad0bed0bcd0bfd0b0d0bdd0b8d0b820d0b220d0bed0b1d0bbd0b0d181d182d0b820d0bfd180d0bed0b8d0b7d0b2d0bed0b4d181d182d0b2d0b020d0bed0b4d0b5d0b6d0b4d18b20d0b820d0b5d0b520d180d0b5d0b0d0bbd0b8d0b7d0b0d186d0b8d0b820d0bdd0b020d180d18bd0bdd0bad0b0d18520d098d182d0b0d0bbd0b8d0b820d0b820d095d0b2d180d0bed0bfd18b20d0bfd0bed0b4d181d0bad0b0d0b7d0b0d0bb20d0b2d0b5d180d0bdd0bed0b520d0bdd0b0d0bfd180d0b0d0b2d0bbd0b5d0bdd0b8d0b520d0b220d0b4d0b5d182d181d0bad0bed0b920d0bcd0bed0b4d0b52c20d181d0b4d0b5d0bbd0b0d0b220d0b0d0bad186d0b5d0bdd18220d0bdd0b020d0bed0b4d0b5d0b6d0b4d18320d0b4d0bbd18f20d0bcd0b0d0bbd0b5d0bdd18cd0bad0b8d18520d0b4d0b5d0b2d0bed187d0b5d0ba20d0b820d18ed0bdd18bd18520d0b4d0b5d0b2d183d188d0b5d0ba2e20d09cd0bed0b4d0bdd0b0d18f2c20d18fd180d0bad0b0d18f2c20d0b8d0b7d18fd189d0bdd0b0d18f2c20d0b3d0bbd0b0d0bcd183d180d0bdd0b0d18f20d0bcd0b0d180d0bad0b020266c6171756f3b46554e26616d703b46554e206769726c26726171756f3b20d181d180d0b0d0b7d18320d0b6d0b520d0b7d0b0d0bdd18fd0bbd0b020d0bfd180d0bed187d0bdd18bd0b520d0bfd0bed0b7d0b8d186d0b8d0b82c20d0b7d0b0d0b2d0bed0b5d0b2d0b0d0b220d0bbd18ed0b1d0bed0b2d18c20d18320d18ed0bdd18bd18520d0bcd0bed0b4d0bdd0b8d1862e203c6272202f3e3c6272202f3ed09820d0bdd0b520d181d0bbd183d187d0b0d0b9d0bdd0be2e20d092d0b5d0b4d18c20d182d0b2d0bed180d187d0b5d181d0bad0b8d0b920d0bad0bed0bbd0bbd0b5d0bad182d0b8d0b220d0bcd0b0d180d0bad0b820266c6171756f3b46554e26616d703b46554e206769726c26726171756f3b20d0bed0b1d0bbd0b0d0b4d0b0d0b5d18220d183d0bdd0b8d0bad0b0d0bbd18cd0bdd0bed0b920d181d0bfd0bed181d0bed0b1d0bdd0bed181d182d18cd18e20d0bfd180d0b5d0b4d183d0b3d0b0d0b4d18bd0b2d0b0d182d18c20d0b8d0b7d0bcd0b5d0bdd0b5d0bdd0b8d18f20d0b220d0bcd0b8d180d0b520d0b4d0b5d182d181d0bad0bed0b920d0bcd0bed0b4d18b2c20d0b4d0b5d0b9d181d182d0b2d0bed0b2d0b0d182d18c20d0b1d18bd181d182d180d0be20d0b820d183d0b2d0b5d180d0b5d0bdd0bdd0be2c20d181d0bed0b7d0b4d0b0d0b2d0b0d18f20d0bdd0b5d0bfd0bed0b2d182d0bed180d0b8d0bcd18bd0b520d0bad0bed0bbd0bbd0b5d0bad186d0b8d0b820d0bed0b4d0b5d0b6d0b4d18b20d0b4d0bbd18f20d0b4d0b5d0b2d0bed187d0b5d0ba20d0bed182203620d0bcd0b5d181d18fd186d0b5d0b220d0b4d0be2031362dd182d0b820d0bbd0b5d1822e203c6272202f3e3c6272202f3e266c6171756f3b46554e26616d703b46554e26726171756f3b2120d0a4d0b8d0bbd0bed181d0bed184d0b8d18f20d0b1d180d0b5d0bdd0b4d0b020d0b7d0b0d0bad0bbd18ed187d0b0d0b5d182d181d18f20d183d0b6d0b520d0b220d181d0b0d0bcd0bed0bc20d0bdd0b0d0b7d0b2d0b0d0bdd0b8d0b82e20d0a8d183d182d0bbd0b8d0b2d18bd0b920d185d0b0d180d0b0d0bad182d0b5d18020d0b820d0b3d0bbd0b0d0bcd183d180d0bdd18bd0b920d181d182d0b8d0bbd18c20d0bad0bed0bbd0bbd0b5d0bad186d0b8d0b92c20d0bdd0b5d0bed0b1d18bd187d0bdd18bd0b520d181d0bed187d0b5d182d0b0d0bdd0b8d18f20d186d0b2d0b5d182d0bed0b220d0b820d0bcd0bed0b4d0bdd18bd0b520d0b4d0b5d182d0b0d0bbd0b820d0bfd180d0b8d0b4d0b0d18ed18220d0bed0b1d180d0b0d0b7d18320d0bcd0b0d0bbd0b5d0bdd18cd0bad0b8d18520d0bbd0b5d0b4d0b820d0bdd0b5d0bed0b1d18bd0bad0bdd0bed0b2d0b5d0bdd0bdd183d18e20d0bbd0b5d0b3d0bad0bed181d182d18c2c20d0b7d0b0d0b4d0bed180d0bdd0bed181d182d18c2c20d0b2d0bed0b7d0b4d183d188d0bdd0bed181d182d18c2e203c6272202f3e3c6272202f3ed09ad0bed0bbd0bbd0b5d0bad186d0b8d18f20d0b4d0bbd18f20d0b4d0b5d0b2d0bed187d0b5d0ba20266c6171756f3b46554e26616d703b46554e206769726c26726171756f3b20d0bfd0bed0b7d0b2d0bed0bbd18fd0b5d18220d18ed0bdd18bd0bc20d0bcd0bed0b4d0bdd0b8d186d0b0d0bc20d187d183d0b2d181d182d0b2d0bed0b2d0b0d182d18c20d181d0b5d0b1d18f20d0bdd0b5d0bed182d180d0b0d0b7d0b8d0bcd18bd0bcd0b820d0bdd0b520d182d0bed0bbd18cd0bad0be20d0bdd0b020d0b2d0b0d0b6d0bdd18bd18520d182d0bed180d0b6d0b5d181d182d0b2d0b0d1852c20d0bdd0be20d0b820d0b220d0bfd0bed0b2d181d0b5d0b4d0bdd0b5d0b2d0bdd0bed0b920d0b6d0b8d0b7d0bdd0b82e20d09ed0b4d0b5d0b6d0b4d0b02c20d0b2d18bd0bfd0bed0bbd0bdd0b5d0bdd0bdd0b0d18f20d0b220d181d182d0b8d0bbd0b520266c6171756f3b63617375616c206368696326726171756f3b2c20266e646173683b20d18dd182d0be20d0b8d0b7d18fd189d0bdd0b0d18f20d0bed0b4d0b5d0b6d0b4d0b020d18120d181d183d0bfd0b5d180d0bcd0bed0b4d0bdd18bd0bcd0b820d0b0d0bad186d0b5d0bdd182d0b0d0bcd0b820d0b4d0bbd18f20d0bed181d0bed0b1d18bd18520d181d0bbd183d187d0b0d0b5d0b220d0b820d0bdd0b520d182d0bed0bbd18cd0bad0be2e20d092d18bd0b1d0bed18020d0bcd0bed0b4d0b5d0bbd0b5d0b920d0bed187d0b5d0bdd18c20d180d0b0d0b7d0bdd0bed0bed0b1d180d0b0d0b7d0b5d0bd20d0b820d188d0b8d180d0bed0ba3a20d18120d0bdd0b8d0bcd0b820d0bcd0bed0b6d0bdd0be20d0b8d0bcd0bfd180d0bed0b2d0b8d0b7d0b8d180d0bed0b2d0b0d182d18c2c20d0b2d0b5d189d0b820d0bcd0bed0b6d0bdd0be20d181d0bed187d0b5d182d0b0d182d18c20d181d0b0d0bcd18bd0bc20d0bdd0b5d0b2d0b5d180d0bed18fd182d0bdd18bd0bc20d0bed0b1d180d0b0d0b7d0bed0bc2c20d0bfd180d0b820d18dd182d0bed0bc20d181d0bed185d180d0b0d0bdd18fd18f20d0b6d0b5d0bdd181d182d0b2d0b5d0bdd0bdd18bd0b920d0b820d188d0b0d0bbd0bed0b2d0bbd0b8d0b2d18bd0b920d0b2d0b8d0b42c20d181d182d0bed0bbd18c20d0bfd180d0b8d181d183d189d0b8d0b920d0b1d180d0b5d0bdd0b4d18320266c6171756f3b46554e26616d703b46554e206769726c26726171756f3b2e3c6272202f3e3c6272202f3e266c6171756f3b3c7374726f6e673e46554e26616d703b46554e206769726c3c2f7374726f6e673e26726171756f3b20266e646173683b20d18dd182d0be20d0bed0b4d0b5d0b6d0b4d0b02c20d0bad0bed182d0bed180d0b0d18f20d0bfd0bed0b7d0b2d0bed0bbd18fd0b5d18220d0b7d0b0d18fd0b2d0b8d182d18c20d0be20d181d0b5d0b1d0b520d18120d181d0b0d0bcd0bed0b3d0be20d180d0b0d0bdd0bdd0b5d0b3d0be20d0b2d0bed0b7d180d0b0d181d182d0b0213c2f703e0a3c70207374796c653d22746578742d616c69676e3a2063656e7465723b223e3c696d67207372633d22696d616765732f66616e2d66616e2e6a70672220616c743d22222077696474683d2235383022206865696768743d2234313022202f3e3c2f703e, NULL, 23, ''),
(24, 1328595085, 1328595195, 0x3c703e5b6e6577735f6d6f64756c653f73656374696f6e3d385d3c2f703e, NULL, 24, '');

-- --------------------------------------------------------

--
-- Table structure for table `code_menu_revision`
--

CREATE TABLE IF NOT EXISTS `code_menu_revision` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `record_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `page_title` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `keywords` text COLLATE utf8_bin NOT NULL,
  `page_description` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `seo_url` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `published` int(10) unsigned NOT NULL DEFAULT '0',
  `active` int(10) unsigned NOT NULL DEFAULT '1',
  `google_priority` varchar(3) COLLATE utf8_bin NOT NULL DEFAULT '',
  `access` varchar(255) COLLATE utf8_bin NOT NULL,
  `header_image` varchar(255) COLLATE utf8_bin NOT NULL,
  `created_user_id` varchar(255) COLLATE utf8_bin NOT NULL,
  `updated_user_id` varchar(255) COLLATE utf8_bin NOT NULL,
  `content` text COLLATE utf8_bin,
  `page_type` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `template` varchar(255) COLLATE utf8_bin NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Dumping data for table `code_menu_revision`
--


-- --------------------------------------------------------

--
-- Table structure for table `code_news_module`
--

CREATE TABLE IF NOT EXISTS `code_news_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `items` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `code_news_module`
--

INSERT INTO `code_news_module` (`id`, `name`, `items`, `created`, `updated`) VALUES
(7, 'СТАТЬИ', 10, 1326426149, 1326426149),
(8, 'АКЦИИ', 10, 0, 0),
(6, 'НОВОСТИ', 10, 1326426131, 1326426131);

-- --------------------------------------------------------

--
-- Table structure for table `code_news_module_entry`
--

CREATE TABLE IF NOT EXISTS `code_news_module_entry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `short` text NOT NULL,
  `full` text NOT NULL,
  `created` int(11) NOT NULL DEFAULT '0',
  `updated` int(11) NOT NULL DEFAULT '0',
  `news_id` int(11) NOT NULL DEFAULT '0',
  `publish` int(11) NOT NULL DEFAULT '1',
  `adddate` date NOT NULL DEFAULT '0000-00-00',
  `addtime` time NOT NULL DEFAULT '00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `code_news_module_entry`
--

INSERT INTO `code_news_module_entry` (`id`, `name`, `short`, `full`, `created`, `updated`, `news_id`, `publish`, `adddate`, `addtime`) VALUES
(8, 'Смешные советы по воспитанию детей ', '<p>Ваш ребенок будет относиться к вам с большим уважением и признает в вас  "своего", если вы невзначай попросите его помочь застегнуть булавку в  носу или спросите, какого цвета платок лучше всего намотать на голову,  идя на работу.</p>', '<p>Ваш ребенок будет относиться к вам с большим уважением и признает в вас "своего", если вы невзначай попросите его помочь застегнуть булавку в носу или спросите, какого цвета платок лучше всего намотать на голову, идя на работу.<br /><br />Если вашему ребенку уже хорошо за сорок, а он все еще пускает слюни и писается в штаны, попробуйте некоторое время не орать на ребенка и перестать бить его ремнем по попе при посторонних.<br /><br />Не секрет, что многие дети любят играть в прятки. А родители не хотят с ними играть из-за якобы постоянной занятости. А что, если попробовать совместить работу с игрой? Спрячьтесь от ребенка, например, в командировке, и целую неделю он будет вас искать.<br /><br />Что делать, если ваш сын залез на дерево и не может слезть? Ни в коем случае не пытайтесь трясти дерево или сбивать мальчика палкой. Осенью ребенок созреет и упадет сам.<br /><br />Отучить ребенка играть со спичками можно следующим образом: забудьте несколько раз на видном месте спичечный коробок с анализами.<br /><br />Чтобы забыть о детских комплексах неполноценности, никогда не давайте своему ребенку почувствовать ваше умственное или физическое превосходство. Для этого во время серьезных разговоров с сыном косите глазами, ковыряйте в носу и пускайте слюни.<br /><br />Если ваш ребенок икает, закройте уши. Это на время избавит вас от икоты.<br /><br />Если ваш ребенок иногда ворует у вас деньги, ни в коем случае не кричите на него, чтобы не травмировать психику. Лучше всего весело и непринужденно провести обыск в комнате ребенка, а затем всей семьей поиграть в суд или в расстрел.<br /><br />Чтобы лучше понять вашего ребенка, вам нужно думать и чувствовать так, как это делает он. Попробуйте вжиться в образ вашего сына: покурите тайком от себя сигарету и незаметно разбейте три-четыре окна из рогатки.<br /><br />Причин, по которым ваш ребенок не слушается вас, может быть множество: ваш ребенок плохо слышит, вы тихо говорите, он не понимает то, что вы говорите, вы сами не понимаете то, что вы говорите, и т.д. Что же делать? К счастью, средство есть: по попе, по попе и еще раз по попе.<br /><br />Определить, что ваш сын в очередной раз влюбился, можно по следующим признакам: он часами прихорашивается перед зеркалом, следит за своим внешним видом и лексиконом, от него пахнет вашим одеколоном, а из вашего кошелька пропадают деньги. Определить окончание краткосрочного романа можно по следующим признакам: ваш сын неряшлив, в разговоре появились грубые выражения, от него пахнет сигаретами, а из вашего кошелька пропадают деньги.<br /><br />Если вы намереваетесь ударить ваше чадо ремнем по попе, убедитесь, что с ремня сняты пейджер, мобильный телефон и кобура с пистолетом, - иначе воспитательный эффект принесет гораздо больше пользы, чем вы рассчитываете.<br /><br />Научить вашего ребенка осторожному поведению на балконе можно следующим образом. Возьмите большой, слегка подгнивший помидор, покажите его своему ребенку и скажите: "Представь, что это - твоя голова". Затем сбросьте помидор с балкона, желательно на асфальт. После этого выйдите с ребенком во двор и внимательно изучите помидорное пятно. Как правило, после этого нехитрого эксперимента дети до глубокой старости вообще не подходят к балконной двери.<br /><br />Если ваш ребенок постоянно на всех дуется, купите ему тромбон. У ребенка талант.<br /><br />Если ваш ребенок плохо кушает, общество "Чистые тарелки" рекомендует. Приготовленный обед разбросайте по всей детской и запустите туда ребенка. Ваш малыш обязательно будет подымать с пола всякую гадость и тащить ее в рот. Вскоре ребенок будет сыт, и тарелки мыть не надо.<br /><br />Рецепт приготовления ребенка ко сну. Возьмите молодого ребенка - не более 15 кг. Тщательно смойте с него грязь в теплой воде. Заверните чистое тельце в пижаму и слегка прижмите его к груди. В течение пяти минут медленно покачивайте. Затем процедите сквозь зубы сказку и тщательно уложите ребенка в заранее приготовленную посудину, желательно - кровать. Обложите размякшего ребенка с боков мягкими игрушками. Машинки и пупсики по вкусу. Накройте сверху плотно одеялом и при этом сделайте в детской маленький огонек, чтобы ребенок "не сбежал". Через час ребенок готов. Готовность можно определить по слегка подрумянившимся щечкам.</p>', 1326426481, 1326426481, 7, 1, '2012-01-13', '06:47:00'),
(9, 'Таблица размеров', '<ul>\r\n<li><strong><em><span style="color: #ff0000;"><span style="font-size: medium;">Многим родителям хотелось бы, чтобы их дети выглядели стильными и модными, для этого немаловажное значение имеют размеры детской одежды, но не всегда имеется возможность примерить вещи. В различных частях света существует своя шкала измерений и на данный момент установить единые размеры детской одежды</span></span></em></strong><strong><em><span style="color: #ff0000;"><span style="font-size: medium;"> достаточно сложно.</span></span></em></strong><span style="text-decoration: underline;"><br /><strong> <br /></strong><strong><br /><br /> </strong></span></li>\r\n</ul>', '<p><strong><em><span style="color: #ff0000;"><span style="font-size: medium;">Многим родителям хотелось бы, чтобы их дети выглядели стильными и модными, для этого немаловажное значение имеют размеры детской одежды, но не всегда имеется возможность примерить вещи. В различных частях света существует своя шкала измерений и на данный момент установить единые размеры детской одежды достаточно сложно.</span></span></em></strong><br /><strong> <em class="rside"></em></strong></p>\r\n<p><strong><em class="rside"><span style="font-size: medium;"><span style="color: #00ff00;">В России, странах Европпы и США существует разница между обозначениями:</span></span></em><br /></strong><span style="font-size: medium;"><span style="color: #ff00ff;"><em><strong></strong></em></span></span></p>\r\n<p><span style="font-size: medium;"><span style="color: #ff00ff;"><em><strong>- в России и Франции очень часто на одежде указывается рост ребенка;<br />- американские размеры детской одежды обозначаются цифрами, в которых очень трудно так просто разобраться;</strong></em></span></span><strong><br /><span style="font-size: medium;"><em></em></span></strong></p>\r\n<p><strong><span style="font-size: medium;"><em><span style="color: #00ffff;">- в некоторых странах Европы размеры обозначаются просто латинскими буквами. </span></em></span><br /><br /> </strong><span style="color: #ff6600;"><em><span style="font-size: medium;"><strong>Но даже одни и те-же цифры на ярлыках одежды различных стран могут соответствовать совершенно разным размерам. Например, одежду из Франции приобретайте на один размер больше, так как она маломерит, одежду из Германии, Италии и Дании надо покупать на размер меньше, так как она чаще всего большемерит на размер а то и на полтора. Если Вы сомневаетесь по поводу выбора одежды загляните в таблицы размеров детской одежды, а лучше проконсультируйтесь у продавца. <br /><br />&nbsp; Примерная таблица размеров детской одежды приведена ниже.</strong></span></em></span></p>', 1326426526, 1328233024, 7, 1, '2012-01-31', '10:46:00'),
(10, 'Мы открылись!', '<p>Мы открылись!!!</p>', '<p>Мы открылись!!!</p>', 1327554800, 1327554800, 6, 1, '2012-01-26', '08:12:00'),
(11, 'Ещё новость', '<p>аы ыфолфыо&nbsp; фываорфыва фы вафгыва фырва фыва фыварфывлафыва фыв аф ыварфыва фыв афырвафыв афывраф ывда</p>', '', 1327555347, 1327555347, 6, 1, '2012-01-26', '08:22:00'),
(7, 'Стихотворение про маму', '<p>Много горя у ребенка, как младенца жизнь трудна!<br /> И печалью и скорбями сплошь наполнена она! <br /> Те, кто вырос, забывают и никак уж не поймут: <br /> Воспитанье папы с мамой тяжкий, каждодневный труд.</p>', '<p>Много горя у ребенка, как младенца жизнь трудна! <br />И печалью и скорбями сплошь наполнена она! <br />Те, кто вырос, забывают и никак уж не поймут: <br />Воспитанье папы с мамой тяжкий, каждодневный труд. <br /><br />Мама, барыня какая! Положила и ушла! <br />И вот то, чем занята ты, называется &laquo;дела&raquo;? <br />Эта стирка и уборка, протирание полов <br />Лишь отмазка, отговорка от действительных делов! <br /><br />Что ты тряпкой там елозишь? Что посудой там гремишь? <br />Положи ты пыль на место! Слышишь, что сказал малыш? <br />Ты, лентяйка, не старайся притворяться занятой. <br />Хоть не вижу, но уверен: занимаешься фигней. <br /><br />Ну-ка быстро брось котлету! Я же плачу: хватит жрать! <br />Чтобы делом занялась ты, сколько можно мне орать? <br />Наконец-то подошла ты Ну! На ручки-то бери! <br />Вооо! Дошло? Вот это дело: целый день меня носи! <br /><br />Наигрался, нагулялся, мама положила спать. <br />Вдруг во сне я испугался, надо маму срочно звать. <br />Со мной мама поскакала, убаюкала опять. <br />Буду спать теперь я долго, можешь мама тоже спать. <br /><br />Только что-то неспокойно началось вдруг с животом. <br />Мама, обними скорее, поцелуй, поспишь потом. <br />Мама снова поскакала, попыталась грудь мне дать. <br />Ладно, мама, засыпаю, положи меня в кровать. <br /><br />Но в кровати не лежится, жестко, холодно мне тут. <br />Мне б сейчас на ручки к маме и услышать сердца стук. <br />Со мной снова мама скачет. Можешь мама не скакать. <br />Если буду я на ручках, буду я отлично спать. <br /><br />Что такое? Что случилось? Нос не дышит, мамы нет. <br />Заору: &laquo;Ну где ты, мама?&raquo; Сколько ночью всяких бед. <br />Носик дышит, пузо в норме, добрый сон пришел в кровать. <br />Мама, спи. Малыш в кроватке будет очень крепко спать. <br /><br />Хочется перевернуться, в бортик врезался и вот, <br />Я сижу кричу и ною, да еще щекочет рот. <br />Помоги скорее, мама, не могу уснуть опять. <br />Очень уж хочу я, мама, перелезть к тебе в кровать. <br /><br />Мама десна мне намажет, поменяет мне штаны, <br />Грудь мне даст, споет и спляшет, скажет: &laquo;Люди спать должны&raquo;. <br />Ладно, мама, спать я буду только на тебе пока. <br />Мама снова поскакала, чтобы усыпить дитя. <br /><br />Я глазенки открываю. Что я вижу? Расцвело! <br />Мама, мама, просыпайся, уже солнышко взошло! <br />Что за тетенька с глазами как у рыбы-камбалы? <br />Что у тети с волосами? Дыбом встали все они.</p>\r\n<p>Смотрит тетенька безумно! Может маму мне позвать? <br />Это мама, запах чую! Мамочка, давай играть!!!</p>', 1326426438, 1326426438, 7, 1, '2012-01-13', '06:45:00'),
(14, 'Акция', '<p>Мы открылись!</p>', '<p>авыавы</p>', 1328594971, 1328594982, 8, 1, '2012-02-07', '09:09:00'),
(15, '123', '<p>123</p>', '', 1331543460, 1331543460, 7, 1, '2012-03-12', '12:09:00'),
(16, '32', '<p>32</p>', '', 1331543464, 1331543464, 7, 1, '2012-03-12', '12:11:00'),
(17, '32', '<p>32</p>', '', 1331543467, 1331543467, 7, 1, '2012-03-12', '12:11:00'),
(18, '32', '<p>32</p>', '', 1331543470, 1331543470, 7, 1, '2012-03-12', '12:11:00'),
(19, '32', '<p>32</p>', '', 1331543472, 1331543472, 7, 1, '2012-03-12', '12:11:00'),
(20, '32', '<p>32</p>', '', 1331543475, 1331543475, 7, 1, '2012-03-12', '12:11:00'),
(21, '32', '<p>32</p>', '', 1331543477, 1331543477, 7, 1, '2012-03-12', '12:11:00'),
(22, '32', '<p>32</p>', '', 1331543483, 1331543483, 7, 1, '2012-03-12', '12:11:00');

-- --------------------------------------------------------

--
-- Table structure for table `code_popup_module`
--

CREATE TABLE IF NOT EXISTS `code_popup_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_seo` varchar(255) NOT NULL,
  `link_text` varchar(255) NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `code_popup_module`
--


-- --------------------------------------------------------

--
-- Table structure for table `code_price`
--

CREATE TABLE IF NOT EXISTS `code_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL DEFAULT '0',
  `width` varchar(255) NOT NULL DEFAULT '',
  `height` varchar(255) NOT NULL DEFAULT '',
  `price` varchar(255) NOT NULL DEFAULT '',
  `created` int(11) NOT NULL DEFAULT '0',
  `updated` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=414 ;

--
-- Dumping data for table `code_price`
--


-- --------------------------------------------------------

--
-- Table structure for table `code_product`
--

CREATE TABLE IF NOT EXISTS `code_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `item_code` varchar(255) NOT NULL DEFAULT '',
  `number` varchar(255) NOT NULL DEFAULT '',
  `price` double NOT NULL DEFAULT '0',
  `newprice` double NOT NULL,
  `lash_type` int(11) NOT NULL DEFAULT '0',
  `weight` int(11) NOT NULL DEFAULT '0',
  `order_no` int(11) NOT NULL DEFAULT '0',
  `picture1` varchar(255) NOT NULL,
  `picture2` varchar(255) NOT NULL,
  `picture3` varchar(255) NOT NULL,
  `picture4` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `full_description` text NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT '0',
  `subcategory_picture` int(1) NOT NULL DEFAULT '0',
  `created` int(11) NOT NULL DEFAULT '0',
  `updated` int(11) NOT NULL DEFAULT '0',
  `quantity` int(11) NOT NULL DEFAULT '1',
  `inactive` int(1) NOT NULL DEFAULT '0',
  `featured` int(1) NOT NULL,
  `seo` varchar(255) NOT NULL,
  `has_options` int(1) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `not_wholesale` int(1) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `other_info` text NOT NULL,
  `keywords` text NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `page_description` text NOT NULL,
  `house` varchar(255) NOT NULL,
  `release_year` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `m_e_classification` int(11) NOT NULL,
  `top_notes` varchar(255) NOT NULL,
  `heart_notes` varchar(255) NOT NULL,
  `base_notes` varchar(255) NOT NULL,
  `fragrance_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `code_product`
--


-- --------------------------------------------------------

--
-- Table structure for table `code_product_option`
--

CREATE TABLE IF NOT EXISTS `code_product_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL DEFAULT '0',
  `item_code` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `small_name` varchar(255) NOT NULL,
  `price` double NOT NULL DEFAULT '0',
  `weight` varchar(255) NOT NULL DEFAULT '',
  `order_no` int(11) NOT NULL DEFAULT '0',
  `created` int(11) NOT NULL DEFAULT '0',
  `updated` int(11) NOT NULL DEFAULT '0',
  `inactive` int(1) NOT NULL,
  `quantity` int(11) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `other_info` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `code_product_option`
--


-- --------------------------------------------------------

--
-- Table structure for table `code_product_review`
--

CREATE TABLE IF NOT EXISTS `code_product_review` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `approved` int(1) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `code_product_review`
--


-- --------------------------------------------------------

--
-- Table structure for table `code_restore_password`
--

CREATE TABLE IF NOT EXISTS `code_restore_password` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `confirmation_code` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `password` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `status` int(11) NOT NULL DEFAULT '0',
  `created` int(11) NOT NULL DEFAULT '0',
  `updated` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=38 ;

--
-- Dumping data for table `code_restore_password`
--

INSERT INTO `code_restore_password` (`id`, `user_id`, `confirmation_code`, `password`, `status`, `created`, `updated`) VALUES
(1, 611, '88744e71776c91074d399881c06f8b9c', '88744e', 0, 1271249961, 1271249961),
(2, 648, '3af126c875ea70135a4608457835b5c6', '3af126', 0, 1271303988, 1271303988),
(3, 98, 'a5e6976449f16e18d444d5810186e273', 'a5e697', 0, 1271488237, 1271488237),
(4, 98, '293eba817e495c0284f16576cc4f7afd', '293eba', 0, 1271488384, 1271488384),
(5, 271, '6f3c17157b00088513ded069b368e11e', '6f3c17', 0, 1271744529, 1271744529),
(6, 665, '8309d136cf1e78f5c8bcac158d110ec8', '8309d1', 0, 1271746761, 1271746761),
(7, 665, 'a10b6b64ff314f5ae0109629c7f2c99a', 'a10b6b', 0, 1271747077, 1271747077),
(8, 665, 'c2c223433607248e3c2f5e1db68b3296', 'c2c223', 0, 1271747205, 1271747205),
(9, 665, '04e216f254a237f68bf4e0c9c901bf69', '04e216', 0, 1271747826, 1271747826),
(10, 665, '84d58475153bc48634521a63f429638f', '84d584', 0, 1271814092, 1271814092),
(11, 5, 'd14d66eba0c2c2cb965f6ec7b94d9a4f', 'd14d66', 0, 1271825424, 1271825424),
(12, 5, '71d4038059c64c4f821b0c8aee6902b2', '71d403', 1, 1271825942, 1271825957),
(13, 5, 'c1ae67e2f0b8db9f9e12df51e3b22105', 'c1ae67', 1, 1271827111, 1271827130),
(14, 665, '267a55253c2427412adf4d5a72b4293b', '267a55', 0, 1271827208, 1271827208),
(15, 98, 'a83d3d08c24540e2ecd8fbf578fe0b81', 'a83d3d', 1, 1272007045, 1272007065),
(16, 266, 'd62d4b5f7866ca9d87e947a2c3772b62', 'd62d4b', 1, 1272243824, 1272326109),
(17, 633, '28baedfb5088a885421076d4f6562b09', '28baed', 1, 1272716781, 1272716812),
(18, 98, '17d1ac088569ac0cd8852d15ed34b714', '17d1ac', 1, 1273540028, 1273540119),
(19, 641, '1a8d6db3412f2dbe0d18261469a5f63e', '1a8d6d', 0, 1273721622, 1273721622),
(20, 780, '9ee58da389adbde64c5026e7fadfd7ab', '9ee58d', 1, 1274155512, 1274155753),
(21, 5, '64987455ae6a4a8856f6718df9ae655a', '649874', 1, 1274155791, 1274155826),
(22, 780, '15c3e6b7d58aa14cb3682c4cb0db04aa', '15c3e6', 1, 1274156088, 1274156104),
(23, 44, '63ea1a09adbded02051da8675bf98e7a', '63ea1a', 1, 1274261962, 1274262367),
(24, 799, '3523665f3fa4fe22a634fc2b75aa7249', '352366', 1, 1275632966, 1275633230),
(25, 611, '1e797da11b7ac341e9ac97534a262347', '1e797d', 1, 1275650436, 1275650479),
(26, 611, '256ece8e43b09efd050c5580fe23fddf', '256ece', 1, 1275650536, 1275650595),
(27, 657, '36e2bf0922bfe8488003707b44fedec2', '36e2bf', 1, 1275721610, 1275721634),
(28, 797, '448c424e77f4b56611fbed9ff6213684', '448c42', 1, 1275763027, 1275763092),
(29, 69, '706f4e7e1c6194bf8eb056a93e7016cb', '706f4e', 1, 1275977926, 1275977964),
(30, 592, '418a2f75c824a06dd7488ab24d558dd6', '418a2f', 1, 1276084981, 1276085169),
(31, 592, '1424a5dd3adcf6cd45923403b3a6bf40', '1424a5', 1, 1276085358, 1276085382),
(32, 592, '94c76add3f987f6936f660207fde61ea', '94c76a', 1, 1276124975, 1276124992),
(33, 655, '202316ae5d3904c3179ffe9bd069f751', '202316', 0, 1276472421, 1276472421),
(34, 817, '75a597f497d7d282d638c7beb3784aa3', '75a597', 1, 1277016922, 1277016943),
(35, 819, 'd60cfa557dd395628f781a9244025936', 'd60cfa', 0, 1277257133, 1277257133),
(36, 2, 'bbb718ea1416864a3bfb846e71c7318a', 'bbb718', 1, 1294181573, 1294181674),
(37, 17, '2a11051a3b2ced148ea8bbdeab1fca2b', '2a1105', 1, 1297725149, 1297725255);

-- --------------------------------------------------------

--
-- Table structure for table `code_rss`
--

CREATE TABLE IF NOT EXISTS `code_rss` (
  `rss_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rss_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `rss_list` smallint(5) unsigned NOT NULL DEFAULT '0',
  `rss_ajax` tinyint(1) NOT NULL DEFAULT '0',
  `rss_title` tinyint(1) NOT NULL DEFAULT '0',
  `rss_pubdate` tinyint(1) NOT NULL DEFAULT '0',
  `rss_description` tinyint(1) NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `updated` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`rss_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `code_rss`
--

INSERT INTO `code_rss` (`rss_id`, `rss_url`, `rss_list`, `rss_ajax`, `rss_title`, `rss_pubdate`, `rss_description`, `created`, `updated`) VALUES
(1, 'http://www.scenarhealth.com/blog/feed/', 4, 0, 1, 0, 0, 1291795207, 1292914097);

-- --------------------------------------------------------

--
-- Table structure for table `code_session`
--

CREATE TABLE IF NOT EXISTS `code_session` (
  `id` varchar(32) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `content` longblob NOT NULL,
  `created` int(11) NOT NULL DEFAULT '0',
  `updated` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `code_session`
--

INSERT INTO `code_session` (`id`, `content`, `created`, `updated`) VALUES
('e7e026cdfb1ae59e4603bde8e80c5a07', 0x6e6577735f6c6973747c613a343a7b733a333a2273716c223b733a32373a222a2046524f4d202370236e6577735f6d6f64756c655f656e747279223b733a373a2266696c74657273223b613a323a7b693a303b613a323a7b733a313a2266223b733a373a226e6577735f6964223b733a313a2276223b733a313a2236223b7d693a313b613a323a7b733a313a2266223b733a373a227075626c697368223b733a313a2276223b693a313b7d7d733a363a22706172616d73223b613a323a7b733a31343a226974656d735f7065725f70616765223b693a333b733a383a226f726465725f6279223b613a313a7b693a303b733a32363a226164646461746520444553432c2061646474696d652044455343223b7d7d733a31323a2263757272656e745f70616765223b693a313b7d, 1335260569, 1335260610);

-- --------------------------------------------------------

--
-- Table structure for table `code_settings`
--

CREATE TABLE IF NOT EXISTS `code_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `width` int(11) NOT NULL DEFAULT '0',
  `height` int(11) NOT NULL DEFAULT '0',
  `paypal` int(1) NOT NULL DEFAULT '1',
  `credit_card` int(1) NOT NULL DEFAULT '0',
  `products_per_page` int(11) NOT NULL DEFAULT '10',
  `categories_per_page` int(11) NOT NULL DEFAULT '10',
  `created` int(11) NOT NULL DEFAULT '0',
  `updated` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `code_settings`
--

INSERT INTO `code_settings` (`id`, `width`, `height`, `paypal`, `credit_card`, `products_per_page`, `categories_per_page`, `created`, `updated`) VALUES
(1, 180, 150, 1, 0, 10, 10, 0, 1241669601);

-- --------------------------------------------------------

--
-- Table structure for table `code_settings_new`
--

CREATE TABLE IF NOT EXISTS `code_settings_new` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `value` varchar(255) NOT NULL DEFAULT '',
  `created` int(11) NOT NULL DEFAULT '0',
  `updated` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=74 ;

--
-- Dumping data for table `code_settings_new`
--

INSERT INTO `code_settings_new` (`id`, `name`, `value`, `created`, `updated`) VALUES
(1, 'show_on_top', '1', 1244012165, 1299039200),
(20, 'featured_per_page', '1', 1244099351, 1299039200),
(3, 'height', '0', 1244012728, 1321195603),
(4, 'width', '0', 1244012728, 1321195603),
(5, 'remind_email', '', 1244012873, 1321195580),
(6, 'remind_name', '', 1244012873, 1321195580),
(7, 'remind_subject', '', 1244012873, 1321195580),
(8, 'deposit', '0', 1244013107, 1321195631),
(9, 'paypal', '0', 1244013107, 1321195631),
(10, 'credit_card', '0', 1244013107, 1321195631),
(11, 'direct_deposit_email', '', 1244013436, 1321195589),
(12, 'direct_deposit_from_email', '', 1244013436, 1321195589),
(13, 'direct_deposit_from_name', '', 1244013436, 1321195589),
(14, 'credit_card_email', '', 1244013436, 1321195589),
(15, 'credit_card_from_email', '', 1244013436, 1321195589),
(16, 'credit_card_name', '', 1244013436, 1321195589),
(17, 'products_per_page', '6', 1244013528, 1299039200),
(18, 'categories_per_page', '6', 1244013528, 1299039200),
(19, 'show_on_left', '0', 1244028281, 1299039200),
(21, 'featured_on_module', '1', 1244202318, 1244202322),
(22, 'featured_random', '1', 1244202318, 1244202322),
(23, 'coupon_product', '1', 1245336294, 1299039200),
(24, 'coupon_category', '1', 1245336294, 1299039200),
(25, 'color', '', 1245838719, 1321195603),
(26, 'rows_per_category', '3', 1246968545, 1299039200),
(27, 'tip_height', '0', 1247467967, 1321195603),
(28, 'tip_width', '0', 1247467967, 1321195603),
(29, 'tip_color', '', 1247467967, 1321195603),
(30, 'use_out_of_stock', '0', 1248945203, 1321195647),
(31, 'discount_point', '', 1251202264, 1299039200),
(32, 'discount_limit', '0', 1251202264, 1299039200),
(33, 'new_product_days', '21', 1251203902, 1299039200),
(34, 'smtp_check', '0', 1254916870, 1321195655),
(35, 'smtp_admin_register_email', '', 1254916870, 1321195655),
(36, 'smtp_admin_from_email', '', 1254916870, 1321195655),
(37, 'smtp_admin_from', '', 1254916870, 1321195655),
(38, 'smtp_admin_subject', '', 1254916870, 1321195655),
(39, 'smtp_server', '', 1254916870, 1321195655),
(40, 'smtp_port', '0', 1254916870, 1321195655),
(41, 'smtp_username', '', 1254916870, 1321195655),
(42, 'smtp_password', '', 1254916870, 1321195655),
(43, 'option_height', '0', 1257339448, 1321195623),
(44, 'option_width', '0', 1257339448, 1321195623),
(45, 'option_color', '', 1257339448, 1321195623),
(46, 'option_tip_height', '0', 1257339448, 1321195623),
(47, 'option_tip_width', '0', 1257339448, 1321195623),
(48, 'option_tip_color', '', 1257339448, 1321195623),
(49, 'reviews_only_logged', '0', 1258551105, 1321195663),
(50, 'review_number', '0', 1258551105, 1321195663),
(51, 'review_admin_number', '0', 1258551105, 1321195663),
(52, 'review_admin_email', '', 1258551105, 1321195663),
(53, 'review_admin_subject', '', 1258551105, 1321195663),
(54, 'cross_height', '0', 1281439237, 1321195611),
(55, 'cross_width', '0', 1281439237, 1321195611),
(56, 'cross_tip_height', '0', 1281439515, 1321195611),
(57, 'cross_tip_width', '0', 1281439515, 1321195611),
(58, 'low_stock_limit', '1', 1281526005, 1321195647),
(59, 'low_stock_notify', '0', 1281526005, 1321195647),
(60, 'low_stock_email', '', 1281526005, 1321195647),
(61, 'friend_site_name', '', 1281957367, 1321195669),
(62, 'friend_subject', '', 1281957367, 1321195669),
(63, 'friend_captcha', '0', 1281957367, 1321195669),
(64, 'columns_per_category', '4', 1282117721, 1299039200),
(65, 'Blog_User', 'chris@scenarhealth.com', 1256730562, 1256730562),
(66, 'Blog_Password', 'de2ab0ea74a2dcac594bcc3ad1c98304', 1256730562, 1256730562),
(67, 'Blog_Login_Page', 'http://www.scenarhealth.com/blog/wp-admin/', 0, 0),
(68, 'Blog_Redirect_Page', 'http://www.scenarhealth.com/blog/wp-admin/', 0, 0),
(69, 'blog_redirect_page', 'http://www.scenarhealth.com/blog/wp-admin/', 0, 0),
(70, 'blog_login_page', 'http://www.scenarhealth.com/blog/wp-admin/', 0, 0),
(71, 'blog_password', 'Lanf5e2ac', 0, 0),
(72, 'blog_user', 'chris@scenarhealth.com', 0, 0),
(73, 'shipping_type', '1', 1292574972, 1299039200);

-- --------------------------------------------------------

--
-- Table structure for table `code_testimonial_module`
--

CREATE TABLE IF NOT EXISTS `code_testimonial_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `items_per_page` int(11) NOT NULL,
  `seo_page` varchar(255) NOT NULL,
  `timer` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `code_testimonial_module`
--

INSERT INTO `code_testimonial_module` (`id`, `name`, `description`, `created`, `updated`, `items_per_page`, `seo_page`, `timer`) VALUES
(5, '12', '12112112221', 1259920785, 1259920785, 12312, '123123', 12);

-- --------------------------------------------------------

--
-- Table structure for table `code_testimonial_module_entry`
--

CREATE TABLE IF NOT EXISTS `code_testimonial_module_entry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `order_no` int(11) NOT NULL,
  `active` int(1) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `testimonial_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `code_testimonial_module_entry`
--


-- --------------------------------------------------------

--
-- Table structure for table `code_text_module`
--

CREATE TABLE IF NOT EXISTS `code_text_module` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `updated` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `module_text` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=6 ;

--
-- Dumping data for table `code_text_module`
--

INSERT INTO `code_text_module` (`id`, `created`, `updated`, `title`, `module_text`) VALUES
(4, 1292992048, 1292992048, 'Home Page Flash', 0x3c68343e5363656e61722053706f727420262053706f72742044202d2074686520646966666572656e63652e2e3c2f68343e0d0a3c6f626a6563742077696474683d2233303522206865696768743d22313936223e3c706172616d206e616d653d226d6f766965222076616c75653d22687474703a2f2f7777772e796f75747562652e636f6d2f762f314f775775774370436c383f66733d3126616d703b686c3d656e5f474226616d703b72656c3d30223e3c2f706172616d3e3c706172616d206e616d653d22616c6c6f7746756c6c53637265656e222076616c75653d2274727565223e3c2f706172616d3e3c706172616d206e616d653d22616c6c6f77736372697074616363657373222076616c75653d22616c77617973223e3c2f706172616d3e3c656d626564207372633d22687474703a2f2f7777772e796f75747562652e636f6d2f762f314f775775774370436c383f66733d3126616d703b686c3d656e5f474226616d703b72656c3d302220747970653d226170706c69636174696f6e2f782d73686f636b776176652d666c6173682220616c6c6f777363726970746163636573733d22616c776179732220616c6c6f7766756c6c73637265656e3d2274727565222077696474683d2233303522206865696768743d22313936223e3c2f656d6265643e3c2f6f626a6563743e),
(5, 1298248870, 1298332739, 'A current Affair video program', 0x203c736372697074207372633d226a732f7377666f626a6563745f6d6f6469666965642e6a732220747970653d22746578742f6a617661736372697074223e3c2f7363726970743e0d0a0d0a203c6f626a65637420636c61737369643d22636c7369643a44323743444236452d414536442d313163662d393642382d343434353533353430303030222077696474683d2234323022206865696768743d22333038222069643d22466c617368494422207469746c653d22412043757272656e7420416666616972202d205363656e6172204865616c746820223e0d0a2020202020203c706172616d206e616d653d226d6f766965222076616c75653d227377662f612d63757272656e742d6166666169722d766964656f2e73776622202f3e0d0a2020202020203c706172616d206e616d653d227175616c697479222076616c75653d226869676822202f3e0d0a2020202020203c706172616d206e616d653d22776d6f6465222076616c75653d226f706171756522202f3e0d0a2020202020203c706172616d206e616d653d2273776676657273696f6e222076616c75653d22362e302e36352e3022202f3e0d0a2020202020203c212d2d205468697320706172616d207461672070726f6d707473207573657273207769746820466c61736820506c6179657220362e302072363520616e642068696768657220746f20646f776e6c6f616420746865206c61746573742076657273696f6e206f6620466c61736820506c617965722e2044656c65746520697420696620796f7520646f6ee28099742077616e7420757365727320746f20736565207468652070726f6d70742e202d2d3e0d0a2020202020203c706172616d206e616d653d2265787072657373696e7374616c6c222076616c75653d227377662f65787072657373496e7374616c6c2e73776622202f3e0d0a2020202020203c212d2d204e657874206f626a6563742074616720697320666f72206e6f6e2d49452062726f77736572732e20536f20686964652069742066726f6d204945207573696e6720494543432e202d2d3e0d0a2020202020203c212d2d5b6966202149455d3e2d2d3e0d0a2020202020203c6f626a65637420747970653d226170706c69636174696f6e2f782d73686f636b776176652d666c6173682220646174613d227377662f612d63757272656e742d6166666169722d766964656f2e737766222077696474683d2234323022206865696768743d22333038223e0d0a20202020202020203c212d2d3c215b656e6469665d2d2d3e0d0a20202020202020203c706172616d206e616d653d227175616c697479222076616c75653d226869676822202f3e0d0a20202020202020203c706172616d206e616d653d22776d6f6465222076616c75653d226f706171756522202f3e0d0a20202020202020203c706172616d206e616d653d2273776676657273696f6e222076616c75653d22362e302e36352e3022202f3e0d0a20202020202020203c706172616d206e616d653d2265787072657373696e7374616c6c222076616c75653d227377662f65787072657373496e7374616c6c2e73776622202f3e0d0a20202020202020203c212d2d205468652062726f7773657220646973706c6179732074686520666f6c6c6f77696e6720616c7465726e617469766520636f6e74656e7420666f72207573657273207769746820466c61736820506c6179657220362e3020616e64206f6c6465722e202d2d3e0d0a20202020202020203c6469763e0d0a202020202020202020203c68343e436f6e74656e74206f6e207468697320706167652072657175697265732061206e657765722076657273696f6e206f662041646f626520466c61736820506c617965722e3c2f68343e0d0a202020202020202020203c703e3c6120687265663d22687474703a2f2f7777772e61646f62652e636f6d2f676f2f676574666c617368706c61796572223e3c696d67207372633d22687474703a2f2f7777772e61646f62652e636f6d2f696d616765732f7368617265642f646f776e6c6f61645f627574746f6e732f6765745f666c6173685f706c617965722e6769662220616c743d224765742041646f626520466c61736820706c61796572222077696474683d2231313222206865696768743d22333322202f3e3c2f613e3c2f703e0d0a20202020202020203c2f6469763e0d0a20202020202020203c212d2d5b6966202149455d3e2d2d3e0d0a2020202020203c2f6f626a6563743e0d0a2020202020203c212d2d3c215b656e6469665d2d2d3e0d0a202020203c2f6f626a6563743e0d0a202020203c73637269707420747970653d22746578742f6a617661736372697074223e0d0a3c212d2d0d0a7377666f626a6563742e72656769737465724f626a6563742822466c617368494422293b0d0a2f2f2d2d3e0d0a3c2f7363726970743e);

-- --------------------------------------------------------

--
-- Table structure for table `code_tops_module`
--

CREATE TABLE IF NOT EXISTS `code_tops_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `count` int(11) NOT NULL DEFAULT '0',
  `created` int(11) NOT NULL DEFAULT '0',
  `updated` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `code_tops_module`
--

INSERT INTO `code_tops_module` (`id`, `count`, `created`, `updated`) VALUES
(1, 3, 1266844296, 1266844306),
(2, 5, 1266844311, 1266844311);

-- --------------------------------------------------------

--
-- Table structure for table `code_user`
--

CREATE TABLE IF NOT EXISTS `code_user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `updated` int(10) unsigned NOT NULL DEFAULT '0',
  `login` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `groups` varchar(255) NOT NULL DEFAULT '',
  `last_login` int(10) unsigned NOT NULL DEFAULT '0',
  `num_logins` int(10) unsigned NOT NULL DEFAULT '0',
  `disabled` int(1) NOT NULL,
  `discount_point` double NOT NULL,
  `howhear` int(11) NOT NULL,
  `subscribe` int(11) NOT NULL,
  `wholesale` int(1) NOT NULL,
  `referral_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `code_user`
--

INSERT INTO `code_user` (`user_id`, `created`, `updated`, `login`, `password`, `email`, `groups`, `last_login`, `num_logins`, `disabled`, `discount_point`, `howhear`, `subscribe`, `wholesale`, `referral_id`) VALUES
(1, 0, 0, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'pavel@evaxsoft.com', 'admin', 1332151295, 84, 0, 0, 0, 0, 0, 0),
(2, 1299052180, 1299052180, 'sannek', '352cda9fd4068dccbfef8e28fb3e617e', 'sannek@sannek.ru', 'user', 1299664128, 4, 0, 0, 0, 0, 0, 0);
