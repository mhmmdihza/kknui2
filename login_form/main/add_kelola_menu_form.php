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
	<script src=" 
https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"> 
    </script>
</head>
<body>
	<div class="judul">		
		<h2>KKN</h2>
		<h3>KKN</h3>
	</div>

	<br />
	<a href="kelolamenu.php">< Lihat Semua Data</a>

	<h3>Input user Baru</h3>
	<form action="add_kelola_menu_form2.php" method="post">		
		<table>
			<tr>
				<td>Nama Menu</td>
				<td><input type="text" name="namamenu" required></td>					
			</tr>	
			<tr>
				<td>Jumlah Kolom input</td>
				<td><input type="text" name="numonly" placeholder="Input angka (1-20)"
                   maxlength="2"></td>					
			</tr>	
				<td></td>
				<td><button type="submit">Simpan</button></td>					
			</tr>				
		</table>
	</form>
	
	<script> 
    $(function() { 
        $("input[name='numonly']").on('input', function(e) { 
            $(this).val($(this).val().replace(/^(([2-9]|[1-9]\d)[05])|([A-Za-z]+)|(0)$/gm, '')); 
        }); 
    }); 
</script> 
<script> 
    function onlynum() { 
        var fm = document.getElementById("form2"); 
        var ip = document.getElementById("num"); 
        var tag = document.getElementById("value"); 
        var res = ip.value; 
  
        if (res != '') { 
            if (isNaN(res)) { 
                  
                // Set input value empty 
                ip.value = ""; 
                  
                // Reset the form 
                fm.reset(); 
                return false; 
            } else { 
                return true 
            } 
        } 
    } 
</script>
	
</body>
</html>