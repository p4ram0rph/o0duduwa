<?php

class psb{


	private $api 	= 'http://psbdmp.com/api';
	private $dd	= '/dump/daily';
	private $email	= '/search/email/';
	private $domain	= '/search/domain';


	public function __construct(){


	}
	private function getData($url){

		$result = array();
		$data = (array)json_decode(file_get_contents($this->api . $url, true));
		foreach($data['data'] as $poop){

			$useful_data = (array)$poop;
			array_push($result,$useful_data);
		}

		return $result;

	}
	public function mail($email){
		$result = array();
		$data = $this->getData($this->email . $email);
		foreach($data as $ud){

			array_push( $result ,'http://www.pastebin.com/'.$ud['id']."\n");

		}

		return $result;

	}
	public function domain($dom){
		$result = array();
		$data = $this->getData($this->domain . $dom);
		foreach($data as $ud){

			array_push( $result ,'http://www.pastebin.com/'.$ud['id']."\n");

		}


		return $result;

	}
	public function daily(){
		$result = array();
		$data = $this->getData($this->dd);
		foreach($data as $ud){

			if((int)$ud['leakedmails'] == 0){ }
			else{
				array_push( $result ,'http://www.pastebin.com/'.$ud['id']."\n");

			}

		}

		return $result;

	}




}

/**
$a = new psb();
$a->daily();
var_dump($a->mail('poop@gmail.com'));
$a->domain('fbi.gov');

**/
