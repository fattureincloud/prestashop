<?php
/**
* FattureInCloud Prestashop Module
*
*  @author    Websuvius di Michele Matto <michele@websuvius.it>
*  @copyright FattureInCloud - Madbit Entertainment S.r.l.
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*/

require_once dirname(__FILE__).'/../../libs/fattureincloudClient.php';
    
class AdminFattureincloudController extends ModuleAdminController
{
    /**
     * Get access token from device code and save it to db
     */
    public function ajaxProcessGetAccessToken()
    {
        if (Tools::getAdminTokenLite('AdminFattureincloud') != Tools::getValue('token')) {
            $result = array(
                "status" => "FAIL",
                "error" => "Il token di sicurezza di Prestashop non è valido"
            );
        } else {
            $device_code = Tools::getValue("device_code");
            
            $fic_client = new FattureInCloudClient();
            $token_request = $fic_client->oauthToken($device_code);
            
            if (isset($token_request['access_token'])) {
                Configuration::updateValue("FATTUREINCLOUD_DEVICE_CODE", $device_code);
                Configuration::updateValue("FATTUREINCLOUD_ACCESS_TOKEN", $token_request['access_token']);
                Configuration::updateValue("FATTUREINCLOUD_REFRESH_TOKEN", $token_request['refresh_token']);
                
                $result = array(
                    "status" => "SUCCESS"
                );
            } else {
                $result = $token_request;
            }
        }
        
        $this->ajaxDie(json_encode($result));
    }
    
    /**
     * Save selected company id to db
     */
    public function ajaxProcessSaveCompanyId()
    {
        if (Tools::getAdminTokenLite('AdminFattureincloud') != Tools::getValue('token')) {
            $result = array(
                "status" => "FAIL",
                "error" => "Il token di sicurezza di Prestashop non è valido"
            );
        } else {
            $company_id = Tools::getValue("company_id");
            
            Configuration::updateValue("FATTUREINCLOUD_COMPANY_ID", $company_id);
            
            $result = array(
                "status" => "SUCCESS"
            );
        }
        
        $this->ajaxDie(json_encode($result));
    }
}
