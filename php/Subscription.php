<?php
include_once 'Connection.php';
class Subscription
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
	public function addSubscription($email)
	{
		$query =  "SELECT ID from Subscription where Email = ?";
		$stmt = $this->con->prepare($query);
		$stmt->execute([$email]);
		$row = $stmt->fetch();
		if (!empty($row['ID'])) {
				return $row['ID'];
		}
		
		else {
			// Build the SQL query
			$sql = "INSERT INTO Subscription (Email) VALUES (?)";
			$result = $this->con->prepare($sql)->execute([$email]);
			if ($result) {
				$subscription_id = $this->con->lastInsertId();
				return $subscription_id;
				// document.location = '../index.php' </script>";
			} else {
				echo "<script>alert('Adding Failed! Please check your connection');
			document.location = '../index.php' </script>";
			}
		}
	}
	//View all the recurring and previous tips
	public function viewSubscription()
	{
		try {
			$stmt = $this->con->query("SELECT * FROM Subscription");
			if (!$stmt) {
				echo $this->con->errorInfo();
				throw new Exception("Error executing the query: " . $this->con->errorInfo());
			}
			return $stmt->fetchAll(); // Note: This line is not necessary since you already fetched all the data in the while loop.
		} catch (Exception $e) {
			echo "Error: " . $e->getMessage();
			return []; // Return an empty array to handle errors gracefully.
		}
	}
	//Remove project
	public function removeSubscription($ID, $paths)
	{
		$sql = "DELETE FROM `Subscription` WHERE `ID` = ?";
		$stmt = $this->con->prepare($sql);
		$result = $stmt->execute([$ID]);
		if ($result) {
			foreach ($paths as $path) {
				if (file_exists($path)) {
					unlink($path);
				}
			}
			echo "<script>alert('Removed Successfully!');
				  document.location = '../index.php' </script>";
		} else {
			echo "<script>alert('Remove Failed! Please check your connection.');
				  document.location = '../index.php' </script>";
		}
	}
}
