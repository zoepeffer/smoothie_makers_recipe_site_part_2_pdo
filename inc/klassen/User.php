<?php
namespace Klassen;
class User
{
	// Attribute
	protected $UserID;
	protected $Email;
	protected $User_Name;
	protected $Passwort;
	protected $Login;
	// GET- und SET-Methoden
	protected function getUserID()
	{
		return $this->UserID;
	}
	protected function setUserID($UserID)
	{
		$this->UserID = $UserID;
	}
	protected function getEmail()
	{
		return $this->Email;
	}
	protected function setEmail($Email)
	{
		$this->Email = $Email;
	}
	protected function getUser_Name()
	{
		return $this->User_Name;
	}
	protected function setUser_Name($User_Name)
	{
		$this->User_Name = $User_Name;
	}
	protected function getPasswort()
	{
		return $this->Passwort;
	}
	protected function setPasswort($Passwort)
	{
		$this->Passwort = $Passwort;
	}
	protected function getLogin()
	{
		return $this->Login;
	}
	protected function setLogin($Login)
	{
		$this->Login = $Login;
	}
}
?>
