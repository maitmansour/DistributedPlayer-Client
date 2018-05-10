<?php

/**
* Api LastFm Class
*/
class LastFmInvoker
{
	private $url;
	private $api_key;
	private $params;

	function __construct()
	{
		$this->url="http://ws.audioscrobbler.com/2.0/";
		$this->api_key="API_KEY_HERE";
	}

	public function prepare($data)
	{
		$data['api_key']=$this->api_key;
		foreach($data as $key=>$value)
			$params .= $key.'='.$value.'&';    
		$params = trim($params, '&');
	}
}