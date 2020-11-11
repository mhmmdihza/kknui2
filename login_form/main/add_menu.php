<?php 

session_start();

if( !isset($_SESSION['username']) ){
    die( "<a href="."http://".$_SERVER['HTTP_HOST'].'/login_form/login.php'.">Login required</a>" );
    
    header("Location: http://".$_SERVER['HTTP_HOST'].'/login_form/login.php');
}




$myArray = explode('@@', $_POST['89r3aw3es']);

$stringjson = '{"key" : "'.$_GET['id'].'","map":{';

for($i=1;$i<sizeof($myArray);$i++){
    $stringjson = $stringjson.'"'.$myArray[$i].'" : "'.$_POST["$myArray[$i]"].'" ';
    if($i<sizeof($myArray)-1){
        $stringjson = $stringjson.",";
    }
};
$stringjson = $stringjson."}}";

$make_call = callAPI('POST', 'http://localhost:8080/menu/saveform', $stringjson);
$response = json_decode($make_call, true);

if($response){
    echo "<script>alert('Data berhasil ditambahkan!'); window.location='/login_form/main/menu.php?id=".$_GET['id']."&page=1';</script>";
}else{
    echo "<script>alert('Data gagal ditambahkan');</script>";
}


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

