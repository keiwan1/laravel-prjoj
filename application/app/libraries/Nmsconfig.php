<?php

class Nmsconfig {

	private $cfg = array();
	private $config_file = './config.php';

	public function __construct(){
		$this->cfg = include $this->config_file;
	}

	public function getConfig(){
		return $this->cfg;
	}

	public function add($key, $value){
		$this->cfg[$key] = $value;
	}

	public function delete($key, $value){

	}

	public function updateConfig(){

		$results = var_export($this->cfg, true);
		$config_string = "<?php return " . $results . ";";
		return file_put_contents($this->config_file, $config_string);

	}

}