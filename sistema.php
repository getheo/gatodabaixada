<?php
session_start();
if(!isset($_SESSION['sistema_cpf'])){
	//session_destroy();
	//echo '<meta http-equiv="refresh" content="0; url=https://gatodabaixada.com.br/index.php">';
	//echo "<script>alert('Cadastro Correto')</script>";		
}
if(isset($_POST['candidato_filtro']) && $_POST['candidato_filtro']<>""){
	//echo "<script>alert('Cadastro Correto')</script>";
	if($_POST['candidato_filtro']==0){
		$query_candidato = " ";
	} else{
		$query_candidato = " AND candidato.candidato_id = '".$_POST['candidato_filtro']."' ";
	}
} else { $query_candidato = " AND candidato.candidato_id>0"; }

if(isset($_POST['pesquisar_cpf']) && $_POST['pesquisar_cpf']<>""){
	$pesquisar_cpf = addslashes(preg_replace("/[^0-9]/", "", $_POST['pesquisar_cpf']));
	$query_pesquisar_cpf = " AND cadastro.cadastro_cpf = '".$pesquisar_cpf."' ";
	$msg .= "<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>x</a>Pesquisando por CPF: <strong>".$_POST['pesquisar_cpf']."</strong></div>";
} else {
	$query_pesquisar_cpf = "";
}

//Pesquisar Status do Voto
if(isset($_GET['pesquisar_status']) && $_GET['pesquisar_status']<>""){
	$query_status = " AND votacao.votacao_status = '".$_GET['pesquisar_status']."'";	
} else { $query_status = ""; }


if(isset($_POST['login_cpf']) && isset($_POST['login_senha'])){
	
	$login_cpf = addslashes(preg_replace("/[^0-9]/", "", $_POST["login_cpf"]));
	$login_senha = addslashes($_POST["login_senha"]);
	
	//echo "<script>alert('Akiii')</script>";
	//die();
	
	if( ($login_cpf=="91649692153" || $login_cpf=="73682187120") && $login_senha=="g@to2021"){		
		$_SESSION['sistema_cpf'] = $login_cpf;
	} else {
		session_destroy();
		$msg .= "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>x</a><strong>Aten&ccedil;&atilde;o!</strong>&nbsp;Acesso negado Informe corretamente.</div>";		
		//echo '<meta http-equiv="refresh" content="0; url=https://gatodabaixada.com.br/?pg=sistema">';
		
	}
	
}


//Excluir CPF e Voto de cpf inválido
if(isset($_POST['excluir_votacao_id'])){
	
	//echo "<script>alert('Teste')</script>";
	//die(); excluir_votacao_status	
	$excluir_votacao_status = addslashes($_POST['excluir_votacao_status']);	
	$excluir_votacao_id = addslashes(preg_replace("/[^0-9]/", "", $_POST['excluir_votacao_id']));
	$excluir_cadastro_id = addslashes(preg_replace("/[^0-9]/", "", $_POST['excluir_cadastro_id']));
	$excluir_cadastro_cpf = addslashes(preg_replace("/[^0-9]/", "", $_POST['excluir_cadastro_cpf']));
	
	//$excluir_cadastro_status = addslashes(preg_replace("/[^0-9]/", "", $_POST['excluir_cadastro_status']));
	
	$status_tramite = array("A" => "Aprovado", "I" => "Reprovado", "P" => "Pendente", "E" => "Excluído");
	
	//Excluir
	if($excluir_votacao_status=="E"){
		
		$sqlExcluirVoto = "DELETE FROM votacao WHERE votacao.votacao_cadastro_id = '$excluir_cadastro_id' AND votacao.votacao_id = '$excluir_votacao_id' AND votacao.votacao_status <>'E'";
		$exeExcluirVoto = mysqli_query($conexao,$sqlExcluirVoto);
		
		$sqlExcluirCadastro = "DELETE FROM cadastro WHERE cadastro.cadastro_id = '$excluir_cadastro_id' AND cadastro.cadastro_cpf = '$excluir_cadastro_cpf'";
		$exeExcluirCadastro = mysqli_query($conexao,$sqlExcluirCadastro);
		
	
		if($exeExcluirCadastro && $exeExcluirVoto){
			$msg .= "<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>x</a>CPF: ".mascara_cpf($excluir_cadastro_cpf)." <strong>".$status_tramite[$excluir_votacao_status].".</strong></div>";		
		} else {
			$msg .= "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>x</a>CPF: <strong>".mascara_cpf($excluir_cadastro_cpf)." não foi excluído corretamente.</strong></div>";
		}
		
		
	} else {
	
	$sqlExcluirCadastro = "UPDATE cadastro SET cadastro_status = '$excluir_votacao_status' WHERE cadastro.cadastro_id = '$excluir_cadastro_id' AND cadastro.cadastro_cpf = '$excluir_cadastro_cpf'";
	$exeExcluirCadastro = mysqli_query($conexao,$sqlExcluirCadastro);
	//$totalConsultaCpf = mysqli_num_rows($exeConsultaCpf);
	//$verExcluirCadastro = mysqli_fetch_array($exeExcluirCadastro,MYSQLI_ASSOC);
	
	$sqlExcluirVoto = "UPDATE votacao SET votacao_status = '$excluir_votacao_status' WHERE votacao.votacao_id = '$excluir_votacao_id' AND votacao.votacao_cadastro_id = '$excluir_cadastro_id'";
	$exeExcluirVoto = mysqli_query($conexao,$sqlExcluirVoto);
	//$totalConsultaCpf = mysqli_num_rows($exeConsultaCpf);
	//$verExcluirCadastro = mysqli_fetch_array($exeExcluirCadastro,MYSQLI_ASSOC);
	
	if($exeExcluirCadastro && $exeExcluirVoto){
		$msg .= "<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>x</a>CPF: ".mascara_cpf($excluir_cadastro_cpf)." <strong>".$status_tramite[$excluir_votacao_status].".</strong></div>";		
	} else {
		$msg .= "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>x</a>CPF: <strong>".mascara_cpf($excluir_cadastro_cpf)." não foi excluído corretamente.</strong></div>";
	}
		
	}
}


