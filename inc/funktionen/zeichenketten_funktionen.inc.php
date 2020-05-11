<?php
// Leerzeichen entfernen
function leerzeichen_entfernen($zeichenkette, $sonderzeichen = null)
{
	/*
	Die Zeichenliste könnte folgendes enthalten, ist aber optional:
	-" " (ASCII 32 (0x20)), ein normales Leerzeichen.
	-"\t" (ASCII 9 (0x09)), ein Tabulatorzeichen.
	-"\n" (ASCII 10 (0x0A)), einen Zeilenvorschub (Line Feed).
	-"\r" (ASCII 13 (0x0D)), ein Wagenrücklaufzeichen (Carriage Return)
	-"\0" (ASCII 0 (0x00)), das NULL-Byte.
	-"\x0B" (ASCII 11 (0x0B)), ein vertikaler Tabulator.
	*/	
	if($sonderzeichen != null)
	{
		return trim($zeichenkette, $sonderzeichen); // nur spezielle Zeichen werden entfernt
	}
	else
	{
		return trim($zeichenkette);	// alles wird entfernt
	}		
}
#$zeichenkette = "      Text     ";
#echo trim($zeichenkette, " "); // "Text";
#echo leerzeichen_entfernen($zeichenkette, " "); // "Text";

// Umwandeln von Zeichen in Kleinbuchstaben
function klein_schreiben($zeichenkette)
{
	return mb_strtolower($zeichenkette);
}
// Umwandeln von Zeichen in Großbuchstaben
function gross_schreiben($zeichenkette)
{
	return mb_strtoupper($zeichenkette);
}

// Den ersten Buchstaben groß schreiben
function anfang_gross_schreiben($zeichenkette)
{
	return ucfirst($zeichenkette);
}


/*
Umwandelt von < > & " '
in &lt; &gt; &amp; &quot; &apos; - Wichtig wegen der Sicherheit
*/
function html_konvertieren($zeichenkette)
{
	return htmlspecialchars($zeichenkette, ENT_HTML5 | ENT_QUOTES , "UTF-8");
}


# echo html_konvertieren("<h1><b>Fett</b></h1>");

function html_tags_entfernen($zeichenkette, $ausnahme="")
{
	return strip_tags($zeichenkette, $ausnahme);
	/*							
	DIV-Tags und SPAN-Tags werden nicht entfernt
	NUR geöffnete Tags hinschreiben!!!
	
	return strip_tags($zeichenkette, '<div><span>');
	*/	
}

#echo html_tags_entfernen("Hier kommt mein Text mit <b>Fettdruck</b>");

#echo html_tags_entfernen("Hier <b>kommt</b> mein <div>Text</div> mit 
#<a href='http://www.google.de'>Fettdruck</a>", "<b><div>");

#echo html_tags_entfernen("Hier <b>kommt</b> mein <div>Text</div> mit 
#<a href='http://www.google.de'>Fettdruck</a>");

// Zur Sicherheit alles bereinigen, was Probleme machen könnte
function eingabe_saeubern($zeichenkette, $ausnahme = "")
{
	return html_konvertieren(html_tags_entfernen($zeichenkette, $ausnahme));
}

# echo eingabe_saeubern("<b>Text</b><a href='http://www.google.de'>link</a>");

# echo eingabe_saeubern("<b>Text</b><a href='http://www.google.de'>link</a>", "<a>");

function ausgabeformat_ohne_rueckgabewert($format, $array)
{
	/*
	%s = Zeichenkette
	%.30s = Zeichenkette mit max. 30 Zeichen
	%d = ganze Zahl
	%f = Fließkommazahl
	%.2f = Fließkommazahl mit 2 Nachkommastellen
	*/	
	vprintf($format, $array); // ohne return aber mit einem echo
}

/*
ausgabeformat_ohne_rueckgabewert(
			"Diese Ausgabe enthält eine %.30s, eine %.2f und noch eine %.1f"
			,
			array("Zeichenkette", 72, 4.99) // Reihenfolge wichtig!!!
			);
*/
function ausgabeformat_mit_rueckgabewert($format, $array)
{
	return vsprintf($format, $array); // identisch wie vprintf aber mit return (ohne echo)
}	
/*			
echo ausgabeformat_mit_rueckgabewert(
			"Diese Ausgabe enthält eine %.10s, eine %d und noch eine %.2f"
			,
			array("Zeichenkette mit mehr Text", 36, 8.749)
			);			
*/			
			
function laenge_der_zeichenkette($zeichenkette)
{
	return mb_strlen($zeichenkette); // UTF-8
	#return strlen($zeichenkette); // ANSI
}				
			
// Suche nach der Nadel im Heuhaufen
function suche_in_der_zeichenkette($heuhaufen, $nadel)
{
	return mb_strpos($heuhaufen, $nadel); // UTF-8
	//return strpos($heuhaufen, $nadel);  // Normal ANSI
}			
			
// Ausschneiden
function ausschneiden($zeichenkette, $start, $laenge = null)
{
	if($laenge == null)
	{
		return mb_substr($zeichenkette, $start); // bis zum Ende
	}
	else
	{
		return mb_substr($zeichenkette, $start, $laenge); // Länge= Anzahl der Zeichen, die man haben möchte
	}
}

function suchen_und_ersetzen($suche, $ersatz, $vorlage)
{
	$ersetzte_zeichenkette = str_replace($suche, $ersatz, $vorlage); 
	return $ersetzte_zeichenkette;				   
}	
/*
$neu = suchen_und_ersetzen("A","a","Ampel");
print_r($neu);		

echo "<hr />";
$neu = suchen_und_ersetzen("Hindernis","Hürden","Hindernislauf");
print_r($neu);

echo "<hr />";
// i gegen | und n gegen _ tauschen
$neu = suchen_und_ersetzen(array("i","n"),array("|","_"),array("Hindernislauf","Hürdenlauf"));
print_r($neu);
*/
?>