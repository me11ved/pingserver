<?php
  class View {
   
  public function render($name, $noInclude = false) {
   if($noInclude == true) {
   require_once 'views/'.$name.'.php';
   } else {
	if($name != 'login/index') {
		require_once 'views/header.php';;
		require 'views/'.$name.'.php';
		require_once 'views/footer.php';;

    }
	else {
		require 'views/'.$name.'.php';
		
	}
   }
  }

  
 }
?>