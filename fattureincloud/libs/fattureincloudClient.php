<?php
/**
* FattureInCloud Prestashop Module
*
*  @author    Websuvius di Michele Matto <michele@websuvius.it>
*  @copyright FattureInCloud - Madbit Entertainment S.r.l.
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*/

class FattureInCloudClient
{
    private $apiBaseUrl = "https://api-v2.fattureincloud.it";
    private $clientId = "NTRjNjY0MjU1YzBiODFhYmI4MDc0NGFm";
    private $clientSecret = "RQg9xcbF3M6Uwb4RvEAV6KmCIahqqUJ3ng4OlUkWoxrKfTYD3m47f2pLNycdVSQZ";
    private $scope = "entity.clients:a issued_documents.orders:a issued_documents.invoices:a settings:a";
    private $redirectUri = "https://fattureincloud.it/connetti";
    private $maxRetry = 2;
    
    private $deviceCode;
    private $accessToken;
    private $refreshToken;
    private $companyId;
    
    public function __construct()
    {
    }
    
    // public function __construct($companyId, $accessToken)
    // {
    //     $this->companyId = $companyId;
    //     $this->accessToken = $accessToken;
    // }
    
    public function toJson()
    {
        $output = array(
            "device_code" => $this->deviceCode,
            "access_token" => $this->accessToken,
            "refresh_token" => $this->refreshToken,
            "company_id" => $this->companyId
        );
        
        return json_encode($output);
    }
    
