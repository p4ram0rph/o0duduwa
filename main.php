<?php
define('PATH', realpath(dirname(__FILE__)) . '/', true);
$GLOBALS['modules'] = array();
$GLOBALS['lib'] = array();
$GLOBALS['api'] = array();

spl_autoload_register(function ($class){


	if(file_exists(PATH . 'lib/' . $class . '.php')){

		array_push( $GLOBALS['lib'], $class );
		include PATH . 'lib/' . $class . '.php';

	}elseif(file_exists(PATH . 'api/' . $class . '.php')){

		array_push( $GLOBALS['api'], $class );
		include PATH . 'api/' . $class . '.php';

	}elseif(file_exists(PATH . 'modules/' . $class . '.php')){

		array_push( $GLOBALS['modules'], $class );
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
