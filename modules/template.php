<?php

class template{

	public function __construct($parameters){

		$this->param = $parameters;
		echo  "Running template\r\n";


	}

	public function run($param){

		echo "Method Called \r\n";
		return $this->param;

	}

}