    public function setDeviceCode($deviceCode)
    {
        $this->deviceCode = $deviceCode;
    }
            
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }
    
    public function setRefreshToken($refreshToken)
    {
        $this->refreshToken = $refreshToken;
    }
    
    public function setCompanyId($companyId)
    {
        $this->companyId = $companyId;
    }
    
    public function oauthDevice()
    {
        $data = array(
            "client_id" => $this->clientId,
            "scope" => $this->scope
        );
        
        $return = $this->makeOAuthRequest("oauth/device", $data);
        
        return $return;
    }
    
    public function oauthToken($deviceCode)
    {
        $data = array(
            "client_id" => $this->clientId,
            "device_code" => $deviceCode,
            "grant_type" => "urn:ietf:params:oauth:grant-type:device_code"
        );
        
        $return = $this->makeOAuthRequest("oauth/token", $data);
        
        return $return;
    }
    
    public function oauthRefreshToken()
    {
        $data = array(
            "grant_type" => "refresh_token",
            "client_id" => $this->clientId,
            "client_secret" => $this->clientSecret,
            "refresh_token" => $this->refreshToken
        );
        
        $refresh_token_request = $this->makeOAuthRequest("oauth/token", $data);
        
        if (isset($refresh_token_request['access_token'])) {
            $this->setAccessToken($refresh_token_request['access_token']);
            $this->setRefreshToken($refresh_token_request['refresh_token']);
            
            Configuration::updateValue("FATTUREINCLOUD_ACCESS_TOKEN", $refresh_token_request['access_token']);
            Configuration::updateValue("FATTUREINCLOUD_REFRESH_TOKEN", $refresh_token_request['refresh_token']);
        }
        
        return $refresh_token_request;
    }
    
    public function getControlledCompanies()
    {
        $return = $this->makeGenericRequest("user/companies");
        
        return $return;
    }
    
    public function getClients($filters)
    {
        $return = $this->makeCompanyRequest("entities/clients", $filters);
        
        return $return;
    }
    
    public function createClient($data)
    {
        $return = $this->makeCompanyRequest("entities/clients", $data, "POST");
        
        return $return;
    }
    
    public function editClient($data)
    {
        $return = $this->makeCompanyRequest("entities/clients/" . $data['data']['id'], $data, "PUT");
        
        return $return;
    }
    
    public function createVatType($data)
    {
        $return = $this->makeCompanyRequest("settings/vat_types", $data, "POST");
        
        return $return;
    }
    
    public function getVatTypes()
    {
        $return = $this->makeCompanyRequest("info/vat_types");
        
        return $return;
    }
    
    public function getPaymentAccounts()
    {
        $return = $this->makeCompanyRequest("settings/payment_accounts");
                
        return $return;
    }
    
    public function createPaymentAccount($data)
    {
        $return = $this->makeCompanyRequest("settings/payment_accounts", $data, "POST");
        
        return $return;
    }
    
    public function getIssuedDocumentDetails($documentId, $params = null)
    {
        $return = $this->makeCompanyRequest("issued_documents/" . $documentId, $params);
        
        return $return;
    }
    
    public function createIssuedDocument($data)
    {
        $return = $this->makeCompanyRequest("issued_documents", $data, "POST");
        
        return $return;
    }
    
    public function verifyEInvoiceXML($invoiceId)
    {
        $return = $this->makeCompanyRequest("issued_documents/". $invoiceId . '/e_invoice/xml_verify');
        
        return $return;
    }
    
    public function sendEInvoice($invoiceId)
    {
        $return = $this->makeCompanyRequest("issued_documents/". $invoiceId . '/e_invoice/send', null, "POST");
        
        return $return;
    }
    
    private function makeOAuthRequest($endpoint, $body = null)
    {
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $this->apiBaseUrl . '/'. $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/json", "Content-Type: application/json"));
        
        curl_setopt($ch, CURLOPT_POST, true);
                                
        if (isset($body)) {
            $jsonToSend = json_encode($body);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonToSend);
        }
                
        curl_setopt($ch, CURLOPT_HEADERFUNCTION, function ($curl, $header) use (&$headers) {
            $len = strlen($header);
            $header = explode(':', $header, 2);
            if (count($header) < 2) {
                return $len;
            }
        
            $headers[strtolower(trim($header[0]))][] = trim($header[1]);
        
            return $len;
        });
        
        $response = curl_exec($ch);
        
        $return = false;
        
        $data = json_decode($response, true);
       
        curl_close($ch);
        
        return $data;
    }
    
    private function makeGenericRequest($endpoint, $body = null, $method = "GET")
    {
        $makeRequest = true;
        $retry = 0;
        
        while ($makeRequest && $retry <= $this->maxRetry) {
            
            $ch = curl_init();
            
            switch ($method) {
                case "GET":
                    
                    if (isset($body)) {
                        $query = http_build_query($body);
                        $endpoint .= "?" . $query;
                    }
                    break;
                    
                case "POST":
                    
                    curl_setopt($ch, CURLOPT_POST, true);
                    
                    if (isset($body)) {
                        $jsonToSend = json_encode($body);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonToSend);
                    }
                    break;
                    
                case "PUT":
                    
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                    curl_setopt($ch, CURLOPT_POST, true);
                    
                    if (isset($body)) {
                        $jsonToSend = json_encode($body);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonToSend);
                    }
                    break;
            }
            
            curl_setopt($ch, CURLOPT_URL, $this->apiBaseUrl . '/'. $endpoint);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $this->accessToken , "Accept: application/json", "Content-Type: application/json"));
                        
            curl_setopt($ch, CURLOPT_HEADERFUNCTION, function ($curl, $header) use (&$headers) {
                $len = strlen($header);
                $header = explode(':', $header, 2);
                if (count($header) < 2) {
                    return $len;
                }
            
                $headers[strtolower(trim($header[0]))][] = trim($header[1]);
            
                return $len;
            });
            
            $response = curl_exec($ch);
            
            $return = false;
            
            $data = json_decode($response, true);
            
            if (!curl_errno($ch)) {
                switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
                    case 200:
                        $return = $data;
                        $makeRequest = false;
                        break;
                    case 403:
                        $return = $data;
                        $return['retry-after'] = $headers['retry-after'];
                        $makeRequest = false;
                        break;
                    case 429:
                        $return = $data;
                        $return['retry-after'] = $headers['retry-after'];
                        $makeRequest = false;
                        break;
                    case 401:
                        $retry++;
                        $refresh_token_request = $this->oauthRefreshToken();
                        break;
                    default:
                        $return = $data;
                        $makeRequest = false;
                        break;
                }
            }
        
            curl_close($ch);
        }
        
        return $return;
    }
    
    private function makeCompanyRequest($endpoint, $body = null, $method = "GET")
    {
        
        $makeRequest = true;
        $retry = 0;
        
        while ($makeRequest && $retry <= $this->maxRetry) {
            
            $ch = curl_init();
            
            switch ($method) {
                case "GET":
                    
                    if (isset($body)) {
                        $query = http_build_query($body);
                        $endpoint .= "?" . $query;
                    }
                    break;
                    
                case "POST":
                    
                    curl_setopt($ch, CURLOPT_POST, true);
                    
                    if (isset($body)) {
                        $jsonToSend = json_encode($body);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonToSend);
                    }
                    break;
                    
                case "PUT":
                    
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                    curl_setopt($ch, CURLOPT_POST, true);
                    
                    if (isset($body)) {
                        $jsonToSend = json_encode($body);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonToSend);
                    }
                    break;
            }
            
            curl_setopt($ch, CURLOPT_URL, $this->apiBaseUrl . '/c/' . $this->companyId . '/'. $endpoint);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $this->accessToken , "Accept: application/json", "Content-Type: application/json"));
            
            curl_setopt($ch, CURLOPT_HEADERFUNCTION, function ($curl, $header) use (&$headers) {
                $len = strlen($header);
                $header = explode(':', $header, 2);
                if (count($header) < 2) {
                    return $len;
                }
            
                $headers[strtolower(trim($header[0]))][] = trim($header[1]);
            
                return $len;
            });
            
            $response = curl_exec($ch);
            
            $return = false;
            
            $data = json_decode($response, true);
            
            if (!curl_errno($ch)) {
                switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
                    case 200:
                        $return = $data;
                        $makeRequest = false;
                        break;
                    case 403:
                        $return = $data;
                        $return['retry-after'] = $headers['retry-after'];
                        $makeRequest = false;
                        break;
                    case 429:
                        $return = $data;
                        $return['retry-after'] = $headers['retry-after'];
                        $makeRequest = false;
                        break;
                    case 401:
                        $retry++;
                        $refresh_token_request = $this->oauthRefreshToken();
                        break;
                    default:
                        $return = $data;
                        $makeRequest = false;
                        break;
                }
            }
            
            curl_close($ch);
        }
        
        return $return;
    }
}
