<?php
session_start();
ob_start();
include("SourceFile/layout.php");
$DesignPanel = new DesignPanel;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="keywords" content="bozuk para ile çalışan bilgisayar, para ile çalışan bilgisayar, jeton ile çalışan bilgisayar, netmatik, kiosk, bozuk para, 1 lira, bir lira, dinlenme tesisi, jeton, " />
<meta http-equiv="description" content="1 Lira ile çalışan internet üzerinden izlenebilen bilgisayarlar. Dinlenme tesislerinde internet bilgisayarları." />
<meta http-equiv="author" content="ESNET" />
<title>ESNET Kiosk Y&ouml;netim Sistemleri</title>
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/call_demand.js"></script>
<script type="text/javascript" src="js/headline-news.js"></script>
<link rel="stylesheet" type="text/css" href="css/main.css"/>
<link rel="shortcut icon" href="/favicon.ico">
<script type="text/javascript">
</script>
</head>
<body style="background-image: url(images/bg5.png)">
<?php include_once("SourceFile/analyticstracking.php") ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
    <div id="Wrapper">
    	<div id="TopRegion">
        	<div id="LogoField">
            <?php
			
			if($_SESSION["LoginUser"]=="")
			{
            	echo '<a title="AnaSayfa" href="index.php"><img id="SiteLogo" src="images/logo-last.gif" border="0" width="273" height="110" alt="Esnet Logo" /></a>';
			}
			else
			{
				echo '<a title="AnaSayfa" href="index.php?Pg=KioskState"><img id="SiteLogo" src="images/logo-last.gif" border="0" width="273" height="110" alt="Esnet Logo" /></a>';
			}
			
			?>
            
            </div>
            <div id="LoginAndMenus">
                <div id="LoginArea">
					<?php
					if($_SESSION["LoginUser"]=="")
					{
						$DesignPanel->LoginForm();
					}
					else
					{
						$DesignPanel->TopAreaWithLogin();
					}
					
					?>
                    
                </div>
                <div id="MenuArea">
                    <?php
					if($_SESSION["LoginUser"]=="")
					{
						echo
						'
						<style type="text/css">
							#MenuArea ul li {
								background-color: #2f8be8;
							}
						</style>
						';
						$DesignPanel->MenuAreaWithoutLogin();
					}
					else
					{
						echo
						'
						<style type="text/css">
							#MenuArea ul li {
								background-color: #ff0000;
							}
						</style>
						';
						$DesignPanel->MenuAreaWithLogin();
					}
					?>
                </div>
            </div>
        </div>
        <div id="Middle_Content">
			<?php
            $DesignPanel->MiddleContentLayout();
            ?>
        </div>

        <div style="background-color: #0066CC; height:5px;" class="SpaceBar"></div>

        <div id="CenterContent">
        	<?php
			if($_SESSION["LoginUser"]=="")
			{
	        	echo '<div id="SoftwareAttributes" style="background-image: url(images/software3232.png);background-repeat: no-repeat;background-position: 350px 15px;">';
			}
			else
			{
	        	echo '<div id="SoftwareAttributes" style="background-image: url(images/coin3232.png);background-repeat: no-repeat;background-position: 350px 15px;">';
			}
			?>
            
        	<?php
			if($_SESSION["LoginUser"]=="")
			{
	            echo '<h1 style="font-size:22px; color:#06C;">ES-NET Kiosk Yazılımı</h1>';
			}
			else
			{
				echo '<h1 style="font-size:22px; color:#06C;">Para Atılan Son 6 Bilgisayar</h1>';
			}
			?>
            
            <hr style="color:#F60;"/>
                <ul>
				  <?php
                  if($_SESSION["LoginUser"]=="")
                  {
					  $DesignPanel->ESNETKioskSoftwareonCenterofPage();
                  }
				  else
				  {
                      echo '<div id="AjaxLastSixCoinDiv">';
					  $DesignPanel->LastSixCoinInserted();
                      echo '</div>';
				  }
			
				  ?>

                </ul>

            </div>
            <div style="background-image: url(images/replacement_part3232.png);background-repeat: no-repeat;background-position: 250px 15px;" id="ReplacementPart">
                <?php
                    if($_SESSION["LoginUser"]=="")
                    {
                        echo'<h2 style="font-size:19px; color:#F60;">Yedek Par&ccedil;alarımız</h2>';
                    }
                    else
                    {
                        echo '<h2 style="font-size:19px; color:#F60;">Arızalı Son 6 Bilgisayarınız</h2>';
                    }

                ?>

                <hr />
                <ul>
                <?php
                    if($_SESSION["LoginUser"]=="")
                    {
                        echo
                        '
                        <li title="Devre">Elektronik Devre</li>
                        <li title="Bozuk-Para">Bozuk Para Tanıyıcı</li>
                        <li title="Kablo">A&ccedil;ılış Kablosu</li>
                        <li title="Modul">Bilgisayar Mod&uuml;l&uuml;</li>
                        <li title="Klavye">Klavye</li>
                        <a style="text-decoration:none;" href="#"><span style="color:#03C;  font-weight:bold; font-size:14px; font-family:Tahoma, Geneva, sans-serif; padding-left:200px;">Detay</span></a>
                        ';


                    }
                    else
                    {
                        $DesignPanel->ErrorPcLastSix();
                    }
                ?>


                </ul>

            </div>
            <div style="background-image: url(images/question_mark3232.png);background-repeat: no-repeat;background-position: 250px 15px;" id="WhyAreWe">

                <?php
                if($_SESSION["LoginUser"]=="")
                {
                    echo '<h3 style="font-size:17px; color:#333;">Neden Biz</h3>';
                }
                else
                {
                    echo '<h3 style="font-size:17px; color:#333;">Bugün En Çok Kazanan 6 Bölge</h3>';
                }
                ?>
                <hr />
                <ul>
                    <?php
                    if($_SESSION["LoginUser"]=="")
                    {
                        echo '
                        <li>Lisans A&ccedil;ılış &Uuml;creti Yok</li>
                        <li>Yıllık Lisans &Uuml;creti Yok</li>
                        <li>Uygun Lisans Ücretleri</li>
                        <li>M&uuml;şteri Memnuniyeti Odaklı &Ccedil;alışma</li>
                        <li>Ucuz Yedek Par&ccedil;alar</li>
                        <li>Tek işimiz Kiosk Bilgisayarları</li>
                        ';
                    }
                    else
                    {
                        $DesignPanel->TheMostRevenueOnRegions();

                    }
                    ?>
                </ul>
            </div>
        </div>
        
        <div style=" background-color: #CC6600; height:5px;" class="SpaceBar">
        
        </div>
        <div id="Bottom">
        <img src="images/footer.png" alt="Footer" title="Footer" border="0" width="1000" height="70"/>
        </div>
    </div>
    </td>
  </tr>
</table>
</body>
</html>