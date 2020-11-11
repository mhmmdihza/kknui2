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
	<title>Tambah User</title>
	<link rel="stylesheet" type="text/css" href="style2.css">
</head>
<body>
	<div class="judul">		
		<h2>KKN</h2>
		<h3>KKN</h3>
	</div>

	<br />
	<a href="user.php">< Lihat Semua Data</a>

	<h3>Input user Baru</h3>
	<form action="add_user.php" method="post">		
		<table>
			<tr>
				<td>Username</td>
				<td><input type="text" name="username" required></td>					
			</tr>	
			<tr>
				<td>Password</td>
				<td><input type="text" name="password" required></td>					
			</tr>					
			</tr>
				<td></td>
				<td><button type="submit">Simpan</button></td>					
			</tr>				
		</table>
	</form>
	
</body>
</html>