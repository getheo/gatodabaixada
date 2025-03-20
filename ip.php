<?php

if(isset($_POST['pesquisar_ip']) && $_POST['pesquisar_ip']<>""){
	$pesquisar_ip = addslashes(preg_replace("/[^0-9]/", "", $_POST['pesquisar_ip']));
	$query_pesquisar_ip = " AND cadastro.cadastro_ip = '".$pesquisar_ip."' ";
	//$msg .= "<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>x</a>Pesquisando por CPF: <strong>".$_POST['pesquisar_cpf']."</strong></div>";
} else {
	$query_pesquisar_ip = "";
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
	<h3>Informe o IP para realizar a consulta do voto:</h3>
	    <div class="col-md-12 col-sm-6">
<form name="filtrar" method="post" action="">
<input type="text" class="" id="pesquisar_ip" name="pesquisar_ip" placeholder="Pesquisar por IP" value="" maxlength="14">&nbsp;
<input type="hidden" name="pg" value="consulta">
<p>&nbsp;</p>
<button type="submit" class="btn btn-primary">Consultar IP</button>
</form>
</div>
		<?php
		  //if(isset($_POST['pesquisar_ip']) && $_POST['pesquisar_ip']<>""){
		  ?>
		  <div class="col-md-12 col-sm-6">
			  	<?php
					//$sqlCadastroIP = "SELECT * FROM cadastro GROUP BY cadastro.cadastro_ip ORDER BY cadastro_id DESC ";
			  
			  		$sqlCadastroIP = "SELECT cadastro_ip, COUNT(cadastro_ip) AS TOTAL FROM cadastro GROUP BY cadastro_ip ORDER BY COUNT(cadastro_ip) DESC";
						
					$exeCadastroIP = mysqli_query($conexao,$sqlCadastroIP);
					echo "<h3 class='text-center'>".$verCadastroIP = mysqli_num_rows($exeCadastroIP)."</h3>";
				?>
				<table width="100%" class="table">
					<thead>
					<tr>					  					  
					  <th scope="col" width="30%">IP</th>
					  
					  <th scope="col" width="70%">Cadastro</th>					  					  
					</tr>
				  </thead>
				<?php
					while($verCadastroIP = mysqli_fetch_array($exeCadastroIP,MYSQLI_ASSOC)){						
				?>					
				  	<tbody>				
					  <tr>
						  <td><?php echo $verCadastroIP['cadastro_ip']; ?></td>	
						  <!--<td><?php //echo $verCadastroIP['TOTAL']; ?></td>	-->
						  
						  <td>
						<?php
							$tam = strlen($verCadastroIP['cadastro_ip']); // Verifica o tamanho do texto.
							$max = 15; // exibirá apenas os 400 primeiros caracteres de um texto.
							// Se o texto for maior do que 14, retira o restante.
							if($tam > $max) { $remote_addr_corrigido = substr($verCadastroIP['cadastro_ip'], 0, $max - $tam);}
							else { $remote_addr_corrigido = $verCadastroIP['cadastro_ip'];}
						
							//Verifica quantos Cadastro (votos) cada IP fez
							$sqlVerIPCad = "SELECT * FROM cadastro WHERE cadastro.cadastro_ip LIKE '%$remote_addr_corrigido%' ORDER BY cadastro_data DESC";
							$exeVerIPCad = mysqli_query($conexao,$sqlVerIPCad);
							echo "<p style='text-align: left;'>Voto(s): <strong>".$totalVerIPCad = mysqli_num_rows($exeVerIPCad)."</strong></p>";
							while($verVerIPCad = mysqli_fetch_array($exeVerIPCad,MYSQLI_ASSOC)){
						?>
							<p style="text-align: left;"><a href="https://servicos.receita.fazenda.gov.br/servicos/cpf/consultasituacao/ConsultaPublica.asp?CPF=<?php echo mascara_cpf($verVerIPCad['cadastro_cpf']); ?>&NASCIMENTO=<?php echo date("d/m/Y", strtotime($verVerIPCad['cadastro_nascimento'])); ?>" target="_blank">					  
							<?php echo mascara_cpf($verVerIPCad['cadastro_cpf']); ?></a><br>
							<span style="font-size: 0.8em;"><?php echo date("d/m/Y", strtotime($verVerIPCad['cadastro_nascimento'])); ?></span><br>
							  
							<span style="font-size: 0.8em;"><?php echo date("d/m/Y H:i:s", strtotime($verVerIPCad['cadastro_data'])); ?></span></p>
						<?php
							}							
						?>
						  </td>
						  					  
						  						  
						</tr>
					  
				  	</tbody>									
				
				<?php	
					  }
				?>
				</table>				
			</div>
		  
		<?php
			//}
		?>
	  </div>
	  </div>
	</section>
</body>
</html>