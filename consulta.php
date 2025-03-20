<?php

if(isset($_POST['pesquisar_cpf']) && $_POST['pesquisar_cpf']<>""){
	$pesquisar_cpf = addslashes(preg_replace("/[^0-9]/", "", $_POST['pesquisar_cpf']));
	$query_pesquisar_cpf = " AND cadastro.cadastro_cpf = '".$pesquisar_cpf."' ";
	//$msg .= "<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>x</a>Pesquisando por CPF: <strong>".$_POST['pesquisar_cpf']."</strong></div>";
} else {
	$query_pesquisar_cpf = "";
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sem título</title>
</head>

<body class="sub_page">

  <!-- portfolio section -->

  <section class="portfolio_section layout_padding">
    <div class="container">
      <div class="heading_container">
	<h3>Informe o CPF para realizar a consulta do voto:</h3>
	    <div class="col-md-12 col-sm-6">
<form name="filtrar" method="post" action="">
<input type="text" class="" id="pesquisar_cpf" name="pesquisar_cpf" placeholder="Pesquisar por CPF" value="" maxlength="14">&nbsp;
<input type="hidden" name="pg" value="consulta">
<p>&nbsp;</p>
<button type="submit" class="btn btn-primary">Consultar Voto</button>
</form>
</div>
		<?php
		  if(isset($_POST['pesquisar_cpf']) && $_POST['pesquisar_cpf']<>""){
		  ?>
		  <div class="col-md-12 col-sm-6">
				<table width="100%" class="table">
				<?php
					  
					  $sqlVotos = "SELECT * FROM votacao INNER JOIN cadastro ON votacao.votacao_cadastro_id = cadastro.cadastro_id INNER JOIN candidato ON votacao.votacao_candidato_id = candidato.candidato_id WHERE votacao.votacao_id>0 $query_pesquisar_cpf ";
					  $exeVotos = mysqli_query($conexao,$sqlVotos);
			  		  $totalVotos = mysqli_num_rows($exeVotos);
					  //echo "<h3 style='text-align:center; color:red;'>Total de votos: <strong>".$totalVotos = mysqli_num_rows($exeVotos)."</strong></h3>";
			  		  if($totalVotos==0){ 
						  echo $msg .= "<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>x</a>Este CPF: <strong>".$_POST['pesquisar_cpf']."</strong> não votou ainda.</div>";
						  //echo "Este CPF não votou ainda.";
					  } else { 			  
				
					  $verVotos = mysqli_fetch_array($exeVotos,MYSQLI_ASSOC);
				?>
					<thead>
					<tr>
					  <th scope="col">#</th>					  
					  <th scope="col">CPF</th>					  
					  <th scope="col">Candidato</th>
					  <th scope="col">Data do Voto</th>
					  <th scope="col">&nbsp;</th>
					</tr>
				  </thead>
				  <tbody>
				
					  <tr>
						  <td><?php echo $verVotos['votacao_id']; ?></td>
						  <td><p><a href="https://servicos.receita.fazenda.gov.br/servicos/cpf/consultasituacao/ConsultaPublica.asp?CPF=<?php echo mascara_cpf($verVotos['cadastro_cpf']); ?>&NASCIMENTO=<?php echo date("d/m/Y", strtotime($verVotos['cadastro_nascimento'])); ?>" target="_blank"><?php echo mascara_cpf($verVotos['cadastro_cpf']); ?></a><br>
							  <span style="font-size: 0.8em;">Nascimento: <?php echo date("d/m/Y", strtotime($verVotos['cadastro_nascimento'])); ?></span></p>
							  <p><?php if($verVotos['votacao_status']=="I"){ echo "<span class='badge badge-danger'>REPROVADO</span>"; $btnSelect = "btn-danger"; } elseif($verVotos['votacao_status']=="P"){ echo "<span class='badge badge-warning'>PENDENTE</span>"; $btnSelect = "btn-warning";} else { echo "<span class='badge badge-success'>APROVADO</span>"; $btn = "disabled"; $btnSelect = "btn-success"; } ?></p>
						  </td>
						  
						  <td>
							  <img src="images/p-<?php echo $verVotos['candidato_id']; ?>.jpg" alt="" style="max-width: 60px;">
							<?php echo utf8_encode($verVotos['candidato_nome']); ?>
							  
						  </td>
						  <td><span style="font-size: 0.8em;"><?php echo date("d/m/Y H:i:s", strtotime($verVotos['votacao_data'])); ?></span></td>					  
						  
						  <td>
							  <button type="button" class="btn btn-warning <?php echo $btn; ?>" data-toggle="modal" data-target="#cadastro<?php echo $verVotos['cadastro_cpf']; ?>"> Ver</button>
							  
							  <div class="modal fade" id="cadastro<?php echo $verVotos['cadastro_cpf']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
								  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
									  <div class="modal-content">
										  <div class="modal-header">
											  <h5 class="modal-title">Informações do Cadastro e do voto:</h5>
											  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
										  </div>
										  
										  <div class="modal-body">											  
											  <p>
											  <select name="excluir_votacao_status" class="form-control <?php echo $btnSelect; ?>" required disabled>
												  <option value="P" <?php if($verVotos['cadastro_status']=="P") echo "selected"; ?> >Pendente de Aprovação</option>
												  <option value="A" <?php if($verVotos['cadastro_status']=="A") echo "selected"; ?> >Aprovado</option>
												  <option value="I" <?php if($verVotos['cadastro_status']=="I") echo "selected"; ?>>Reprovado</option>
											  </select>
											  </p>												
											  <p>CPF: <strong><a href="https://servicos.receita.fazenda.gov.br/servicos/cpf/consultasituacao/ConsultaPublicaSonoro.asp?CPF=<?php echo mascara_cpf($verVotos['cadastro_cpf']); ?>&NASCIMENTO=<?php echo date("d/m/Y", strtotime($verVotos['cadastro_nascimento'])); ?>" target="_blank"><?php echo mascara_cpf($verVotos['cadastro_cpf']); ?></a></strong></p>
											  <p>Data de Nascimento: <?php echo date("d/m/Y", strtotime($verVotos['cadastro_nascimento'])); ?></p>
											  <p>Data do registro do voto <?php echo date("d/m/Y H:i:s", strtotime($verVotos['votacao_data'])); ?></p>												
											  <p>IP: <strong><?php echo ($verVotos['cadastro_ip']); ?></strong></p>
											  
										  </div>
										  <div class="modal-footer">
											  
											  <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
										  </div>
										  
										  
									  </div>
								  </div>
							  </div>
							  
						  </td>
						</tr>
					  
				  </tbody>
				<?php	
					  }
				?>
				</table>				
			</div>
		  
		  <div class="col-md-12 col-sm-6">
			  <h5 style="font-size: 0.8em; color: red;">*Caso o voto seja REPROVADO, signfica que você informou a data de nascimento incorreta, assim, entre em contato com administrador e informe seu CPF para que você possa realizar o voto corretamente.</h5>
			  <h3><a href="https://api.whatsapp.com/send?l=pt_br&phone=5565999188717&text=Gato+da+Baixada:+Erro+CPF" target="_blank">+55 65 9 9918-8717</a></h3>
		  </div>
		<?php
			}
		?>
	  </div>
	  </div>
	</section>
</body>
</html>