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
		$this->content = "<h1></h1>";
		include("von_uns.php");

	}
	protected function actionSmoothie_suchen()
	{
		$this->content = "<h1>Smoothie  Makers suchen</h1>";
	}





	protected function actionSmoothie_schreiben()
	{
		$this->content = "";
		$this->formData = $_POST;
		// Speichern der Daten in einer TXT-Datei
		// Wenn das Formular verschickt wurde
		if(isset($this->formData["smoothie_schreiben"]))
		{
			// Post Array umwandeln in eine serialisierte Version einer Zeichenkette
			$speicherbare_zeichenkette = serialize($this->formData);
			// Dateiname generieren
			$dateiname = uniqid("smoothierezepte_"); // smoothierezepte_5b28d75206bec
			// Die Zeichenkette in die Datei schreiben
			file_put_contents("smoothierezepten/$dateiname.txt", $speicherbare_zeichenkette);
			$this->content .= "Daten wurden gespeichert";

			$db = new Datenbank(); 				# BEI use Klassen\PDO\Datenbank;
			# $db = new \Klassen\PDO\Datenbank(); #	ohne use
			
/*			$dominierte_zutat_typ = $db->sql_select("select * from zutat where zutat_id =".$this->formData["option_zutat_typ"]);		
			print_r($dominierte_zutat_typ);
			
			$smoothie_farbe = $db->sql_select("select * from farbe where farbe_id =".$this->formData["option_farbe"]);		
			print_r($smoothie_farbe);
			
			$smoothie_selektion = $db->sql_select("select * from selektion where selektion_id =".$this->formData["option_selektion"]);		
			print_r($smoothie_selektion);

			$smoothie_geschmack = $db->sql_select("select * from geschmack where geschmack_id =".$this->formData["option_geschmack"]);		
			print_r($smoothie_geschmack);
*/
			$datei = new Datei($_FILES["uploaddatei"]);
			$dateimanager = new Dateimanager();
			
			$db->sql_insert
				("insert into rezepte 
					(rezension, user_id, farbe_id, zutat_typ, geschmack_id, selektion_id, bearbeitung_id, rezept_name, zutaten_list, rezept_beschreibung, rezeptbild)
				values
					(
					:platzhalter_rezension,
					:platzhalter_user_id,	
					:platzhalter_farbe_id,
					:platzhalter_zutat_typ,
					:platzhalter_geschmack_id,
					:platzhalter_selektion_id,
					:platzhalter_bearbeitung_id,
					:platzhalter_rezept_name, 
					:platzhalter_zutaten_list, 
					:platzhalter_rezept_beschreibung,
					:platzhalter_rezeptbild
					)",
					array
					(
						"platzhalter_rezension" => 1,						// DEFAULT
						"platzhalter_user_id" => 1,						// DEFAULT bitte dinamisch SESSION
						"platzhalter_farbe_id" => $this->formData["option_farbe"],
						"platzhalter_zutat_typ" => $this->formData["option_zutat_typ"],
						"platzhalter_geschmack_id" => $this->formData["option_geschmack"],
						"platzhalter_selektion_id" => $this->formData["option_selektion"],
						"platzhalter_bearbeitung_id" => 2,						// DEFAULT
						"platzhalter_rezept_name" => $this->formData["neu_rezept_name"],
						"platzhalter_zutaten_list" => $this->formData["neu_zutaten_list"],
						"platzhalter_rezept_beschreibung" => $this->formData["neu_rezept_beschreibung"],
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
			
			$this->content = "<h1></h1>";

			# Datenverarbeitung
			#echo "<pre>";
			#print_r($_POST);
			#echo "</pre>";			
			
			if(isset($_POST["rezension_id"]))
			{
				$teile = explode(";", $_POST["rezension_id"]);
				$rezension_id = $teile[0];
				$db = new Datenbank();
				$db->sql_update("update rezepte set rezension = '".$rezension_id."' 
								where rezept_id='".$_POST["rezept_id"]."'");
				$this->content .= "<div style='color:red;'>Der Rezension wurde geändert!</div>";									  
			}
			
			if(isset($_POST["rezept_name"]) && isset($_POST["zutaten_list"]))
			{
				$db = new Datenbank();
				$db->sql_update("update rezepte set 
								rezept_name = :rezept_name, 
								zutaten_list = :zutaten_list 
								where rezept_id=:rezept_id",
								array(
								 "rezept_name" => $_POST["rezept_name"],
								 "zutaten_list" => $_POST["zutaten_list"],
								 "rezept_id" => $_POST["rezept_id"]
								)
								);	
				$this->content .= "<div style='color:red;'>Die Daten wurden geändert!</div>";		
			}
			
			if(isset($_POST["loeschen"]))
			{
				$db = new Datenbank();
				$this->content .= $db->sql_delete("delete from rezepte where rezept_id = ".$_POST["rezept_id"]);
				$this->content .= "<div style='color:red;'>Die Daten wurden gelöscht!</div>";	
			}	
			
			# Darstellung
			switch(@$_GET["modus"])
			{
				case "details":		include("smoothie_details.php");				break;
				case "loeschen":	include("smoothie_loeschbestaetigung.php");  	break;
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
		$this->content = "<h1></h1>";
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