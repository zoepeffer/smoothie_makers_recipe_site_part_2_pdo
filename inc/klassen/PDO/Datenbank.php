<?php
namespace klassen\PDO;
class Datenbank
{
	public $host="localhost";
	public $port=3306;
	public $dbname="_smoothie_maker";
	public $user="root";
	public $kennwort="";
	public $db_objekt;	
	
	public function __construct()
	{
		$this->verbindung_herstellen();	
	}
	protected function verbindung_herstellen()
	{
		$this->db_objekt = new \PDO("mysql:host=".$this->host."; dbname=".$this->dbname.";port:".
		$this->port."",$this->user, $this->kennwort,
			array
			(
				\PDO::ATTR_ERRMODE 					=> \PDO::ERRMODE_WARNING,
				\PDO::ATTR_DEFAULT_FETCH_MODE 		=> \PDO::FETCH_ASSOC,
				\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY 	=> true,
				\PDO::MYSQL_ATTR_INIT_COMMAND 		=> "SET NAMES utf8"
			)
		);		
	}		
	
	public function abfrage_ausfuehren($sql, $array = array())
	{
		$antwort = $this->db_objekt->prepare($sql);
		$antwort->execute($array);
		return $antwort;
	}
	
	public function sql_insert($sql, $array = array())
	{
		$antwort = $this->abfrage_ausfuehren($sql, $array);
		return $this->db_objekt->lastInsertId();
	}
	
	public function sql_update($sql, $array = array())
	{
		$antwort = $this->abfrage_ausfuehren($sql, $array);
		if($antwort->rowCount() == 0)
		{
			return "Update fehlgeschlagen: ".$antwort->rowCount()." Datensätze aktualisiert";
		}
		else
		{
			return "Update erfolgreich: ".$antwort->rowCount()." Datensätze aktualisiert";
		}		
	}

	public function sql_select($sql, $array = array())
	{
		$antwort = $this->abfrage_ausfuehren($sql, $array);
		$daten = $antwort->fetchAll(); // alle Datensätze
		return $daten;
	}

	public function sql_delete($sql, $array = array())
	{
		$antwort = $this->abfrage_ausfuehren($sql, $array);
		if($antwort->rowCount() == 0)
		{
			return "Delete fehlgeschlagen: ".$antwort->rowCount()." Datensätze gelöscht";
		}
		else
		{
			return "Delete erfolgreich: ".$antwort->rowCount()." Datensätze gelöscht";
		}		
	}	
}
?>