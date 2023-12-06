<?php 
include_once('email/PHPMailerAutoload.php');
//Configration of Database : These information w//ill be changed when it is deployed
class Config{
    private $serverName="localhost";
    private $userName="root";
    private $password="password";
    private $database="mhbet_design";

    public function getServerName(){
        return $this->serverName;
    }
    public function getUserName(){
        return $this->userName;
    }
    public function getPassword(){
        return $this->password;
    }
    public function getDatabase(){
        return $this->database;
    }
}
class EmailConfig {
    // public function getEmailConfig() {
    //     $mail = new PHPMailer;
    //     $mail->isSMTP();
    //     $mail->Host = 'mail.sammkin.com';
    //     $mail->SMTPAuth = true;
    //     $mail->Username = 'info@sammkin.com';
    //     $mail->Password = 'samkin@info';
    //     $mail->SMTPSecure = 'ssl';
    //     $mail->Port = 465;
    //     $mail->setFrom("info@sammkin.com");
    //     $mail->addReplyTo("info@sammkin.com");
    //     return $mail;
    // }
}
// <?php  
// class config{
// private $servername="sql310.epizy.com";
// private $username="epiz_28691464";
// private $password="sqN5d47HVXDA9M";
// private $database="epiz_28691464_samkin";
//     public function getservername(){
//     return $this->servername;
//     }
//     public function getusername(){
//     return $this->username;
//     }
//     public function getpassword(){
//     return $this->password;
//     }
//     public function getdatabase(){
//     return $this->database;
//     }
// }
// ?><?php  
