<?php 
session_start();

if( !isset($_SESSION['username']) ){
    die( "<a href="."http://".$_SERVER['HTTP_HOST'].'/login_form/login.php'.">Login required</a>" );
    
    header("Location: http://".$_SERVER['HTTP_HOST'].'/login_form/login.php');
}

    
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body {
  margin: 0;
  font-family: "Lato", sans-serif;
  background: -webkit-linear-gradient(bottom, #2dbd6e, #a6f77b);
    background-repeat: no-repeat;
}

.sidebar {
  margin: 0;
  padding: 0;
  width: 200px;
  position: fixed;
  height: 100%;
  overflow: auto;
  position: fixed;
  background: #312450;
  font-size: 0.65em;
  font-family: Arial;
  background: #5e42a6;
}

.sidebar a {
  display: block;
  color: black;
  padding: 16px;
  text-decoration: none;
}
 
.sidebar a.active {
  background-color: #4CAF50;
  color: white;
}

.sidebar a:hover:not(.active) {
  background-color: #555;
  color: white;
}

div.content {
  margin-left: 200px;
  padding: 1px 16px;
  height: 1000px;
}

@media screen and (max-width: 700px) {
  .sidebar {
    width: 100%;
    height: auto;
    position: relative;
  }
  .sidebar a {float: left;}
  div.content {margin-left: 0;}
}

@media screen and (max-width: 400px) {
  .sidebar a {
    text-align: center;
    float: none;
  }
}
#card-title {
  font-family: "Raleway Thin", sans-serif;
  letter-spacing: 4px;
  padding-bottom: 23px;
  padding-top: 13px;
  text-align: center;
}


</style>
</head>
<body>

<div class="sidebar">
  <a class="active" id="card-title" href="#home">Home</a>
  <?php 
      $data_array =  array('username' => $_SESSION["username"], 'role' => $_SESSION["role"]);
      $make_call = callAPI('POST', 'http://localhost:8080/menu/findmenu', json_encode($data_array));
      $response = json_decode($make_call, true);
      
      foreach($response as $key => $value) {
          //$value
          
          echo "<a href=menu.php?id=".$value."&page=1>".$key."</a>";
      };
  
  ?>
  
  <a href="<?php if($_SESSION["role"]==1){
  echo "http://".$_SERVER['HTTP_HOST'].'/login_form/main/user.php">Kelola User</a>';
  }else{
      echo '"></a>';
  }
    
  ?>
  
  <a href="<?php if($_SESSION["role"]==1){
  echo "http://".$_SERVER['HTTP_HOST'].'/login_form/main/kelolamenu.php">Kelola Menu</a>';
  }else{
      echo '"></a>';
  }
  ?>

</div>
<div class="content">
  <h2>Hallo  <?php echo $_SESSION['username']?></h2>
  <?php 
  echo "<a class='logout' href="."http://".$_SERVER['HTTP_HOST'].'/login_form/logout.php'.">Logout</a>";
  ?>
</div>

</body>
</html>
<?php 
function callAPI($method, $url, $data){
    $curl = curl_init();
    switch ($method){
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
        case "PUT":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }
    // OPTIONS:
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Key: 111111111111111111111',
        'Content-Type: application/json',
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    // EXECUTE:
    $result = curl_exec($curl);
    if(!$result){
        $message = "Password atau username salah";
        echo "<script type='text/javascript'>alert('$message');</script>";
        echo "<a href=\"javascript:history.go(-1)\">kembali ke halaman login</a>";
        die('');
    }
    
    curl_close($curl);
    return $result;
}
?>