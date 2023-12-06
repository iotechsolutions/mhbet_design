<?php
include_once 'Connection.php';
class Gallery
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
	public function addGallery($name, $description, $category, $paths, $images)
	{
		$uploadDir = "../photo/gallery/";
		// Handle path parameters
		$fileNames = [];
		foreach ($paths as $index => $path) {
			$fileName = $uploadDir . $path;
			$fileNames[$index] = $fileName;
		}
		// Build the SQL query
		$sql = "INSERT INTO gallery (`name`, `description`, `category_id`, Path1) VALUES (?, ?, ?, ?)";
		$params = array_merge([$name, $description, $category], $fileNames);
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
		} else {
			echo "<script>alert('Adding Failed! Please check your connection');
			document.location = '../admin/gallery.php' </script>";
		}
	}
	public function updateGallery($ID, $name, $description, $category, $paths, $images, $pathOlds)
	{
		$uploadDir = "../photo/gallery/";
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
		$sql = "UPDATE `gallery` SET `name` = ?, `description` = ?, `category_id` = ?";
		// Add placeholders for the Path columns based on the number of elements in $fileNames
		for ($i = 1; $i <= count($fileNames); $i++) {
			$sql .= ", `Path{$i}` = ?";
			
		}
		$sql .= " WHERE `id` = ?";
		echo $sql;
		// Combine all parameters, including $fileNames and $ID
		$params = array_merge([$name, $description, $category], $fileNames, [$ID]);
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
			// document.location = '../admin/gallerys.php' </script>";
		} else {
			echo "<script>alert('Update Failed! Please check your connection.');
			document.location = '../admin/gallerys.php' </script>";
		}
	}
	//View all the recurring and previous tips
	public function viewGallery()
	{
		try {
			$stmt = $this->con->query("SELECT g.*, c.id AS cid, c.name AS cname FROM gallery g JOIN category c ON g.category_id = c.id");
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
	public function viewGalleryById($gallery_id)
	{
		try {
			$sql = "SELECT * FROM gallery WHERE ID = ?";
			$stmt = $this->con->prepare($sql);
			$stmt->execute([$gallery_id]);
			if (!$stmt) {
				echo $this->con->errorInfo();
				throw new Exception("Error executing the query: " . $this->con->errorInfo());
			}
			
			return $stmt->fetch(); // Note: This line is not necessary since you already fetched all the data in the while loop.
		} catch (Exception $e) {
			echo "Error: " . $e->getMessage();
			return []; // Return an empty array to handle errors gracefully.
		}
	}
	//Remove project
	public function removegallery($ID, $paths)
	{
		$sql = "DELETE FROM `gallery` WHERE `ID` = ?";
		$stmt = $this->con->prepare($sql);
		$result = $stmt->execute([$ID]);
		if ($result) {
			foreach ($paths as $path) {
				if (file_exists($path)) {
					unlink($path);
				}
			}
			echo "<script>alert('Removed Successfully!');
				  document.location = '../admin/gallerys.php' </script>";
		} else {
			echo "<script>alert('Remove Failed! Please check your connection.');
				  document.location = '../admin/gallerys.php' </script>";
		}
	}
}
