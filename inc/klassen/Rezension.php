<?php
namespace Klassen;
class Rezension
{
	// Attribute
	protected $RezensionID;
	protected $Rezension_Beschreiben;
	protected $Front_Seite;
	// GET- und SET-Methoden
	protected function getRezensionID()
	{
		return $this->RezensionID;
	}
	protected function setRezensionID($RezensionID)
	{
		$this->RezensionID = $RezensionID;
	}
	protected function getRezension_Beschreiben()
	{
		return $this->Rezension_Beschreiben;
	}
	protected function setRezension_Beschreiben($Rezension_Beschreiben)
	{
		$this->Rezension_Beschreiben = $Rezension_Beschreiben;
	}
	protected function getFront_Seite()
	{
		return $this->Front_Seite;
	}
	protected function setFront_Seite($Front_Seite)
	{
		$this->Front_Seite = $Front_Seite;
	}
}
?>
