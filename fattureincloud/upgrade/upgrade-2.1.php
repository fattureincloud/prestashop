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

function upgrade_module_2_1_0($module) {
	
	if (!Configuration::updateValue('FATTUREINCLOUD_DEVICE_CODE', '') ||
		!Configuration::updateValue('FATTUREINCLOUD_COMPANY_ID', '') ||
		!Configuration::updateValue('FATTUREINCLOUD_ACCESS_TOKEN', '') ||
		!Configuration::updateValue('FATTUREINCLOUD_REFRESH_TOKEN', '')
	) {
		return false;
	}
	
	return true;
}