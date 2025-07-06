<?php

namespace App\Library;

class SslCommerzNotification
{
    protected $sslc_data;
    protected $config;

    public function __construct()
    {
        $this->config = config('sslcommerz');
    }

    public function makePayment($post_data, $host_type)
    {
        if ($host_type == 'sandbox') {
            $url = "https://sandbox.sslcommerz.com/gwprocess/v4/api.php";
        } else {
            $url = "https://securepay.sslcommerz.com/gwprocess/v4/api.php";
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => http_build_query($post_data),
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return false;
        } else {
            return $response;
        }
    }

    public function orderValidate($post_data, $host_type, $store_passwd)
    {
        if ($host_type == 'sandbox') {
            $url = "https://sandbox.sslcommerz.com/validator/api/validationserverAPI.php";
        } else {
            $url = "https://securepay.sslcommerz.com/validator/api/validationserverAPI.php";
        }

        $post_data['store_passwd'] = $store_passwd;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => http_build_query($post_data),
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return false;
        } else {
            return $response;
        }
    }
}
