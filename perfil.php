<?php
session_start();
if(!isset($_SESSION['perfil_cpf'])){
	session_destroy();
	echo '<meta http-equiv="refresh" content="0; url=https://gatodabaixada.com.br/index.php">';
	//echo "<script>alert('Cadastro Correto')</script>";		
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

  <title>Gato da Baixada</title>

</head>

<body class="sub_page">

  <!-- portfolio section -->

  <section class="portfolio_section layout_padding">
    <div class="container">
      <div class="heading_container">
        <h2>Perfil</h2>
        <p>Confira o Perfil de cada um dos candidatos</p>
      </div>

      <div class="layout_padding2-top">
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
				elseif($_GET['perfil']==7){ $nome = "Matheus Popular Papagaio"; $idade = "25 anos"; $texto = "Mais novo concorrente.";}
				else { }
			?>
				<h3><?php echo $nome;?></h3>
				<p><?php echo $idade;?></p>
				<p><?php echo $texto;?></p>
				
				<div class="btn-box" style="display: none;">
					<a href="#" data-link="https://gatodabaixada.com.br/?pg=perfil&perfil=<?php echo $_GET['perfil']; ?>" data-text="<?php echo $nome; ?>" class="whatsapp"><i class="fab fa-whatsapp-square">Compartilhar</i></a>
					
					<a href="https://gatodabaixada.com.br/?pg=perfil&perfil=<?php echo $_GET['perfil']; ?>">Compartilhar</a>
				</div>
		
		
				
			</div>
			
			<div class="col-md-12 col-sm-6">
				
				<div class="btn-box">
        <a href="https://gatodabaixada.com.br/?pg=perfil">
          Confira os outros candidatos
        </a>
      </div>
				
			</div>
			
		<?php
			} else { 
		?>
			
          <div class="col-md-3 col-sm-6">
            <div class="img-box">
              <img src="images/p-1.jpg" alt="">
              <a href="?pg=perfil&perfil=1">
                <img src="images/link.png" alt="">
              </a>
            </div>
          </div>
          <div class="col-md-3 col-sm-6">
            <div class="img-box">
              <img src="images/p-2.jpg" alt="">
              <a href="?pg=perfil&perfil=2">
                <img src="images/link.png" alt="">
              </a>
            </div>
          </div>
          <div class="col-md-3 col-sm-6">
            <div class="img-box">
              <img src="images/p-3.jpg" alt="">
              <a href="?pg=perfil&perfil=3">
                <img src="images/link.png" alt="">
              </a>
            </div>
          </div>
          <div class="col-md-3 col-sm-6">
            <div class="img-box">
              <img src="images/p-4.jpg" alt="">
              <a href="?pg=perfil&perfil=4">
                <img src="images/link.png" alt="">
              </a>
            </div>
          </div>
          <div class="col-md-3 col-sm-6">
            <div class="img-box">
              <img src="images/p-5.jpg" alt="">
              <a href="?pg=perfil&perfil=5">
                <img src="images/link.png" alt="">
              </a>
            </div>
          </div>
          <div class="col-md-3 col-sm-6">
            <div class="img-box">
              <img src="images/p-6.jpg" alt="">
              <a href="?pg=perfil&perfil=6">
                <img src="images/link.png" alt="">
              </a>
            </div>
          </div>
			
		  <div class="col-md-3 col-sm-6">
            <div class="img-box">
              <img src="images/p-7.jpg" alt="">
              <a href="?pg=perfil&perfil=7">
                <img src="images/link.png" alt="">
              </a>
            </div>
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