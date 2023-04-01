<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE');
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Access-Control-Allow-Credentials: true');
ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

$mail = new PHPMailer(true);
// $postdata = file_get_contents("php://input");
// $request = json_decode($postdata);
// $emailToInform = $request->email;
$random_number = rand(11111111,99999999);
//store this random number in session or database
$priority = isset($_GET['priority']) ? $_GET['priority'] : "";
$category = isset($_GET['category']) ? $_GET['category'] : "";
$sub = isset($_GET['sub']) ? $_GET['sub'] : "";
$issue = isset($_GET['issue']) ? $_GET['issue'] : "";
$name = isset($_GET['name']) ? $_GET['name'] : "";
$email = isset($_GET['email']) ? $_GET['email'] : "";
// reservation
$time = isset($_GET['date']) ? $_GET['date'] : "";
$duration = isset($_GET['duration']) ? $_GET['duration'] : "";
$building = isset($_GET['building']) ? $_GET['building'] : "";

// if($request->pass == "requestVerification"){
//   $obj = new method();
//   $obj->getFollowingShow($postdata);
// }
try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'mohamad.rm93q@gmail.com';                     //SMTP username
    $mail->Password   = 'zokczsdqoceuvxzz';                               //SMTP password
    $mail->SMTPSecure =  PHPMailer::ENCRYPTION_STARTTLS; 
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('mohamad.rm93q@gmail.com', 'IT Support');
    // $mail->addAddress('alkhalil93q@yahoo.com', 'Joe User');     //Add a recipient
    $mail->addAddress("$email");               //Name is optional
    $mail->addReplyTo("$email", 'Information');
    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Request Confirmation';
    if($building !== ""){
        $mail->Body    = "
    

    
        <div style='border:1px solid #eee; width:100%;'>
        <div style='padding:10px;background-color:rgb(3, 169, 244); width:auto;font-size:18px; font-family:arial'>
            <span >
                     Request Confirmation
            </span>
    
     </div>
        <div style='padding:10px; font-size:14px; font-family:arial'>
          Dear $name,<br>
           We have received your support ticket [$random_number], and currently reviewing your ticket.<br>
           <p>
            Details about your ticket:
           </p>
            <p>
                 Ticket Number: <b style='color:blue;'>$random_number</b>
            </p>
            <p>
            Building: <b style='color:blue;'>$building</b>
        </p>
            <p>
            Date: <b style='color:blue;'>$time</b>
        </p>
      
        <p>
        Duration: <b style='color:blue;'>$duration</b>
        </p><br>
      
            Thank You,<br>
            IT Management Centre, UDST
            <hr>
        </div>
        
    </div>
    
    
        
        ";
    }else{
        $mail->Body    = "
    

    
        <div style='border:1px solid #eee; width:100%;'>
        <div style='padding:10px;background-color:rgb(3, 169, 244); width:auto;font-size:18px; font-family:arial'>
            <span >
                     Request Confirmation
            </span>
    
     </div>
        <div style='padding:10px; font-size:14px; font-family:arial'>
             Dear $name, <br>
        We have received your support ticket [$random_number], and currently reviewing your ticket.<br>
           
            <p>
                 Ticket Number: <b style='color:blue;'>$random_number</b>
            </p>
            <p>
            Priority: <b style='color:blue;'>$priority</b>
        </p>
    
        <p>
        Category: <b style='color:blue;'>$category</b>
        <p>
        Sub Category: <b style='color:blue;'>$sub</b>
    </p>
    <p>
    Issue <b style='color:blue;'>$issue</b>
</p>
        </p><br>
         
            Thank You,<br>
            IT Management Centre, UDST
            <hr>
        </div>
        
    </div>
    
    
        
        ";
    }

    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    // echo 'Message has been sent';
    // echo $random_number;
    // $feedData=json_encode($random_number);
    
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>