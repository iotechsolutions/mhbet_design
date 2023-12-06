<?php
include_once 'Connection.php';
//Accepts username to check if it exists or not
class Account
{
    protected $userName, $password;
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
    //Login with valid credentials to different part of the system
    public function login($username,$password)
    {
        $stmt = $this->con->prepare("SELECT `username`, `password` FROM `account` WHERE username=?");
        $stmt->execute([$username]);
        $row = $stmt->fetch();
        if (is_array($row)) {
            $pass = $row[1];
            //Since we cant decrypt a PASSWORD_BCRYPT, we fetch the password with a specfic username and compare the newly entered password with the retrieved
            // if (password_verify($passwords, $pass)) {
                if ($password== $pass) {
                session_start();
                $_SESSION["UserName"] = $row[0];
                $UserName = $row[0];
                echo '<script language="javascript">';
                echo 'alert("Welcom! ' . $_SESSION["UserName"] . '"); document.location = "../about.php"';
                echo '</script>';
            } else {
                echo "<script>alert('Invaild UserName or Password');
                document.location = '/admin/Login/login.php' </script>";
            }
        }
      
    }
    //Logout of the system
    public function logout()
    {
        session_start();
        unset($_SESSION["UserName"]);
        echo "<script>alert('GoodBye!');
        document.location = '../Login/login.php' </script>";
    }
    public function resetPassword($password)
	{
		$sql = "UPDATE account SET `password` =? WHERE `ID` =?";
		$result = $this->con->prepare($sql)->execute([$password, 1]);
		if ($result) {
				echo "<script>alert('Reset Successfully!');
				document.location = '/admin/about.php' </script>";
			} else {
				echo "<script>alert('Reset Failed! Please check your coonection.');
				document.location = '/admin/about.php' </script>";
			}
		}
}
    