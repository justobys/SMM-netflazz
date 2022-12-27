<?php

class GoPay{
    
    public $nomerGojek;
    public $kodeVerifikasi;
    public $loginToken;
    public $bearerToken;
    
    public function sendRequest($nomerGojek){
        
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://api.gojekapi.com/v3/customers/login_with_phone");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{"phone":"'.$nomerGojek.'"}');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
        
        $headers = array();
        $headers[] = "X-UniqueId: 23b: ".rand(111111111111,999999999999)."b";
        $headers[] = "X-Appversion: 3.14.0";
        $headers[] = "X-Platform: Android";
        $headers[] = "X-Appid: com.gojek.app";
        $headers[] = "Accept: application/json";
        $headers[] = "X-Phonemodel: asus,ASUS_Z00AD";
        $headers[] = "X-Pushtokentype: FCM";
        $headers[] = "X-Deviceos: Android,5.0";
        $headers[] = "User-Uuid: ";
        $headers[] = "Authorization: Bearer";
        $headers[] = "Accept-Language: id-ID";
        $headers[] = "X-User-Locale: id_ID";
        $headers[] = "Content-Type: application/json; charset=UTF-8";
        $headers[] = "Host: api.gojekapi.com";
        $headers[] = "User-Agent: okhttp/3.10.0";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close ($ch);
        
        $this->nomerGojek   =   $nomerGojek;
        $this->loginToken   =   json_decode($result,true)['data']['login_token'];
        return "token verifikasi : ".json_decode($result,true)['data']['login_token'];
        
    }
    
    public function konfirmasiCode($loginToken,$kodeVerifikasi,$nomerGojek){
        
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, "https://api.gojekapi.com/v3/customers/token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{"scopes":"gojek:customer:transaction gojek:customer:readonly","login_token":"'.$loginToken.'","client_secret":"83415d06-ec4e-11e6-a41b-6c40088ab51e","grant_type":"password","client_id":"gojek:cons:android","otp":"'.$kodeVerifikasi.'"}');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
        
        $headers = array();
        $headers[] = "X-Appversion: 3.10.0";
        $headers[] = "X-Platform: Android";
        $headers[] = "X-Appid: com.gojek.app";
        $headers[] = "Accept: application/json";
        $headers[] = "X-Pushtokentype: GCM";
        $headers[] = "X-User-Locale: id_ID";
        $headers[] = "User-Uuid: ";
        $headers[] = "Accept-Language: id-ID";
        $headers[] = "Authorization: Bearer";
        $headers[] = "Content-Type: application/json; charset=UTF-8";
        $headers[] = "Host: api.gojekapi.com";
        $headers[] = "User-Agent: okhttp/3.10.0";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close ($ch);
        
        $akun = $nomerGojek.".txt";
        $fopen = fopen($akun, "a");
        fwrite($fopen, json_decode($result,true)['data']['access_token']);
        fclose($fopen);
        return 'token: '.json_decode($result,true)['data']['access_token'];
        
    }
    
    public function seeMutation($nomerGojek,$page='20'){
        
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, "https://api.gojekapi.com/wallet/history?page=1&limit=".$page);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
        
        $headers = array();
        $headers[] = "X-UniqueId: 23b: ".rand(111111111111,999999999999)."b";
        $headers[] = "X-Appversion: 3.10.0";
        $headers[] = "X-Platform: Android";
        $headers[] = "X-Appid: com.gojek.app";
        $headers[] = "Accept: application/json";
        $headers[] = "Content-Type: application/json";
        $headers[] = "X-Pushtokentype: GCM";
        $headers[] = "X-User-Locale: id_ID";
        $headers[] = "Accept-Language: id-ID";
        $headers[] = "Authorization: Bearer " . file_get_contents($nomerGojek . ".txt");
        $headers[] = "Host: api.gojekapi.com";
        $headers[] = "User-Agent: okhttp/3.10.0";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close ($ch);
        
        return json_encode($result,true);
        
    }
    
    public function cekSaldo($saldo,$mutasi){
        
        if (strpos($mutasi, $saldo) !== false) {
            return true;
        }else{
            return false;
        }
        
    }
    
}