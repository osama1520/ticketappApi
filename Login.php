<?php 

include("config.php");

class method extends database{

    public function Login($postdata){

      $request = json_decode($postdata);
      $username = isset($request->adminName) ? mysqli_real_escape_string($this->con, $request->adminName) : '';
      $password = isset($request->adminPassword) ? mysqli_real_escape_string($this->con, $request->adminPassword) : '';
      
      $sql = "select * from user where username = '$username' and password = '$password'";
      $result = $this->con->query($sql);
      
      if ($result && $result->num_rows > 0) {
          $fetch = $result->fetch_assoc(); 
          if ($fetch['username'] === $username && $fetch['password'] === $password) {
              echo json_encode($fetch);
          } else {
              echo "false";
          }
      } else {
          echo "false";
      }
      
         
    }
    public function submit($postdata, $get, $files){
     
        $request = json_decode($postdata);
      

        $userid=   isset($get['userid']) ? mysqli_real_escape_string($this->con, $get['userid']) : '';
        $issue=    isset($get['issue']) ? mysqli_real_escape_string($this->con,$get['issue']) : '';
        $condition= isset( $get['condition'] ) ? mysqli_real_escape_string($this->con, $get['condition'] ) : '';
        $txtareaval=   isset( $get['txtareaval'] ) ? mysqli_real_escape_string($this->con, $get['txtareaval']  ) : '';
        $priority=    isset( $get['priority']) ? mysqli_real_escape_string($this->con, $get['priority']  ) : '';
        $asigneeId=   isset( $get['asigneeId']) ? mysqli_real_escape_string($this->con, $get['asigneeId']  ) : '';
       
        $ticketid =  isset( $get['ticketid']) ? mysqli_real_escape_string($this->con, $get['ticketid']  ) : '';
        // $sub = ;
        $sub =  isset(  $get['sub']) ? mysqli_real_escape_string($this->con,  $get['sub'] ) : '';
      if(empty($files["file"])){
      
        
        $date = new DateTime('now', new DateTimeZone('Asia/Qatar'));
        $date1 = $date->format('Y-m-d H:i:s');
          $sql2 = "INSERT into ticket (userID, asigneeId,Priority, description, additional,ticketType, ticketTopic, status) VALUES ('$userid', '$asigneeId','$priority','$txtareaval','$sub', '$condition','$issue', '0')";
          $this->con->query($sql2);
      }else{
        $errors = [];
		
        $result = [];
        $all_files = count($files['file']['tmp_name']);
        for ($i = 0; $i < $all_files; $i++) {
        $path = $_SERVER['DOCUMENT_ROOT']."/ticketAppAPI/user/". $userid . "/files/";
  
          // $file_name = $files['file']['name'][$i];
          // $file_tmp = $files['file']['tmp_name'][$i];
          // $file_type = $files['file']['type'][$i];
          // $file_size = $files['file']['size'][$i];
          $file_name = mysqli_real_escape_string($this->con, $files['fileg']['name'][$i]);
          $file_tmp = mysqli_real_escape_string($this->con, $files['fileg']['tmp_name'][$i]);
          $file_size = mysqli_real_escape_string($this->con, $files['fileg']['size'][$i]);
          $file_ext = strtolower(end(explode('.', $files['file']['name'][$i])));
          $file_type = strtolower(end(explode('.', $files['file']['type'][$i])));
          
          $newName = hash("sha256",rand(1,900000000000000) . $userid . $i);
          $hash = md5($newName);
          $extensions = array("png","PNG","gif","GIF", "jpg","JPG", "JPEG", "jpeg");
    
        
          if ($file_size > 30000974) {
          $errors[] = 'Image size must not be more than 30 MB';
          }
          if(!file_exists($path) && !is_dir($path)){
           mkdir($path, 0777, true);
          }
              
          move_uploaded_file($files['file']['tmp_name'], $path.$hash.".$file_type");
          
          $domainPath = "http://localhost/ticketAppAPI/user/". $userid . "/files/";
          $fullPath = $domainPath . $hash . ".$file_type";
        
          $date = new DateTime('now', new DateTimeZone('Asia/Qatar'));
          $date1 = $date->format('Y-m-d H:i:s');
            $sql2 = "INSERT into ticket (userID, asigneeId,Priority, description, additional,ticketType, ticketTopic, status, files) VALUES ('$userid', '$asigneeId','$priority','$txtareaval','$sub', '$condition','$issue', '0','$fullPath')";
            $this->con->query($sql2);
        }
       
          
      }
      
    
       
              // echo $txtareaval;
		

      

       

      
    }


