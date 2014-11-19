#
# Table structure for table 'tx_pfjcsvimporter_domain_model_csvimporter'
#
CREATE TABLE tx_pfjcsvimporter_domain_model_csvimporter (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumtext,
	sorting int(10) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	starttime int(11) DEFAULT '0' NOT NULL,
	endtime int(11) DEFAULT '0' NOT NULL,
	fe_group int(11) DEFAULT '0' NOT NULL,
	item_number tinytext,
	item_name tinytext,
	buy tinytext,
	sell tinytext,
	inventory tinytext,
	item_pic tinytext,
	description text,
	custlist_1 tinytext,
	sellingprice tinytext,
	show_onsite tinytext,
	metal tinytext,
	brand tinytext,
	stone_details tinytext,
	quant_break_1 tinytext,
	
	PRIMARY KEY (uid),
	KEY parent (pid)

);
