<?php
class User
{
	public $name;
	public $followers;

	public function setUsername($name)
	{
		$this->name = $name;
	}

	public function setFollowersCount($followers)
	{
		$this->followers = $followers;
	}

	public function getUsername()
	{
		return $this->name;
	}

	public function getFollowersCount()
	{
		return $this->followers;
	}
}
?>