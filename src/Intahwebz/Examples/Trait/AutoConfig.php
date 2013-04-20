<?php


define('CONFIG_PATH', "./");


trait AutoConfig{

	abstract public function parseConfig($configDataArray);

	public function loadConfig(){
		$configData = NULL;
		$configFilename = $this->getConfigFilename();

		if(file_exists($configFilename) == TRUE){
			$yaml = file_get_contents($configFilename);
			$configData = yaml_parse($yaml);
		}

		$this->parseConfig($configData);
	}

	public function saveConfig($configDataArray){

		$configFilename = $this->getConfigFilename();

		$yaml = yaml_emit($configDataArray , YAML_UTF8_ENCODING, YAML_CRLN_BREAK);

		$result = file_put_contents($configFilename, $yaml);

		if($result === FALSE){
			throw new UnsupportedOperationException("Failed to write config file [$configFilename].");
		}
	}

	function getConfigFilename(){
		$className  = get_class();

		$firstChar = substr($className, 0, 1);

		if($firstChar == "\\"){
			$className = substr($className, 1);
		}

		$className = str_replace("\\", "/", $className);
		$className = str_replace(".", "", $className);

		return CONFIG_PATH.$className.".yaml";
	}
}

?>