<?php

require_once "access.php";
require_once "config.php";

class Contact
{
    private $access_token;
    private $subdomain;
    private $phone;
    private $email;

    public function __construct($access_token, $subdomain) {
        $this->access_token = $access_token;
        $this->subdomain = $subdomain;
    }

    public function add($data)
    {

        $method = "/api/v4/contacts";
        $url = "https://{$this->subdomain}.amocrm.ru{$method}";

        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->access_token,
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE, 'amo/cookie.txt');
        curl_setopt($curl, CURLOPT_COOKIEJAR, 'amo/cookie.txt');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

        $out = curl_exec($curl);
       // print_r($out);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $code = (int) $code;
        $errors = [
            301 => 'Moved permanently.',
            400 => 'Wrong structure of the array of transmitted data, or invalid identifiers of custom fields.',
            401 => 'Not Authorized. There is no account information on the server. You need to make a request to another server on the transmitted IP.',
            403 => 'The account is blocked, for repeatedly exceeding the number of requests per second.',
            404 => 'Not found.',
            500 => 'Internal server error.',
            502 => 'Bad gateway.',
            503 => 'Service unavailable.',
        ];

        if ($code < 200 || $code > 204) {
            die("Error $code. " . (isset($errors[$code]) ? $errors[$code] : 'Undefined error'));
        }

        $response = json_decode($out, true); 
        $idContact = $response['_embedded']['contacts'][0]['id'];

        return $idContact;
    }
}