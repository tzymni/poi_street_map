<?php

/**
 * Description of cUrl
 *
 * @author tzymni
 */
class CUrl {

    private $curl;

    public function __construct() {
        $this->curl = curl_init();
    }

    public function setCurlHeaders($headers) {
        if ($this->curl) {
            curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);
        }
    }

    public function curlRun($url) {
        
        $userAgent = 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.2 (KHTML, like Gecko) Chrome/22.0.1216.0 Safari/537.2';
curl_setopt( $this->curl, CURLOPT_USERAGENT, $userAgent );
//curl_setopt($this->curl, CURLOPT_REFERER, 'http://localhost/poi_adder/api/poi/add.php');
        // Return Page contents.
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        //grab URL and pass it to the variable.
        curl_setopt($this->curl, CURLOPT_URL, $url);
        $result = curl_exec($this->curl);
        return $result;
    }

}
