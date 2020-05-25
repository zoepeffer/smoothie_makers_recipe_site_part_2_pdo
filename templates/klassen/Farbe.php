<?php
namespace Klassen;
class Farbe
{
	// Attribute
	protected $FarbeID;
	protected $FarbeName;
	// GET- und SET-Methoden
	protected function getFarbeID()
	{
		return $this->FarbeID;
	}
	protected function setFarbeID($FarbeID)
	{
		$this->FarbeID = $FarbeID;
	}
	protected function getFarbeName()
	{
		return $this->FarbeName;
	}
	protected function setFarbeName($FarbeName)
	{
		$this->FarbeName = $FarbeName;
	}
}
?>
