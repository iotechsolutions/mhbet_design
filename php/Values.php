<?php
include_once 'Connection.php';
class Values
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
	public function addValues($name, $description)
	{
		// Build the SQL query
		$sql = "INSERT INTO `values` (`name`, `description`) VALUES (?, ?)";
		$result = $this->con->prepare($sql)->execute([$name, $description]);
		// Handle image uploads
		if ($result) {
			echo "<script>alert('Added Successfully!');</script>";
		} else {
			echo "<script>alert('Adding Failed! Please check your connection');
			document.location = '../admin/properties.php' </script>";
		}
	}

	public function updateValues($id, $name, $description)
	{

		$sql = "UPDATE `values` SET `name` = ?,`description` = ? WHERE `id` =?";
		$result = $this->con->prepare($sql)->execute([trim($name), trim($description), $id]);
		if ($result) {
			echo "<script>alert('Updated Successfully!');
				document.location = '/admin/values.php' </script>";
		} else {
			echo "<script>alert('Update Failed! Please check your connection.');
				document.location = '/admin/values.php' </script>";
		}
	}


	//View all the recurring and previous tips
	public function viewValues()
	{
		try {
			$stmt = $this->con->query("SELECT * FROM `values` order by ID desc");
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
	public function removeValues($ID, $paths)
	{
		$sql = "DELETE FROM `values` WHERE `ID` = ?";
		$stmt = $this->con->prepare($sql);
		$result = $stmt->execute([$ID]);
		if ($result) {
			foreach ($paths as $path) {
				if (file_exists($path)) {
					unlink($path);
				}
			}
			echo "<script>alert('Removed Successfully!');
				  document.location = '../admin/properties.php' </script>";
		} else {
			echo "<script>alert('Remove Failed! Please check your connection.');
				  document.location = '../admin/properties.php' </script>";
		}
	}
}
