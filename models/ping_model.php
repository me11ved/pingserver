<?php
  class Ping_Model extends Model {
   public function __construct() {
	parent::__construct();
   }
   
	
	public function index ()
	{
		$pingResults = $this->db->GetAll("SELECT
									ps.*,
									IFNULL(ps.response_time,'-') as response_time,
									s.ip,
									gs.title as `group`
								FROM
									pingResults ps
									LEFT JOIN Servers s ON ps.server_id = s.id
									LEFT JOIN groupServers gs ON gs.id = s.group_id
								ORDER BY ps.id DESC");
		
		$groups = $this->db->GetAll("SELECT * from groupServers");
		
		if (is_array($groups))
		{
			foreach ($groups as $k => $g)
			{
				$Servers = $this->db->GetAll("SELECT	s.*,
											gs.title gr
										FROM
											Servers s
											LEFT JOIN groupServers gs ON gs.id = s.group_id
										WHERE 
											s.group_id = ?i",
										$g["id"]);
				
				if ($Servers)
				{
				
					$groups[$k]["servers"] = $Servers;
				}
			}
		}
		
		
		$data = [
					"pingResults" => $pingResults,
					"serverLists" => $groups];
	
		return $data;
  }
  
  public function groupsList ()
  {
	  $data = $this->db->GetAll("SELECT * from groupServers");
	  
	  return $data;
  }
  
  public function addServers ($params)
  {
	$errors[] = '';
	  
	if (is_array($params))
	{
		if (empty($params["groupList"]) and empty($params["newGroup"]))
		{
			$errors[] = "Не выбрана группа или не введено название новой группы";
		}
		else if (empty($params["ips"]))
		{
			$errors[] = "Не заполено поле: Список ip";
		}
		else
		{
			
			$ips = explode("\r\n",$params["ips"]);
			$ips_s_comments = [];
			
			if ($ips)
			{
				foreach ($ips as $k => $val)			
				{
					$ic = explode(";",$val);
					if($ic[0])
					{
						array_push($ips_s_comments,$ic);
					}
				}
			}
			
			$ips = $this->pt->ipList($ips_s_comments);
			
			if ($ips)
			{
				if (!empty($params["newGroup"]))
				{
					$g = $this->db->GetOne("SELECT id FROM 
														groupServers 
													WHERE 
														title = ?s",
													$params["newGroup"]);
					if ($g)
					{
						$group_id = $g;
					}
					else
					{
						$this->db->query("INSERT INTO groupServers SET title = ?s",$params["newGroup"]);
						
						$group_id = $this->db->insertId();
					}
				}
				else
				{
					$group_id = $params["groupList"];
				}
				
				foreach($ips as $serv)
				{
					isset($serv[1]) ? $comment = $serv[1] : $comment = null;
					
					$check_ip = $this->db->GetOne("SELECT ip FROM Servers WHERE ip = ?s",$serv[0]);
					
					if (!$check_ip)
					{
						
						$adds = $this->db->query("INSERT INTO Servers SET ip = ?s,
																		  comments = ?s,
																		  group_id = ?i",
																		  $serv[0],
																		  $comment,
																		  $group_id);
					}
					else
					{
						$errors[] = "Данный ip: ".$check_ip." - уже есть в базе данных";
					}
				}
				
				if(!$errors[1])
				{
					$ret = ["status" => true];
				}
				else
				{
					$ret = ["status" => true,"response" => [
														"errors" => $errors]];
				}
				
				return $ret;
			}
			else
			{
				$errors[] = "Некорректно заполнено поле Список IP";
			}
		}
			
	}
	else
	{
		$errors[] = "Нет данных, заполните поля формы";
	}
  
	return [
			"status" => false, 
			"response" => [
							"errors" => $errors]];
  }
  
  
  public function ServersList() {
	  
	  $data = $this->db->GetAll("SELECT s.*,
										gs.title
											FROM 
												Servers s 
											LEFT JOIN groupServers gs ON gs.id = s.group_id");
	  
	  return $data;
  }
  
  
  public function pingServersStart ($params)
  {
	if (!empty($params["server"]))
	{
		$test = $this->db->GetOne("SELECT id FROM Servers WHERE ip = ?s",$params["server"]);
		
		if ($test)
		{
			$result = $this->pt->ping($params["server"]);
		
			if($result)
			{
				return [
							"status" => true,
							"response" => [
											"result" => $result,
											"id" => $test]];
			}
			else
			{
				$errors[] = "Не удалось выполнить команду ping";
			}
		}
		else
		{
			$errors[] = "Данного IP нет в базе данных";
		}	
	}
	else
	{
		$errors[] = "Не выбран сервер для пинга-теста";
	}
	
	return [
			"status" => false, 
			"response" => [
							"errors" => $errors]];
							
  }
  
  public function pingServersSave ($params)
  {
	if (!empty($params["result"]))
	{
		$data = $this->pt->parse($params["result"]);
		
		if($data["status"])
		{
			$status = 1;
			$response_time = $data["time"];
		}
		else
		{
			$status = 0;
			$response_time = null;
		}
		
		if (isset($status))
		{
			$in = $this->db->query("INSERT INTO pingResults 
													SET
													  server_id = ?i,
													  success = ?i,
													  check_date = NOW(),
													  response_time = ?s",
													  $params["id"],
													  $status,
													  $response_time);
			
			if ($in)
			{
				header("Location: /ping/");
			}
			else
			{
				$errors = "Ошибка при добавлении";
				
				return [
						"status" => false, 
						"response" => [
										"errors" => $errors]];
			}
		}
		else
		{
			$errors[] = "Нет состояния сервера в результате";
		}
	}
	else
	{
		$errors[] = "Не заданы параметры";
	}
	
	return [
			"status" => false, 
			"response" => [
							"errors" => $errors]];
							
  }
  
  
  
}
?>