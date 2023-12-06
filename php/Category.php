<?php
include_once 'Connection.php';
class Category
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
	public function addCategory($name)
	{
		$sql = "INSERT INTO `category`(`name`) VALUES(?)";
		$result = $this->con->prepare($sql)->execute([$name]);
		if ($result) {
			echo "<script>alert('Added Successfully!');
				document.location = '/admin/categorys.php' </script>";
				
		} else {
			echo "<script>alert('Adding Failed! Please check your connection');
				document.location = '/admin/category.php' </script>";
		}
	}
	public function updateCategory($ID, $name)
	{
	
		$sql = "UPDATE `category` SET `name` =? WHERE `ID` =?";
		$result = $this->con->prepare($sql)->execute([$name, $ID]);
		if ($result) {
				echo "<script>alert('Updated Successfully!');
				document.location = '/admin/categorys.php' </script>";
			} else {
				echo "<script>alert('Update Failed! Please check your coonection.');
				document.location = '/admin/category.php' </script>";
			}
	}
	public function removeCategory($ID)
	{
	
		$sql = "DELETE from `category` WHERE `ID` =?";
		$result = $this->con->prepare($sql)->execute([$ID]);
		if($result){
			echo "<script>alert('Removed Successfully!');
			document.location = '/admin/categorys.php'</script>";
		}
		else{
			echo "<script> alert('Removing Failed! Please check your connection.');
			document.location = '/admin/categorys.php'</script>";
		}
	}
	//View all the recurring and previous tips
	public function viewCategory()
	{
		try {
			$stmt = $this->con->query("SELECT * FROM category");
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
}