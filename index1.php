<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  

<?php
	if($_GET['perfil']==1){ $nome = "Nézio Popular Botoado"; $idade = "55 anos"; $texto = "Feio igual um trem"; $img = "https://gatodabaixada.com.br/images/p-1.jpg"; $link = "https://gatodabaixada.com.br/?pg=perfil&perfil=1"; }
	elseif($_GET['perfil']==2){ $nome = "Mauro Popular Gauchinho"; $idade = "37 anos"; $texto = "Mais feio ainda"; $img = "https://gatodabaixada.com.br/images/p-2.jpg"; $link = "https://gatodabaixada.com.br/?pg=perfil&perfil=2"; }
	elseif($_GET['perfil']==3){ $nome = "Névez Popular Belo de Acorizal"; $idade = "36 anos"; $texto = "Esse num tem mais jeito, só nascendo de novo."; $img = "https://gatodabaixada.com.br/images/p-3.jpg"; $link = "https://gatodabaixada.com.br/?pg=perfil&perfil=3"; }
	elseif($_GET['perfil']==4){ $nome = "Ronail"; $idade = "32 anos"; $texto = "Amigos do bunitos mais num teve jeito, feio igual um trem também"; $img = "https://gatodabaixada.com.br/images/p-4.jpg"; $link = "https://gatodabaixada.com.br/?pg=perfil&perfil=4"; }
	elseif($_GET['perfil']==5){ $nome = "Luciano Popular Jagunço"; $idade = "32 anos"; $texto = "O Brad Pitt dos galã"; $img = "https://gatodabaixada.com.br/images/p-5.jpg"; $link = "https://gatodabaixada.com.br/?pg=perfil&perfil=5"; }
	elseif($_GET['perfil']==6){ $nome = "Ditão Popular Tubarão"; $idade = "37 anos"; $texto = "O simpático da galera com seu carote do lado."; $img = "https://gatodabaixada.com.br/images/p-6.jpg"; $link = "https://gatodabaixada.com.br/?pg=perfil&perfil=6";  }
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
  <link href="css/style.css" rel="stylesheet" />
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
	
<script async custom-element="amp-auto-ads"
        src="https://cdn.ampproject.org/v0/amp-auto-ads-0.1.js">
</script>
	
<script type="text/javascript" src="js/whatsapp-button.js"></script>
	
<script type="text/javascript">
$(document).ready(function() {
	
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
	
</head>

<body>

  <div class="hero_area">
    <!-- header section strats -->
    <header class="header_section">
      <div class="container">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
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
                  <a class="nav-link" href="#candidatos"> Candidatos </a>
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
                    <img src="images/candidatos.jpg" alt="">
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
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-4">
          <div class="img-box">
              <img src="images/about-img.png" alt="" /><br>
			  
			<iframe width="100%" height="315" src="https://www.youtube.com/embed/uWBNoL5G22U" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			  
          </div>
        </div>
        <div class="col-md-8">
          <div class="detail-box">
            <div class="heading_container">
              <h2>Quem somos</h2>
            </div>
            <p>Idealizado pelos amigos Junior Barreto, Wagno Slash e Odilson Júnior, elege o homem mais <strong>“gato”</strong>. O concurso surgiu como uma brincadeira entre amigos que tomam tereré juntos e, desde sua edição passada, tem recebido atenção de moradores de diversas localidades do Brasil. Este grupo e demais amigos e moradores do município de Acorizal se reunem diariamente para conversar, fuxicar e zoar, sempre com respeito.</p>
			  <p><strong>Baixada</strong> na verdade se trata do bairro perto da beira do rio em Acorizal. O nome pegou principalmente porque acorizal está na baixada cuiabana, por isso ganhou uma amplitude maior.</p>
          </div>
        </div>
      </div>
    </div>
  </section>
	
  <div id="votacao" style="position: relative; float: left; width: 60%; margin: 2% 20%; -webkit-box-shadow: 0px 5px 9px -1px rgb(194 194 194 / 50%); -moz-box-shadow: 0px 5px 9px -1px rgba(194,194,194,0.6); box-shadow: 0px 5px 9px -1px rgb(194 194 194 / 50%); text-align: center;" class="heading_container">
	  <h2 style="position: relative; float: left; width: 60%; margin: 2% 20%; color: #AB0A0C; text-align: center;">A votação tem início em: </h2>
	  <h1 id="demo" style="position: relative; float: left; width: 60%; margin: 2% 20%; font-size:3em; text-align: center;"></h1>
	  <script>
// Set the date we're counting down to
var countDownDate = new Date("Apr 28, 2021 07:00:00").getTime();

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
    document.getElementById("demo").innerHTML = "EXPIRED";
  }
}, 1000);
</script>
	  
	 <!--<iframe src="https://pt.surveymonkey.com/r/5CQZD26" style="position: relative; float: left; width: 100%; min-height: 500px;"></iframe>
	  
	  <iframe src="https://www.ferendum.com/pt/PID659016PSD2045983414" style="position: relative; float: left; width: 100%; min-height: 500px;"></iframe>-->
  
  </div>

  <div style="clear: both;">&nbsp;</div>
	
  <section class="portfolio_section layout_padding">
    <div class="container">
      <div id="candidatos" class="heading_container">
        <h2>Candidatos 2021</h2>
        <p>Confira os candidatos a Gato da Baixada deste ano.</p>
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
      <div id="premiacao" class="heading_container" style="text-align: center;">
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
  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.js"></script>

</body>

</html>