//Premiacao
if(isset($_POST['premiacao_cadastrar'])){
	
	$premiacao_titulo = addslashes(utf8_decode($_POST['premiacao_titulo']));
	$premiacao_descricao = addslashes(utf8_decode($_POST['premiacao_descricao']));
	$premiacao_data = addslashes($_POST['premiacao_data']);
	
	if($premiacao_foto = basename($_FILES["premiacao_foto"]["name"]));
	
	$sqlPremiacaoCadastro = "INSERT INTO premiacao (premiacao_titulo, premiacao_descricao, premiacao_data) VALUES ('".$premiacao_titulo."', '".$premiacao_descricao."', '".$premiacao_data."');";
	
	$exePremiacaoCadastro = mysqli_query($conexao,$sqlPremiacaoCadastro);
	$premiacao_id = mysqli_insert_id($conexao);
	//$verExcluirCadastro = mysqli_fetch_array($exeExcluirCadastro,MYSQLI_ASSOC);
	
	if($exePremiacaoCadastro){
		
		if($premiacao_foto<>""){
				if(is_dir("premiacao/$premiacao_id/")){
					@rmdir("premiacao/$premiacao_id/");
					//echo "A Pasta Existe";
				}		
				@mkdir("premiacao/$premiacao_id/", 0777, true);			
				//chmod("../noticia/$pasta/", 0777);		

				$extensaoF1 = strtolower(pathinfo($_FILES["premiacao_foto"]["name"],PATHINFO_EXTENSION));		
				$novo_nomeF1 = md5(time()).".". $extensaoF1; //define o nome do arquivo

				//Grava Foto 1)
				$sqlGravaFoto = "UPDATE premiacao SET premiacao_foto = '".$novo_nomeF1."' WHERE premiacao.premiacao_id = '$premiacao_id'";			
				$exeGravaFoto = mysqli_query($conexao,$sqlGravaFoto);

				$target_dirF1 = "premiacao/$premiacao_id/";
				$target_fileF1 = $target_dirF1 . $novo_nomeF1;
				$uploadOkF1 = 1;
				$imageFileTypeF1 = strtolower(pathinfo($target_fileF1,PATHINFO_EXTENSION));
				
				// Check if image file is a actual image or fake image
				if(isset($_POST["submit"])) {
					$checkF1 = getimagesize($_FILES["premiacao_foto"]["tmp_name"]);
					if($checkF1 !== false) {
						$msg = "<div class='w3-panel w3-green'><h3>Ok!</h3><p>Arquivo é uma imagem - " . $check["mime"] . ".</p></div>";
						$uploadOkF1 = 1;
					} else {
						$msg = "<div class='w3-panel w3-red'><h3>Erro!</h3><p>O arquivo não é uma imagem</p></div>";
						$uploadOkF1 = 0;
					}
				}
				// Check if file already exists
				if (file_exists($target_fileF1)) {
					$msg .= "<div class='w3-panel w3-red'><h3>Erro!</h3><p>O arquivo não existente</p></div>";
					$uploadOkF1 = 0;
				}
				// Check file size
				if ($_FILES["premiacao_foto"]["size"] > 5000000) {
					$msg .= "<div class='w3-panel w3-red'><h3>Erro!</h3><p>O arquivo muito grande. Max: 5MB</p></div>";
					$uploadOkF1 = 0;
				}
				// Allow certain file formats
				if($imageFileTypeF1 != "jpg" && $imageFileTypeF1 != "png" && $imageFileTypeF1 != "jpeg" && $imageFileTypeF1 != "gif" && $imageFileTypeF1 != "bmp" ) {
					$msg .= "<div class='w3-panel w3-red'><h3>Erro!</h3><p>Somente JPG, PNG, GIF e BMP são aceitos.</p></div>";
					$uploadOkF1 = 0;
				}
				// Check if $uploadOk is set to 0 by an error
				if ($uploadOkF1 == 0) {
					$msg .= "<div class='w3-panel w3-red'><h3>Erro!</h3><p>Arquivo não enviado</p></div>";
				// if everything is ok, try to upload file
				} else {
					if (move_uploaded_file($_FILES["premiacao_foto"]["tmp_name"], $target_fileF1)) {
						$msg .= "<h3 class='text-success'>Ok!</h3><p class='text-success'>O arquivo $novo_nomeF1 foi enviado</p>";
					}
				}
			} //Upload Foto1)
		
		$msg .= "<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>x</a>Sucesso: <strong>".$_POST['pesquisar_cpf']." Premiação cadastrada.</strong></div>";		
	} else {
		$msg .= "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>x</a>Erro: <strong>".$_POST['pesquisar_cpf']." Premiação não foi cadastrada.</strong></div>";
	}	
}

