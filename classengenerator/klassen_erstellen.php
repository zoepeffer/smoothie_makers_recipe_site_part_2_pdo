<?php
require("klassengenerator.php");
echo Klassengenerator::erzeuge_PHP_Quellcode("Bearbeitung", array("BearbeitungID","UserID","Datum","Art_der_Bearbeitung"));
echo Klassengenerator::erzeuge_PHP_Quellcode("Farbe", array("FarbeID","FarbeName"));
echo Klassengenerator::erzeuge_PHP_Quellcode("Geschmack", array("GeschmackID","GeschmackName"));
echo Klassengenerator::erzeuge_PHP_Quellcode("Rezension", array("RezensionID","Rezension_Beschreiben","Front_Seite"));
echo Klassengenerator::erzeuge_PHP_Quellcode("Rezepte", array("RezepteID","RezensionID","UserID","FarbeID","ZutatTyp","GeschmackID","SelectionID","BearbeitungID","RezepteName","Datum","Rezept_Beschreiben","Rezeptbild"));
echo Klassengenerator::erzeuge_PHP_Quellcode("Selection", array("SelectionID","SelectionName"));
echo Klassengenerator::erzeuge_PHP_Quellcode("User", array("UserID","Email","User_Name","Passwort","Login"));
echo Klassengenerator::erzeuge_PHP_Quellcode("Zutat", array("ZutatID","FarbeID","ZutatName"));														
?>