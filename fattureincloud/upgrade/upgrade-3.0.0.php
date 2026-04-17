<?php

/**
* FattureInCloud Prestashop Module
*
*  @author    Token S.a.s. di Matto Michele & C. <michele@webtoken.it>
*  @copyright FattureInCloud - Madbit Entertainment S.r.l.
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*/

if (!defined('_PS_VERSION_')) {
	exit;
}

function upgrade_module_3_0_0($module) {
	
	try {
	
		$sendToSdi = (int) Configuration::get('FATTUREINCLOUD_INVOICES_SEND_TO_SDI');
		$createInvoices = (int) Configuration::get('FATTUREINCLOUD_INVOICES_CREATE');
		
		if ($sendToSdi === 1) {
	
			Configuration::updateValue('FATTUREINCLOUD_INVOICES_CREATE_AS_EINVOICE', 1);
		
			if ($createInvoices !== 1) {
				Configuration::updateValue('FATTUREINCLOUD_INVOICES_CREATE', 1);
			}
		} else {
			
			if (Configuration::get('FATTUREINCLOUD_INVOICES_CREATE_AS_EINVOICE') === false) {
				Configuration::updateValue('FATTUREINCLOUD_INVOICES_CREATE_AS_EINVOICE', 0);
			}
		}
		
		return true;
		
	} catch (Exception $e) {
		return false;
	}
	
	
}