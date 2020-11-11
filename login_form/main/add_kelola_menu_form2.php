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
	<title>Tambah Menu</title>
	<link rel="stylesheet" type="text/css" href="style2.css">
</head>
<body>
	<div class="judul">		
		<h2>KKN</h2>
		<h3>KKN</h3>
	</div>

	<br />
	<a href="user.php">< Lihat Semua Data</a>

	<h3>Input Menu Baru</h3>
	<form action="add_kelola_menu.php" method="post">		
		<table>
			<tr>
				Nama Menu : <?php 
				echo $_POST['namamenu']?>
			</tr>
			<tr>
				<th>Nama Kolom</th>
				<th>Tipe kolom</th>
				<th>jadi filter untuk pencarian</th>						
			</tr>
			<?php 
			for($i = 0  ; $i < $_POST['numonly'];$i++){
			  echo '<tr>
        				<td><input type="text" name="kol'.$i.'" required></td>
        				<td align="center"><select name="tipe'.$i.'" id="cars">
  <option value="TEXT">Text</option>
  <option value="DATE">Tanggal</option>
</select></td>	

				<td><input type="checkbox" name="filter'.$i.'" value="1"></td>			
        			</tr>
';  
			}
			?>					
			</tr>
				<td></td>
				<td><button type="submit">Simpan</button></td>					
			</tr>				
		</table>
		<input type="hidden" name="namamenu" value="<?php echo $_POST['namamenu']?>">
		<input type="hidden" name="numonly" value="<?php echo $_POST['numonly']?>">
		
	</form>
	
</body>
</html>