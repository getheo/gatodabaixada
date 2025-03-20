<?php
// fuso
date_default_timezone_set("America/Cuiaba");

$conexao = mysqli_connect("localhost", "banco_de_dados", "root","");

// Checa conexão
if (mysqli_connect_errno()) {
   echo "Falha na conexão com o servido MySQLi:  " . mysqli_connect_error();
} else {
   //echo 'Conexão Ok!';
	//echo "<script>alert('Ok')</script>";
}


function urlAmigavel($string, $slug = false) {
  $string = strtolower($string);
  // Código ASCII das vogais
  $ascii['a'] = range(224, 230);
  $ascii['e'] = range(232, 235);
  $ascii['i'] = range(236, 239);
  $ascii['o'] = array_merge(range(242, 246), array(240, 248));
  $ascii['u'] = range(249, 252);
  // Código ASCII dos outros caracteres
  $ascii['b'] = array(223);
  $ascii['c'] = array(231);
  $ascii['d'] = array(208);
  $ascii['n'] = array(241);
  $ascii['y'] = array(253, 255);
  foreach ($ascii as $key=>$item) {
    $acentos = '';
    foreach ($item AS $codigo) $acentos .= chr($codigo);
    $troca[$key] = '/['.$acentos.']/i';
  }
  $string = preg_replace(array_values($troca), array_keys($troca), $string);
  // Slug?
  if ($slug) {
    // Troca tudo que não for letra ou número por um caractere ($slug)
    $string = preg_replace('/[^a-z0-9]/i', $slug, $string);
    // Tira os caracteres ($slug) repetidos
    $string = preg_replace('/' . $slug . '{2,}/i', $slug, $string);
    $string = trim($string, $slug);
  }
  return $string;
}

function codifica($valor) {
    return trim(base64_encode(strrev(base64_encode($valor))));
}

function decodifica($valor) {
    return trim(base64_decode(strrev(base64_decode($valor))));
}

function mascara_cpf($texto) {
	return substr($texto, 0, 3).".".substr($texto, 3, 3).".".substr($texto, 6,3)."-".substr($texto, 9);
}

function mascara_cnpj($texto) {
	return substr($texto, 0, 2).".".substr($texto, 2, 3).".".substr($texto, 5, 3)."/".substr($texto, 8, 4)."-".substr($texto, 12,2);
}

function mascara_celular($texto) {
	return "(".substr($texto, 0, 2).") ".substr($texto, 2, 1)." ".substr($texto, 3,4)."-".substr($texto, 7,4);
}

$remote_addr = $_SERVER['REMOTE_ADDR'];
$remote_host = "<br>".$_SERVER['REMOTE_HOST'];
$php_self = "<br>".$_SERVER['PHP_SELF'];
$server_name = "<br>".$_SERVER['SERVER_NAME'];
$server_addr = "<br>".$_SERVER['SERVER_ADDR'];
$http_host = "<br>".$_SERVER['HTTP_HOST'];	
$http_referer = "<br>".$_SERVER['HTTP_REFERER'];
$http_user_agent = "<br>".$_SERVER['HTTP_USER_AGENT'];	
$script_name = "<br>".$_SERVER['SCRIPT_NAME'];
$request_uri = $_SERVER['REQUEST_URI'];

$QUERY_STRING = "<br>".$_SERVER['QUERY_STRING'];
$DOCUMENT_ROOT = "<br>".$_SERVER['DOCUMENT_ROOT'];
$PATH_INFO = "<br>".$_SERVER['PATH_INFO'];


$log_dados = ($DOCUMENT_ROOT.$QUERY_STRING.$PATH_INFO.$remote_addr.$remote_host.$php_self.$server_name.$server_addr.$http_host.$http_referer.$http_user_agent.$script_name.$request_uri);

//Cadastro Log de Acesso
$sqlLogAcesso = "INSERT INTO log (log_ip, log_data, log_dados) VALUES ('".addslashes($remote_addr)."','".date("Y-m-d H:i:s", time())."','".$log_dados."')";
$exeLogAcesso = mysqli_query($conexao,$sqlLogAcesso);

?>
