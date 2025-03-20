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
<script>
	function porcentagem_nx ( $parcial, $total ) {
		return ( $parcial * 100 ) / $total;
	}
</script>
</head>

<body class="sub_page">

  <!-- portfolio section -->

  <section class="portfolio_section layout_padding">
    <div class="container">
      <div class="heading_container">
        <h2>Resultado Parcial</h2>        
      </div>

      <div class="layout_top">
        <div class="row">
		<?php
			if(isset($_GET['perfil'])){
				
		?>
			<div class="col-md-4 col-sm-6">
				<div class="img-box">
				  <img src="images/p-<?php echo $_GET['perfil']; ?>.jpg" alt="">
				  <a href="?pg=perfil&perfil=<?php echo $_GET['perfil']; ?>">
					<img src="images/link.png" alt="">
				  </a>
				</div>
			</div>
			
			<div class="col-md-4 col-sm-6">
			<?php
				if($_GET['perfil']==1){ $nome = "Nézio Popular Botoado"; $idade = "55 anos"; $texto = "Feio igual um trem"; }
				elseif($_GET['perfil']==2){ $nome = "Mauro Popular Gauchinho"; $idade = "37 anos"; $texto = "Mais feio ainda";}
				elseif($_GET['perfil']==3){ $nome = "Névez Popular Belo de Acorizal"; $idade = "36 anos"; $texto = "Esse num tem mais jeito, só nascendo de novo.";}
				elseif($_GET['perfil']==4){ $nome = "Ronail"; $idade = "32 anos"; $texto = "Amigos do bunitos mais num teve jeito, feio igual um trem também";}
				elseif($_GET['perfil']==5){ $nome = "Luciano Popular Jagunço"; $idade = "32 anos"; $texto = "O Brad Pitt dos galã";}
				elseif($_GET['perfil']==6){ $nome = "Ditão Popular Tubarão"; $idade = "37 anos"; $texto = "O simpático da galera com seu carote do lado.";}
				else { echo "header:location"; }
			?>
				<h3><?php echo $nome;?></h3>
				<p><?php echo $idade;?></p>
				<p><?php echo $texto;?></p>
				
				<div class="btn-box" style="display: none;">
					<a href="#" data-link="https://gatodabaixada.com.br/?pg=perfil&perfil=<?php echo $_GET['perfil']; ?>" data-text="<?php echo $nome; ?>" class="whatsapp"><i class="fab fa-whatsapp-square">Compartilhar</i></a>
					
					<a href="https://gatodabaixada.com.br/?pg=perfil&perfil=<?php echo $_GET['perfil']; ?>">Compartilhar</a>
				</div>
		
		
				
			</div>
			
		<?php
			} else {
				
			function descobrir_porcentagem($valor_base, $valor){
				return $valor / $valor_base * 100;
			}
			//Conta a Qtd de Todos os Votos
			$sqlConsultaTodosVotos = "SELECT count(*) AS TODOS FROM votacao";
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
						
			//Conta a Qtd de Votos Candidatos
			$sqlVotosCandidato1 = "SELECT count(*) AS CANDIDATO1 FROM votacao WHERE votacao.votacao_status = 'A' AND votacao.votacao_candidato_id = 1";
			$exeVotosCandidato1 = mysqli_query($conexao,$sqlVotosCandidato1);		
			$verVotosCandidato1 = mysqli_fetch_array($exeVotosCandidato1,MYSQLI_ASSOC);
			//$totalConsultaVotos = mysqli_num_rows($exeVotosCandidato1);
			$candidato1 = $verVotosCandidato1['CANDIDATO1'];			
			$candidato1_porcentagem = number_format(descobrir_porcentagem ($totalConsultaVotos, $candidato1), 2);
							
			//Conta a Qtd de Votos Candidatos
			$sqlVotosCandidato2 = "SELECT count(*) AS CANDIDATO2 FROM votacao WHERE votacao.votacao_status = 'A' AND votacao.votacao_candidato_id = 2";
			$exeVotosCandidato2 = mysqli_query($conexao,$sqlVotosCandidato2);		
			$verVotosCandidato2 = mysqli_fetch_array($exeVotosCandidato2,MYSQLI_ASSOC);
			//$totalConsultaVotos = mysqli_num_rows($exeVotosCandidato1);
			$candidato2 = $verVotosCandidato2['CANDIDATO2'];			
			$candidato2_porcentagem = number_format(descobrir_porcentagem ($totalConsultaVotos, $candidato2), 2);
				
			//Conta a Qtd de Votos Candidatos
			$sqlVotosCandidato3 = "SELECT count(*) AS CANDIDATO3 FROM votacao WHERE votacao.votacao_status = 'A' AND votacao.votacao_candidato_id = 3";
			$exeVotosCandidato3 = mysqli_query($conexao,$sqlVotosCandidato3);		
			$verVotosCandidato3 = mysqli_fetch_array($exeVotosCandidato3,MYSQLI_ASSOC);
			//$totalConsultaVotos = mysqli_num_rows($exeVotosCandidato1);
			$candidato3 = $verVotosCandidato3['CANDIDATO3'];			
			$candidato3_porcentagem = number_format(descobrir_porcentagem ($totalConsultaVotos, $candidato3), 2);
				
			//Conta a Qtd de Votos Candidatos
			$sqlVotosCandidato4 = "SELECT count(*) AS CANDIDATO4 FROM votacao WHERE votacao.votacao_status = 'A' AND votacao.votacao_candidato_id = 4";
			$exeVotosCandidato4 = mysqli_query($conexao,$sqlVotosCandidato4);		
			$verVotosCandidato4 = mysqli_fetch_array($exeVotosCandidato4,MYSQLI_ASSOC);
			//$totalConsultaVotos = mysqli_num_rows($exeVotosCandidato1);
			$candidato4 = $verVotosCandidato4['CANDIDATO4'];			
			$candidato4_porcentagem = number_format(descobrir_porcentagem ($totalConsultaVotos, $candidato4), 2);
				
			//Conta a Qtd de Votos Candidatos
			$sqlVotosCandidato5 = "SELECT count(*) AS CANDIDATO5 FROM votacao WHERE votacao.votacao_status = 'A' AND votacao.votacao_candidato_id = 5";
			$exeVotosCandidato5 = mysqli_query($conexao,$sqlVotosCandidato5);		
			$verVotosCandidato5 = mysqli_fetch_array($exeVotosCandidato5,MYSQLI_ASSOC);
			//$totalConsultaVotos = mysqli_num_rows($exeVotosCandidato1);
			$candidato5 = $verVotosCandidato5['CANDIDATO5'];			
			$candidato5_porcentagem = number_format(descobrir_porcentagem ($totalConsultaVotos, $candidato5), 2);
				
			//Conta a Qtd de Votos Candidatos
			$sqlVotosCandidato6 = "SELECT count(*) AS CANDIDATO6 FROM votacao WHERE votacao.votacao_status = 'A' AND votacao.votacao_candidato_id = 6";
			$exeVotosCandidato6 = mysqli_query($conexao,$sqlVotosCandidato6);		
			$verVotosCandidato6 = mysqli_fetch_array($exeVotosCandidato6,MYSQLI_ASSOC);
			//$totalConsultaVotos = mysqli_num_rows($exeVotosCandidato1);
			$candidato6 = $verVotosCandidato6['CANDIDATO6'];			
			$candidato6_porcentagem = number_format(descobrir_porcentagem ($totalConsultaVotos, $candidato6), 2);
				
			//Conta a Qtd de Votos Candidatos
			$sqlVotosCandidato7 = "SELECT count(*) AS CANDIDATO7 FROM votacao WHERE votacao.votacao_status = 'A' AND votacao.votacao_candidato_id = 7";
			$exeVotosCandidato7 = mysqli_query($conexao,$sqlVotosCandidato7);		
			$verVotosCandidato7 = mysqli_fetch_array($exeVotosCandidato7,MYSQLI_ASSOC);
			//$totalConsultaVotos = mysqli_num_rows($exeVotosCandidato1);
			$candidato7 = $verVotosCandidato7['CANDIDATO7'];			
			$candidato7_porcentagem = number_format(descobrir_porcentagem ($totalConsultaVotos, $candidato7), 2);
				
			$candidatosPlacar = array($candidato1_porcentagem => $candidato1, $candidato2_porcentagem => $candidato2, $candidato3_porcentagem => $candidato3, $candidato4_porcentagem => $candidato4, $candidato5_porcentagem => $candidato5, $candidato6_porcentagem => $candidato6, $candidato7_porcentagem => $candidato7);
			
			//$candidatosPlacar = array($candidato1_porcentagem, $candidato2_porcentagem, $candidato3_porcentagem, $candidato4_porcentagem, $candidato5_porcentagem, $candidato6_porcentagem, $candidato7_porcentagem);
			sort($candidatosPlacar);
				$ordenar = array(0 => 1, 1 => 2, 2 => 3, 3 => 4, 4 => 5, 5 => 6, 6 => 7);
			foreach ($candidatosPlacar as $key => $val) {
		?>
			<div class="col-md-12 col-sm-6">
				<?  //echo $key.$val; ?>
			</div>
		<?php
			
			}
				
				
		?>
			<div class="col-md-12 col-sm-6">
			<div id="votacao_tempo" style="position: relative; float: left; width: 92%; margin: 2% 4%; -webkit-box-shadow: 0px 5px 9px -1px rgb(194 194 194 / 50%); -moz-box-shadow: 0px 5px 9px -1px rgba(194,194,194,0.6); box-shadow: 0px 5px 9px -1px rgb(194 194 194 / 50%); text-align: center;" class="heading_container">
				<p style="position: relative; float: left; width: 60%; margin: 2% 20%; color: #AB0A0C; text-align: center;">A votação encerra em: </p>
				<h3 id="demo" style="position: relative; float: left; width: 60%; margin: 2% 20%; text-align: center;"></h3>
				<script>
// Set the date we're counting down to
var countDownDate = new Date("May 1, 2021 17:00:01").getTime();

// Update the count down every 1 second
var countdownfunction = setInterval(function() {

  // Get todays date and time
  var now = new Date().getTime();
  
  // Find the distance between now an the count down date
  var distance = countDownDate - now;
  
  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
  
  // Output the result in an element with id="demo"
  document.getElementById("demo").innerHTML = days + "d " + hours + "h "
  + minutes + "m " + seconds + "s ";
  
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(countdownfunction);
    document.getElementById("demo").innerHTML = "VOTAÇÃO ENCERRADA";
  }
}, 1000);
</script>
			</div>
			</div>
				
			<div class="col-md-12 col-sm-6">
				<p style="text-align: center; font-size: 0.8em; font-weight: bold;">Apuração dos votos:</p>
				<div class="progress">
					<div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?php echo "100"; ?>%" aria-valuenow="<?php echo "100"; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo "100"; ?>>%</div>
				</div>
			</div>
			<p>&nbsp;</p>
			
		  <div class="col-md-12 col-sm-6">
			<div class="alert alert-primary" role="alert" style="text-align: center;">Total de votos parcial: <strong><?php echo $totalConsultaVotos; ?></strong></div>
		  </div>
			
          <div class="col-md-12 col-sm-6">
			  
			<table width="100%" border="0" align="center" cellpadding="10" cellspacing="10">
				<tr style="background-color: #C9C3C3">
				  <td valign="middle"></td>
				  <td width="36%" valign="middle">Candidato</td>
			  	  <td width="25%" align="center" valign="middle">Voto(s)</td>
					<td width="39%" align="center" valign="middle">%</td>
				</tr>
				
				
				
				
				<tr>
				  <td><img src="images/1lugar.png" width="80" /></td>
				  <td width="36%" valign="middle"><a href="?pg=candidato&candidato=7"><img src="images/p-7.jpg" alt="" style="max-width: 80px;"></a> <strong>Matheus</strong> Popular Papagaio</td>
				  <td width="25%" align="center" valign="middle"><h3><strong><?php echo $candidato7; ?></strong></h3></td>
				  <td width="39%" valign="middle"><div class="progress"><div class="progress-bar progress-bar-striped" role="progressbar" style="width: <?php echo $candidato7_porcentagem; ?>%;" aria-valuenow="<?php echo $candidato7_porcentagem; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $candidato7_porcentagem; ?>%</div></div></td>
		  	  </tr>
				
				<tr style="background-color: #f9f6f6;">
				  <td><img src="images/2lugar.png" width="80" /></td>
				  <td width="36%" valign="middle"><a href="?pg=candidato&candidato=2"><img src="images/p-2.jpg" alt="" style="max-width: 80px;"></a> <strong>Mauro</strong> Popular Gauchinho</td>
			    <td width="25%" align="center" valign="middle"><h3><strong><?php echo $candidato2; ?></strong></h3></td>
				  <td width="39%" valign="middle"><div class="progress"><div class="progress-bar" role="progressbar" style="width: <?php echo $candidato2_porcentagem; ?>%;" aria-valuenow="<?php echo $candidato2_porcentagem; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $candidato2_porcentagem; ?>%</div></div></td>
			  	</tr>
				
				<tr>
				  <td><img src="images/3lugar.png" width="80" /></td>
				  <td width="36%" valign="middle"><a href="?pg=candidato&candidato=3"><img src="images/p-3.jpg" alt="" style="max-width: 80px;"></a> <strong>Névez</strong> Popular Belo</td>
				  <td width="25%" align="center" valign="middle"><h3><strong><?php echo $candidato3; ?></strong></h3></td>
				  <td width="39%" valign="middle"><div class="progress"><div class="progress-bar" role="progressbar" style="width: <?php echo $candidato3_porcentagem; ?>%;" aria-valuenow="<?php echo $candidato3_porcentagem; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $candidato3_porcentagem; ?>%</div></div></td>
			  	</tr>
				
			  	<tr style="background-color: #f9f6f6;">
				  <td></td>
				  <td width="36%" valign="middle"><a href="?pg=candidato&candidato=4"><img src="images/p-4.jpg" alt="" style="max-width: 80px;"></a> <strong>Ronail</strong></td>
				  <td width="25%" align="center" valign="middle"><h3><strong><?php echo $candidato4; ?></strong></h3></td>
				  <td width="39%" valign="middle"><div class="progress"><div class="progress-bar progress-bar-striped" role="progressbar" style="width: <?php echo $candidato4_porcentagem; ?>%;" aria-valuenow="<?php echo $candidato4_porcentagem; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $candidato4_porcentagem; ?>%</div></div></td>
			  	</tr>
				
				<tr>
				  <td></td>
				  <td valign="middle"><a href="?pg=candidato&candidato=6"><img src="images/p-6.jpg" alt="" style="max-width: 80px;"></a> <strong>Ditão</strong> Popular Tubarão</td>
				  <td align="center" valign="middle"><h3><strong><?php echo $candidato6; ?></strong></h3></td>
				  <td valign="middle"><div class="progress"><div class="progress-bar progress-bar-striped" role="progressbar" style="width: <?php echo $candidato6_porcentagem; ?>%;" aria-valuenow="<?php echo $candidato6_porcentagem; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $candidato6_porcentagem; ?>%</div></div></td>
			  	</tr>
				
				<tr style="background-color: #f9f6f6;">
				  <td></td>
				  <td width="36%" valign="middle"><a href="?pg=candidato&candidato=1"><img src="images/p-1.jpg" alt="" style="max-width: 80px;"></a> <strong>Nézio</strong> Popular Botoado</td>
				  <td width="25%" align="center" valign="middle"><h3><strong><?php echo $candidato1; ?></strong></h3></td>
				  <td width="39%" valign="middle"><div class="progress"><div class="progress-bar progress-bar-striped" role="progressbar" style="width: <?php echo $candidato1_porcentagem; ?>%;" aria-valuenow="<?php echo $candidato1_porcentagem; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $candidato1_porcentagem; ?>%</div></div></td>
				</tr>
				
				<tr>
				  <td></td>
				  <td width="36%" valign="middle"><a href="?pg=candidato&candidato=5"><img src="images/p-5.jpg" alt="" style="max-width: 80px;"></a> <strong>Luciano</strong> Popular Jagunço</td>
				  <td width="25%" align="center" valign="middle"><h3><strong><?php echo $candidato5; ?></strong></h3></td>
				  <td width="39%" valign="middle"><div class="progress"><div class="progress-bar progress-bar-striped" role="progressbar" style="width: <?php echo $candidato5_porcentagem; ?>%;" aria-valuenow="<?php echo $candidato5_porcentagem; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $candidato5_porcentagem; ?>%</div></div></td>
			  	</tr>
				
				
			  	
				
			</table>
			
			
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