    public function update($postdata, $get, $files){
     
      $request = json_decode($postdata);
      

      $userid= isset($get['userid']) ? $get["userid"] : "";
      $issue = isset($get['issue']) ? $get['issue'] : "";

      $condition= isset($get['condition']) ? $get["condition"] : "";
      $priority = isset($get['priority']) ? $get['priority'] : "";
      $asigneeId = isset($get['asigneeId']) ? $get['asigneeId'] : "";
      $txtareaval= isset($get['txtareaval']) ? $get["txtareaval"] : "";
      $ticketid = isset($get['ticketid']) ? $get['ticketid'] : "";
      echo $txtareaval;
      echo 12;
    if($txtareaval !== "undefined"){
       $sql = "update ticket set description = '$txtareaval', `counter`= `counter` + 1 WHERE ticketID='$ticketid'";
      $this->con->query($sql);
    }
    if(!empty($files["fileUpdate"])){
      $errors = [];
  
      $result = [];
      $all_files = count($files['fileUpdate']['tmp_name']);
      for ($i = 0; $i < $all_files; $i++) {
      $path = $_SERVER['DOCUMENT_ROOT']."/ticketAppAPI/user/". $userid . "/files/";

        $file_name = $files['fileUpdate']['name'][$i];
        $file_tmp = $files['fileUpdate']['tmp_name'][$i];
        $file_type = $files['fileUpdate']['type'][$i];
        $file_size = $files['fileUpdate']['size'][$i];
        $file_ext = strtolower(end(explode('.', $files['fileUpdate']['name'][$i])));
        $newName = hash("sha256",rand(1,900000000000000) . $userid . $i);
        $hash = md5($newName);
        $extensions = array("png","PNG","gif","GIF", "jpg","JPG", "JPEG", "jpeg");
  
      
        if ($file_size > 30000974) {
        $errors[] = 'Image size must not be more than 30 MB';
        }
        if(!file_exists($path) && !is_dir($path)){
         mkdir($path, 0777, true);
        }
            
      // }
      move_uploaded_file($files['fileUpdate']['tmp_name'], $path.$hash.".$file_type");
      $domainPath = "http://localhost/ticketAppAPI/user/". $userid . "/files/";
      $fullPath = $domainPath . $hash . ".$file_type";
    
      $date = new DateTime('now', new DateTimeZone('Asia/Qatar'));
      $date1 = $date->format('Y-m-d H:i:s');
      $sql2 = "update ticket set files = '$fullPath', `counter`= `counter` + 1 WHERE ticketID='$ticketid'";
        $this->con->query($sql2);

      }
        
      
        
    }
    
  
     
        
  

    

     

    
  }
    public function insertSelected($postdata){

        $request = json_decode($postdata);

     
          
    
    $firstname = isset($request->firstname) ? mysqli_real_escape_string($this->con, $request->firstname) : '';
     $lastname = isset($request->lastname) ? mysqli_real_escape_string($this->con, $request->lastname) : '';
     $username = isset($request->username) ? mysqli_real_escape_string($this->con, $request->username) : '';
     $password = isset($request->password) ? mysqli_real_escape_string($this->con, $request->password) : '';
     $phone = isset($request->phone) ? mysqli_real_escape_string($this->con, $request->phone) : '';
     $email = isset($request->email) ? mysqli_real_escape_string($this->con, $request->email) : '';
     $selectedImg = isset($request->selectedImg) ? mysqli_real_escape_string($this->con, $request->selectedImg) : '';

     $occupation = isset($request->occupation) ? mysqli_real_escape_string($this->con, $request->occupation) : '';

    $sql = "INSERT into user (phone, profileImage, firstName, lastName, username,email,password,universityID, occupation)
     VALUES ('$phone', '$selectedImg','$firstname','$lastname', '$username','$email','$password','$username','$occupation')";
    $this->con->query($sql);
         
    }
    public function insertSelectedForm($postdata, $files, $get) {
      $request = json_decode($postdata);
      
      $occupation = isset($get['occupation']) ? mysqli_real_escape_string($this->con, $get['occupation']) : '';
      $firstname = isset($get['firstname']) ? mysqli_real_escape_string($this->con, $get['firstname']) : '';
      $lastname = isset($get['lastname']) ? mysqli_real_escape_string($this->con, $get['lastname']) : '';
      $username = isset($get['username']) ? mysqli_real_escape_string($this->con, $get['username']) : '';
      $password = isset($get['password']) ? mysqli_real_escape_string($this->con, $get['password']) : '';
      $phone = isset($get['phone']) ? mysqli_real_escape_string($this->con, $get['phone']) : '';
      $email = isset($get['email']) ? mysqli_real_escape_string($this->con, $get['email']) : '';
      $selectedImg = isset($request->selectedImg) ? mysqli_real_escape_string($this->con, $request->selectedImg) : '';
  
     if (isset($files['fileg']) && $files['fileg']['error'] == UPLOAD_ERR_OK) {
          $file_name = mysqli_real_escape_string($this->con, $files['fileg']['name']);
          $file_tmp = mysqli_real_escape_string($this->con, $files['fileg']['tmp_name']);
          $file_size = mysqli_real_escape_string($this->con, $files['fileg']['size']);
  
          $file_parts = explode('.', $file_name);
          $file_ext = strtolower(end($file_parts));
          $newName = hash("sha256", rand(1, 900000000000000) . $username);
          $hash = md5($newName);
          $path = mysqli_real_escape_string($this->con, $_SERVER['DOCUMENT_ROOT'] . "/ticketAppAPI/user/" . $username . "/profilePhoto/");
  
          if (!file_exists($path)) {
              mkdir($path, 0777, true);
          }
  
          move_uploaded_file($file_tmp, $path . $hash . ".jpeg");
  
          $domainPath = "http://localhost/ticketAppAPI/user/". $username . "/profilePhoto/";
          $fullPath = $domainPath . $hash . ".jpeg";
  
          $sql = "INSERT into user (phone, profileImage, firstName, lastName, username, email, password, universityID, occupation)
                  VALUES ('$phone', '$fullPath', '$firstname', '$lastname', '$username', '$email', '$password', '$username','$occupation')";
          $result = $this->con->query($sql);
          if ($result) {
              return true;
          } else {
              return false;
          }
      }
  }
  
public function UpdateProfile($get, $files) {
  // $request = json_decode($postdata);

  $firstname = mysqli_real_escape_string($this->con, $get['firstname']);
  $lastname = mysqli_real_escape_string($this->con, $get['lastname']);
  $phone = mysqli_real_escape_string($this->con, $get['phone']);
  $userid = mysqli_real_escape_string($this->con, $get['userid']);
  // $update = mysqli_real_escape_string();
  $update = isset($get['update']) ? mysqli_real_escape_string($this->con, $get['update']) : '';
  $email = isset($get['email']) ? mysqli_real_escape_string($this->con, $get['email']) : '';

  $selected = isset($get['selected']) ? mysqli_real_escape_string($this->con, $get['selected']) : '';
  // $password = isset($request->adminPassword) ? mysqli_real_escape_string($this->con, $request->adminPassword) : '';
  // echo $selected;
  $errors = [];
  $result = [];

  // if ( isset($files['filep']['tmp_name']) &&  is_array($files['filep']['tmp_name'])  ) {
  //   $all_files = count($files['filep']['tmp_name']);
  // } else {
  //   $all_files = 0;
  // }

  $path = $_SERVER['DOCUMENT_ROOT'] . "/ticketAppAPI/user/" . $userid . "/profilePhoto/";
  
  if (isset($files['filep']) && $files['filep']['error'] == UPLOAD_ERR_OK) {
    $file_name = $files['filep']['name'];
    $file_tmp = $files['filep']['tmp_name'];
    $file_size = $files['filep']['size'];
    // $file_ext = strtolower(end(explode('.', $file_name)));

    $file_parts = explode('.', $file_name);
$file_ext = strtolower(end($file_parts));
    $newName = hash("sha256", rand(1, 900000000000000) . $userid);
    $hash = md5($newName);

    // Set the path where you want to save the file
    $path = $_SERVER['DOCUMENT_ROOT'] . "/ticketAppAPI/user/" . $userid . "/profilePhoto/";

    // Create the directory if it doesn't exist
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }

    // Move the uploaded file to the desired location
    move_uploaded_file($file_tmp, $path . $hash . ".jpeg");

    // Set the full path to the uploaded file
    $domainPath = "http://localhost/ticketAppAPI/user/". $userid . "/profilePhoto/";
    $fullPath = $domainPath . $hash . ".jpeg";

    // Update the user record with the full path to the uploaded file
    $sql = "UPDATE user SET  firstName = '$firstname', lastName = '$lastname', phone = '$phone', profileImage = '$fullPath' WHERE id = '$userid'";
    $result = $this->con->query($sql);

  
}else{
  $sql = "UPDATE user SET profileImage = '$selected', firstName = '$firstname', lastName = '$lastname' ,email = '$email', phone = '$phone' WHERE id = '$userid'";

  $result = $this->con->query($sql);

 
}

$sql1 = "SELECT * FROM user WHERE id = '$userid'";
$result = $this->con->query($sql1);
$feedData = mysqli_fetch_all($result,MYSQLI_ASSOC);
$feedData=json_encode($feedData);

echo '{"feedData":'.$feedData.'}';
 
  
}

