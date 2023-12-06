<?php
include_once 'Connection.php';
class Contact
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
	
	//Send tip about a potential member
	public function addContact($address, $email, $phone, $wT)
	{
		$sql = "INSERT INTO `contact`(`Address` , `Email`, `PhoneNo`, `WorkingTime`) VALUES(?,?,?,?)";
		$result = $this->con->prepare($sql)->execute([$address, $email, $phone, $wT]);
		if ($result) {
			echo "<script>alert('Added Successfully! We will contact you for farther information');
				document.location = '/contact.php' </script>";
		} else {
			echo "<script>alert('Adding Failed! Please check your connection');
				document.location = '/contact.php' </script>";
		}
	}
	//View all the recurring and previous tips
	public function viewContact()
	{
        $accept = array(); $contactID = []; $address = []; $email = []; $phone = []; $wT = [];
		$stmt = $this->con->query("SELECT `ID`, `Address` , `Email`, `PhoneNo`, `WorkingTime` FROM `contact`");
		while ($row = $stmt->fetch()) {
			array_push($contactID, $row[0]);
			array_push($address, $row[1]);
			array_push($email, $row[2]);
			array_push($phone, $row[3]);
            array_push($wT, $row[4]);
		}
		array_push($accept, $contactID, $address, $email, $phone, $wT);
		return $accept;
	}
	
}
