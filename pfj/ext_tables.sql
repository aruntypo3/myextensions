#
# Table structure for table 'tx_pfj_items'
#
CREATE TABLE tx_pfj_items (
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
	asset_acct int(11) DEFAULT '0' NOT NULL,
	income_acct int(11) DEFAULT '0' NOT NULL,
	expcos_acct int(11) DEFAULT '0' NOT NULL,
	item_pic tinytext,
	description text,
	use_desc_on_sale tinytext,
	custlist_1 tinytext,
	custlist_2 tinytext,
	custlist_3 tinytext,
	custfield_1 tinytext,
	custfield_2 tinytext,
	custfield_3 tinytext,
	prim_supplier tinytext,
	supplier_item_number tinytext,
	tax_code_when_bought tinytext,
	buy_unit_measure int(11) DEFAULT '0' NOT NULL,
	items_buy_unit int(11) DEFAULT '0' NOT NULL,
	reorder_quant int(11) DEFAULT '0' NOT NULL,
	min_level int(11) DEFAULT '0' NOT NULL,
	sellingprice tinytext,
	sell_unit_measure int(11) DEFAULT '0' NOT NULL,
	tax_code_when_sold tinytext,
	sell_price_inclusive tinytext,
	sales_tax_calc_method int(11) DEFAULT '0' NOT NULL,
	items_sell_unit int(11) DEFAULT '0' NOT NULL,
	quant_break_1 int(11) DEFAULT '0' NOT NULL,
	quant_break_2 int(11) DEFAULT '0' NOT NULL,
	quant_break_3 int(11) DEFAULT '0' NOT NULL,
	quant_break_4 int(11) DEFAULT '0' NOT NULL,
	quant_break_5 int(11) DEFAULT '0' NOT NULL,
	level_a_break_1 int(11) DEFAULT '0' NOT NULL,
	level_b_break_1 int(11) DEFAULT '0' NOT NULL,
	level_c_break_1 int(11) DEFAULT '0' NOT NULL,
	level_d_break_1 int(11) DEFAULT '0' NOT NULL,
	level_e_break_1 int(11) DEFAULT '0' NOT NULL,
	level_f_break_1 int(11) DEFAULT '0' NOT NULL,
	level_a_break_2 int(11) DEFAULT '0' NOT NULL,
	level_b_break_2 int(11) DEFAULT '0' NOT NULL,
	level_c_break_2 int(11) DEFAULT '0' NOT NULL,
	level_d_break_2 int(11) DEFAULT '0' NOT NULL,
	level_e_break_2 int(11) DEFAULT '0' NOT NULL,
	level_f_break_2 int(11) DEFAULT '0' NOT NULL,
	level_a_break_3 int(11) DEFAULT '0' NOT NULL,
	level_b_break_3 int(11) DEFAULT '0' NOT NULL,
	level_c_break_3 int(11) DEFAULT '0' NOT NULL,
	level_d_break_3 int(11) DEFAULT '0' NOT NULL,
	level_e_break_3 int(11) DEFAULT '0' NOT NULL,
	level_f_break_3 int(11) DEFAULT '0' NOT NULL,
	level_a_break_4 int(11) DEFAULT '0' NOT NULL,
	level_b_break_4 int(11) DEFAULT '0' NOT NULL,
	level_c_break_4 int(11) DEFAULT '0' NOT NULL,
	level_d_break_4 int(11) DEFAULT '0' NOT NULL,
	level_e_break_4 int(11) DEFAULT '0' NOT NULL,
	level_f_break_4 int(11) DEFAULT '0' NOT NULL,
	level_a_break_5 int(11) DEFAULT '0' NOT NULL,
	level_b_break_5 int(11) DEFAULT '0' NOT NULL,
	level_c_break_5 int(11) DEFAULT '0' NOT NULL,
	level_d_break_5 int(11) DEFAULT '0' NOT NULL,
	level_e_break_5 int(11) DEFAULT '0' NOT NULL,
	level_f_break_5 int(11) DEFAULT '0' NOT NULL,
	inactive_item tinytext,
	standard_cost tinytext,
	default_ship_loc tinytext,
	default_recvd_loc tinytext,
	show_onsite tinytext,
	metal tinytext,
	brand tinytext,
	stone_details tinytext,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);

#
# Table structure for table 'fe_users'
#
CREATE TABLE fe_users (
         card_id text,
	     babylinks text,
	     luvlets text,
	     address_line2 text,
	     address_line3 text,
);



#
# Table structure for table 'tx_pfj_items'
#
CREATE TABLE tx_pfj_items_order (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

        userId int(11) DEFAULT '0' NOT NULL,
        productUid int(11) DEFAULT '0' NOT NULL,
        productQuanity int(11) DEFAULT '0' NOT NULL,
        productPrice varchar(255) DEFAULT '' NOT NULL,


	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);