public function updatePassword($postdata){
  $request = json_decode($postdata);
  // $userid = mysqli_real_escape_string($this->con, $request->userid);
  //       $confirm = mysqli_real_escape_string($this->con, $request->confirm);

        $userid = isset($request->userid) ? mysqli_real_escape_string($this->con, $request->userid) : '';
        $confirm = isset($request->confirm) ? mysqli_real_escape_string($this->con, $request->confirm) : '';
        $sql = "UPDATE user SET password = '$confirm' WHERE id = '$userid'";
        $result = $this->con->query($sql);
  // echo $confirm;

}
public function updateReservation($postdata){
  $request = json_decode($postdata);
  $room = isset($request->room) ? mysqli_real_escape_string($this->con, $request->room) : '';
  $building = isset($request->building) ? mysqli_real_escape_string($this->con, $request->building) : '';
  $userid = isset($request->userid) ? mysqli_real_escape_string($this->con, $request->userid) : '';
  $ticketID = isset($request->ticketID) ? mysqli_real_escape_string($this->con, $request->ticketID) : '';
  $duration = isset($request->duration) ? mysqli_real_escape_string($this->con, $request->duration) : '';
  $eventDate = isset($request->eventDate) ? mysqli_real_escape_string($this->con, $request->eventDate) : '';
  
  
  $sql = "UPDATE ticket SET room = '$room', building ='$building',duration ='$duration', dateEvent = '$eventDate' WHERE ticketID = '$ticketID'";
  $result = $this->con->query($sql);
}
public function deptProcess($postdata){

  $request = json_decode($postdata);


$department = $request->department;
$id = $request->id;
$name = $request->name;
$title = $request->title;
$email = $request->email;

$userid = $request->userid;

if($title !== ""){
  $sql = "INSERT into department (asigneeId,userId,  name, title,email) VALUES ('$id', '$userid','$name', '$title','$email')";
  $this->con->query($sql);
}else{
  $sql = "select * from ticket left join department on user.id = department.userId where userId = '$userid'";

$result = $this->con->query($sql);

$feedData = mysqli_fetch_all($result,MYSQLI_ASSOC);
$feedData=json_encode($feedData);

echo '{"check":'.$feedData.'}';
}

   
}
public function checkTicket($postdata){

    $request = json_decode($postdata);

    $userid = isset($request->id) ? mysqli_real_escape_string($this->con, $request->id) : '';
    $sort = mysqli_real_escape_string($this->con, $request->sort);

    if($userid == "5"){
      if($sort == "Sort by Status"){
        $sql = "
        select * from ticket   GROUP BY ticket.ticketID   ORDER BY ticket.status = '2' DESC    

;

        ";
      }else if($sort == "Sort by Date"){
        $sql = "
      
                 
        select * from ticket   GROUP BY ticket.ticketID         ORDER BY ticket.createdOn  DESC;
        ";
       
      }else if ($sort == "Sort by Priority"){

        $sql = "
        select * from ticket    GROUP BY ticket.ticketID                 ORDER BY ticket.Priority  asc

        

        ";

      }else{
        $sql = "
        select * from ticket      GROUP BY ticket.ticketID       
        ";
      }
      $result = $this->con->query($sql);
      
      $feedData = mysqli_fetch_all($result,MYSQLI_ASSOC);
      $feedData=json_encode($feedData);
      
      echo '{"tickets":'.$feedData.'}';
    }else{
      if($sort == "Sort by Status"){
        $sql = "
      
        select * from ticket where ticket.userID = '$userid'  GROUP BY ticket.ticketID  ORDER BY ticket.status = '2' DESC;
        ";
      }else if($sort == "Sort by Date"){
        $sql = "
       select * from ticket where ticket.userID = '$userid'  GROUP BY ticket.ticketID order by ticket.createdOn
        
        ";
       
      }else if ($sort == "Sort by Priority"){

        $sql = "
        select * from ticket where ticket.userID = '$userid'  GROUP BY ticket.ticketID ORDER BY ticket.Priority ASC;
        
        ";

      }else{
        $sql = "select * from ticket  where ticket.userID = '$userid'  GROUP BY ticket.ticketID  ";

      }
      $result = $this->con->query($sql);
      
      $feedData = mysqli_fetch_all($result,MYSQLI_ASSOC);
      $feedData=json_encode($feedData);
      
      echo '{"tickets":'.$feedData.'}';
    }

     

}
public function deleteTicket($postdata){

  $request = json_decode($postdata);


  $ticketID = mysqli_real_escape_string($this->con, $request->ticketID);

      $sql = "DELETE FROM ticket WHERE ticketID='$ticketID'";
      $result = $this->con->query($sql);
     
}
public function updateStatus($postdata){

$request = json_decode($postdata);


$ticketid = mysqli_real_escape_string($this->con, $request->ticketid);
$update = mysqli_real_escape_string($this->con, $request->update);

    $sql = "update ticket set status = '$update' WHERE ticketID='$ticketid'";
    $result = $this->con->query($sql);
   
}
public function submitTicket($postdata){

    $request = json_decode($postdata);

 
// $time = $request->time;
// $duration = $request->duration;
// $building = $request->building;
// $userid = $request->userid;
// $type = $request->type;
$time = isset($request->time) ? mysqli_real_escape_string($this->con, $request->time) : '';
 $duration = isset($request->duration) ? mysqli_real_escape_string($this->con, $request->duration) : '';
 $building = isset($request->building) ? mysqli_real_escape_string($this->con, $request->building) : '';
 $type = isset($request->type) ? mysqli_real_escape_string($this->con, $request->type) : '';
 $userid = isset($request->userid) ? mysqli_real_escape_string($this->con, $request->userid) : '';
 $room = isset($request->room) ? mysqli_real_escape_string($this->con, $request->room) : '';
 $date = isset($request->date) ? mysqli_real_escape_string($this->con, $request->date) : '';
$status = 0;

$sql = "INSERT into ticket (userID, building, time,duration,room,dateEvent,ticketType) VALUES ('$userid','$building', '$time','$duration','$room','$date','$type')";
$this->con->query($sql);
     
}
public function checkAvailability($postdata){

  $request = json_decode($postdata);


$userid = $request->userid;


  $sql = "SELECT asigneeId, name, title,COUNT(*) AS num_records
  FROM department
  GROUP BY asigneeId
  ";

$result = $this->con->query($sql);

$feedData = mysqli_fetch_all($result,MYSQLI_ASSOC);
$feedData=json_encode($feedData);

echo '{"check":'.$feedData.'}';


   
}


}
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$obj = new method();

