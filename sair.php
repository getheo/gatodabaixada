<div id="conteudo">
<?php
// deleta
unset($_SESSION);
session_destroy();

// reinicia
//session_start();
	
//session_start();
//session_unset();

$cache_limiter = false;
$cache_expire = false;

// Apaga todas as variáveis da sessão
$_SESSION = array();

// Se é preciso matar a sessão, então os cookies de sessão também devem ser apagados.
// Nota: Isto destruirá a sessão, e não apenas os dados!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    @setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

unset($_SESSION);
session_unset();

@session_destroy();

echo $msg .= "<div class='container-fluid'><div class='alert alert-danger alert-dismissible'><strong>Saiu do sistema!</strong>&nbsp;Você será direcionado para a página de Login.<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div></div>";
echo '<meta http-equiv="refresh" content="5; url=?pg=sistema">';
?>
</div>
