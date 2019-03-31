<?php
  class Bootstrap {
   public function __construct() {
	$url = isset($_GET['url']) ? $_GET['url'] : null;
    $url = rtrim($url, '/');
    $url = explode('/', $url);
	
	if (!DB_USER or !DB_PASSWORD or !DB_NAME)
	{
		die("Запоните данные в файле <i>config.php</i> для подключения к БД");	
	}
	
	if(empty($url[0])) 
	{
		require 'controllers/ping.php';
		$controller = new Ping();
		$controller->loadModel('ping');
		$controller->index();	
		return false;
	}
	
    $file = 'controllers/'.$url[0].'.php';
    
	if(file_exists($file)) {
     require $file;
    } else {
     require 'controllers/ping.php';
     $controller = new index();
     return false;
    }
    $controller = new $url[0];
	$controller->loadModel($url[0]);
   
	if(isset($url[2])) {
		if(method_exists($controller, $url[1])) {
			$controller->{$url[1]}($url[2]);
		} 
		else {
			echo 'Error!';
		}
	} 
	else {
		if(isset($url[1])) {
			
		$controller->{$url[1]}();
		} 
		else {
		$controller->index();
		
		}
	}
   
   }
  }
?>