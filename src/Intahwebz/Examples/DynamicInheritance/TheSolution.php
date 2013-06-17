<?php

//An interface that defines the method that must be implemented by any renderer.
interface Render {
	public function render();
}


/**
 * Class DynamicExtender
 */
class DynamicExtender implements Render {

	var $parentInstance = null;

	/**
	 * Construct a class with it's parent class chosen dynamically.
	 *
	 * @param $parentClassName The parent class to extend.
	 */
	public function __construct($parentClassName) {
		$parentClassName = "Proxied".$parentClassName;

		//Check that the requested parent class implements the interface 'Render'
		//to prevent surprises later.
		if (is_subclass_of($parentClassName, 'Render') == false) {
			throw new Exception("Requested parent class $parentClassName does not implement Render, so cannot extend it.");
		}

		$this->parentInstance = new $parentClassName($this);
	}

	/**
	 * Magic __call method is triggered whenever the child class tries to call a method that doesn't
	 * exist in the child class. This is the case whenever the child class tries to call a method of
	 * the parent class. We then redirect the method call to the parentInstance.
	 *
	 * @param $name
	 * @param array $arguments
	 * @return mixed
	 * @throws PHPTemplateException
	 */
	public function __call($name, array $arguments) {
		if ($this->parentInstance == null) {
			throw new Exception("parentInstance is null in Proxied class in renderInternal.");
		}

		return call_user_func_array([$this->parentInstance, $name], $arguments);
	}

	/**
	 * Render method needs to be defined to satisfy the 'implements Render' but it
	 * also just delegates the function to the parentInstance.
	 * @throws Exception
	 */
	function render() {
		$this->parentInstance->render();
	}
}



/**
 * Class PageLayout
 *
 * Implements render with a full HTML layout.
 */
class PageLayout implements Render {

	//renders the whole page.
	public function render() {
		$this->renderHeader();
		$this->renderMainContent();
		$this->renderFooter();
	}

	//Start HTML page
	function renderHeader() {
		echo "<html><head></head><body>";
		echo "<h2>Welcome to a test server!</h2>";

		echo "<span id='mainContent'>";
	}

	//Renders the main page content. This method should be overridden for each page
	function renderMainContent(){
		echo "Main content goes here.";
	}

	//End the HTML page, including Javascript
	function renderFooter(){
		echo "</span>";
		echo "<div style='margin-top: 20px'>Dynamic Extension Danack@basereality.com</div>";
		echo "</body>";
		echo "<script type='text/javascript' src='jquery-1.9.1.js' ></script>";
		echo "<script type='text/javascript' src='content.js' ></script>";
		echo "</html>";
	}

	//Just to prove we're extending dynamically.
	function getLayoutType() {
		return get_class($this);
	}
}

/**
 * Class ProxiedPageLayout
 *
 * Implements render for rendering some content surrounded by the opening and closing HTML
 * tags, along with the Javascript required for a page.
 */
class ProxiedPageLayout extends PageLayout {

	/**
	 * The child instance which has extended this class.
	 */
	var $childInstance = null;

	/**
	 * Construct a ProxiedPageLayout. The child class must be passed in so that any methods
	 * implemented by the child class can override the same method in this class.
	 * @param $childInstance
	 */
	function __construct($childInstance){
		$this->childInstance = $childInstance;
	}

	/**
	 * Check if method exists in child class or just call the version in PageLayout
	 */
	function renderHeader() {
		if (method_exists ($this->childInstance, 'renderHeader') == true) {
			return $this->childInstance->renderHeader();
		}
		parent::renderHeader();
	}

	/**
	 * Check if method exists in child class or just call the version in PageLayout
	 */
	function renderMainContent(){
		if (method_exists ($this->childInstance, 'renderMainContent') == true) {
			return $this->childInstance->renderMainContent();
		}
		parent::renderMainContent();
	}

	/**
	 * Check if method exists in child class or just call the version in PageLayout
	 */
	function renderFooter(){
		if (method_exists ($this->childInstance, 'renderFooter') == true) {
			return $this->childInstance->renderFooter();
		}
		parent::renderFooter();
	}
}


/**
 * Class AjaxLayout
 *
 * Implements render for just rendering a panel to replace the existing content.
 */
class AjaxLayout implements Render {

	//Render the Ajax request.
	public function render() {
		$this->renderMainContent();
	}

	//Renders the main page content. This method should be overridden for each page
	function renderMainContent(){
		echo "Main content goes here.";
	}

	//Just to prove we're extending dynamically.
	function getLayoutType() {
		return get_class($this);
	}
}

/**
 * Class ProxiedAjaxLayout
 *
 * Proxied version of AjaxLayout. All public functions must be overridden with a version that tests
 * whether the method exists in the child class.
 */
class ProxiedAjaxLayout extends AjaxLayout {

	/**
	 * The child instance which has extended this class.
	 */
	var $childInstance = null;

	/**
	 * Construct a ProxiedAjaxLayout. The child class must be passed in so that any methods
	 * implemented by the child class can override the same method in this class.
	 * @param $childInstance
	 */
	function __construct($childInstance){
		$this->childInstance = $childInstance;
	}

	/**
	 * Check if method exists in child class or just call the version in AjaxLayout
	 */
	function renderMainContent() {
		if (method_exists ($this->childInstance, 'renderMainContent') == true) {
			return $this->childInstance->renderMainContent();
		}
		parent::renderMainContent();
	}
}



/**
 * Class ImageDisplay
 *
 * Renders some images on a page or Ajax request.
 */
class ImageDisplay extends DynamicExtender {

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

	//Renders the images on a page, along with a refresh button
	function renderMainContent() {
		$totalImages = count($this->images);
		$imagesToShow = 4;
		$startImage = rand(0, $totalImages - $imagesToShow);

		//Code inspection will not be available for 'getLayoutType' as it
		//doesn't exist statically in the class hierarchy
		echo "Parent class is of type: ".$this->getLayoutType()."<br/>";

		for($x=0 ; $x<$imagesToShow ; $x++) {
			echo "<img src='images/".$this->images[$startImage + $x]."'/>";
		}

		echo "<br/>&nbsp;<br/>";
		echo "<span onclick='loadImagesDynamic();' style='border: 2px solid #000000; padding: 4px:'>Click to refresh images</span>";
	}
}


$parentClassName = 'PageLayout';

if (isset($_REQUEST['panel']) && $_REQUEST['panel']) {
	//YAY! Dynamically set the parent class.
	$parentClassName = 'AjaxLayout';
}

$page = new ImageDisplay($parentClassName);

$page->render();




?>