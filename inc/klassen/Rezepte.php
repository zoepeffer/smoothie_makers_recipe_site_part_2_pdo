<?php
class Rezepte
{
	// Attribute
	protected $RezepteID;
	protected $RezensionID;
	protected $UserID;
	protected $FarbeID;
	protected $ZutatTyp;
	protected $GeschmackID;
	protected $SelectionID;
	protected $BearbeitungID;
	protected $RezepteName;
	protected $Datum;
	protected $Rezept_Beschreiben;
	protected $Rezeptbild;
	// GET- und SET-Methoden
	protected function getRezepteID()
	{
		return $this->RezepteID;
	}
	protected function setRezepteID($RezepteID)
	{
		$this->RezepteID = $RezepteID;
	}
	protected function getRezensionID()
	{
		return $this->RezensionID;
	}
	protected function setRezensionID($RezensionID)
	{
		$this->RezensionID = $RezensionID;
	}
	protected function getUserID()
	{
		return $this->UserID;
	}
	protected function setUserID($UserID)
	{
		$this->UserID = $UserID;
	}
	protected function getFarbeID()
	{
		return $this->FarbeID;
	}
	protected function setFarbeID($FarbeID)
	{
		$this->FarbeID = $FarbeID;
	}
	protected function getZutatTyp()
	{
		return $this->ZutatTyp;
	}
	protected function setZutatTyp($ZutatTyp)
	{
		$this->ZutatTyp = $ZutatTyp;
	}
	protected function getGeschmackID()
	{
		return $this->GeschmackID;
	}
	protected function setGeschmackID($GeschmackID)
	{
		$this->GeschmackID = $GeschmackID;
	}
	protected function getSelectionID()
	{
		return $this->SelectionID;
	}
	protected function setSelectionID($SelectionID)
	{
		$this->SelectionID = $SelectionID;
	}
	protected function getBearbeitungID()
	{
		return $this->BearbeitungID;
	}
	protected function setBearbeitungID($BearbeitungID)
	{
		$this->BearbeitungID = $BearbeitungID;
	}
	protected function getRezepteName()
	{
		return $this->RezepteName;
	}
	protected function setRezepteName($RezepteName)
	{
		$this->RezepteName = $RezepteName;
	}
	protected function getDatum()
	{
		return $this->Datum;
	}
	protected function setDatum($Datum)
	{
		$this->Datum = $Datum;
	}
	protected function getRezept_Beschreiben()
	{
		return $this->Rezept_Beschreiben;
	}
	protected function setRezept_Beschreiben($Rezept_Beschreiben)
	{
		$this->Rezept_Beschreiben = $Rezept_Beschreiben;
	}
	protected function getRezeptbild()
	{
		return $this->Rezeptbild;
	}
	protected function setRezeptbild($Rezeptbild)
	{
		$this->Rezeptbild = $Rezeptbild;
	}
}
?>
