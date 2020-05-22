<?php
namespace seitensteuerung;

use Klassen\PDO\Datenbank;  // benutze diesen Namespace für Datenbank
#use Klassen\MYSQLI\Datenbank; // benutze diesen Namespace für Datenbank

// benutzte den Namensraum nur für die spezielle Klasse
use Klassen\Bearbeitung;
use Klassen\Farbe;
use Klassen\Geschmack;
use Klassen\Rezension;
use Klassen\Rezept;
use Klassen\Selection;
use Klassen\User;
use Klassen\Zutat;

use Klassen\Datei;
use Klassen\Dateimanager;

class Seitensteuerung
{
	// Attribute
	public $action 		= "";								// Seitenauswahl
	public $formData 	= array();							// Formulardaten
	public $template 	= "templates/grundgeruest.html";	// HTML-Seite
	public $content 	= "Inhalt ist noch leer"; 			// Seiteninhalt der Unterseite
	
	public function selectPage($page)
	{
		$this->action = $page;

		if(isset($_POST["login_formular"]))
		{
			$db = new Datenbank();
			$user = $db->sql_select("select * from user where login =:login",
											array("login" => $_POST['login']));
			if(count($user) == 1)
			{			
				$hash = $user[0]["passwort"]; # $2y$10$L2SrVQ8Ll5lO.OvyBHBzYOXuzXwGoIBwrzTHuFwKzCUNAVNk47uXe
				if(password_verify($_POST["passwort"], $hash))
				{
					$_SESSION["user_id"] = $user[0]["user_id"];
				}
			}
		}
		
		
		switch($this->action)
		{
			case "von_uns":				$this->actionVon_uns();					break;
			case "smoothie_suchen":		$this->actionSmoothie_suchen();  	  	break;
			case "smoothie_schreiben":	$this->actionSmoothie_schreiben();		break;
			case "smoothie_bearbeiten":	$this->actionSmoothie_bearbeiten();		break;

			#case "login":				$this->actionLogin();					break;
			case "logout":				$this->actionLogout();					break;

			case "kontakt":				$this->actionKontakt();					break;
			case "impressum":			$this->actionImpressum();				break;
			case "agb":					$this->actionAGB();						break;
			case "download":			$this->actionDownload();				break;
			case "veraltet":			$this->actionVeraltet();				break;
			default:					$this->actionSeiteNichtGefunden();
		}
		// Template Vorlage holen
		$zeichenkette = file_get_contents($this->template);
		//echo $zeichenkette;
		$logout_string = "";
		$login_string = "";
		
		if(isset($_SESSION["user_id"]))
		{
			$logout_string = '<a href="index.php?action=logout">Logout</a>';
		}
		else
		{
			#$login_string = '<a href="index.php?action=login">Login</a>';
		}	
		
		
		$zeichenkette = suchen_und_ersetzen("__#__LOGIN__#__", $login_string,	$zeichenkette);
		$zeichenkette = suchen_und_ersetzen("__#__LOGOUT__#__", $logout_string,	$zeichenkette);
		
		$ersatztext = suchen_und_ersetzen("__#__CONTENT__#__", $this->content,	$zeichenkette);
		return $ersatztext;
	}

