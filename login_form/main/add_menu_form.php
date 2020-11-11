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
	<title>Tambah data 
	<?php 
	   echo $_GET['menu'];
	?>
	</title>
	<link rel="stylesheet" type="text/css" href="style2.css">
</head>
<body>
	<div class="judul">		
		<h2>KKN</h2>
		<h3>KKN</h3>
	</div>

	<br />
	
	
	<a <?php 
	echo 'href="menu.php?id='.$_GET['menu'].'&page=1"';
	?>>< Lihat Semua Data</a>
	

	<h3>Input <?php 
	   echo $_GET['menu'];
	?> Baru</h3>
	<form action=
	<?php 
	echo '"add_menu.php?id='.$_GET['menu'].'"'?> method="post">		
		<table>
			<?php 
			 $make_call2 = callAPI('POST', 'http://localhost:8080/menu/listcolandtype/'.$_GET['menu'], "{}");
			 $responseH = json_decode($make_call2, true);
			 $xyz = "";
			 $column = "ozijasdojas";
			 $i = 0;
    			 foreach($responseH as $key => $val) {
    			     if($i>"0" && $i<sizeof($responseH)-1){
        			     if (strpos($val, 'date') !== false) {
        			         $xyz = "date";
        			     }else{
        			         $xyz = "text";
        			     }
        			     
        			     echo '<tr>
        				<td>'.$key.'</td>
        				<td><input type="'.$xyz.'" name="'.$key.'"></td>					
        			     </tr>	';
        			     $column = $column."@@".$key;
    			     }
    			     $i++;
			     }
			 
			?>
			<tr>
				<td><input type="hidden" name="89r3aw3es" value="<?php
				echo $column;
				?>" required></td>					
			</tr>	
			</tr>
				<td></td>
				<td><button type="submit">Simpan</button></td>					
			</tr>				
		</table>
	</form>
	
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