<?php

interface Render {

	public function render();
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

class AjaxLayout implements Render {

	public function render() {
		$this->renderMainContent();
	}

	function renderMainContent(){
		echo "Main content goes here.";
	}
}


class ImageDisplay extends PageLayout {
//class ImageDisplay extends AjaxLayout {

	private $images = array(
		"http://farm7.staticflickr.com/6204/6041165491_08ff32ba94_q.jpg",
		"http://farm5.staticflickr.com/4068/4467006490_1e8669d4c1_q.jpg",
		"http://farm5.staticflickr.com/4056/4467003496_9c162e9e10_q.jpg",
		"http://farm7.staticflickr.com/6231/6405523525_64e65ec9e0_q.jpg",
		"http://farm5.staticflickr.com/4056/4467003496_9c162e9e10_q.jpg",
		"http://farm5.staticflickr.com/4065/4714412918_0afc6018dc_q.jpg",
		"http://farm5.staticflickr.com/4023/4713771435_b85f8a86a6_q.jpg",
		"http://farm5.staticflickr.com/4058/4714411532_2dd7b3a361_q.jpg",
		"http://farm5.staticflickr.com/4070/4709078920_fcf39baa70_q.jpg",
		"http://farm5.staticflickr.com/4071/4709078252_d13aeb5655_q.jpg",
		"http://farm2.staticflickr.com/1269/4708434945_fd6e9c06e6_q.jpg",
	);

	function renderMainContent() {

		$totalImages = count($this->images);
		$imagesToShow = 4;
		$startImage = rand(0, $totalImages - $imagesToShow);

		for($x=0 ; $x<$imagesToShow ; $x++) {
			echo "<img src='".$this->images[$startImage + $x]."'/>";
		}

		echo "<br/>&nbsp;<br/>";
		echo "<span onclick='loadImages();' style='border: 2px solid #000000; padding: 4px:'>Click to refresh images</span>";
	}
}


if (isset($_REQUEST['panel']) && $_REQUEST['panel']) {
	echo "We would really like ImageDisplay to inherit from AjaxLayout.<br/>";
}

$page = new ImageDisplay();

$page->render();




?>