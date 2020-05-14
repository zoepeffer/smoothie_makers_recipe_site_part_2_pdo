<?php
namespace Klassen;
class Selection
{
	// Attribute
	protected $SelectionID;
	protected $SelectionName;
	// GET- und SET-Methoden
	protected function getSelectionID()
	{
		return $this->SelectionID;
	}
	protected function setSelectionID($SelectionID)
	{
		$this->SelectionID = $SelectionID;
	}
	protected function getSelectionName()
	{
		return $this->SelectionName;
	}
	protected function setSelectionName($SelectionName)
	{
		$this->SelectionName = $SelectionName;
	}
}
?>
