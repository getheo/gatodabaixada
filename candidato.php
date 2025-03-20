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

  <title>Gato da Baixada</title>

</head>

<body class="sub_page">

  <!-- portfolio section -->

  <section class="portfolio_section layout_padding">
    <div class="container">
      <div class="heading_container">
        <h2>Candidatos</h2>
        <p>Confira o Perfil de cada um dos candidatos</p>
      </div>

      <div class="layout_padding2-top">
        <div class="row">
		<?php
			function descobrir_porcentagem($valor_base, $valor){
				return $valor / $valor_base * 100;
			}
			//Conta a Qtd de Votos até o momento
			$sqlConsultaVotos = "SELECT count(*) AS TOTAL FROM votacao WHERE votacao.votacao_status = 'A' ORDER BY votacao.votacao_data DESC";
			$exeConsultaVotos = mysqli_query($conexao,$sqlConsultaVotos);		
			$verConsultaVotos = mysqli_fetch_array($exeConsultaVotos,MYSQLI_ASSOC);
			//$totalConsultaVotos = mysqli_num_rows($exeConsultaVotos);
			$totalConsultaVotos = $verConsultaVotos['TOTAL'];
			
			if(isset($_GET['candidato'])){
				
		?>
			<div class="col-md-4 col-sm-6">
				<div class="img-box" style="text-align: center;">
				  <img src="images/p-<?php echo $_GET['candidato']; ?>.jpg" alt="" style="max-width: 280px;">
				  <a href="?pg=candidato&candidato=<?php echo $_GET['candidato']; ?>">
					<img src="images/link.png" alt="">
				  </a>
				</div>
			</div>
			
			<div class="col-md-4 col-sm-6">
			<?php
				//Sql Lista Candidatos
				$sqlListaCandidatos = "SELECT * FROM candidato WHERE candidato.candidato_id = '".$_GET['candidato']."'";
				$exeListaCandidatos = mysqli_query($conexao,$sqlListaCandidatos);		
				
				//$totalListaCandidatos = mysqli_num_rows($exeListaCandidatos);				
				$verListaCandidatos = mysqli_fetch_array($exeListaCandidatos,MYSQLI_ASSOC);
			?>
				<h3 style="text-align: center;"><?php echo $nome = utf8_encode($verListaCandidatos['candidato_nome']); ?></h3>
				<p style="text-align: center;"><?php echo $idade = $verListaCandidatos['candidato_descricao'];?></p>				
				
				<div class="btn-box" style="display: none;">
					<a href="#" data-link="https://gatodabaixada.com.br/?pg=candidato&candidato=<?php echo $verListaCandidatos['candidato_id']; ?>" data-text="<?php echo $nome; ?>" class="whatsapp"><i class="fab fa-whatsapp-square">Compartilhar</i></a>
					
					<a href="https://gatodabaixada.com.br/?pg=candidato&candidato=<?php echo $_GET['perfil']; ?>">Compartilhar</a>
				</div>
			</div>
			
			<div class="col-md-4 col-sm-6 text-left">
		<?
			//Conta a Qtd de Votos Candidatos validos
			$sqlVotosCandidato = "SELECT count(*) AS CANDIDATO FROM votacao WHERE votacao.votacao_status = 'A' AND votacao.votacao_candidato_id = '".$_GET['candidato']."'";
			$exeVotosCandidato = mysqli_query($conexao,$sqlVotosCandidato);		
			$verVotosCandidato = mysqli_fetch_array($exeVotosCandidato,MYSQLI_ASSOC);
			//$totalConsultaVotos = mysqli_num_rows($exeVotosCandidato1);
			$candidato = $verVotosCandidato['CANDIDATO'];			
			$candidato_porcentagem = number_format(descobrir_porcentagem ($totalConsultaVotos, $candidato), 2);
				
			//Conta a Qtd de Votos invalidos
			$sqlVotosCandidatoI = "SELECT count(*) AS INVALIDO FROM votacao WHERE votacao.votacao_status = 'I' AND votacao.votacao_candidato_id = '".$_GET['candidato']."'";
			$exeVotosCandidatoI = mysqli_query($conexao,$sqlVotosCandidatoI);		
			$verVotosCandidatoI = mysqli_fetch_array($exeVotosCandidatoI,MYSQLI_ASSOC);
			//$totalConsultaVotos = mysqli_num_rows($exeVotosCandidato1);
			$candidatoI = $verVotosCandidatoI['INVALIDO'];
		?>
				<p class="text-center">Votos:</p>
				<h3 class="text-center"><span class="badge badge-success">Aprovados: <strong><? echo $candidato; ?></strong></span> <span class="badge badge-danger">Reprovados: <strong><? echo $candidatoI; ?></strong></span></h3>
				<div class="progress" style="width: 92%; margin: 2% 4%;"><div class="progress-bar" role="progressbar" style="width: <?php echo $candidato_porcentagem; ?>%;" aria-valuenow="<?php echo $candidato_porcentagem; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $candidato_porcentagem; ?>%</div></div>
			</div>
			
			
			
			<div class="col-md-4 col-sm-6 text-right">
				
				<div class="btn-box"><a href="https://gatodabaixada.com.br/?pg=candidato">Todos os candidatos</a></div>
				
			</div>
			
			<div class="col-md-4 col-sm-6 text-left">
				
				<div class="btn-box"><a href="https://gatodabaixada.com.br/?pg=resultado">Resultado Final</a></div>
				
			</div>
			
		<?php
			} else { 
		?>
			
          <div class="col-md-3 col-sm-6">
            <div class="img-box">
              <img src="images/p-1.jpg" alt="" style="max-width: 280px; text-align: center;">
              <a href="?pg=candidato&candidato=1">
                <img src="images/link.png" alt="">
              </a>
            </div>
          </div>
          <div class="col-md-3 col-sm-6">
            <div class="img-box">
              <img src="images/p-2.jpg" alt="" style="max-width: 280px; text-align: center;">
              <a href="?pg=candidato&candidato=2">
                <img src="images/link.png" alt="">
              </a>
            </div>
          </div>
          <div class="col-md-3 col-sm-6">
            <div class="img-box">
              <img src="images/p-3.jpg" alt="" style="max-width: 280px; text-align: center;">
              <a href="?pg=candidato&candidato=3">
                <img src="images/link.png" alt="">
              </a>
            </div>
          </div>
          <div class="col-md-3 col-sm-6">
            <div class="img-box">
              <img src="images/p-4.jpg" alt="" style="max-width: 280px; text-align: center;">
              <a href="?pg=candidato&candidato=4">
                <img src="images/link.png" alt="">
              </a>
            </div>
          </div>
          <div class="col-md-3 col-sm-6">
            <div class="img-box">
              <img src="images/p-5.jpg" alt="" style="max-width: 280px; text-align: center;">
              <a href="?pg=candidato&candidato=5">
                <img src="images/link.png" alt="">
              </a>
            </div>
          </div>
          <div class="col-md-3 col-sm-6">
            <div class="img-box">
              <img src="images/p-6.jpg" alt="" style="max-width: 280px; text-align: center;">
              <a href="?pg=candidato&candidato=6">
                <img src="images/link.png" alt="">
              </a>
            </div>
          </div>			
		  <div class="col-md-3 col-sm-6">
            <div class="img-box">
              <img src="images/p-7.jpg" alt="" style="max-width: 280px; text-align: center;">
              <a href="?pg=candidato&candidato=7">
                <img src="images/link.png" alt="">
              </a>
            </div>
          </div>
			
		<?php
			}
		?>
			
			<div class="col-md-12 col-sm-6">				
				<p></p>
				<h2>Acontecimentos:</h2>
				
				<ul class="timeline">				
				<?php
					if(isset($_GET['candidato']) && $_GET['candidato']<>""){
						$query_candidato = " AND arquivo.arquivo_candidato_id = '".$_GET['candidato']."'"; 
					} else { $query_candidato = "";}
						
					//Sql Lista Publicacoes
					$sqlArquivo = "SELECT * FROM arquivo INNER JOIN candidato ON arquivo.arquivo_candidato_id = candidato.candidato_id WHERE arquivo.arquivo_data>'2021-04-01 00:00:00' $query_candidato ORDER BY arquivo.arquivo_data DESC";
					$exeArquivo = mysqli_query($conexao,$sqlArquivo);		

					//$totalListaCandidatos = mysqli_num_rows($exeListaCandidatos);				
					while($verArquivo = mysqli_fetch_array($exeArquivo,MYSQLI_ASSOC)){
				?>
					<li>
						<p><a target="_blank" href="?pg=candidato&candidato=<?php echo $verArquivo['arquivo_candidato_id']; ?>"><?php echo utf8_encode($verArquivo['candidato_nome']); ?></a></p>
						
						<div style="position: relative; float: left width: 34%; margin: 2% auto;">
						<?php
							if(pathinfo($verArquivo['arquivo_foto'], PATHINFO_EXTENSION)==".mp4"){
						?>
							<video width="100%" controls style="max-width: 400px;">
								<source src="<?php echo $verArquivo['arquivo_foto']; ?>" type="video/mp4">
							</video>
						<?php
							} else { 
						?>							
							<span type="button" class="btn" data-toggle="modal" data-target="#arquivo<?php echo $verArquivo['arquivo_id']; ?>"> <img src="arquivo/<?php echo $verArquivo['arquivo_id']; ?>/<?php echo $verArquivo['arquivo_foto']; ?>" width="100%" style="max-width: 80px;" /></span>
						<?php
							}
						?>
						</div>
						<div style="position: relative; float: left width: 56%; margin: 2% auto;"><?php echo $verArquivo['arquivo_titulo']; ?></div>
						
						<div class="modal fade" id="arquivo<?php echo $verArquivo['arquivo_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
							  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
								  <div class="modal-content">
									  <div class="modal-header">											  
										  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
									  </div>										  
									  <div class="modal-body">
										  <img src="arquivo/<?php echo $verArquivo['arquivo_id']; ?>/<?php echo $verArquivo['arquivo_foto']; ?>" width="100%" style="max-width: 1050px;" />

									  </div>
									  <div class="modal-footer">											  
										  <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
									  </div>


								  </div>
							  </div>
						  </div>
						
					</li>
				<?php
					}
				?>
				</ul>
			</div>
		
        </div>
      </div>
      
    </div>
  </section>



</body>

</html>