if(isset($request->pass) && $request->pass == "updatePassword"){

  $obj->updatePassword($postdata);
}
else if(isset($_GET['pass']) && $_GET['pass'] == "UpdateProfile" || isset($_FILES['filep'])){

  $obj->UpdateProfile($_GET, $_FILES);
}
else if(isset($request->pass) && $request->pass == "loginToAdminPortal"){

  $obj->Login($postdata);
}
elseif(isset($request->pass) && $request->pass == "registerStudent"){

  $obj->registerStudent($postdata);
}
else if(isset($request->pass) && $request->pass == "submitRequest"){

  $obj->submitTicket($postdata);
}else if(isset($request->pass) && $request->pass =="updateReservation"){
  $obj->updateReservation($postdata);
}
else if(isset($request->pass) && $request->pass == "checkTicket"){

  $obj->checkTicket($postdata);
}
else if(isset($_GET["pass"]) && $_GET["pass"] == "submit"  ){

  $obj->submit($postdata,$_GET, $_FILES);
}
else if(isset($_GET["pass"]) && $_GET["pass"] == "update" || isset($_FILES['fileUpdate']) ){

  $obj->update($postdata,$_GET, $_FILES);
}

else if(isset($request->pass) && $request->pass == "deleteTicket"){

  $obj->deleteTicket($postdata);
}
else if(isset($request->pass) && $request->pass == "updateStatus"){

  $obj->updateStatus($postdata);
}
else if(isset($request->pass) && $request->pass == "deptProcess"){

  $obj->deptProcess($postdata);
} 
else if(isset($request->pass) && $request->pass == "checkAvailability"){

  $obj->checkAvailability($postdata);
}
else if(isset($request->pass) && $request->pass == "insertSelected"){

  $obj->insertSelected($postdata);
}
else if(isset($_GET["pass"]) && $_GET["pass"]== "insertSelectedForm" && isset($_FILES['fileg'])){
  $obj->insertSelectedForm($postdata, $_FILES, $_GET);
}



?>