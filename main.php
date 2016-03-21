<?php
define('PATH', realpath(dirname(__FILE__)) . '/', true);

spl_autoload_register(function ($class){


	if(file_exists(PATH . 'lib/' . $class . '.php')){

		include PATH . 'lib/' . $class . '.php';

	}elseif(file_exists(PATH . 'api/' . $class . '.php')){

		include PATH . 'api/' . $class . '.php';

	}else{

		throw new Exception("$class could not be found!");

	}


});


$irc = new irc('localhost',6697,'o0duduwa',str_repeat('Ass ',4),1);
