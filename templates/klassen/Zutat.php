<?php
namespace Klassen;
class Zutat
{
	// Attribute
	protected $ZutatID;
	protected $FarbeID;
	protected $ZutatName;
	// GET- und SET-Methoden
	protected function getZutatID()
	{
		return $this->ZutatID;
	}
	protected function setZutatID($ZutatID)
	{
		$this->ZutatID = $ZutatID;
	}
	protected function getFarbeID()
	{
		return $this->FarbeID;
	}
	protected function setFarbeID($FarbeID)
	{
		$this->FarbeID = $FarbeID;
	}
	protected function getZutatName()
	{
		return $this->ZutatName;
	}
	protected function setZutatName($ZutatName)
	{
		$this->ZutatName = $ZutatName;
	}
}
?>
