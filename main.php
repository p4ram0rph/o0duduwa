<?php
define('PATH', realpath(dirname(__FILE__)) . '/', true);

spl_autoload_register(function ($class){


	if(file_exists(PATH . 'lib/' . $class . '.php')){

		include PATH . 'lib/' . $class . '.php';

	}elseif(file_exists(PATH . 'api/' . $class . '.php')){

		include PATH . 'api/' . $class . '.php';

	}elseif(file_exists(PATH . 'modules/' . $class . '.php')){

		include PATH . 'modules/' . $class . '.php';

	}else{

//		throw new Exception("$class could not be found!");

	}


});

try{

	$irc = new irc('localhost',6697,'o0duduwa',str_repeat('Test ',4),1);

}catch(Exception $e){

	echo 'Caught exception: ',  $e->getMessage(), "\n";

}