//Arquivo
if(isset($_POST['arquivo_cadastrar'])){
	
	$arquivo_titulo = addslashes(utf8_decode($_POST['arquivo_titulo']));
	$arquivo_descricao = addslashes(utf8_decode($_POST['arquivo_descricao']));
	$arquivo_candidato = addslashes($_POST['arquivo_candidato']);
	$arquivo_data = addslashes($_POST['arquivo_data']);
	
	if($arquivo_foto = basename($_FILES["arquivo_foto"]["name"]));
	
	$sqlArquivoCadastro = "INSERT INTO arquivo (arquivo_cadastro_id, arquivo_candidato_id, arquivo_titulo, arquivo_descricao, arquivo_data) VALUES (0, '".$arquivo_candidato."', '".$arquivo_titulo."', '".$arquivo_descricao."','".$arquivo_data."')";
	
	$exeArquivoCadastro = mysqli_query($conexao,$sqlArquivoCadastro);
	$arquivo_id = mysqli_insert_id($conexao);
	//$verExcluirCadastro = mysqli_fetch_array($exeExcluirCadastro,MYSQLI_ASSOC);
	
	if($exeArquivoCadastro){
		
		if($arquivo_foto<>""){
				if(is_dir("arquivo/$arquivo_id/")){
					@rmdir("arquivo/$arquivo_id/");
					//echo "A Pasta Existe";
				}		
				@mkdir("arquivo/$arquivo_id/", 0777, true);			
				//chmod("../noticia/$pasta/", 0777);		

				$extensaoF1 = strtolower(pathinfo($_FILES["arquivo_foto"]["name"],PATHINFO_EXTENSION));		
				$novo_nomeF1 = md5(time()).".". $extensaoF1; //define o nome do arquivo

				//Grava Foto 1)
				$sqlGravaFoto = "UPDATE arquivo SET arquivo_foto = '".$novo_nomeF1."' WHERE arquivo.arquivo_id = '$arquivo_id'";			
				$exeGravaFoto = mysqli_query($conexao,$sqlGravaFoto);

				$target_dirF1 = "arquivo/$arquivo_id/";
				$target_fileF1 = $target_dirF1 . $novo_nomeF1;
				$uploadOkF1 = 1;
				$imageFileTypeF1 = strtolower(pathinfo($target_fileF1,PATHINFO_EXTENSION));
				
				// Check if image file is a actual image or fake image
				if(isset($_POST["submit"])) {
					$checkF1 = getimagesize($_FILES["arquivo_foto"]["tmp_name"]);
					if($checkF1 !== false) {
						$msg = "<div class='w3-panel w3-green'><h3>Ok!</h3><p>Arquivo é uma imagem - " . $check["mime"] . ".</p></div>";
						$uploadOkF1 = 1;
					} else {
						$msg = "<div class='w3-panel w3-red'><h3>Erro!</h3><p>O arquivo não é uma imagem</p></div>";
						$uploadOkF1 = 0;
					}
				}
				// Check if file already exists
				if (file_exists($target_fileF1)) {
					$msg .= "<div class='w3-panel w3-red'><h3>Erro!</h3><p>O arquivo não existente</p></div>";
					$uploadOkF1 = 0;
				}
				// Check file size
				if ($_FILES["premiacao_foto"]["size"] > 5000000) {
					$msg .= "<div class='w3-panel w3-red'><h3>Erro!</h3><p>O arquivo muito grande. Max: 5MB</p></div>";
					$uploadOkF1 = 0;
				}
				// Allow certain file formats
				if($imageFileTypeF1 != "jpg" && $imageFileTypeF1 != "png" && $imageFileTypeF1 != "jpeg" && $imageFileTypeF1 != "gif" && $imageFileTypeF1 != "bmp" && $imageFileTypeF1 != "mp4" && $imageFileTypeF1 != "WEBM" ) {
					$msg .= "<div class='w3-panel w3-red'><h3>Erro!</h3><p>Somente JPG, PNG, GIF, BMP, MP4 e WEBM são aceitos.</p></div>";
					$uploadOkF1 = 0;
				}
				// Check if $uploadOk is set to 0 by an error
				if ($uploadOkF1 == 0) {
					$msg .= "<div class='w3-panel w3-red'><h3>Erro!</h3><p>Arquivo não enviado</p></div>";
				// if everything is ok, try to upload file
				} else {
					if (move_uploaded_file($_FILES["arquivo_foto"]["tmp_name"], $target_fileF1)) {
						$msg .= "<h3 class='text-success'>Ok!</h3><p class='text-success'>O arquivo $novo_nomeF1 foi enviado</p>";
					}
				}
			} //Upload Foto1)
		
		$msg .= "<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>x</a>Sucesso: <strong>".$_POST['pesquisar_cpf']." Arquivo publicado.</strong></div>";		
	} else {
		$msg .= "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>x</a>Erro: <strong>".$_POST['pesquisar_cpf']." Arquivo não foi publicado.</strong></div>";
	}	
}

