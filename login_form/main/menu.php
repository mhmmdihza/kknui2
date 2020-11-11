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
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>KKN</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="styletable.css">
	<style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}
table {
  font-family: Arial, Helvetica, sans-serif;
  color: #666;
  text-shadow: 1px 1px 0px #fff;
  background: #eaebec;
  border: #ccc 1px solid;
}

table th {
  padding: 15px 35px;
  border-left:1px solid #e0e0e0;
  border-bottom: 1px solid #e0e0e0;
  background: #ededed;
}

table th:first-child{  
  border-left:none;  
}

table tr {
  text-align: center;
  padding-left: 20px;
}

table td:first-child {
  text-align: left;
  padding-left: 20px;
  border-left: 0;
}

table td {
  padding: 15px 35px;
  border-top: 1px solid #ffffff;
  border-bottom: 1px solid #e0e0e0;
  border-left: 1px solid #e0e0e0;
  background: #fafafa;
  background: -webkit-gradient(linear, left top, left bottom, from(#fbfbfb), to(#fafafa));
  background: -moz-linear-gradient(top, #fbfbfb, #fafafa);
}

table tr:last-child td {
  border-bottom: 0;
}

table tr:last-child td:first-child {
  -moz-border-radius-bottomleft: 3px;
  -webkit-border-bottom-left-radius: 3px;
  border-bottom-left-radius: 3px;
}

table tr:last-child td:last-child {
  -moz-border-radius-bottomright: 3px;
  -webkit-border-bottom-right-radius: 3px;
  border-bottom-right-radius: 3px;
}

table tr:hover td {
  background: #f2f2f2;
  background: -webkit-gradient(linear, left top, left bottom, from(#f2f2f2), to(#f0f0f0));
  background: -moz-linear-gradient(top, #f2f2f2, #f0f0f0);
}
</style>
</head>
<body>
	<script>window.setMobileTable = function(selector) {
  // if (window.innerWidth > 600) return false;
  const tableEl = document.querySelector(selector);
  const thEls = tableEl.querySelectorAll('thead th');
  const tdLabels = Array.from(thEls).map(el => el.innerText);
  tableEl.querySelectorAll('tbody tr').forEach( tr => {
    Array.from(tr.children).forEach( 
      (td, ndx) =>  td.setAttribute('label', tdLabels[ndx])
    );
  });
}
	</script>
	<div class="judul">		
		<h2>KKN</h2>
		<h3>KKN</h3>
	</div>

	<br />
	<form action="http://<?php echo $_SERVER['HTTP_HOST'].'/login_form/main/mainmenu.php'?>">
    <input type="submit" value="Kembali ke menu utama" />
    </form>
	
	
	<br />
	<form class="example" action="/login_form/main/menu.php" align="left" style="margin:auto;max-width:300px">
  
    
	<?php 
	   $urlparam = "";
	   echo '<input type="hidden" name="id" value="'.$_GET['id'].'" required>					
			<input type="hidden" name="page" value="'.$_GET['page'].'" required>';
	   $callSearch = callAPI('POST', 'http://localhost:8080/filtermenu/find', '{"menuId" : "'.$_GET['id'].'"}');
        $resp = json_decode($callSearch,true);
        foreach($resp as $item){
            $defaultvalue = "";
            if(isset($_GET[$item['col']])){
                $defaultvalue = $_GET[$item['col']];
            }     
            echo '<input type="text" placeholder="cari berdasarkan '.$item['col'].'" name="'.$item['col'].'" align="right" value="'.$defaultvalue.'">';
            $urlparam = $urlparam.$item['col'].'='.$defaultvalue.'&';
            
        }
        echo '<button type="submit"><i class="fa fa-search"></i></button>'
	?>
	</form>
	
		
    <br />
	
	<a class="fa fa-plus" style="color:black;" href="
	<?php 
	   echo "add_menu_form.php?menu=".$_GET['id']."";
	?>
	">Tambah Data Baru</a>

	<h3><?php echo $_GET['id']; ?></h3>
	<div>
		<table>
		<thead>
			<?php 
            $menu = $_GET['id'];
            
            //$data_array =  array('username' => $_POST["username"], 'password' => $_POST["password"], 'role' => $_POST["role"]);
            $stringjson = '{';
            $x = 0;
            for($i=0;$i<sizeof($resp);$i++){
                if(isset($_GET[$resp[$i]['col']]) && !empty($_GET[$resp[$i]['col']])&& !is_null($_GET[$resp[$i]['col']])){
                    
                    if($x>0){
                        $stringjson = $stringjson.',';
                    }
                    
                    $stringjson = $stringjson.'"'.$resp[$i]['col'].'" : "'.$_GET[$resp[$i]['col']].'"';
                    
                    $x++;
                    /* $asd = "";
                    if(empty($_GET[$resp[$i]['col']])){
                        $asd = $_GET[$resp[$i]['col']];
                    }
                    
                    $stringjson = $stringjson.'"'.$$resp[$i]['col'].'" 
                    : "'.$asd.'"';*/
                    
                }
            };
            $stringjson = $stringjson.'}';
            
            $make_call = callAPI('POST', 'http://localhost:8080/menu/list/'.$menu.'/'.$_GET['page'], $stringjson);
            $make_call2 = callAPI('POST', 'http://localhost:8080/menu/listcol/'.$menu, "{}");
            $response = json_decode($make_call, true);
            $responseH = json_decode($make_call2, true);
            
            ?>
		
			<tr>
				<?php 
    				foreach($responseH as $item){
    				    echo '<th class="numeric">'.$item.'</th>';
    				} 
				
				?>
				<th>Actions</th>
			</tr>
			</thead>
			<tbody>
			<?php 
			
			for ($i = 0; $i < sizeof($response); $i++){
			//foreach($response as $data => $value) { 
			?>
				<tr>
					<?php 
    					foreach($responseH as $item){
    					    echo '<td data-title="change" class="numeric">'.$response[$i][$item].'</td>';
    					    
    					} 
					?>
					<td width="90px" align="center">
						<a href="p_hapus.php?id=<?php echo $response[$i]['id']; ?>&menu=<?php echo $menu?>" class="fa fa-trash" onclick="return confirm('Yakin hapus data?')">Hapus</a>					
					</td>
				</tr>
			<?php
			} ?>
			</tbody>
		</table>
	
	<div class="">
  <?php 
  $make_hal = callAPI('POST', 'http://localhost:8080/menu/countpage/'.$_GET['id'], $stringjson);
  $halaman = json_decode($make_hal, true);
  for ($i=1; $i<=$halaman ; $i++){ ?>
  <a href="?page=<?php echo $i.'&id='.$_GET['id'].'&'.$urlparam; ?>"><?php echo $i; ?></a>
 
  <?php } ?>
 
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