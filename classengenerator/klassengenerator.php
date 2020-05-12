<?php
/*
class NAME
{
	protected $ATTRIBUT;
	protected $ATTRIBUT;
	protected $ATTRIBUT;
	protected $ATTRIBUT;
	protected $ATTRIBUT;
	protected $ATTRIBUT;
	
	protected function getATTRIBUT()
	{
		return $this->ATTRIBUT
	}
	
	protected function setATTRIBUT($ATTRIBUT)
	{
		$this->ATTRIBUT = $ATTRIBUT
	}
	
	// public Funktionen
}
*/
class Klassengenerator
{
	const ZEILENUMBRUCH = "\r\n";
	const TABULATOR = "\t";	
	
	protected static $klassenname;
	protected static $attribute = array();

	protected static function setKlassenname($klassenname)
	{
		self::$klassenname = $klassenname;
	}		
	protected static function getKlassenname()
	{
		return self::$klassenname;
	}	
	protected static function setAttribute($attribute)
	{
		self::$attribute = $attribute;
	}	
	public static function erzeuge_PHP_Quellcode($klassenname, $attribute)
	{	
		self::setKlassenname($klassenname);
		self::setAttribute($attribute);
		
		$string = "<?php".self::ZEILENUMBRUCH;
		
		$string .= "class ".self::getKlassenname().self::ZEILENUMBRUCH;
		$string .= "{".self::ZEILENUMBRUCH;
		
				// Alle Attribute erzeugen
		$string .= self::TABULATOR."// Attribute".self::ZEILENUMBRUCH;
		
		foreach(self::$attribute as $attribut)
		{
			$string .= self::TABULATOR."protected $".$attribut.";".self::ZEILENUMBRUCH;
		}	
		
		// Alle Methoden erzeugen
		$string .= self::TABULATOR."// GET- und SET-Methoden".self::ZEILENUMBRUCH;	
		
		foreach(self::$attribute as $attribut)
		{
			$string .= self::TABULATOR.'protected function get'.$attribut.'()'.self::ZEILENUMBRUCH;		
			$string .= self::TABULATOR.'{'.self::ZEILENUMBRUCH;
			$string .= self::TABULATOR.self::TABULATOR.'return $this->'.$attribut.';'.self::ZEILENUMBRUCH;	
			$string .= self::TABULATOR.'}'.self::ZEILENUMBRUCH;
			
			$string .= self::TABULATOR.'protected function set'.$attribut.'($'.$attribut.')'.self::ZEILENUMBRUCH;
			$string .= self::TABULATOR.'{'.self::ZEILENUMBRUCH;
			$string .= self::TABULATOR.self::TABULATOR.'$this->'.$attribut.' = $'.$attribut.';'.self::ZEILENUMBRUCH;
			$string .= self::TABULATOR.'}'.self::ZEILENUMBRUCH;			
		}	
		
		$string .= "}".self::ZEILENUMBRUCH;
		
		$string .= "?>".self::ZEILENUMBRUCH;
		
		// Schreibbefehl
		self::generiere_PHP_Datei(self::getKlassenname().".php", $string);
		return "<h1>".self::getKlassenname().".php"." Klasse erfolgreich erzeugt</h1>";	
	}
	
	protected static function generiere_PHP_Datei($datei, $string)
	{
		file_put_contents("dateien/".$datei, $string);
	}	
}
