	protected function actionVon_uns()
	{
		#$this->content = "<h1>Von uns</h1>";
		$this->content = file_get_contents("templates/von_uns.html");

		#$db = new \klassen\PDO\Datenbank();
		$db = new Datenbank();
		$rezept = new Rezept();
	}
	protected function actionSmoothie_suchen()
	{
		$this->content = "<h1>Smoothie suchen</h1>";
	}
	protected function actionSmoothie_schreiben()
	{
		$this->content = "<h1>Smoothie schreiben</h1>";
		$this->formData = $_POST;
		// Speichern der Daten in einer TXT-Datei
		// Wenn das Formular verschickt wurde
		if(isset($this->formData["smoothie_schreiben"]))
		{
			// Post Array umwandeln in eine serialisierte Version einer Zeichenkette
			$speicherbare_zeichenkette = serialize($this->formData);
			// Dateiname generieren
			$dateiname = uniqid("smoothierezepte_"); // paketsendung_5b28d75206bec
			// Die Zeichenkette in die Datei schreiben
			file_put_contents("smoothierezepten/$dateiname.txt", $speicherbare_zeichenkette);
			$this->content .= "Daten wurden gespeichert";

			$db = new Datenbank(); 				#  BEI use Klassen\PDO\Datenbank;
			# $db = new \Klassen\PDO\Datenbank(); #	ohne use
			
			$dominierte_zutat_typ = $db->sql_select("select * from zutat where zutat_id =".$this->formData["zutat_typ"]);		
			
			$datei = new Datei($_FILES["uploaddatei"]);
			$dateimanager = new Dateimanager();
			
			$db->sql_insert
				("insert into rezepte 
					(rezension, rezept_name, zutaten_list, preisstufe, rezeptbild)
				values
					(
					:platzhalter_rezension, 
					:platzhalter_rezept_name, 
					:platzhalter_zutaten_list, 
					:platzhalter_zutat_typ,
					:platzhalter_rezeptbild
					)",
					array
					(
						"platzhalter_rezension" => 1,						// DEFAULT
						"platzhalter_rezept_name" => $this->formData["rezept_name"],
						"platzhalter_zutaten_list" => $this->formData["zutaten_list"],
						"platzhalter_zutat_typ" => $this->formData["zutat_typ"],
						"platzhalter_rezeptbild" => $dateimanager->datei_hochladen($datei->getDateiinfo())
					)
				);			
		}
		else
		{
			// Teiltemplate
			$this->content .= file_get_contents("templates/smoothie_schreiben_formular.html");
		}
	}
	protected function actionSmoothie_bearbeiten()
	{
		if(isset($_SESSION["user_id"]))
		{
			
			$this->content = "<h1>Bearbeitung</h1>";







			
			# Datenverarbeitung
			#echo "<pre>";
			#print_r($_POST);
			#echo "</pre>";			
			
			if(isset($_POST["rezension_id"]))
			{
				$teile = explode(";", $_POST["rezension_id"]);
				$rezension_id = $teile[0];
				$beschreibung = $teile[1];
				$db = new Datenbank();
				$db->sql_update("update rezepte set rezension = '".$rezension_id."' 
								where rezept_id='".$_POST["rezept_id"]."'");
				$db->sql_insert("insert into bearbeitung (auftragnr, user_id, art_der_taetigkeit)
												 values (:auftragnr, :mitarbeiternr, :art_der_taetigkeit)",
								
								array("auftragnr" => $_POST["auftragnr"],
									  "mitarbeiternr" => $_SESSION["mitarbeiternr"],
									  "art_der_taetigkeit" => $beschreibung));	
				$this->content .= "<div style='color:red;'>Der Status wurde geändert!</div>";									  
			}
			
			if(isset($_POST["absender"]) && isset($_POST["empfaenger"]))
			{
				$db = new Datenbank();
				$db->sql_update("update auftraege set 
								absender = :absender, 
								empfaenger = :empfaenger 
								where auftragnr=:auftragnr",
								array(
								 "absender" => $_POST["absender"],
								 "empfaenger" => $_POST["empfaenger"],
								 "auftragnr" => $_POST["auftragnr"]
								)
								);	
				$this->content .= "<div style='color:red;'>Die Daten wurden geändert!</div>";		
			}
			
			if(isset($_POST["loeschen"]))
			{
				$db = new Datenbank();
				$this->content .= $db->sql_delete("delete from bearbeitung where auftragnr = ".$_POST["auftragnr"]);
				$this->content .= $db->sql_delete("delete from auftraege where auftragnr = ".$_POST["auftragnr"]);
				$this->content .= "<div style='color:red;'>Die Daten wurden gelöscht!</div>";	
			}	
			
			# Darstellung
			switch(@$_GET["modus"])
			{
				case "details":		include("smoothie_details.php");				break;
				case "loeschen":	include("smoothie_loeschbestaetigung.php");	break;
				default:			include("smoothie_bearbeiten.php");
			}

			










		}		
		else
		{
			$this->actionLogin(); // Weiterleitung zum Login
		}	
	}
	
	
	protected function actionLogin()
	{
		$this->content = "<h1>Login</h1>";
		// Teiltemplate
		$this->content .= file_get_contents("templates/login_formular.html");		
	}	
	
	protected function actionLogout()
	{
		$this->content = "<h1>Logout</h1>";
		$this->content .= "Sie sind nun abgemeldet";
		unset($_SESSION["user_id"]);
	}		
	protected function actionKontakt()
	{
		$this->content = "<h1>Kontakt</h1>";
	}

	protected function actionImpressum()
	{
		$this->content = "<h1>Impressum</h1>";
	}

	protected function actionAGB()
	{
		$this->content = "<h1>AGB</h1>";
	}	

	protected function actionDownload()
	{
		$this->content = "<h1>Download</h1>";
		header("Location: downloads/download.php"); // Weiterleitung
	}	

	protected function actionVeraltet()
	{
		$this->content = "<h1>Veraltet</h1>";
		header("Expires: Tue, 24 Apr 2018 11:06:00 GMT");
	}	

	protected function actionSeiteNichtGefunden()
	{
		$this->content = "<h1>Seite nicht gefunden</h1>";
		header("HTTP/1.1 404 Not Found"); // Fehlerseite
	}		
}
?>