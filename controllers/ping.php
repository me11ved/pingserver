<?php

class Ping extends Controller {
	
	public function __construct() {
	  parent::__construct();
	  
	}

	public function index () {
		
		$this->view->data = $this->model->index();
		$this->view->title = "История пингов";
		$this->view->render('ping/index');
	}
	
	public function pingServers () {
		
		$this->view->data = $this->model->serversList();
		$this->view->title = "Пинг тест";
		$this->view->render('ping/test');
	}
	
	public function pingServersStart ()
	{
		$params = $_POST;
		
		$this->view->title = "Пинг тест";
		$this->view->data = $this->model->serversList();
		$this->view->result = $this->model->pingServersStart($params);
		$this->view->render('ping/test');
	}
	
	public function pingServersSave ()
	{
		$params = $_POST;
		
		$this->view->title = "Пинг тест";
		$this->view->data = $this->model->serversList();
		$this->view->result = $this->model->pingServersSave($params);
		
	}
	
	public function addServers () {
		$this->view->groupsList = $this->model->groupsList();
		$this->view->title = "Добавить сервер";
		$this->view->result = null;
		$this->view->render('ping/addserv');
	}
	
	public function addServersSave () {
		
		$params = $_POST;
		
		$this->view->title = "Добавить сервер";
		$this->view->groupsList = $this->model->groupsList();
		$this->view->data = $params;
		$this->view->result = $this->model->addServers($params);
		$this->view->render('ping/addserv');
	}
	
	
	

}
?>