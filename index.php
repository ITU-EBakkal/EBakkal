<?php
session_start();
ob_start();
include("SourceFile/layout.php");
$DesignPanel = new DesignPanel;
?>

<!-- Doctype HTML5 -->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<!-- Instruct Internet Explorer to use its latest rendering engine -->
<meta http-equiv="x-ua-compatible" content="ie=edge">
<!-- Viewport for responsive web design -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Meta Description -->
<meta name="description" content="Description of the page less than 150 characters">
<link rel="stylesheet" type="text/css" href="./css/reset.css" />
<link rel="stylesheet" type="text/css" href="./css/style.css"/>
<link rel="stylesheet" type="text/css" href="./css/font-awesome.min.css"/>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>


<title>Bakkalınız Size Bir Tık Kadar Uzak! ~ EBakkal</title>
</head>

<body>
  <div id="FirstContainer" class="container">
    <div class="row">
      <div id="LogoArea" class="col-sm-3">
        <img class="img-responsive" height="80" src="./img/logo.png" alt="Logo"/>
      </div>
      <div id="ComboboxBasketArea" class="col-sm-9">

      <form action="index.php?Pg=SelectEBakkal" method="post">    
		  <select name="bakkal" style="margin-top:10px; width:350px; margin-bottom:10px;" class="custom-select form-control-lg">
       
      <?php
      
      $DesignPanel->GetEBakkals();
      ?>

      </select>
      <button class="btn btn-primary btn-lg">Onayla</button> 
      
      <?php

      if($_SESSION["SelectedEBakkal"]!="")
        echo '<a href="index.php?Pg=QuitAll"><img alt="Tüm Bakkallardan Çık" title="Bakkallardan Çık" width=32 height=32 src="./img/logout.png" /> </a>';
      ?>
      <a href="index.php?Pg=MyBasketArea"><span style="float:right; margin-top:25px; background-size:32px;32px;"><img src="./img/basket.png" /> <span class="badge badge-pill badge-info"><?php $DesignPanel->UserBasketCount(); ?></span> </span></a>
      <br/>
      </form>  
     

      <?php 
      if($_SESSION["SelectedEBakkal"]=="")
      {
        echo '<span class="badge badge-secondary">Bir Bakkal Seçmediniz</span>';
      }
      else
      {
        echo '<span class="badge badge-info">'.$DesignPanel->GetEBakkal($_SESSION["SelectedEBakkal"]).'</span>';
      }
      ?>
      
     

      </div>
     
    </div>

    <div class="row">
      
      <div style="margin-bottom:10px;" class="col-sm-12">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="index.php">
                <img src="./img/e_3232.png" width="30" height="30" class="d-inline-block align-top" alt="">
                EBakkal
              </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                  <a class="nav-link" href="index.php">Anasayfa </a>
                </li>

                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownTemelGida" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Temel Gıda
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdownTemelGida">
                    <a class="dropdown-item" href="index.php?Pg=FetchProduct&Cid=11">Kahvaltılık</a>
                    <a class="dropdown-item" href="index.php?Pg=FetchProduct&Cid=12">Meyve & Sebze</a>
                    <a class="dropdown-item" href="index.php?Pg=FetchProduct&Cid=13">İçeçek</a>
                    <a class="dropdown-item" href="index.php?Pg=FetchProduct&Cid=14">Bakliyat</a>
                    <a class="dropdown-item" href="index.php?Pg=FetchProduct&Cid=15">Tatlı & Şeker</a>
                    <a class="dropdown-item" href="index.php?Pg=FetchProduct&Cid=16">Diğer</a>
                  </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUnluMamuller" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Unlu Mamüller
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownUnluMamuller">
                      <a class="dropdown-item" href="index.php?Pg=FetchProduct&Cid=21">Ekmek</a>
                      <a class="dropdown-item" href="index.php?Pg=FetchProduct&Cid=22">Pasta</a>
                      <a class="dropdown-item" href="index.php?Pg=FetchProduct&Cid=23">Poğaca & Simit</a>
                      <a class="dropdown-item" href="index.php?Pg=FetchProduct&Cid=24">Diğer</a>
                    </div>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownKasap" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Kasap
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownKasap">
                      <a class="dropdown-item" href="index.php?Pg=FetchProduct&Cid=31">Kırmızı Et</a>
                      <a class="dropdown-item" href="index.php?Pg=FetchProduct&Cid=32">Beyaz Et</a>
                      <a class="dropdown-item" href="index.php?Pg=FetchProduct&Cid=33">Diğer</a>
                    </div>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownTemizlikUrunleri" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Temizlik Ürünleri
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownTemizlikUrunleri">
                      <a class="dropdown-item" href="index.php?Pg=FetchProduct&Cid=41">Deterjan</a>
                      <a class="dropdown-item" href="index.php?Pg=FetchProduct&Cid=42">Bulaşık Yıkama</a>
                      <a class="dropdown-item" href="index.php?Pg=FetchProduct&Cid=43">Şampuan & Sabun</a>
                      <a class="dropdown-item" href="index.php?Pg=FetchProduct&Cid=44">Ev Temizlik</a>
                      <a class="dropdown-item" href="index.php?Pg=FetchProduct&Cid=45">Diğer</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?Pg=FetchProduct&Cid=51">Diğer</a>
                </li>

              </ul>
              <form action="index.php?Pg=SearchProduct" method="post" class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-0" type="search" name="searchproduct" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-0 my-sm-0" type="submit">Search</button>
              </form>
            </div>
        </nav>
        
      </div>

    </div>
    <div class="row">
    
    <?php
      $DesignPanel->LoginArea();
    ?>

      <?php
      $DesignPanel->MiddleContentLayout();
      ?>

    </div>
  
    <div class="row">
        <div  class="col-sm-3">
          
        </div>

        <div style="margin-top:10px;" class="col-sm-9">
          
          <?php
          $DesignPanel->MiddleBottomProducts();
          ?>

         </div>

    </div>

    <div style="margin-top:30px;" class="row">
            <div class="col-md-3">
                    <div class="link-area">
                      <h3>HAKKIMIZDA</h3>
                      <P>İnsanların ihtiyaçlarına daha iyi karşılık verebilmek adına geliştirilmiş bir uygulamadır. En büyük amacımız aşağıdaki kriterlere uygun Ürünleri kullanıcıya sunmaktır:</P>
                      <li> Hızlı </li>
                      <li> Ucuz  </li>
                      <li> Kaliteli </li>
                    </div>
            </div>

            <div class="col-md-3">
                <div class="link-area">
                    <h3>ÜRÜNLER</h3>
                    <ul>
                    <li><a href="#"> Temel Gıda</a></li>
                    <li><a href="#"> Unlu Mamuller</a></li>
                    <li><a href="#"> Kasap</a></li>
                    <li><a href="#"> Temizlik Ürünleri</a></li>
                    <li><a href="#"> Diğer</a></li>
                    </ul>
                </div>
            </div>
                                    
            <div class="col-md-3">
                <div class="link-area">
                    <h3>DESTEK</h3>
                    <ul>
                    <li><a href="#"> Müşteri Hizmetleri</a></li>
                    <li><a href="#"> Sıkça Sorulan Sorular</a></li>
                    <li><a href="#"> </a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-3">
                <div class="link-area">
                   <h3>SOSYAL MEDYA</h3>
                   <a href="https://www.facebook.com/tugrul.kurt.777"><img src="img/fb.png"/> </a>
                   <a href="https://twitter.com"><img src="img/twitter.png"/></a>
                   <a href="https://plus.google.com/"><img src="img/google_p.png"/></a>
                   <a href="mailto:ebakkaliletisim@gmail.com"><img src="img/email.png"/></a>
                </div>
            </div>
    </div> <!-- row bitiş --> 
    <div class = "row">
      <h4 style = "margin:auto">   Copyright E-Bakkal © 20017 - 2020. Bütün hakları saklıdır.<h4/> 
    <div/>  
  </div>
        
</body>

</html>