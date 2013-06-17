<?php

//An interface that defines the method that must be implemented by any renderer.
interface Render {
	public function render();
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

		echo "<p>This is the start of the page, it should only appear once, but clicking the refresh button below will make a duplicate.</p>";

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
}


/**
 * Class ImageDisplay
 *
 * Renders some images on a page or Ajax request.
 */
class ImageDisplay extends PageLayout {

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

		for($x=0 ; $x<$imagesToShow ; $x++) {
			echo "<img src='images/".$this->images[$startImage + $x]."'/>";
		}

		echo "<br/>&nbsp;<br/>";
		echo "<span onclick='loadImages();' style='border: 2px solid #000000; padding: 4px:'>Click to refresh images</span>";
	}
}



if (isset($_REQUEST['panel']) && $_REQUEST['panel']) {
	echo "We would really like ImageDisplay to inherit from AjaxLayout, to avoid the full page being returned when we refresh the content.<br/>";
}

$page = new ImageDisplay();

$page->render();


?>