if(isset($_POST['excluir_arquivo_id'])){
	
	$arquivo_id = addslashes($_POST['excluir_arquivo_id']);
	
	$sqlArquivoExcluir = "DELETE FROM arquivo WHERE arquivo.arquivo_id = '$arquivo_id'";	
	$exeArquivoExcluir = mysqli_query($conexao,$sqlArquivoExcluir);
	
	if($exeArquivoExcluir){
		
		$msg .= "<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>x</a>Sucesso: <strong>Arquivo deletado.</strong></div>";		
	} else {
		$msg .= "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>x</a>Erro: <strong>Arquivo não foi excluido.</strong></div>";
	}	
}

?>
<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>Gato da Baixada - Sistema</title>

</head>

<body class="sub_page">

  <!-- portfolio section -->

  <section class="portfolio_section layout_padding">
    <div class="container">
      <div class="heading_container">
        <h2><a href="?pg=sistema">Sistema</a></h2>
        <p>Gerenciamento dos VOTOS do concurso</p>
      </div>

      <div class="layout_padding2-top">
        <div class="row">
			<div class="col-md-12 col-sm-6"><?php echo $msg; ?> </div>
		<?php
			if(isset($_SESSION['sistema_cpf'])){
				
				function descobrir_porcentagem($valor_base, $valor){
					return $valor / $valor_base * 100;
				}
				//Conta a Qtd de Todos os Votos
				$sqlConsultaTodosVotos = "SELECT count(*) AS TODOS FROM votacao WHERE votacao_status <> 'I'";
				$exeConsultaTodosVotos = mysqli_query($conexao,$sqlConsultaTodosVotos);		
				$verConsultaTodosVotos = mysqli_fetch_array($exeConsultaTodosVotos,MYSQLI_ASSOC);
				//$totalConsultaVotos = mysqli_num_rows($exeConsultaVotos);
				$totalConsultaTodosVotos = $verConsultaTodosVotos['TODOS'];

				//Conta a Qtd de Votos até o momento
				$sqlConsultaVotos = "SELECT count(*) AS TOTAL FROM votacao WHERE votacao.votacao_status = 'A' ORDER BY votacao.votacao_data DESC";
				$exeConsultaVotos = mysqli_query($conexao,$sqlConsultaVotos);		
				$verConsultaVotos = mysqli_fetch_array($exeConsultaVotos,MYSQLI_ASSOC);
				//$totalConsultaVotos = mysqli_num_rows($exeConsultaVotos);
				$totalConsultaVotos = $verConsultaVotos['TOTAL'];

				$apuracao_porcentagem = number_format(descobrir_porcentagem ($totalConsultaTodosVotos, $totalConsultaVotos), 2);
				
		?>
		<div class="col-md-12 col-sm-6">
			<p style="text-align: center; font-size: 0.8em; font-weight: bold;">Apuração dos votos:</p>
			<div class="progress">
				<div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?php echo $apuracao_porcentagem; ?>%" aria-valuenow="<?php echo $apuracao_porcentagem; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $apuracao_porcentagem; ?>%</div>
			</div>
		</div>
		<div style="clear: both;">&nbsp;</div>
			
		<div class="col-md-12 col-sm-6">
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Votação</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Premiação</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Publicação</a>
				</li>
			</ul>
			<div class="tab-content" id="myTabContent">
				
				<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
					<div style="clear: both;">&nbsp;</div>
					
					<div class="col-md-12 col-sm-6 text-center">
					<?php
						$sqlVotosP = "SELECT count(*) AS PENDENTE FROM votacao INNER JOIN cadastro ON votacao.votacao_cadastro_id = cadastro.cadastro_id WHERE cadastro.cadastro_status = 'P'";
						$exeVotosP = mysqli_query($conexao,$sqlVotosP);
						$verVotosP = mysqli_fetch_array($exeVotosP,MYSQLI_ASSOC);
						$totalVotosP = $verVotosP['PENDENTE']; 
				
						$sqlVotosA = "SELECT count(*) AS APROVADO FROM votacao INNER JOIN cadastro ON votacao.votacao_cadastro_id = cadastro.cadastro_id WHERE cadastro.cadastro_status = 'A'";
						$exeVotosA = mysqli_query($conexao,$sqlVotosA);
						$verVotosA = mysqli_fetch_array($exeVotosA,MYSQLI_ASSOC);
						$totalVotosA = $verVotosA['APROVADO'];
				
						$sqlVotosI = "SELECT count(*) AS REPROVADA FROM votacao INNER JOIN cadastro ON votacao.votacao_cadastro_id = cadastro.cadastro_id WHERE cadastro.cadastro_status = 'I'";
						$exeVotosI = mysqli_query($conexao,$sqlVotosI);
						$verVotosI = mysqli_fetch_array($exeVotosI,MYSQLI_ASSOC);
						$totalVotosI = $verVotosI['REPROVADA']; 
					?>
					<a href="?pg=sistema&pesquisar_status=P" class="btn btn-warning">
						PENDENTE <span class="badge badge-light"><?php echo $totalVotosP; ?></span>
					</a>
						
					<a href="?pg=sistema&pesquisar_status=A" class="btn btn-success">
						APROVADOS <span class="badge badge-light"><?php echo $totalVotosA; ?></span>
					</a>
						
					<a href="?pg=sistema&pesquisar_status=I" class="btn btn-danger">
						REPROVADOS <span class="badge badge-light"><?php echo $totalVotosI; ?></span>
					</a>
					
					</div>
					
					<div style="clear: both;">&nbsp;</div>
					
					<div class="col-md-12 col-sm-6">
						<form name="filtrar" method="post" action="">
							<input type="text" class="" id="pesquisar_cpf" name="pesquisar_cpf" placeholder="Pesquisar por CPF" value="<?php if(isset($_POST['pesquisar_cpf'])){ echo $_POST['pesquisar_cpf']; } ?>">&nbsp;					

							<input type="hidden" name="pg" value="<?php echo $_GET['pg']; ?>" />
							<select name="candidato_filtro">
								<option value="0">Todos</option>
						<?php
							  $sqlCandidato = "SELECT * FROM candidato";
							  $exeCandidato = mysqli_query($conexao,$sqlCandidato);					  
							  while($verCandidato = mysqli_fetch_array($exeCandidato,MYSQLI_ASSOC)){
						?>
								<option value="<?php echo $verCandidato['candidato_id'] ?>" <?php if($_POST['candidato_filtro']==$verCandidato['candidato_id']) echo "selected" ?> ><?php echo utf8_encode($verCandidato['candidato_nome']); ?></option>					
						<?php
							  }
						?>	
							</select>					
							<button type="submit" class="btn btn-primary">Filtrar</button>
						</form>
					</div>
					
					<div style="clear: both;">&nbsp;</div>
			
					<div class="col-md-12 col-sm-6">
				<table width="100%" class="table">
				  <thead>
					<tr>
					  <th scope="col">#</th>					  
					  <th scope="col">CPF</th>					  
					  <th scope="col">Status</th>
					  <th scope="col">Candidato</th>
					  <th scope="col">Data do Voto</th>
					  <th scope="col">&nbsp;</th>
					</tr>
				  </thead>
				  <tbody>
				<?php
					  $sqlVotos = "SELECT * FROM votacao INNER JOIN cadastro ON votacao.votacao_cadastro_id = cadastro.cadastro_id INNER JOIN candidato ON votacao.votacao_candidato_id = candidato.candidato_id WHERE votacao.votacao_id>0 $query_candidato $query_pesquisar_cpf $query_status ORDER BY votacao.votacao_data DESC";
					  $exeVotos = mysqli_query($conexao,$sqlVotos);
//					  /$totalConsultaCpf = mysqli_num_rows($exeConsultaCpf);
					  echo "<h3 style='text-align:center; color:red;'>Total de votos: <strong>".$totalVotos = mysqli_num_rows($exeVotos)."</strong></h3>";
				
						$total_reg = "500"; // número de registros por página	
						//$pagina = $_GET['pagina']; 			
						if(isset($_GET['pagina'])){ $pc = $_GET['pagina']; }else{ $pc = "1"; }
						//if (!$_GET['pagina']) { $pc = "1"; } else { $pc = $_GET['pagina']; }
						$inicio = $pc - 1;
						$inicio = $inicio * $total_reg;

						$exeVotos = mysqli_query($conexao, $sqlVotos." LIMIT $inicio,$total_reg");
						//$verVotos = mysqli_query($conexao,$exeVotos);
						$tr = mysqli_num_rows($exeVotos); // verifica o número total de registros
						$tp = $tr / $total_reg; // verifica o número total de páginas
					  	$contador = $tr;
						echo "<p class='text-center'>Mostrando ".$tr." de ".$totalVotos."</p>";
					  while($verVotos = mysqli_fetch_array($exeVotos,MYSQLI_ASSOC)){
				?>
					  <tr>
						  <td><?php echo $contador; //$verVotos['votacao_id']; ?></td>
						  <td><p><a href="https://servicos.receita.fazenda.gov.br/servicos/cpf/consultasituacao/ConsultaPublica.asp?CPF=<?php echo mascara_cpf($verVotos['cadastro_cpf']); ?>&NASCIMENTO=<?php echo date("d/m/Y", strtotime($verVotos['cadastro_nascimento'])); ?>" target="_blank"><?php echo mascara_cpf($verVotos['cadastro_cpf']); ?></a><br>
							  <span style="font-size: 0.8em;">Nascimento: <?php echo date("d/m/Y", strtotime($verVotos['cadastro_nascimento'])); ?></span></p>
						  </td>
						  
						  <td><?php if($verVotos['votacao_status']=="I"){ echo "<span class='badge badge-danger'>REPROVADO</span>";  $btn = ""; $btnSelect = "btn-danger"; } elseif($verVotos['votacao_status']=="P"){ echo "<span class='badge badge-warning'>PENDENTE</span>";  $btn = "disabled"; $btnSelect = "btn-warning";} else { echo "<span class='badge badge-success'>APROVADO</span>"; $btn = "disabled"; $btnSelect = "btn-success"; } ?></td>
						  <td>
							  <img src="images/p-<?php echo $verVotos['candidato_id']; ?>.jpg" alt="" style="max-width: 60px;">
							<?php echo utf8_encode($verVotos['candidato_nome']); ?>
							  
						  </td>
						  <td><span style="font-size: 0.8em;"><?php echo date("d/m/Y H:i:s", strtotime($verVotos['votacao_data'])); ?></span></td>					  
						  
						  <td>
							  <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#cadastro<?php echo $verVotos['cadastro_cpf']; ?>"> Editar</button>
							  
							  <div class="modal fade" id="cadastro<?php echo $verVotos['cadastro_cpf']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
								  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
									  <div class="modal-content">
										  <div class="modal-header">
											  <h5 class="modal-title">Confirme o Cadastro e o voto:</h5>
											  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
										  </div>
										  <form name="excluir_voto<?php echo $verVotos['cadastro_cpf']; ?>" method="post" action="">
										  <div class="modal-body">											  
											  <p>
											  <select name="excluir_votacao_status" class=" <?php echo $btnSelect; ?>" required>
												  <option value="P" <?php if($verVotos['cadastro_status']=="P") echo "selected"; ?> >Pendente de Aprovação</option>
												  <option value="A" <?php if($verVotos['cadastro_status']=="A") echo "selected"; ?> >Aprovado</option>
												  <option value="I" <?php if($verVotos['cadastro_status']=="I") echo "selected"; ?>>Reprovado</option>
												  
												  <option value="E" <?php if($verVotos['cadastro_status']=="E") echo "selected"; ?>>EXCLUIR</option>
												  
											  </select>
											  </p>												
											  <p>CPF: <strong><a href="https://servicos.receita.fazenda.gov.br/servicos/cpf/consultasituacao/ConsultaPublicaSonoro.asp?CPF=<?php echo mascara_cpf($verVotos['cadastro_cpf']); ?>&NASCIMENTO=<?php echo date("d/m/Y", strtotime($verVotos['cadastro_nascimento'])); ?>" target="_blank"><?php echo mascara_cpf($verVotos['cadastro_cpf']); ?></a></strong></p>
											  <p>Data de Nascimento: <?php echo date("d/m/Y", strtotime($verVotos['cadastro_nascimento'])); ?></p>
											  <p>Data do registro do voto <?php echo date("d/m/Y H:i:s", strtotime($verVotos['votacao_data'])); ?></p>												
											  <p>IP: <strong><?php echo ($verVotos['cadastro_ip']); ?></strong></p>
											  
											  <!--<p>Outras informações:</p>
											  <p><textarea class="form-control"><?php //echo ($verVotos['cadastro_descricao']); ?></textarea></p>-->
											  
											  <input type="hidden" name="excluir_votacao_id" value="<?php echo $verVotos['votacao_id']; ?>" />  
											  <input type="hidden" name="excluir_cadastro_id" value="<?php echo $verVotos['cadastro_id']; ?>" />
											  <input type="hidden" name="excluir_cadastro_cpf" value="<?php echo $verVotos['cadastro_cpf']; ?>" />
											  
											  <input type="hidden" name="candidato_filtro" value="<?php echo $_POST['candidato_filtro']; ?>">
											  
										  </div>
										  <div class="modal-footer">
											  <button type="submit" class="btn btn-warning">Editar Status</button>
											  <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
										  </div>
										  </form>
										  
									  </div>
								  </div>
							  </div>
							  
						  </td>
						</tr>
				<?php
						$contador--;
					  }					  
				?>
					
				  </tbody>
				</table>				
			</div>
					<div style="clear: both;">&nbsp;</div>
				
		  			<div style="position: relative; float: left; width: 100%; margin: 1% auto; text-align: center;">
				<?php
					// agora vamos criar os botões "Anterior e próximo"
					$anterior = $pc -1;
					$proximo = $pc +1;
					//echo "<script>alert('$proximo')</script>";
					if ($pc>1) { echo " <a href='?pg=sistema&pagina=$anterior' class='btn btn-sm btn-warning' role='button'><- Anterior</a>"; }				
					if ($pc<$tp) {echo " <a href='?pg=sistema&pagina=$proximo' class='btn btn-sm btn-warning' role='button'>Próxima -></a>";}
				?>
				</div>
					
				</div>
				
				<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
					
					<div style="clear: both;">&nbsp;</div>
					<div class="col-md-12 col-sm-6">
						<table width="100%" class="table">
						  <thead>
							<tr>
							  <th scope="col">#</th>					  
							  <th scope="col">Foto / Titulo / Descrição</th>							  
							  <th scope="col">Data</th>							  
							  <th scope="col" class="text-right">
								  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Premiacao"> + Premiação</button>								  
							  </th>
							  <div class="modal fade" id="Premiacao" tabindex="-1" role="dialog" aria-labelledby="exampleModal" aria-hidden="true">
									  <div class="modal-dialog modal-lg" role="document">
				  <div class="modal-content">
					  <div class="modal-header">
						  <h5 class="modal-title">Informe a Premiação</h5>
						  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
					  </div>
					  <form name="premiacao_form" method="post" action="" enctype="multipart/form-data">
					  <div class="modal-body">											  

						  <p>Titulo: <input class="form-control" type="text" name="premiacao_titulo" value="" /></p>
						  <p>Doado por: <textarea class="form-control" name="premiacao_descricao"></textarea></p>
						  <p>Foto: <input class="form-control" type="file" name="premiacao_foto" /></p> 
						  <input type="hidden" name="premiacao_data" value="<?php echo date("Y-m-d H:i:s"); ?>" />
						  <input type="hidden" name="premiacao_cadastrar" value="sim" />

					  </div>
					  <div class="modal-footer">
						  <button type="submit" class="btn btn-warning">Cadastrar Premiação</button>
						  <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
					  </div>
					  </form>

				  </div>
			  </div>
								  </div>
							</tr>
						  </thead>
						  <tbody>
						<?php
							  $sqlPremiacao = "SELECT * FROM premiacao ORDER BY premiacao.premiacao_data DESC";
							  $exePremiacao = mysqli_query($conexao,$sqlPremiacao);							  
							  echo "<h3 style='text-align:center; color:red;'>Total de prêmios: <strong>".$totalPremiacao = mysqli_num_rows($exePremiacao)."</strong></h3>";
				
							  $contadorPremiacao = 1;

							  while($verPremiacao = mysqli_fetch_array($exePremiacao,MYSQLI_ASSOC)){
						?>
							  <tr>
								  <td><?php echo $contadorPremiacao; //$verPremiacao['premiacao_id']; ?></td>
								  <td><p><?php echo utf8_encode($verPremiacao['premiacao_titulo']); ?><br><img src="premiacao/<?php echo $verPremiacao['premiacao_id']; ?>/<?php echo $verPremiacao['premiacao_foto']; ?>" alt="" style="max-width: 80px;"><br>
									  <span style="font-size: 0.8em;"><?php echo utf8_decode($verPremiacao['premiacao_descricao']); ?></span>
									  </p></td>
								  
								  <td><?php echo date("d/m/Y", strtotime($verPremiacao['premiacao_data'])); ?></td>
								  
								  <td class="text-right">
									  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#premiacao<?php echo $verPremiacao['premiacao_id']; ?>"> Excluir</button>
								  </td>
								  <div class="modal fade" id="premiacao<?php echo $verPremiacao['premiacao_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
										  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
											  <div class="modal-content">
												  <div class="modal-header">
													  <h5 class="modal-title">Excluir a premiação?</h5>
													  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
												  </div>
												  <form name="excluir_premiacao<?php echo $verPremiacao['premiacao_id']; ?>" method="post" action="">
												  <div class="modal-body">											  
													  
													  <p>Premiação: <strong><?php echo utf8_encode($verPremiacao['premiacao_titulo']); ?></strong></p>
													  <p>Doador: <br><strong><?php echo utf8_encode($verPremiacao['premiacao_descricao']); ?></strong></p>

													  <input type="hidden" name="excluir_premiacao_id" value="<?php echo $verPremiacao['premiacao_id']; ?>" />  
													  

												  </div>
												  <div class="modal-footer">
													  <button type="submit" class="btn btn-danger">Excluir premiação</button>
													  <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
												  </div>
												  </form>

											  </div>
										  </div>
									  </div>
								</tr>
						<?php
								$contadorPremiacao++;
							  }					  
						?>

						  </tbody>
						</table>				
					</div>
					
				</div>
				<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
					
					<div style="clear: both;">&nbsp;</div>
					<div class="col-md-12 col-sm-6">
						<table width="100%" class="table">
						  <thead>
							<tr>
							  <th scope="col">#</th>					  
							  <th scope="col">Foto/Video</th>							  
							  <th scope="col">Data</th>							  
							  <th scope="col" class="text-right">
								  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#Arquivo"> + Publicações</button>							  
							  </th>
							  <div class="modal fade" id="Arquivo" tabindex="-1" role="dialog" aria-labelledby="exampleModal" aria-hidden="true">
			  <div class="modal-dialog modal-lg" role="document">
				  <div class="modal-content">
					  <div class="modal-header">
						  <h5 class="modal-title">Publique fotos ou videos</h5>
						  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
					  </div>
					  <form name="arquivo_form" method="post" action="" enctype="multipart/form-data">
					  <div class="modal-body">											  

						  <p>Titulo: <input class="form-control" type="text" name="arquivo_titulo" value="" /></p>
						  <p>Texto: <textarea name="arquivo_descricao" class="form-control"></textarea></p>
						  <p><select name="arquivo_candidato" required>
<option value="0">Todos</option>
<option value="1">Nézio Popular Botoado</option>
<option value="2">Mauro Popular Gauchinho</option>
<option value="3">Névez Popular Belo de Acorizal</option>
<option value="4">Ronail</option>
<option value="5">Luciano Popular Jagunço</option>
<option value="6">Ditão Popular Tubarão</option>
<option value="7">Matheus Popular Papagaio</option>
</select></p>
						  <p>Foto / Video: <input class="form-control" type="file" name="arquivo_foto" /></p> 
						  <input type="hidden" name="arquivo_data" value="<?php echo date("Y-m-d H:i:s"); ?>" />
						  <input type="hidden" name="arquivo_cadastrar" value="sim" />

					  </div>
					  <div class="modal-footer">
						  <button type="submit" class="btn btn-success">Publicar</button>
						  <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
					  </div>
					  </form>

				  </div>
			  </div>
		  </div>
							</tr>
						  </thead>
						  <tbody>
						<?php
							  $sqlArquivo = "SELECT * FROM arquivo ORDER BY arquivo.arquivo_data DESC";
							  $exeArquivo = mysqli_query($conexao,$sqlArquivo);							  
							  echo "<h3 style='text-align:center; color:red;'>Total de Foto/Video: <strong>".$totalArquivo = mysqli_num_rows($exeArquivo)."</strong></h3>";
				
							  $contadorArquivos = $totalArquivo;

							  while($verArquivo = mysqli_fetch_array($exeArquivo,MYSQLI_ASSOC)){
						?>
							  <tr>
								  <td><?php echo $contadorArquivos; //$verArquivo['arquivo_id']; ?></td>
								  <td>
									  <p><?php echo utf8_decode($verArquivo['arquivo_titulo']); ?><br>
									  <img src="arquivo/<?php echo $verArquivo['arquivo_id']; ?>/<?php echo $verArquivo['arquivo_foto']; ?>" alt="" style="max-width: 80px;"><br>
										<span style="font-size: 0.8em;"><?php echo utf8_decode($verArquivo['arquivo_descricao']); ?></span>
										  
									  </p>
								  </td>
								  <td><span style="font-size: 0.8em;"><?php echo date("d/m/Y", strtotime($verArquivo['arquivo_data'])); ?></span></td>
								  
								  <td class="text-right">
									  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#arquivo<?php echo $verArquivo['arquivo_id']; ?>"> Excluir</button>
								  </td>
								  <div class="modal fade" id="arquivo<?php echo $verArquivo['arquivo_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
									  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
										  <div class="modal-content">
											  <div class="modal-header">
												  <h5 class="modal-title">Excluir Foto/Video?</h5>
												  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
											  </div>
											  <form name="excluir_arquivo<?php echo $verArquivo['arquivo_id']; ?>" method="post" action="">
											  <div class="modal-body">											  

												  <p>Foto/Video: <strong><?php echo utf8_encode($verArquivo['arquivo_titulo']); ?></strong></p>
												  <p>Doador: <br><strong><?php echo utf8_encode($verArquivo['arquivo_descricao']); ?></strong></p>

												  <input type="hidden" name="excluir_arquivo_id" value="<?php echo $verArquivo['arquivo_id']; ?>" />  


											  </div>
											  <div class="modal-footer">
												  <button type="submit" class="btn btn-danger">Excluir Foto/Video</button>
												  <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
											  </div>
											  </form>

										  </div>
									  </div>
								  </div>
								</tr>
						<?php
								$contadorArquivos--;
							  }					  
						?>

						  </tbody>
						</table>				
					</div>
				
				</div>
			</div>
		</div>
			
			
		<?php
			} else { 
		?>
			<div class="col-md-12 col-sm-6">				
				<form name="login_form" method="post">
					<div class="form-group">						
						<input type="text" class="form-control" id="login_cpf" name="login_cpf" placeholder="Informe o CPF" required>						
					</div>
					<div class="form-group">						
						<input type="password" class="form-control" id="login_senha" name="login_senha" placeholder="Senha" required>
					</div>
					<div style="clear: both;">&nbsp;</div>
					<button type="submit" class="btn btn-primary">Acessar o sistema</button>
				</form>
			</div>
			
		<?php
			}
		?>
        </div>
      </div>
      
    </div>
  </section>



</body>

</html>