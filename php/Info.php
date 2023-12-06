<?php
include_once 'Connection.php';
class Info
{
	public $con = "";
	public function __construct()
	{
		//Call the Connection class
		$conObj = new Connection();
		$this->con = $conObj->connect();
	}
	// destructor  
	function __destruct()
	{
	}

	public function updateInfo($about, $mission, $vision)
	{

		$sql = "UPDATE info SET `about` = ?,`mission` = ?,`vision` = ? WHERE `ID` =?";
		$result = $this->con->prepare($sql)->execute([trim($about), trim($mission), trim($vision), 1]);
		if ($result) {
			echo "<script>alert('Updated Successfully!');
				document.location = '/admin/about.php' </script>";
		} else {
			echo "<script>alert('Update Failed! Please check your connection.');
				document.location = '/admin/about.php' </script>";
		}
	}

	//View all the recurring and previous tips
	public function viewInfo()
	{
		$accept = array();
		$infoID = [];
		$about = [];
		$mission = [];
		$vision = [];
		$stmt = $this->con->query("SELECT `id`, `about` , `mission`, `vision` FROM `info`");
		while ($row = $stmt->fetch()) {
			array_push($infoID, $row[0]);
			array_push($about, $row[1]);
			array_push($mission, $row[2]);
			array_push($vision, $row[3]);
		}
		array_push($accept, $infoID, $about, $mission, $vision);
		return $accept;
	}
}
