<?php
namespace Klassen;
class Geschmack
{
	// Attribute
	protected $GeschmackID;
	protected $GeschmackName;
	// GET- und SET-Methoden
	protected function getGeschmackID()
	{
		return $this->GeschmackID;
	}
	protected function setGeschmackID($GeschmackID)
	{
		$this->GeschmackID = $GeschmackID;
	}
	protected function getGeschmackName()
	{
		return $this->GeschmackName;
	}
	protected function setGeschmackName($GeschmackName)
	{
		$this->GeschmackName = $GeschmackName;
	}
}
?>
