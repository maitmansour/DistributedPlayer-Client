<?php

/**
 * Api LastFm Class
 */
class LastFmInvoker
{
    private $url;
    private $api_key;
    private $params;
    private $ch;
    
    /**
     * Init variables
     */
    function __construct()
    {
        $this->url     = "http://ws.audioscrobbler.com/2.0/";
        $this->api_key = "API_KEY_HERE";
        $this->params  = "";
        $this->ch      = curl_init();
    }
    
    /**
     * Delete vars
     */
    function __destruct()
    {
        if ($this->ch) {
            curl_close($this->ch);
            
        }
    }
    
    /**
     * Prepare params
     */
    public function prepare($data)
    {
        $data['api_key'] = $this->api_key;
        foreach ($data as $key => $value)
            $this->params .= $key . '=' . $value . '&';
        $this->params = trim($this->params, '&');
    }
    
    /**
     * Get Album Image
     */
    public function getAlbumImage()
    {
        $image = "";
        curl_setopt($this->ch, CURLOPT_URL, $this->url . '?' . $this->params); //Url together with parameters
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1); //Return data instead printing directly in Browser
        curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, 7); //Timeout after 7 seconds
        curl_setopt($this->ch, CURLOPT_HEADER, 0);
        
        $result = curl_exec($this->ch);
        if (curl_errno($this->ch)) {
            echo 'Curl error: ' . curl_error($ch);
        } else {
            $result_array = json_decode($result, true);
            if (isset($result_array['track']['album']['image'][2]["#text"])) {
                $image = $result_array['track']['album']['image'][2]["#text"];
            } else {
                $image = false;
            }
        }
        return $image;
    }
    
    
    
}