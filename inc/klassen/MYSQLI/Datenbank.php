<?php
namespace klassen\MYSQLI;
class Datenbank
{
	// Attribute
	public $host="localhost";
	public $port=3306;
	public $dbname="_smoothie_maker";
	public $user="root";
	public $kennwort="";
	public $db_verbindung;	// MYSQLI Verbindung	
	
	################################################################################################
	// Magische Methoden
	public function __construct()
	{
		$this->verbindung_herstellen();
		echo "<h1>MYSQLI</h1>";
	}
	################################################################################################
	// Methoden
	protected function verbindung_herstellen()
	{
		$this->db_verbindung = mysqli_connect($this->host,$this->user,$this->kennwort, $this->dbname);
		$this->abfrage_ausfuehren("SET NAMES utf8");
	}	
	public function abfrage_ausfuehren($sql, $array = array())
	{	
		// Senden
		#$antwort = mysqli_query($this->db_verbindung, $sql);
		#return $antwort;
		
		/*
		# Variante 1: nur mit ? Platzhalter
		// Befehl ohne Daten vorbereiten
		$prepare = $this->db_verbindung->prepare($sql);
		
		// Daten in den Befehl füllen
		if(count($array) >= 1)
		{
			print_r($array);
			$prepare->bind_param("ss", $array[0],$array[1]);
		}
		// Ausführen
		$prepare->execute();
		
		// Ergebnis holen
		$antwort = $prepare->get_result();
		
		*/
		
		
		# Variante 2: nur mit benannte (mit Namen) Platzhalter
		foreach($array as $schluessel => $wert)
		{
			$array[$schluessel] = mysqli_real_escape_string($this->db_verbindung, $wert);
			$sql = suchen_und_ersetzen(":".$schluessel, "'".$wert."'", $sql);
		}
		// Senden
		$antwort = mysqli_query($this->db_verbindung, $sql);		
		
		
		return $antwort;
	}
	
	public function sql_insert($sql, $array = array())
	{
		$antwort = $this->abfrage_ausfuehren($sql, $array);
		return $this->db_verbindung->insert_id;
	}

	public function sql_update($sql, $array = array())
	{
		$antwort = $this->abfrage_ausfuehren($sql, $array);	
		if($this->db_verbindung->affected_rows == 0)
		{
			return "Update fehlgeschlagen: ".$this->db_verbindung->affected_rows." Datensätze aktualisiert";
		}
		else
		{
			return "Update erfolgreich: ".$this->db_verbindung->affected_rows." Datensätze aktualisiert";
		}
	}
	public function sql_select($sql, $array = array())
	{
		$antwort = $this->abfrage_ausfuehren($sql, $array);
		$datensaetze = array();
		while($daten = mysqli_fetch_assoc($antwort))
		{
			$datensaetze[] = $daten;
		}
		return $datensaetze;
	}
	public function sql_delete($sql, $array = array())
	{
		$antwort = $this->abfrage_ausfuehren($sql, $array);
		if($this->db_verbindung->affected_rows == 0)
		{
			return "Delete fehlgeschlagen: ".$this->db_verbindung->affected_rows." Datensätze gelöscht";
		}
		else
		{
			return "Delete erfolgreich: ".$this->db_verbindung->affected_rows." Datensätze gelöscht";
		}				
	}
	
	public function __destruct()
	{
		mysqli_close($this->db_verbindung);
	}			
}

####################################################################################################
#$db = new Datenbank();

#$insert_id = $db->sql_insert("insert into mitarbeiter (name, vorname) values('Mustermann','Max');");
#$insert_id = $db->sql_insert("insert into mitarbeiter (name, vorname) values(?,?);", 
#array("Fröhlich","Fritz"));
#echo $insert_id;
#echo "<hr />";
#$insert_id = $db->sql_insert("insert into mitarbeiter (name, vorname) values(:nachname,:vorname);", 
#array("nachname" => "Mustermann","vorname" => "Max"));
#echo $insert_id;

#echo "<hr />";
#echo $db->sql_update("update mitarbeiter set vorname='Fritz'");

#echo "<hr />";
#echo "<pre>";
#print_r($db->sql_select("select * from mitarbeiter"));
#echo "</pre>";

#echo "<hr />";
#echo $db->sql_delete("delete from mitarbeiter");
?>