<?php
require_once("initialize.php");

class Photograph{
	
	protected static $table_name="photographs";
	protected static $db_fields=array('id', 'filename', 'type', 'size', 'caption');
	public $id;
	public $filename;
	public $type;
	public $size;
	public $caption;
	
	private $temp_path;
  protected $upload_dir="gallery/";
  public $errors=array();
  
  protected $upload_errors = array(
		UPLOAD_ERR_OK 				=> "Brak bledow",
		UPLOAD_ERR_INI_SIZE  	=> "Za duzo rozmiar pliku",
	  UPLOAD_ERR_FORM_SIZE 	=> "Wiekszy plik niz norma rozmiaru",
	  UPLOAD_ERR_PARTIAL 		=> "Czesciowy upload",
	  UPLOAD_ERR_NO_FILE 		=> "Nie wybrano pliku.",
	  UPLOAD_ERR_NO_TMP_DIR => "Brak katalogu tymczasowego",
	  UPLOAD_ERR_CANT_WRITE => "Nie mozna zapisac na dysku",
	  UPLOAD_ERR_EXTENSION 	=> "Upload pliku zatrzymany"
	);

  public function attach_file($file) {
		if(!$file || empty($file) || !is_array($file)) {
		  $this->errors[] = "Brak plikow do wyslania";
		  return false;
		} elseif($file['error'] != 0) {
		  $this->errors[] = $this->upload_errors[$file['error']];
		  return false;
		} else {
		  $this->temp_path  = $file['tmp_name'];
		  $this->filename   = basename($file['name']);
		  $this->type       = $file['type'];

		  $this->size       = $file['size'];
			return true;

		}
	}
  
	public function save() {
		if(isset($this->id)) {
			$this->update();
		} else {

		  if(!empty($this->errors)) { return false; }

		  if(strlen($this->caption) > 255) {
				$this->errors[] = "Opis musi wyniesc maksymalnie 255 znakow";
				return false;
			}

		  if(empty($this->filename) || empty($this->temp_path)) {
		    $this->errors[] = "Nie znalezniono lokalizacji";
		    return false;
		  }

		  $target_path = "gallery/".$this->filename;

		  if(file_exists($target_path)) {
		    $this->errors[] = "Plik o podanej nazwie {$this->filename} już istnieje";
		    return false;
		  }

			if(move_uploaded_file($this->temp_path, $target_path)) {
		  	// Success
				if($this->create()) {
					unset($this->temp_path);
					return true;
				}
			} else {
		    $this->errors[] = "Blad. Brak uprawnien do zpaisu w katalogu";
		    return false;
			}
		}
	}
	
	public function destroy() {
		if($this->delete()) {
			$target_path = "gallery/".$this->filename;
			return unlink($target_path) ? true : false;
		} else {
			return false;
		}
	}

	
	public function size_as_text() {
		if($this->size < 1024) {
			return "{$this->size} bytes";
		} elseif($this->size < 1048576) {
			$size_kb = round($this->size/1024);
			return "{$size_kb} KB";
		} else {
			$size_mb = round($this->size/1048576, 1);
			return "{$size_mb} MB";
		}
	}
	
	public function comments() {
		return Comment::find_comments_on($this->id);
	}
	

	public static function find_all() {
		return self::find_by_sql("SELECT * FROM ".self::$table_name);
  }
  
  public static function find_by_id($id=0) {
	  global $database;
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE id=".$database->escape_value($id)." LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  
  public static function find_by_sql($sql="") {
    global $database;
    $result_set = $database->query($sql);
    $object_array = array();
    while ($row = $database->fetch_array($result_set)) {
      $object_array[] = self::instantiate($row);
    }
    return $object_array;
  }

	public static function count_all() {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name;
    $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
    return array_shift($row);
	}

	private static function instantiate($record) {
    $object = new self;
		foreach($record as $attribute=>$value){
		  if($object->has_attribute($attribute)) {
		    $object->$attribute = $value;
		  }
		}
		return $object;
	}
	
	private function has_attribute($attribute) {
	  return array_key_exists($attribute, $this->attributes());
	}

	protected function attributes() {
	  $attributes = array();
	  foreach(self::$db_fields as $field) {
	    if(property_exists($this, $field)) {
	      $attributes[$field] = $this->$field;
	    }
	  }
	  return $attributes;
	}
	
	protected function sanitized_attributes() {
	  global $database;
	  $clean_attributes = array();
	  foreach($this->attributes() as $key => $value){
	    $clean_attributes[$key] = $database->escape_value($value);
	  }
	  return $clean_attributes;
	}

	public function create() {
		global $database;
		$attributes = $this->sanitized_attributes();
	  $sql = "INSERT INTO ".self::$table_name." (";
		$sql .= join(", ", array_keys($attributes));
	  $sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
	  if($database->query($sql)) {
	    $this->id = $database->insert_id();
	    return true;
	  } else {
	    return false;
	  }
	}

	public function update() {
	  global $database;
		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		foreach($attributes as $key => $value) {
		  $attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE ".self::$table_name." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE id=". $database->escape_value($this->id);
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	}

	public function delete() {
		global $database;
	  $sql = "DELETE FROM ".self::$table_name;
	  $sql .= " WHERE id=". $database->escape_value($this->id);
	  $sql .= " LIMIT 1";
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;

	}

}

?>