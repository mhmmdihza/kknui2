<?php
session_start();

if( !isset($_SESSION['username']) ){
    die( "<a href="."http://".$_SERVER['HTTP_HOST'].'/login_form/login.php'.">Login required</a>" );
    
    header("Location: http://".$_SERVER['HTTP_HOST'].'/login_form/login.php');
}


$stringjson = '{"key":"'.$_POST['namamenu'].'","map":{';
$fltr = "pppppp";

for($i=0;$i<$_POST['numonly'];$i++){
    $x = 'kol'.$i;
    $y = 'tipe'.$i;
    $z = 'filter'.$i;
    $stringjson = $stringjson.'"'.$_POST[$x].'" : "'.$_POST[$y].'"';
    if($i != $_POST['numonly']-1){
        $stringjson = $stringjson.',';
    }
    if(isset($_POST[$z])){
        
        $fltr = $fltr."@@".$_POST[$x];
    }
};
$stringjson = $stringjson."}}";



$myArray = explode('@@', $fltr);


$make_call = callAPI('POST', 'http://localhost:8080/menu/create', $stringjson);
$response = json_decode($make_call, true);

for($i= 1 ; $i<sizeof($myArray);$i++){
    $make_call2 = callAPI('POST', 'http://localhost:8080/filtermenu/save', '{"menuId":"'.$_POST['namamenu'].'","col":"'.$myArray[$i].'"}');
} 

 if($response){
    echo "<script>alert('Data berhasil ditambahkan!'); window.location='/login_form/main/kelolamenu.php';</script>";
}else{
    echo "<script>alert('Data gagal ditambahkan');</script>";
};  


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

