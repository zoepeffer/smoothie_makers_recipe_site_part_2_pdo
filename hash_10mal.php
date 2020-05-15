<?php
$passwort = "p";
$optionen = array("cost" => 4); // 4 - 31

$hashes = array();

for($i = 1; $i <= 1000; $i++)
{
	$hash = password_hash($passwort, PASSWORD_DEFAULT, $optionen);
	$hashes[$hash] = $i;
}

echo "<pre>";
print_r($hashes);
echo "</pre>";
?>