<?php

if (!jwt($_GET['token'])){
    die (json_encode(['cod'=>403, 'msg'=>'Token inválido']));
}


$validadeEmSegundos = 60;
$arquivoCache =  '../cache/'.$_GET['nome'].'.html';

if (file_exists($arquivoCache) && (filemtime($arquivoCache) > time() - $validadeEmSegundos)) {

   
    $conteudo = file_get_contents($arquivoCache);
} else {

    $conteudo = api();
    
    file_put_contents($arquivoCache, $conteudo);
}

echo $conteudo;

    
function api(){
if (isset($_GET['nome']) && $_GET['nome'] != null){
    $url= "https://api.thecatapi.com/v1/breeds/search?q=" . $_GET['nome'];
}
else{
    $url = "https://api.thecatapi.com/v1/breeds";
}

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('x-api-key: 3f7d7795-cb4f-4f32-8d20-598470b5af51'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);


$r_cat = array();
$execat= curl_exec($ch);

$json_array = json_decode($execat);


foreach ($json_array as $idcat){
    curl_setopt($ch, CURLOPT_URL, 'https://api.thecatapi.com/v1/images/search?breed_ids='.$idcat->id);
    $eqexe = curl_exec($ch);
    $json_ar = json_decode($eqexe);
    array_push($r_cat, $json_ar);

}
curl_close($ch);
return (json_encode($r_cat));
}

function jwt($token){
    if (!isset($token)) {
        return false;
    }
    $separete= explode('.', $token);

    if (count($separete) != 3){
        return false;
    }
    $data = $separete[1];
    $data = base64_decode($data);
    $jsontrans= json_decode($data);
    $data_at= new DateTime("now");
    if ($data_at -> getTimestamp()<= $jsontrans->exp ){
        return true;
    } else {
        return false;
    }
}

?>