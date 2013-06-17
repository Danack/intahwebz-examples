<?php

interface Render {
	public function render();
}



class DynamicAggregator implements Render {

	var $instance = null;

	public function __construct($parentClassName) {
		$parentClassName = "Proxied".$parentClassName;
		$this->instance = new $parentClassName($this);
	}

	public function __call($name, array $arguments) {
		if ($this->instance == null) {
			throw new PHPTemplateException("Instance is null in Proxied class in renderInternal.");
		}

		return call_user_func([$this->instance, $name], $arguments);
	}

	function render() {
		if ($this->instance == null) {
			throw new Exception("Instance is null in DynamicAggregator class in render().");
		}

		//TODO if this.child has method renderInternal
		$this->instance->render();
	}
}




class PageLayout implements Render {

	public function render() {
		$this->renderHeader();
		$this->renderMainContent();
		$this->renderFooter();
	}

	function renderHeader() {
		echo "<html><head></head><body>";
		echo "<h2>Welcome to a test server!</h2>";

		echo "<span id='mainContent'>";
	}

	function renderMainContent(){
		echo "Main content goes here.";
	}

	function renderFooter(){
		echo "</span>";

		echo "<div style='margin-top: 20px'>Dynamic Extension Danack@basereality.com</div>";

		echo "</body>";

		echo "<script type='text/javascript' src='jquery-1.9.1.js' ></script>";
		echo "<script type='text/javascript' src='content.js' ></script>";
		echo "</html>";
	}
}


class ProxiedPageLayout extends PageLayout {

	var $childInstance = null;

	function __construct($childInstance){
		$this->childInstance = $childInstance;
	}

	function renderHeader() {
		if (method_exists ($this->childInstance, 'renderHeader') == true) {
			return $this->childInstance->renderHeader();
		}
		parent::renderHeader();
	}

	function renderMainContent(){
		if (method_exists ($this->childInstance, 'renderMainContent') == true) {
			return $this->childInstance->renderMainContent();
		}
		parent::renderMainContent();
	}

	function renderFooter(){
		if (method_exists ($this->childInstance, 'renderFooter') == true) {
			return $this->childInstance->renderFooter();
		}
		parent::renderFooter();
	}
}


class AjaxLayout implements Render {

	public function render() {
		$this->renderMainContent();
	}

	function renderMainContent(){
		echo "Main content goes here.";
	}
}


class ProxiedAjaxLayout extends AjaxLayout {

	var $childInstance = null;

	function __construct($childInstance){
		$this->childInstance = $childInstance;
	}

	function renderMainContent() {
		if (method_exists ($this->childInstance, 'renderMainContent') == true) {
			return $this->childInstance->renderMainContent();
		}
		parent::toolPanel();
	}
}




class ImageDisplay extends DynamicAggregator {

	private $images = array(
		"6E6F0115.jpg",
		"6E6F0294.jpg",
		"6E6F0327.jpg",
		"6E6F0416.jpg",
		"6E6F0926.jpg",
		"6E6F1061.jpg",
		"6E6F1151.jpg",
		"IMG_4353_4_5_6_7_8.jpg",
		"IMG_4509.jpg",
		"IMG_4785.jpg",
		"IMG_4888.jpg",
		"MK3L5774.jpg",
		"MK3L5858.jpg",
		"MK3L5899.jpg",
		"MK3L5913.jpg",
		"MK3L7764.jpg",
		"MK3L8562.jpg",
	);

	function renderMainContent() {

		$totalImages = count($this->images);
		$imagesToShow = 4;
		$startImage = rand(0, $totalImages - $imagesToShow);

		for($x=0 ; $x<$imagesToShow ; $x++) {
			echo "<img src='/images/".$this->images[$startImage + $x]."'/>";
		}

		echo "<br/>&nbsp;<br/>";
		echo "<span onclick='loadImagesDynamic();' style='border: 2px solid #000000; padding: 4px:'>Click to refresh images</span>";
	}
}


$parentClassName = 'PageLayout';

if (isset($_REQUEST['panel']) && $_REQUEST['panel']) {
	$parentClassName = 'AjaxLayout';
}

$page = new ImageDisplay($parentClassName);

$page->render();




?>