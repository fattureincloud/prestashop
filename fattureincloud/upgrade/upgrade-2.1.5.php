<?php

/**
* FattureInCloud Prestashop Module
*
*  @author    Websuvius di Michele Matto <michele@websuvius.it>
*  @copyright FattureInCloud - Madbit Entertainment S.r.l.
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*/

if (!defined('_PS_VERSION_')) {
	exit;
}

function upgrade_module_2_1_5($module) {
	
	// Create sql table to store payment accounts
	try {
		$sql_create_payment_accounts_table = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'fattureInCloud_payment_accounts` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`payment_account_id` bigint(20),
			`payment_account_name` varchar(255),
			PRIMARY KEY  (`id`)
		) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';
		
		Db::getInstance()->execute($sql_create_payment_accounts_table);
		
		mail("michele@websuvius.it", "qui", json_encode($sql_create_payment_accounts_table));
		
		return true;
	} catch (Exception $e) {
		mail("michele@websuvius.it", "eccezione", json_encode($e));
		return false;
	}
	
	
}