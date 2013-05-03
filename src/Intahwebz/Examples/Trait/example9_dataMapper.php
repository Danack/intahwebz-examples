<?php


//Cheap + sane class reflection
//
//Instead of using the actual reflection methods just embed a trait inside a class, and then you can
// iterate over the member variables.


trait JSONFactory {

	static function factory($data){
		$object = new static();

		foreach ($data AS $key => $value){
			//TODO - figure out what to do about defines in other files for PHP-to-javascript converter.
			//if($key != OBJECT_TYPE){
			if($key != 'x-objectType'){
				$object->$key = $value;
			}
		}

		return $object;
	}

	static function	fromJSON($jsonString){
		return json_decode_object($jsonString);
	}

	function	toJSON(){
		return json_encode_object($this);//, $className);
	}

	function	jumpToJS(){
		$jsonString = $this->toJSON();
		$output = "\n";

		//TODO - this shouldn't be hardcoded.
		$output .= "window.contentFilterData = createContentObject(json_decode('".addslashes($jsonString)."'));\n";
		return $output;
	}
}




/**
 * Trait DataMapper
 *
 * Allows objects to be created directly from an array of data, mapping keynames in the array to member
 * variable names.
 *
 * @package Intahwebz\FlickrGuzzle
 */
trait DataMapper {

	static function getValueFromAlias($data, $dataMapElement, &$notSet){

		$dataVariableNameArray = $dataMapElement[1];

		if ($dataVariableNameArray == null){
			//Return the original data array
			return $data;
		}

		if(is_array($dataVariableNameArray) == FALSE){
			$dataVariableNameArray = array($dataVariableNameArray);
		}

		$dereferenced = $data;

		$aliasPath = '';

		foreach($dataVariableNameArray as $dataVariableName){
			$aliasPath .= '/'.$dataVariableName;

			if (is_array($dereferenced) == false ||
				//Probably an element that can exist as different entries e.g. for tags
				//[raw]
				//or [raw, _content]
				array_key_exists($dataVariableName, $dereferenced) == FALSE){
				$notSet = TRUE;
				return FALSE;
			}
			$dereferenced = $dereferenced[$dataVariableName];
		}

		if (array_key_exists('unindex', $dataMapElement) == true) {
			$index = $dataMapElement['unindex'];

			//Amazingly sometimes text is returned as $title['_content'] = $text other
			//times it's just $title = $text
			if (is_array($dereferenced)) {
				if (array_key_exists($index, $dereferenced) == true) {
					$dereferenced = $dereferenced[$index];
				}
			}
		}

		return $dereferenced;
	}

	/**
	 * @param $data
	 * @return static
	 * @throws \Exception
	 */
	static function createFromData($data){
		if (property_exists(__CLASS__, 'dataMap') == FALSE){
			throw new \Exception("Class ".__CLASS__." is using DataMapper but has not set DataMap.");
		}

		$instance = new static();

		$count = 0;

		foreach(static::$dataMap as $dataMapElement){

			$classVariableName = $dataMapElement[0];
			//$dataVariableNameArray = $dataMapElement[1];
			$className = FALSE;
			$multiple = FALSE;

			if (is_array($dataMapElement) == false) {
				$string = var_export(static::$dataMap, true);
				throw new \Exception("DataMap is meant to be composed of arrays of entries. You've missed some brackets in class ". __CLASS__." : ".$string);
			}

			if(array_key_exists('class', $dataMapElement) == TRUE){
				$className = $dataMapElement['class'];
			}
			if(array_key_exists('multiple', $dataMapElement) == TRUE){
				$multiple = $dataMapElement['multiple'];
			}

			$notFound = FALSE;

			$sourceValue = self::getValueFromAlias($data, $dataMapElement, $notFound);

			if($notFound == TRUE){
				if (array_key_exists('optional', $dataMapElement) == TRUE &&
					$dataMapElement['optional'] == TRUE){
					continue;
				}

//				var_dump($data);
//				echo "count is $count <br/>";
//				var_dump(static::$dataMap);

				$alias = $dataMapElement[1];//$dataVariableNameArray;

				if(is_array($alias) == TRUE){
					$alias = implode('->', $alias);
				}

				var_dump($data);
				//$dataString = implode(',', $data);

				throw new \Exception("DataMapper cannot find value from [".$alias."] for mapping to actual value in array ");
				//.var_export($data)
			}

			if($multiple == TRUE){
				$instance->{$classVariableName} = array();

				foreach($sourceValue as $sourceValueInstance){
					if($className != FALSE){
						$object = $className::createFromData($sourceValueInstance);
						$instance->{$classVariableName}[] = $object;
					}
					else{
						$instance->{$classVariableName}[] = $sourceValueInstance;
					}
				}
			}
			else{
				if($className != FALSE){
					$object = $className::createFromData($sourceValue);
					$instance->{$classVariableName} = $object;
				}
				else{
					$instance->{$classVariableName} = $sourceValue;
				}
			}

			$count++;
		}

		return $instance;
	}

	function remap($remap, $index){
		foreach($remap as $map){
			if($this->$map != NULL){
				$this->$map = $this->{$map}[$index];
			}
		}
	}
}




$object = $className::createFromData($aliasedData);



?>