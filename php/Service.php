<?php
include_once 'Connection.php';
class Service
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
	public function addService($name, $description, $paths, $images)
	{
		$uploadDir = "../photo/service/";
		// Handle path parameters
		$fileNames = [];
		foreach ($paths as $index => $path) {
			$fileName = $uploadDir . $path;
			$fileNames[$index] = $fileName;
		}

		$sql = "INSERT INTO `services`(`name`, `description`, Path1) VALUES(?,?,?)";
		$params = array_merge([$name, $description], $fileNames);
		// Execute the SQL query
		$stmt = $this->con->prepare($sql);
		$result = $stmt->execute($params);
		// Handle image uploads
		if ($result) {
			foreach ($images as $index => $image) {
				if ($image != null && $image != "") {
					move_uploaded_file($image, $fileNames[$index]) or die("Cannot copy uploaded file");
				}
			}
			echo "<script>alert('Added Successfully!');</script>";
			// document.location = '../admin/projects.php' </script>";
		} else {
			echo "<script>alert('Adding Failed! Please check your connection');
			document.location = '../admin/projects.php' </script>";
		}
	}
	public function updateService($ID, $name, $description, $paths, $images, $pathOlds)
	{
		$uploadDir = "../photo/service/";
		// Handle path parameters
		$fileNames = [];
		foreach ($paths as $index => $path) {
			if ($path != "" && !strpos($path, $uploadDir)) {
				$fileName = $uploadDir . $path;
				$fileNames[$index] = $fileName;
			} else {
				$fileNames[$index] = $pathOlds[$index];
			}
		}
		$sql = "UPDATE `services` SET `name` =?, `description`=?";
		for ($i = 1; $i <= count($fileNames); $i++) {
			$sql .= ", `Path{$i}` = ?";
			
		}
		$sql .= " WHERE `id` = ?";
		echo $sql;
		// Combine all parameters, including $fileNames and $ID
		$params = array_merge([$name, $description], $fileNames, [$ID]);
		$stmt = $this->con->prepare($sql);
		$result = $stmt->execute($params);
		// Handle image uploads and deletions
		if ($result) {
			foreach ($images as $index => $image) {
				if ($image != null && $image != "") {
					echo $index;
					move_uploaded_file($image, $fileNames[$index]) or die("Cannot copy uploaded file");
				}
			}
			// Unlink old files that are no longer needed
			foreach ($pathOlds as $oldPath) {
				if (!in_array($oldPath, $fileNames) && file_exists($oldPath)) {
					unlink($oldPath);
				}
			}
			echo "<script>alert('Updated Successfully!');</script>";
			// document.location = '../admin/projects.php' </script>";
		} else {
			echo "<script>alert('Update Failed! Please check your connection.');
			document.location = '../admin/projects.php' </script>";
		}
	}
	public function removeService($ID)
	{
	
		$sql = "DELETE from `services` WHERE `ID` =?";
		$result = $this->con->prepare($sql)->execute([$ID]);
		if($result){
			echo "<script>alert('Removed Successfully!');
			document.location = '/admin/services.php'</script>";
		}
		else{
			echo "<script> alert('Removing Failed! Please check your connection.');
			document.location = '/admin/services.php'</script>";
		}
	}
	//View all the recurring and previous tips
	public function viewService()
	{
		try {
			$stmt = $this->con->query("SELECT * FROM services");
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

	public function addSubService($name, $description, $service)
	{
		$sql = "INSERT INTO `subservices`(`name`, `description`, `service_id`) VALUES(?,?,?)";
		$result = $this->con->prepare($sql)->execute([$name, $description, $service]);
		if ($result) {
			echo "<script>alert('Added Successfully!');
				document.location = '/admin/subservices.php' </script>";
				
		} else {
			echo "<script>alert('Adding Failed! Please check your connection');
				document.location = '/admin/subservices.php' </script>";
		}
	}
	public function updateSubService($ID, $name, $description, $serviceUpdate)
	{
	
		$sql = "UPDATE `subservices` SET `name` =?, `description`=?, `service_id`=? WHERE `ID` =?";
		$result = $this->con->prepare($sql)->execute([$name, $description, $serviceUpdate, $ID]);
		if ($result) {
				echo "<script>alert('Updated Successfully!');
				document.location = '/admin/subservices.php' </script>";
			} else {
				echo "<script>alert('Update Failed! Please check your coonection.');
				document.location = '/admin/subservices.php' </script>";
			}
	}

	public function viewSubService()
	{
		try {
			$stmt = $this->con->query("SELECT ss.id as 'id', ss.name as `name`, ss.description as 'description', s.id as 'sid', s.name as 'sname' FROM subservices ss join services s on s.id = ss.service_id");
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
