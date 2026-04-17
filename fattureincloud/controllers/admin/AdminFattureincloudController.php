<?php
/**
 * FattureInCloud Prestashop Module
 *
 * @author    Token S.a.s. di Matto Michele & C. <michele@webtoken.it>
 * @copyright FattureInCloud - Madbit Entertainment S.r.l.
 * @license   http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 */

use Symfony\Component\HttpFoundation\JsonResponse;

require_once dirname(__FILE__) . '/../../libs/fattureincloudClient.php';

class AdminFattureincloudController extends ModuleAdminController
{
    /**
     * Get access token from device code and save it to db
     */
    public function ajaxProcessGetAccessToken()
    {
        if (!$this->isValidAdminToken()) {
            $this->sendJsonResponse([
                'status' => 'FAIL',
                'error' => 'Il token di sicurezza di PrestaShop non è valido',
            ]);
        }

        $deviceCode = (string) Tools::getValue('device_code', '');

        if ($deviceCode === '') {
            $this->sendJsonResponse([
                'status' => 'FAIL',
                'error' => 'Device code mancante',
            ]);
        }

        $ficClient = new FattureInCloudClient();
        $tokenRequest = $ficClient->oauthToken($deviceCode);

        if (is_array($tokenRequest) && isset($tokenRequest['access_token'], $tokenRequest['refresh_token'])) {
            Configuration::updateValue('FATTUREINCLOUD_DEVICE_CODE', $deviceCode);
            Configuration::updateValue('FATTUREINCLOUD_ACCESS_TOKEN', (string) $tokenRequest['access_token']);
            Configuration::updateValue('FATTUREINCLOUD_REFRESH_TOKEN', (string) $tokenRequest['refresh_token']);

            $this->sendJsonResponse([
                'status' => 'SUCCESS',
            ]);
        }

        $this->sendJsonResponse(is_array($tokenRequest) ? $tokenRequest : [
            'status' => 'FAIL',
            'error' => 'Risposta non valida ricevuta da Fatture in Cloud',
        ]);
    }

    /**
     * Save selected company id to db
     */
    public function ajaxProcessSaveCompanyId()
    {
        if (!$this->isValidAdminToken()) {
            $this->sendJsonResponse([
                'status' => 'FAIL',
                'error' => 'Il token di sicurezza di PrestaShop non è valido',
            ]);
        }

        $companyId = Tools::getValue('company_id', '');

        if ($companyId === '' || $companyId === null) {
            $this->sendJsonResponse([
                'status' => 'FAIL',
                'error' => 'Company ID mancante',
            ]);
        }

        Configuration::updateValue('FATTUREINCLOUD_COMPANY_ID', (string) $companyId);

        $this->sendJsonResponse([
            'status' => 'SUCCESS',
        ]);
    }

    /**
     * Validate admin token
     *
     * @return bool
     */
    protected function isValidAdminToken()
    {
        $providedToken = (string) Tools::getValue('token', '');
        return $providedToken !== '';
    }

    /**
     * Output JSON response and stop execution
     *
     * @param array $data
     *
     * @return void
     */
    protected function sendJsonResponse(array $data)
    {
        $response = new JsonResponse($data);
        $response->send();
        exit;
    }
}