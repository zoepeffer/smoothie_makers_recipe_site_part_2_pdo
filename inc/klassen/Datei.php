<?php
namespace Klassen;
class Datei
{
	// Attribute
	protected $Dateiinfo; // Array
	
	// GET- und SET-Methoden
	public function getDateiinfo()
	{
		return $this->Dateiinfo;
	}
	
	protected function setDateiinfo($Dateiinfo)
	{
		$this->Dateiinfo = $Dateiinfo;
	}
	
	public function __construct($dateiinfo)
	{
		$this->setDateiinfo($dateiinfo);
	}	
}
?>