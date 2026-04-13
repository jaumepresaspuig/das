#
# Table structure for table 'pages'
#
CREATE TABLE pages (
    tx_das_logo smallint(1) unsigned DEFAULT '0' NOT NULL,
    tx_das_showlanguageselector smallint(1) unsigned DEFAULT '0' NOT NULL,
    tx_das_searchpageuid int(11) unsigned DEFAULT '0' NOT NULL,
    tx_das_navigationlevels smallint(1) unsigned DEFAULT '1' NOT NULL,
    tx_das_structureddata varchar(255) DEFAULT 'json' NOT NULL,
    tx_das_breadcrumb smallint(1) unsigned DEFAULT '0' NOT NULL,
    tx_das_breadcrumbseparator char(2) DEFAULT '/' NOT NULL,
    tx_das_showpagetitle smallint(1) unsigned DEFAULT '0' NOT NULL,
    tx_das_columns smallint(1) unsigned DEFAULT '1' NOT NULL,
    tx_das_bstheme varchar(255) DEFAULT '' NOT NULL,
    tx_das_megamenu smallint(1) unsigned DEFAULT '0' NOT NULL
);

#
# Table structure for table 'tt_content'
#
CREATE TABLE tt_content (
    tx_das_htmlinheader smallint(1) unsigned DEFAULT '0' NOT NULL,
    tx_das_galleryanimate smallint(1) unsigned DEFAULT '0' NOT NULL,
    tx_das_order1 smallint(1) unsigned DEFAULT '0' NOT NULL,
    tx_das_imageratio varchar(255) DEFAULT '4x3' NOT NULL,
    tx_das_customclasses varchar(255) DEFAULT '' NOT NULL,
    tx_das_customstyles text DEFAULT '' NOT NULL,
    tx_das_visibility smallint(2) unsigned DEFAULT '0' NOT NULL,
    tx_das_dropshadow smallint(1) unsigned DEFAULT '0' NOT NULL,
    tx_das_bgpredefinedcolor varchar(255) DEFAULT '' NOT NULL,
    tx_das_bgcolor varchar(255) DEFAULT '' NOT NULL,
    tx_das_bgimage smallint(1) unsigned DEFAULT '0' NOT NULL,
    tx_das_bgoverlay varchar(255) DEFAULT '' NOT NULL,
    tx_das_bgoverlayvignete smallint(1) unsigned DEFAULT '0' NOT NULL,
    tx_das_fixedbg smallint(1) unsigned DEFAULT '0' NOT NULL,
    tx_das_textcolor varchar(255) DEFAULT '' NOT NULL,
    tx_das_gallerywidth smallint(1) unsigned DEFAULT '6' NOT NULL,
    tx_das_faicon varchar(255) DEFAULT '' NOT NULL,
    tx_das_fasize varchar(255) DEFAULT '' NOT NULL,
    tx_das_fapredefinedcolor varchar(255) DEFAULT '' NOT NULL,
    tx_das_facolor varchar(255) DEFAULT '' NOT NULL,
    tx_das_faposition varchar(255) DEFAULT '' NOT NULL,
    tx_das_textincolumns smallint(1) unsigned DEFAULT '1' NOT NULL,
    tx_das_hidecaption smallint(1) unsigned DEFAULT '0' NOT NULL,
    tx_das_stylemenu smallint(1) unsigned DEFAULT '0' NOT NULL,
    tx_das_pagegallery smallint(1) unsigned DEFAULT '0' NOT NULL,
    tx_das_poll text DEFAULT '' NOT NULL,
);

#
# Table structure for table 'sys_file_metadata'
#
CREATE TABLE sys_file_metadata (
    tx_das_cover smallint(1) unsigned DEFAULT '0' NOT NULL
);
