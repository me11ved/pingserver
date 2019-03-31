<?php 
class PingTools {
   public function __construct() {
   
   }
   
   
   
   public function ping($ip,$parse = true)
   {
		$res = false;
	   
		$valid = filter_var($ip, FILTER_VALIDATE_IP);  
		
		if($valid !== false)
		{
			$output = shell_exec("ping $ip -c 4");
			$res = iconv("cp866","utf-8", $output);
		}
		
		return $res;
	}
	
	
   public function ipList($arr)
   {
	   foreach ($arr as $key => $ip)
	   {
		 $valid = filter_var($ip[0], FILTER_VALIDATE_IP);   
		 
		 if($valid === false)
		 {
			 unset($arr[$key]);
		 }
	   
	   }
	   
	   return $arr;
   }
   
   
  public function parse ($str)
   {
	   if($str)
	   {
		
		$lines = explode("\r\n",$str);
		
		$check = ['1','2','3','4'];
		
		if (is_array($lines))
		{
			
			foreach ($lines as $k => $l)
			{
				if (in_array($k,$check) === true)
				{
					$pr = explode(" ",$l);
					$time = explode("=",$pr[6]);
					$packages[] = array_pop($time);
					 
				}
			}
			
			if (is_array($packages))
			{
				$lines2 = explode(" ",$lines[8]);
				$avg = explode("/",$lines2[3]);
				
				if ($avg[2])
				{
					return [ 
							"status" => true,
							 "time" => $avg[2]];
				}
				else
				{
					return false;
				}
				
				
			}
			else
			{
				return false;
			}
			
		}
		else
		{
			return false;
		}
	   }
	   else
	   {
		   return false;
	   }
   }
   
}

?>