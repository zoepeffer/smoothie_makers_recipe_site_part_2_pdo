<?php
namespace Klassen;
class Dateimanager
{
	public function datei_hochladen($datei)
	{
		$datei_tempname = $datei["tmp_name"];
		$neuer_dateiname = uniqid("smoothiebild_").".png"; 
		$this->datei_kopieren($datei_tempname, $neuer_dateiname);
		return $neuer_dateiname;	
	}
	public function datei_loeschen($datei)
	{
		unlink("uploads/".$datei);
	}
	public function datei_kopieren($datei_tempname, $neuer_dateiname)
	{
		move_uploaded_file($datei_tempname, "uploads/".$neuer_dateiname);
	}
	
	public function datei_downloaden($datei)
	{
		$type = "image/png"; 
		header("Content-type: $type"); 
		header("Content-Disposition: attachment; filename=bild.png"); 
		readfile($datei); 		
	}
}
?>