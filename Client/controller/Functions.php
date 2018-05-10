<?php
require 'Uploader.php';
require 'Client.php';
require 'LastFmInvoker.php';

/**
* all Functions
*/
class Functions
{
	private $client;
	private $uploader;
	private $lastFm;
	
	function __construct()
	{
		$this->client=new Uploader();
		$this->uploader=new Client();
		$this->lastFm=new LastFmInvoker();
	}
}