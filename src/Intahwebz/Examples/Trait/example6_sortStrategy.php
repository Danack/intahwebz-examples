<?php

//From
//http://php.net/manual/en/language.oop5.traits.php#110521

//Traits are useful for strategies, when you want the same data to be handled (filtered, sorted, etc) differently.
//
//For example, you have a list of products that you want to filter out based on some criteria (brands, specs, whatever), or sorted by different means (price, label, whatever). You can create a sorting trait that contains different functions for different sorting types (numeric, string, date, etc). You can then use this trait not only in your product class (as given in the example), but also in other classes that need similar strategies (to apply a numeric sort to some data, etc).


trait SortStrategy {

	private $sort_field = null;

	private function string_asc($item1, $item2) {
		return strnatcmp($item1[$this->sort_field], $item2[$this->sort_field]);
	}

	private function string_desc($item1, $item2) {
		return strnatcmp($item2[$this->sort_field], $item1[$this->sort_field]);
	}

	private function num_asc($item1, $item2) {
		if ($item1[$this->sort_field] == $item2[$this->sort_field]) return 0;
		return ($item1[$this->sort_field] < $item2[$this->sort_field] ? -1 : 1 );
	}

	private function num_desc($item1, $item2) {
		if ($item1[$this->sort_field] == $item2[$this->sort_field]) return 0;
		return ($item1[$this->sort_field] > $item2[$this->sort_field] ? -1 : 1 );
	}

	private function date_asc($item1, $item2) {
		$date1 = intval(str_replace('-', '', $item1[$this->sort_field]));
		$date2 = intval(str_replace('-', '', $item2[$this->sort_field]));
		if ($date1 == $date2) return 0;
		return ($date1 < $date2 ? -1 : 1 );
	}

	private function date_desc($item1, $item2) {
		$date1 = intval(str_replace('-', '', $item1[$this->sort_field]));
		$date2 = intval(str_replace('-', '', $item2[$this->sort_field]));
		if ($date1 == $date2) return 0;
		return ($date1 > $date2 ? -1 : 1 );
	}
}



class Product {
	public $data = array();

	use SortStrategy;

	public function get() {
		// do something to get the data, for this ex. I just included an array
		$this->data = array(
			101222 => array('label' => 'Awesome product', 'price' => 10.50, 'date_added' => '2012-02-01'),
			101232 => array('label' => 'Not so awesome product', 'price' => 5.20, 'date_added' => '2012-03-20'),
			101241 => array('label' => 'Pretty neat product', 'price' => 9.65, 'date_added' => '2012-04-15'),
			101256 => array('label' => 'Freakishly cool product', 'price' => 12.55, 'date_added' => '2012-01-11'),
			101219 => array('label' => 'Meh product', 'price' => 3.69, 'date_added' => '2012-06-11'),
		);
	}

	public function sort_by($by = 'price', $type = 'asc') {
		if (!preg_match('/^(asc|desc)$/', $type)) $type = 'asc';
		switch ($by) {
			case 'name':
				$this->sort_field = 'label';
				uasort($this->data, array('Product', 'string_'.$type));
				break;

			case 'date':
				$this->sort_field = 'date_added';
				uasort($this->data, array('Product', 'date_'.$type));
				break;

			default:
				$this->sort_field = 'price';
				uasort($this->data, array('Product', 'num_'.$type));
		}
	}
}

$product = new Product();
$product->get();
$product->sort_by('name');
echo '<pre>'.print_r($product->data, true).'</pre>';

?>