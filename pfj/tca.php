<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$TCA['tx_pfj_items'] = array(
    'ctrl' => $TCA['tx_pfj_items']['ctrl'],
    'interface' => array(
        'showRecordFieldList' => 'sys_language_uid,l10n_parent,l10n_diffsource,hidden,starttime,endtime,fe_group,item_number,item_name,buy,sell,inventory,asset_acct,income_acct,expcos_acct,item_pic,description,use_desc_on_sale,show_onsite,metal,brand,stone_details,custlist_1,custlist_2,custlist_3,custfield_1,custfield_2,custfield_3,prim_supplier,supplier_item_number,tax_code_when_bought,buy_unit_measure,items_buy_unit,reorder_quant,min_level,sellingprice,sell_unit_measure,tax_code_when_sold,sell_price_inclusive,sales_tax_calc_method,items_sell_unit,quant_break_1,quant_break_2,quant_break_3,quant_break_4,quant_break_5,level_a_break_1,level_b_break_1,level_c_break_1,level_d_break_1,level_e_break_1,level_f_break_1,level_a_break_2,level_b_break_2,level_c_break_2,level_d_break_2,level_e_break_2,level_f_break_2,level_a_break_3,level_b_break_3,level_c_break_3,level_d_break_3,level_e_break_3,level_f_break_3,level_a_break_4,level_b_break_4,level_c_break_4,level_d_break_4,level_e_break_4,level_f_break_4,level_a_break_5,level_b_break_5,level_c_break_5,level_d_break_5,level_e_break_5,level_f_break_5,inactive_item,standard_cost,default_ship_loc,default_recvd_loc'
    ),
    'feInterface' => $TCA['tx_pfj_items']['feInterface'],
    'columns' => array(
        'sys_language_uid' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
            'config' => array(
                'type' => 'select',
                'foreign_table' => 'sys_language',
                'foreign_table_where' => 'ORDER BY sys_language.title',
                'items' => array(
                    array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
                    array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
                )
            )
        ),
        'l10n_parent' => array(
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
            'config' => array(
                'type' => 'select',
                'items' => array(
                    array('', 0),
                ),
                'foreign_table' => 'tx_pfj_items',
                'foreign_table_where' => 'AND tx_pfj_items.pid=###CURRENT_PID### AND tx_pfj_items.sys_language_uid IN (-1,0)',
            )
        ),
        'l10n_diffsource' => array(
            'config' => array(
                'type' => 'passthrough'
            )
        ),
        'hidden' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
            'config' => array(
                'type' => 'check',
                'default' => '0'
            )
        ),
        'starttime' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
            'config' => array(
                'type' => 'input',
                'size' => '8',
                'max' => '20',
                'eval' => 'date',
                'default' => '0',
                'checkbox' => '0'
            )
        ),
        'endtime' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',
            'config' => array(
                'type' => 'input',
                'size' => '8',
                'max' => '20',
                'eval' => 'date',
                'checkbox' => '0',
                'default' => '0',
                'range' => array(
                    'upper' => mktime(3, 14, 7, 1, 19, 2038),
                    'lower' => mktime(0, 0, 0, date('m') - 1, date('d'), date('Y'))
                )
            )
        ),
        'fe_group' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.fe_group',
            'config' => array(
                'type' => 'select',
                'items' => array(
                    array('', 0),
                    array('LLL:EXT:lang/locallang_general.xml:LGL.hide_at_login', -1),
                    array('LLL:EXT:lang/locallang_general.xml:LGL.any_login', -2),
                    array('LLL:EXT:lang/locallang_general.xml:LGL.usergroups', '--div--')
                ),
                'foreign_table' => 'fe_groups'
            )
        ),
        'item_number' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.item_number',
            'config' => array(
                'type' => 'input',
                'size' => '30',
                'eval' => 'required',
            )
        ),
        'item_name' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.item_name',
            'config' => array(
                'type' => 'input',
                'size' => '30',
                'eval' => 'required',
            )
        ),
        'buy' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.buy',
            'config' => array(
                'type' => 'input',
                'size' => '30',
            )
        ),
        'sell' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.sell',
            'config' => array(
                'type' => 'input',
                'size' => '30',
            )
        ),
        'inventory' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.inventory',
            'config' => array(
                'type' => 'input',
                'size' => '30',
            )
        ),
        'asset_acct' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.asset_acct',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'income_acct' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.income_acct',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'expcos_acct' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.expcos_acct',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'item_pic' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.item_pic',
            'config' => array(
                'type' => 'input',
                'size' => '30',
            )
        ),
        'description' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.description',
            'config' => array(
                'type' => 'text',
                'cols' => '30',
                'rows' => '5',
            )
        ),
        'use_desc_on_sale' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.use_desc_on_sale',
            'config' => array(
                'type' => 'input',
                'size' => '30',
            )
        ),
        'custlist_1' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.custlist_1',
            'config' => array(
                'type' => 'input',
                'size' => '30',
            )
        ),
        'custlist_2' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.custlist_2',
            'config' => array(
                'type' => 'input',
                'size' => '30',
            )
        ),
        'custlist_3' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.custlist_3',
            'config' => array(
                'type' => 'input',
                'size' => '30',
            )
        ),
        'custfield_1' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.custfield_1',
            'config' => array(
                'type' => 'input',
                'size' => '30',
            )
        ),
        'custfield_2' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.custfield_2',
            'config' => array(
                'type' => 'input',
                'size' => '30',
            )
        ),
        'custfield_3' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.custfield_3',
            'config' => array(
                'type' => 'input',
                'size' => '30',
            )
        ),
        'prim_supplier' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.prim_supplier',
            'config' => array(
                'type' => 'input',
                'size' => '30',
            )
        ),
        'supplier_item_number' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.supplier_item_number',
            'config' => array(
                'type' => 'input',
                'size' => '30',
            )
        ),
        'tax_code_when_bought' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.tax_code_when_bought',
            'config' => array(
                'type' => 'input',
                'size' => '30',
            )
        ),
        'buy_unit_measure' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.buy_unit_measure',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'items_buy_unit' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.items_buy_unit',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'reorder_quant' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.reorder_quant',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'min_level' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.min_level',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'sellingprice' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.sellingprice',
            'config' => array(
                'type' => 'input',
                'size' => '30',
                'eval' => 'required',
            )
        ),
        'sell_unit_measure' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.sell_unit_measure',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'tax_code_when_sold' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.tax_code_when_sold',
            'config' => array(
                'type' => 'input',
                'size' => '30',
            )
        ),
        'sell_price_inclusive' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.sell_price_inclusive',
            'config' => array(
                'type' => 'input',
                'size' => '30',
            )
        ),
        'sales_tax_calc_method' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.sales_tax_calc_method',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'items_sell_unit' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.items_sell_unit',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'quant_break_1' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.quant_break_1',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'quant_break_2' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.quant_break_2',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'quant_break_3' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.quant_break_3',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'quant_break_4' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.quant_break_4',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'quant_break_5' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.quant_break_5',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'level_a_break_1' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.level_a_break_1',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'level_b_break_1' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.level_b_break_1',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'level_c_break_1' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.level_c_break_1',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'level_d_break_1' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.level_d_break_1',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'level_e_break_1' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.level_e_break_1',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'level_f_break_1' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.level_f_break_1',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'level_a_break_2' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.level_a_break_2',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'level_b_break_2' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.level_b_break_2',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'level_c_break_2' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.level_c_break_2',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'level_d_break_2' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.level_d_break_2',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'level_e_break_2' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.level_e_break_2',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'level_f_break_2' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.level_f_break_2',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'level_a_break_3' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.level_a_break_3',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'level_b_break_3' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.level_b_break_3',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'level_c_break_3' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.level_c_break_3',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'level_d_break_3' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.level_d_break_3',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'level_e_break_3' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.level_e_break_3',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'level_f_break_3' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.level_f_break_3',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'level_a_break_4' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.level_a_break_4',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'level_b_break_4' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.level_b_break_4',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'level_c_break_4' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.level_c_break_4',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'level_d_break_4' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.level_d_break_4',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'level_e_break_4' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.level_e_break_4',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'level_f_break_4' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.level_f_break_4',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'level_a_break_5' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.level_a_break_5',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'level_b_break_5' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.level_b_break_5',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'level_c_break_5' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.level_c_break_5',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'level_d_break_5' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.level_d_break_5',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'level_e_break_5' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.level_e_break_5',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'level_f_break_5' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.level_f_break_5',
            'config' => array(
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'default' => 0
            )
        ),
        'inactive_item' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.inactive_item',
            'config' => array(
                'type' => 'input',
                'size' => '30',
            )
        ),
        'standard_cost' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.standard_cost',
            'config' => array(
                'type' => 'input',
                'size' => '30',
            )
        ),
        'default_ship_loc' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.default_ship_loc',
            'config' => array(
                'type' => 'input',
                'size' => '30',
            )
        ),
        'default_recvd_loc' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.default_recvd_loc',
            'config' => array(
                'type' => 'input',
                'size' => '30',
            )
        ),
       /* 'show_onsite' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.show_onsite',
            'config' => array(
                'type' => 'select',
                'items' => array(
                    array('No', 'no', ''),
                    array('Yes', 'yes', '')
                )
            )
        ),*/
       'show_onsite' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.show_onsite',
            'config' => array(
                'type' => 'input',
                'size' => '30',
            )
        ),
        'metal' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.metal',
            'config' => array(
                'type' => 'input',
                'size' => '30',
            )
        ),
        'brand' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.brand',
            'config' => array(
                'type' => 'input',
                'size' => '30',
            )
        ),
        'stone_details' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items.stone_details',
            'config' => array(
                'type' => 'input',
                'size' => '30',
            )
        ),
    ),
    'types' => array(
        '0' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, item_number, item_name, buy, sell, inventory, asset_acct, income_acct, expcos_acct, item_pic, description, use_desc_on_sale, show_onsite, metal, brand, stone_details, custlist_1, custlist_2, custlist_3, custfield_1, custfield_2, custfield_3, prim_supplier, supplier_item_number, tax_code_when_bought, buy_unit_measure, items_buy_unit, reorder_quant, min_level, sellingprice, sell_unit_measure, tax_code_when_sold, sell_price_inclusive, sales_tax_calc_method, items_sell_unit, quant_break_1, quant_break_2, quant_break_3, quant_break_4, quant_break_5, level_a_break_1, level_b_break_1, level_c_break_1, level_d_break_1, level_e_break_1, level_f_break_1, level_a_break_2, level_b_break_2, level_c_break_2, level_d_break_2, level_e_break_2, level_f_break_2, level_a_break_3, level_b_break_3, level_c_break_3, level_d_break_3, level_e_break_3, level_f_break_3, level_a_break_4, level_b_break_4, level_c_break_4, level_d_break_4, level_e_break_4, level_f_break_4, level_a_break_5, level_b_break_5, level_c_break_5, level_d_break_5, level_e_break_5, level_f_break_5, inactive_item, standard_cost, default_ship_loc, default_recvd_loc')
    ),
    'palettes' => array(
        '1' => array('showitem' => 'starttime, endtime, fe_group')
    )
);
?>