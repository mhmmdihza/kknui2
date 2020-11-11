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
	<title>KKN</title>
	<link rel="stylesheet" type="text/css" href="style2.css">
</head>
<body>
	<div class="judul">		
		<h2>KKN</h2>
		<h3>KKN</h3>
	</div>

	<br />
	<form action="http://<?php echo $_SERVER['HTTP_HOST'].'/login_form/main/mainmenu.php'?>">
    <input type="submit" value="Kembali ke menu utama" />
    </form>

    <script>
    function goBack() {
      window.history.back();
    }
    </script>
	
	<br />
	<a href="add_user_form.php">+ Tambah Data Baru</a>

	<h3>Data Pengguna</h3>
	<div style="overflow: auto;">
		<table border="1" class="table">
			<tr>
				<th>Username</th>
				<th>Password</th>
			</tr>
			<?php 
			$make_call = callAPI('POST', 'http://localhost:8080/login/findall', null);
			$response = json_decode($make_call, true);
			
			for ($i = 0; $i < sizeof($response); $i++){
			//foreach($response as $data => $value) { 
			?>
				<tr>
					<td><?php echo $response[$i]['username']; ?></td>
					<td>*********</td>
					<td width="90px" align="center">
						<a href="proses_hapus.php?id=<?php echo $response[$i]['username']; ?>" onclick="return confirm('Yakin hapus data?')">Hapus</a>					
					</td>
				</tr>
			<?php
			} ?>
		</table>
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