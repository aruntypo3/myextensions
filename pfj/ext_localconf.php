<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_pfj_items=1
');

t3lib_extMgm::addPItoST43($_EXTKEY, 'pi1/class.tx_pfj_pi1.php', '_pi1', 'list_type', 1);


t3lib_extMgm::addTypoScript($_EXTKEY,'setup','
	tt_content.shortcut.20.0.conf.tx_pfj_items = < plugin.'.t3lib_extMgm::getCN($_EXTKEY).'_pi1
	tt_content.shortcut.20.0.conf.tx_pfj_items.CMD = singleView
',43);

$TYPO3_CONF_VARS['FE']['eID_include']['makeProducts'] = 'EXT:pfj/lib/makeProducts.php';
?>