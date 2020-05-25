<?php
namespace Klassen;
class Bearbeitung
{
	// Attribute
	protected $BearbeitungID;
	protected $UserID;
	protected $Datum;
	protected $Art_der_Bearbeitung;
	// GET- und SET-Methoden
	protected function getBearbeitungID()
	{
		return $this->BearbeitungID;
	}
	protected function setBearbeitungID($BearbeitungID)
	{
		$this->BearbeitungID = $BearbeitungID;
	}
	protected function getUserID()
	{
		return $this->UserID;
	}
	protected function setUserID($UserID)
	{
		$this->UserID = $UserID;
	}
	protected function getDatum()
	{
		return $this->Datum;
	}
	protected function setDatum($Datum)
	{
		$this->Datum = $Datum;
	}
	protected function getArt_der_Bearbeitung()
	{
		return $this->Art_der_Bearbeitung;
	}
	protected function setArt_der_Bearbeitung($Art_der_Bearbeitung)
	{
		$this->Art_der_Bearbeitung = $Art_der_Bearbeitung;
	}
}
?>
