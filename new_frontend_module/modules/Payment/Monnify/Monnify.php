<?php

namespace Modules\Payment\Monnify;

use Exception;

/**
 * @mMonnify : Simple mMonnify Class that can be made complex
 *
 * @Author : Simon Ugorji
 *
 **/
class Monnify
{
    protected $authH;

    protected $accessToken;

    protected $credentials;

    // this function is called everytime this class is instantiated
    public function __construct()
    {

        try {

            $this->credentials = json_decode(\App\Models\Gateway::code('Monnify')->first(['credentials'])->credentials, true);

            $auth = $this->authH = base64_encode($this->credentials['api_key'].':'.$this->credentials['api_secret']);

            // var_dump($auth);

            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $this->credentials['base_url'].'/api/v1/auth/login/',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',

            ]);
            curl_setopt($curl, CURLOPT_HTTPHEADER, [

                "Authorization: Basic $auth",

            ]);
            $response = json_decode(curl_exec($curl), true);
            curl_close($curl);
            //Assign accessToken to var
            $access_token = $this->accessToken = $response['responseBody']['accessToken'];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

    }

    public function initTrans($data = [])
    {
        $newData = json_encode($data);
        $curl = curl_init();
        $auth = $this->authH;
        try {
            curl_setopt_array($curl, [
                CURLOPT_URL => $this->credentials['base_url'].'/api/v1/merchant/transactions/init-transaction',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $newData,
                CURLOPT_HTTPHEADER => [
                    'Authorization: Basic '.$auth.'',
                    'Content-Type: application/json',
                ],
            ]);
            $response = curl_exec($curl);
            curl_close($curl);
            $res = json_decode($response, true);

            return $res['responseBody'];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function verifyTrans($transRef)
    {
        $ref = urlencode($transRef);
        $accessToken = $this->accessToken;
        try {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $this->credentials['base_url'].'/api/v2/transactions/'.$ref.'',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ]);
            //Use bearer when dealing with oauth 2
            curl_setopt($curl, CURLOPT_HTTPHEADER, [
                "Authorization: Bearer $accessToken",
            ]);

            $response = curl_exec($curl);
            curl_close($curl);
            $res = json_decode($response, true);

            return $res['responseBody'];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
