<?php 
	include_once("includes/conexao.php");
	include_once("includes/valida-cpf.php");
	$msg="";

	session_start();

	$tam = strlen($remote_addr); // Verifica o tamanho do texto.
	$max = 15; // exibirá apenas os 400 primeiros caracteres de um texto.

	// Se o texto for maior do que 14, retira o restante.
	if($tam > $max) {
		$remote_addr_corrigido = substr($remote_addr, 0, $max - $tam);
	} else { $remote_addr_corrigido = $remote_addr;}




	//Verifica Qtd Logs do REMOTE_ADDR
	//$sqlQtdRemoteAddr = "SELECT count(*) AS LOG_REMOTE_ADDR FROM log WHERE log.log_ip LIKE '%".($remote_addr_corrigido)."%'";

	$sqlQtdRemoteAddr = "SELECT cadastro_ip, count(*) AS LOG_REMOTE_ADDR FROM cadastro WHERE cadastro.cadastro_ip LIKE '". ($remote_addr_corrigido)."'";
	$exeQtdRemoteAddr = mysqli_query($conexao,$sqlQtdRemoteAddr);
	$verQtdRemoteAddr = mysqli_fetch_array($exeQtdRemoteAddr,MYSQLI_ASSOC);
	//$_SESSION['perfil_acessos'] = (int) ($verQtdRemoteAddr['LOG_REMOTE_ADDR']/2);

	$_SESSION['perfil_cadastros'] = $verQtdRemoteAddr['LOG_REMOTE_ADDR'];
	//$acessos = (int) ($verQtdRemoteAddr['LOG_REMOTE_ADDR']/2); 

	//if($_SESSION['perfil_cadastros']<300){ $IPValido=true; } else { $IPValido=false; }
	if($verQtdRemoteAddr['cadastro_ip']==$remote_addr_corrigido){ $IPValido=true; } else { $IPValido=false; }	

	//echo "<script>alert('".$remote_addr_corrigido." : ".$acessos."')</script>";
	
	if(isset($_POST['votacao_analisar']) && $_POST['votacao_analisar']=="sim"){
		//echo "<script>alert('POSTOU')</script>";
		
		$votacao_cpf = addslashes(preg_replace("/[^0-9]/", "", trim($_POST["votacao_cpf"])));
		// Verifica o CPF
		if ( valida_cpf( $votacao_cpf ) ) {
			//echo "<script>alert(CPF é válido.)</script>";
			$cpfValido=true;
		} else {
			$msg .= "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>x</a><strong>Aten&ccedil;&atilde;o!</strong>&nbsp;CPF Inv&aacute;lido.</div>";
			//echo "<script>alert('CPF Invalido.')</script>";
			$cpfValido=false;	
			session_destroy();
		}
	}
	
	if(isset($_POST['votacao_analisar']) && $_POST['votacao_analisar']=="sim" && $cpfValido===true){
		
		$votacao_candidato = addslashes(preg_replace("/[^0-9]/", "", $_POST["votacao_candidato"]));
		$votacao_nascimento_br = explode("/",$_POST["votacao_nascimento"]);
		$votacao_nascimento = addslashes($votacao_nascimento_br[2]."-".$votacao_nascimento_br[1]."-".$votacao_nascimento_br[0]);
		
		//$votacao_nascimento = addslashes($_POST["votacao_nascimento"]);		
		$votacao_status = "P";		
		$votacao_data = date("Y-m-d H:i:s");
		
		$sqlConsultaCpf = "SELECT * FROM cadastro INNER JOIN votacao ON cadastro.cadastro_id = votacao.votacao_cadastro_id WHERE cadastro.cadastro_cpf = '".$votacao_cpf."'";
		$exeConsultaCpf = mysqli_query($conexao,$sqlConsultaCpf);		
		//$verConsultaCpf = mysqli_fetch_array($exeConsultaCpf,MYSQLI_ASSOC);
		$totalConsultaCpf = mysqli_num_rows($exeConsultaCpf);
				
		if($totalConsultaCpf>0){
			//echo "<script>alert('CPF ja votou')</script>";			
			$msg .= "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>x</a><strong>Aten&ccedil;&atilde;o!</strong>&nbsp;Este CPF <strong>".mascara_cpf($votacao_cpf)."</strong> j&aacute; realizou o registro do voto.</div>";
			session_destroy();
			
		} else {
			//echo "<script>alert('Nao votou ainda')</script>";
			
			$sqlCpfCadastrar = "INSERT INTO cadastro (cadastro_ip, cadastro_cpf, cadastro_nascimento, cadastro_data, cadastro_descricao, cadastro_status) VALUES ('$remote_addr','$votacao_cpf','$votacao_nascimento', '$votacao_data','$log_dados','$votacao_status')";
			
			//die();
			$exeCpfCadastrar = mysqli_query($conexao,$sqlCpfCadastrar);
			$idCpfCadastrar = mysqli_insert_id($conexao);
			//$verConsultaCpf = mysqli_fetch_array($exeConsultaCpf,MYSQLI_ASSOC);
			//echo ">>>>>>".$totalConsultaCpf = mysqli_num_rows($exeConsultaCpf);
			
			$sqlCpfRegistrarVoto = "INSERT INTO votacao (votacao_cadastro_id, votacao_cadastro_cpf, votacao_candidato_id, votacao_data, votacao_status) VALUES ('$idCpfCadastrar','$votacao_cpf','$votacao_candidato','$votacao_data','$votacao_status')";
			$exeCpfRegistrarVoto = mysqli_query($conexao,$sqlCpfRegistrarVoto);
			//$verCpfRegistrarVoto = mysqli_insert_id($exeCpfRegistrarVoto);
			
			if($exeCpfCadastrar==true && $exeCpfRegistrarVoto==true){
				$msg .= "<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>x</a><strong>Sucesso!</strong>&nbsp;Parabéns, seu voto foi registrado. Obrigado por participar.</div>";
				
				$_SESSION['perfil_cpf'] = $votacao_cpf;
				$_SESSION['perfil_data'] = $votacao_data;
				
				
			} else {
				$msg .= "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>x</a><strong>Erro!</strong>&nbsp;Problemas com o registro do seu voto.</div>";
				
				session_destroy();
			}			
		}	
	}
	
	if($IPValido===false){
		$msg .= "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>x</a><strong>Aten&ccedil;&atilde;o!</strong>&nbsp;Este IP <strong>".$remote_addr."</strong> realizou ".$_SESSION['perfil_cadastros']." voto(s).</div>";
		//session_destroy();
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
  

<?php
	if($_GET['candidato']==1){ $nome = "Nézio Popular Botoado"; $idade = "48 anos"; $texto = "Feio igual um trem"; $img = "https://gatodabaixada.com.br/images/p-1.jpg"; $link = "https://gatodabaixada.com.br/?pg=candidato&candidato=1"; }
	elseif($_GET['candidato']==2){ $nome = "Mauro Popular Gauchinho"; $idade = "34 anos"; $texto = "Mais feio ainda"; $img = "https://gatodabaixada.com.br/images/p-2.jpg"; $link = "https://gatodabaixada.com.br/?pg=candidato&candidato=2"; }
	elseif($_GET['candidato']==3){ $nome = "Névez Popular Belo de Acorizal"; $idade = "36 anos"; $texto = "Esse num tem mais jeito, só nascendo de novo."; $img = "https://gatodabaixada.com.br/images/p-3.jpg"; $link = "https://gatodabaixada.com.br/?pg=candidato&candidato=3"; }
	elseif($_GET['candidato']==4){ $nome = "Ronail"; $idade = "32 anos"; $texto = "Amigos do bunitos mais num teve jeito, feio igual um trem também"; $img = "https://gatodabaixada.com.br/images/p-4.jpg"; $link = "https://gatodabaixada.com.br/?pg=candidato&candidato=4"; }
	elseif($_GET['candidato']==5){ $nome = "Luciano Popular Jagunço"; $idade = "29 anos"; $texto = "O Brad Pitt dos galã"; $img = "https://gatodabaixada.com.br/images/p-5.jpg"; $link = "https://gatodabaixada.com.br/?pg=candidato&candidato=5"; }
	elseif($_GET['candidato']==6){ $nome = "Ditão Popular Tubarão"; $idade = "37 anos"; $texto = "O simpático da galera com seu carote do lado."; $img = "https://gatodabaixada.com.br/images/p-6.jpg"; $link = "https://gatodabaixada.com.br/?pg=candidato&candidato=6";  }
	elseif($_GET['candidato']==7){ $nome = "Matheus Popular Papagaio"; $idade = "31 anos"; $texto = "O lindão loiro mais gato do baús."; $img = "https://gatodabaixada.com.br/images/p-7.jpg"; $link = "https://gatodabaixada.com.br/?pg=candidato&candidato=7";  }
	else {  $nome = "Gato da Baixada - Acorizal/MT"; $texto = "O concurso mais esperado do estado de Mato Grosso. Participe!!!"; $img = "https://gatodabaixada.com.br/images/candidatos.jpg"; $link = "https://gatodabaixada.com.br/index.php"; }
?>  
<meta property="og:site_name" content="Gato da Baixada - Acorizal/MT" />
<meta property="og:title" content="<?php echo $nome;?>" />
<meta property="og:url" content="<?php echo $link;?>" />
<meta property="og:image" content="<?php echo $img;?>" />
<meta property="og:description" content="<?php echo $texto;?>" />
	
<meta name="author" content="Guilherme Theo - Analista TI">

<title>Gato da Baixada</title>

<!-- slider stylesheet -->
<link rel="stylesheet" type="text/css" href="css/owl.carousel.min.css" />

<!-- bootstrap core css -->
<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

<!-- fonts style -->
<link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700&display=swap" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="css/style.css?jjf" rel="stylesheet" />
<!-- responsive style -->
<link href="css/responsive.css" rel="stylesheet" />
	
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-9XQCFRD9EX"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-9XQCFRD9EX');
</script>

<script data-ad-client="ca-pub-7648703795235196" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7648703795235196"
     crossorigin="anonymous"></script>
	
<script async custom-element="amp-auto-ads"
        src="https://cdn.ampproject.org/v0/amp-auto-ads-0.1.js">
</script>
	
<script type="text/javascript" src="js/whatsapp-button.js"></script>
	
<script type="text/javascript">
$(document).ready(function() {
	
	$("#votacao_cpf").mask("999.999.999-99");
	$("#votacao_nascimento").mask("99/99/9999");
	
	$("#login_cpf").mask("999.999.999-99");
	$("#pesquisar_cpf").mask("999.999.999-99");
	
    $(document).on("click", '.whatsapp', function() {

        if (isMobile()) {
            var text = $(this).attr("data-text");
            var url = $(this).attr("data-link");
            var message = encodeURIComponent(text) + " - " + encodeURIComponent(url);
            var whatsapp_url = "whatsapp://send?text=" + message;
            window.location.href = whatsapp_url;
        } else {
			var text = $(this).attr("data-text");
            var url = $(this).attr("data-link");
            var message = encodeURIComponent(text) + " - " + encodeURIComponent(url);
            var whatsapp_url = "https://wa.me/?text=" + message;
            window.location.href = whatsapp_url;			
        }
    });
});
</script>
	
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<meta name="facebook-domain-verification" content="py1nmj10tpklthiv41tjneah3yppxw" />
	
</head>

<body>

  <div class="hero_area">
    <!-- header section strats -->
    <header class="header_section">
      <div class="container">
        <nav class="navbar navbar-expand-lg custom_nav-container">
          <a class="navbar-brand" href="index.php">
            <span>GATO DA BAIXADA</span></a>          
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="s-1"> </span>
            <span class="s-2"> </span>
            <span class="s-3"> </span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="d-flex ml-auto flex-column flex-lg-row align-items-center">
              <ul class="navbar-nav  ">
                <li class="nav-item active">
                  <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>                
                <li class="nav-item">
                  <a class="nav-link" href="?pg=candidato"> Candidatos </a>
                </li>
				<li class="nav-item">
                  <a class="nav-link" href="?pg=resultado"> Resultado Parcial </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#contato"> Contato</a>
                </li>
              </ul>
            </div>
          </div>
        </nav>
      </div>
    </header>
    <!-- end header section -->
	<div class="container">      
	<?php echo $msg; //echo "<script>alert('".$_SESSION['perfil_acessos']."')</script>"; ?>		
	</div>
	<?php
	  if(!isset($_GET['pg'])){ 
	?>
    <section class=" slider_section ">
      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="container">
              <div class="row">
                <div class="col-md-6 ">
                  <div class="detail_box">
					  <h1>De Acorizal para o Brasil<br>com reconhecimento <span>NACIONAL</span></h1>
                    <p>O concurso mais esperado do estado de Mato Grosso. Participe!!!</p>
                    <a href="#votacao" class="">ESCOLHA O SEU PREFERIDO</a>
                  </div>
                </div>
                <div class="col-md-5 offset-md-1">
                  <div class="img-box">
                    <img src="images/candidatos.jpg" alt="" style="border: 10px solid #FFF;">
                  </div>
                </div>
              </div>
            </div>
          </div>          
          
        </div>
        
      </div>
    </section>
    <!-- end slider section -->
	<?php
	  }
	?>

  </div>
	<?php
        if(isset($_GET['pg'])){
			include_once($_GET['pg'].".php");
		} else { 
	?> 
  <!-- about section -->
  <section class="about_section layout_padding">
    <div class="container">
      <div class="row">
        
        <div class="col-md-7">
          <div class="detail-box">
			<img src="images/about-img.png" alt="" width="100%" style="max-width: 606px;" /><br>
			  
			<p><?php //echo $_SESSION['perfil_acessos']; ?></p>
			  
			<iframe width="100%" height="315" src="https://www.youtube.com/embed/uWBNoL5G22U" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="max-width: 400px;"></iframe>
            <div class="heading_container">
              <h2>Quem somos</h2>
            </div>
            <p>Idealizado pelos amigos Junior Barreto, Wagno Slash e Odilson Júnior, elege o homem mais <strong>“gato” da cidade</strong>, com destaque maior para o bairro da baixada. O concurso surgiu como uma brincadeira entre amigos que tomam tereré juntos e, desde sua edição passada, tem recebido atenção de moradores de diversas localidades do Brasil. Este grupo e demais amigos e moradores do município de Acorizal se reunem diariamente para conversar, fuxicar e zoar, sempre com respeito.</p>
			  <p><strong>Baixada</strong> na verdade se trata do bairro perto da beira do rio em Acorizal. O nome pegou principalmente porque acorizal está na baixada cuiabana, por isso ganhou uma amplitude maior.</p>
          </div>
        </div>
		 
		<div class="col-md-5" style="background-color: #f8f7fb; padding: 2%; -webkit-box-shadow: 0px 5px 9px -1px rgb(194 194 194 / 50%); -moz-box-shadow: 0px 5px 9px -1px rgba(194,194,194,0.6); box-shadow: 0px 5px 9px -1px rgb(194 194 194 / 50%);">
          <div class="col-sm heading_container" id="votacao">
			  <h2>Escolha o seu candidato</h2>
			  
	<?php
		$dataHoje = date("Y-m-d H:i:s");
		if($dataHoje<="2021-05-01 17:00:00"){
	?>
	  <?php
		if(isset($_POST['votacao_analisar'])){
			echo $msg;
	  
		} else { 
	  ?>
	  
	  <form name="votacao_form" method="post" style="text-align: left;">
		  
		  <p id="login-form-username">
			  <label for="votacao_cpf">Informe o seu CPF:</label>
			  <input id="votacao_cpf" type="text" name="votacao_cpf" class="form-control cpf-mask" placeholder="Ex.: 000.000.000-00" autocomplete="off" required="" maxlength="14">
		  </p>
		  <p>
			  <label for="votacao_nascimento">Informe sua data de nascimento:</label><br>
			  <input id="votacao_nascimento" type="text" name="votacao_nascimento" class="" placeholder="Ex.: 00/00/0000" autocomplete="off" required="" maxlength="14">
		  </p>
		  <h5 style="font-size: 0.8em;">*O voto será validado se a data de nascimento estiver correta.</h5>
		  <div style="position: relative; float: left; width: 100%; margin: 2% auto 0% auto;">		  
		  <input type="radio" id="candidato1" name="votacao_candidato" value="1" required>
		  <label for="candidato1"><img src="images/p-1.jpg" alt="" style="max-width: 80px;"> Nézio Popular Botoado</label><br>
		  <input type="radio" id="candidato2" name="votacao_candidato" value="2" required>
		  <label for="candidato2"><img src="images/p-2.jpg" alt="" style="max-width: 80px;"> Mauro Popular Gauchinho</label><br>
		  <input type="radio" id="candidato3" name="votacao_candidato" value="3" required>
		  <label for="candidato3"><img src="images/p-3.jpg" alt="" style="max-width: 80px;"> Névez Popular Belo de Acorizal</label><br>
		  <input type="radio" id="candidato4" name="votacao_candidato" value="4" required>
		  <label for="candidato4"><img src="images/p-4.jpg" alt="" style="max-width: 80px;"> Ronail</label><br>
		  <input type="radio" id="candidato5" name="votacao_candidato" value="5" required>
		  <label for="candidato5"><img src="images/p-5.jpg" alt="" style="max-width: 80px;"> Luciano Popular Jagunço</label><br>
		  <input type="radio" id="candidato6" name="votacao_candidato" value="6" required>
		  <label for="candidato6"><img src="images/p-6.jpg" alt="" style="max-width: 80px;"> Ditão Popular Tubarão</label><br>
		  <input type="radio" id="candidato7" name="votacao_candidato" value="7" required>
		  <label for="candidato7"><img src="images/p-7.jpg" alt="" style="max-width: 80px;"> Matheus Popular Papagaio</label><br>
		  </div>  
		  <div style="clear: both;">&nbsp;</div>
		  
		 <input type="hidden" name="votacao_data" value="<?php echo date("Y-m-d H:i:s"); ?>">
		 <input type="hidden" name="votacao_analisar" value="sim">
		 <p class="text-center"><input type="submit" class="btn btn-success" value="Votar"><i class="fa fa-calendar-check-o" aria-hidden="true"></i></p>
		  
	  </form>	  
	  <div style="clear: both;">&nbsp;</div>
	  <?php
		}
	  ?>
		<?php
		}
	  ?>
  
  		</div>
			
			<div id="votacao_tempo" style="position: relative; float: left; width: 92%; margin: 2% 4%; -webkit-box-shadow: 0px 5px 9px -1px rgb(194 194 194 / 50%); -moz-box-shadow: 0px 5px 9px -1px rgba(194,194,194,0.6); box-shadow: 0px 5px 9px -1px rgb(194 194 194 / 50%); text-align: center;" class="heading_container">
	  <h2 style="position: relative; float: left; width: 60%; margin: 2% 20%; color: #AB0A0C; text-align: center;">A votação encerra em: </h2>
	  <h1 id="demo" style="position: relative; float: left; width: 60%; margin: 2% 20%; font-size:3em; text-align: center;"></h1>
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
	  
	 <!--<iframe src="https://pt.surveymonkey.com/r/5CQZD26" style="position: relative; float: left; width: 100%; min-height: 500px;"></iframe>
	  
	  <iframe src="https://www.ferendum.com/pt/PID659016PSD2045983414" style="position: relative; float: left; width: 100%; min-height: 500px;"></iframe>-->
  
  </div>
		  
		  	<p class="text-center"><a href="?pg=resultado" class="btn btn-primary">Resultado Parcial</a>&nbsp;&nbsp;<a href="?pg=consulta" class="btn btn-primary">Consultar Voto</a></p>
		  	
        </div>
		  
      </div>
    </div>
  </section>
	
  

  <div style="clear: both;">&nbsp;</div>
	
  <section class="portfolio_section layout_padding">
    <div class="container">
      <div id="candidatos" class="heading_container">
        <h2>Perfil dos Candidatos 2021</h2>
        <p>Conheça melhor os candidatos a Gato da Baixada deste ano.</p>
      </div>

      <div class="layout_padding2-top">
        <div class="row" style="text-align: center;">
          <div class="col-md-3 col-sm-6">
            <div class="img-box">
              <img src="images/p-1.jpg" alt="" style="max-width: 300px;">
              <a href="?pg=candidato&candidato=1">
                <img src="images/link.png" alt="">
              </a>
            </div>
          </div>
          <div class="col-md-3 col-sm-6">
            <div class="img-box">
              <img src="images/p-2.jpg" alt="" style="max-width: 300px;">
              <a href="?pg=candidato&candidato=2">
                <img src="images/link.png" alt="">
              </a>
            </div>
          </div>
          <div class="col-md-3 col-sm-6">
            <div class="img-box">
              <img src="images/p-3.jpg" alt="" style="max-width: 300px;">
              <a href="?pg=candidato&candidato=3">
                <img src="images/link.png" alt="">
              </a>
            </div>
          </div>
          <div class="col-md-3 col-sm-6">
            <div class="img-box">
              <img src="images/p-4.jpg" alt="" style="max-width: 300px;">
              <a href="?pg=candidato&candidato=4">
                <img src="images/link.png" alt="">
              </a>
            </div>
          </div>
          <div class="col-md-3 col-sm-6">
            <div class="img-box">
              <img src="images/p-5.jpg" alt="" style="max-width: 300px;">
              <a href="?pg=candidato&candidato=5">
                <img src="images/link.png" alt="">
              </a>
            </div>
          </div>
          <div class="col-md-3 col-sm-6">
            <div class="img-box">
              <img src="images/p-6.jpg" alt="" style="max-width: 300px;">
              <a href="?pg=candidato&candidato=6">
                <img src="images/link.png" alt="">
              </a>
            </div>
          </div>
		  <div class="col-md-3 col-sm-6">
            <div class="img-box">
              <img src="images/p-7.jpg" alt="" style="max-width: 300px;">
              <a href="?pg=candidato&candidato=7">
                <img src="images/link.png" alt="">
              </a>
            </div>
          </div>
        </div>
      </div>      
    </div>
  </section>
	
  <section class="about_section layout_padding">
    <div class="container">
      <div id="premiacao" class="heading_container">
        <h2>Premiação</h2>
        <p>Confira a premiação do concurso gato da Baixada 2021</p>
      </div>

      <div class="layout_padding2-top">
        <div class="row" style="text-align: center;">        
		  <div class="col-md-12 col-sm-6">
            <div class="img-box">
              <img src="images/premiacao.jpg" alt="" style="max-width: 969px;">              
            </div>
          </div>
        </div>
      </div>      
    </div>
  </section>
	
  
  <div id="contato" class="footer_bg">
    <!-- info section -->
    <section class="info_section ">
      <div class="container">
        <div class="row">
          <div class="col-md-6 mb-4 mb-md-0 d-flex d-md-block flex-column align-items-center text-center text-md-left ">
            <div class="info_info">
              <h5>Informações</h5>
              <p>*Este site bem como toda a organização realizada para que este cncurso fosse realizado é gerenciada por amigos e moradores do município, sem quaisquer fins lucrativos.</p>
            </div>
          </div>
          <div class="col-md-6 mb-4 mb-md-0 d-flex d-md-block flex-column align-items-center text-center text-md-left ">
            <div class="info_contact">
              <h5>
                Endereço
              </h5>
              <div>
                <div class="img-box">
                  <img src="images/location-white.png" width="18px" alt="">
                </div>
                <p>Acorizal - MT</p>
              </div>
              <div>
                <div class="img-box">
                  <img src="images/telephone-white.png" width="12px" alt="">
                </div>
                <p>
                  +55 65 9 9918-8717
                </p>
              </div>
              <div>
                <div class="img-box">
                  <img src="images/envelope-white.png" width="18px" alt="">
                </div>
                <p>
                  contato@gatodabaixada.com.br
                </p>
              </div>
            </div>
          </div>
          
          
        </div>
      </div>
    </section>

    <!-- end info_section -->


    <!-- footer section -->
    <section class="container-fluid footer_section">
      <div class="container">
        <div class="row">
          <div class="col-lg-7 col-md-9 mx-auto">
            <p>
              Copyright &copy; 2021. Todos os direitos reservados. <a target="_blank" href="https://mandioqueiro.com.br">Mandioqueiro</a>
            </p>
          </div>
        </div>
      </div>
    </section>
    <!-- footer section -->

  </div>

  <?php
		}
  ?>
  

</body>

</html>