<?php

class rss{

	private $rss	= 'https://news.ycombinator.com/rss';
	private $ua	= 'Opera/9.80 (X11; Linux i686; Ubuntu/14.10) Presto/2.12.388 Version/12.16';
	public  $feeds	= array('cve', 'edb', 'yc'); // more added soon

	public function __construct(){

		//prevent xxe
		libxml_disable_entity_loader(true);


	}
	public function setFeed($feed){

		switch($feed){

			case 'edb':
				$this->rss = 'https://www.exploit-db.com/rss.xml';
			break;

			case 'cve':
				$this->rss = 'https://nvd.nist.gov/download/nvd-rss.xml';
			break;

			default:
				$this->rss = 'https://news.ycombinator.com/rss';
		}

	}

	public function fetchRss(){

		$c = curl_init($this->rss);
		curl_setopt($c, CURLOPT_USERAGENT, $this->ua);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		$xml = curl_exec($c);
		curl_close($c);
		return $xml;
	}

	public function PrettyRss(){

		$results = array();
		$xml = simplexml_load_string($this->fetchRss());

		if(empty((string)$xml->item)){

			$data = $xml->channel->item;
//			print "fooooop\r\n";

		}else{

			$data = $xml->item;


		}

		foreach($data as $__){

			array_push($results, array('title' => (string)$__->title, 'link' => (string)$__->link, 'description' => (string)$__->description));

		}

		return $results;
	}



}

/**
$ed = new Rss();
print_r($ed->PrettyRss());
$ed->setFeed('edb');
print_r($ed->PrettyRss());
**/
