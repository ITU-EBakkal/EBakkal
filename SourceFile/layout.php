<?php
session_start();
ob_start();
include("dblayer.php");
class DesignPanel
{
    private $DbLayer;
    private $isAdmin;
    
	public function __construct()
	{
        $this->DbLayer = new DatabaseLayer;
        $this->isAdmin = false;
    }
    public function EBakkalPanel()
    {
        if(!($this->DbLayer->IsAdmin($_SESSION["LoginUser"])))
            return;
        echo '
        <div class="col-sm-9">
        <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" href="#home" role="tab">Ürün Gir</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#profile" role="tab">Sipariş Takip</a>
        </li>
      </ul>
      
      <!-- Tab panes -->
      <div class="tab-content">
        <div class="tab-pane active" id="home" role="tabpanel">
        ';
        $this->AddProduct();
        echo '
        </div>
        <div class="tab-pane" id="profile" role="tabpanel">Sipariş Takip Ekranı</div>
        
      </div>
        </div>
    ';
    }
	public function CarouselArea()
    {
        echo '
        <div class="col-sm-9">
            <div id="carouselExampleIndicators" style="background-color:#B0C4DE" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                <div class="carousel-item active">
                    <div style="align-items:center; justify-content: center;display: flex;"><img  class="d-block img-fluid" src="./img/bsk_1.png" alt="First slide"></div>
                </div>
                <div class="carousel-item">
                    <div style="align-items:center; justify-content: center;display: flex;"><img class="d-block img-fluid" src="./img/bsk_2.png" alt="Second slide"></div>
                </div>
                <div class="carousel-item">
                    <div style="align-items:center; justify-content: center;display: flex;"><img class="d-block img-fluid" src="./img/bsk_3.png" alt="Third slide"></div>
                </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Önceki</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Sonraki</span>
                </a>
            </div>
        </div>
    ';
    
    }
    public function AddProduct()
    {
        echo '
              <div style="margin-top:20px;" class="form-group">
                 <form action="index.php?Pg=AddProductControl" method="post">
                     <input type="text" name="urunadi"  class="form-control" style="margin-right:5px;margin-left:5px;;width:40%" id="eklemeurunadi" aria-describedby="emailHelp" placeholder="Ürün Adı">
                     <div class="p-1"></div>
                     <input type="text" name="ucret" class="form-control" style="margin-right:5px;margin-left:5px;;width:40%" id="eklemeucret" placeholder="Ücret">
                     <div class="p-1"></div>
                     <input type="text" name="stoksayisi"  class="form-control" style="margin-right:5px;margin-left:5px;;width:40%" id="eklemestoksayisi" aria-describedby="emailHelp" placeholder="Stok Sayisi">
                     <div class="p-1"></div>
                     <input type="text" name="aciklama"  class="form-control" style="margin-right:5px;margin-left:5px;;width:50% ; height: 3cm" id="eklemeaciklama" aria-describedby="emailHelp" placeholder="Açiklama">
                     <div class="p-1"></div>
                     <div style="align-items:center; justify-content: center;display: flex;"><button type="submit" style="cursor:pointer;" role="button" class="btn btn-primary btn-sm">Ürünü Ekle</button></div>
                 </form>  
              </div>
       ';
    }
    public function LoginArea()
    {
        if($_SESSION["LoginUser"] == "")
        {
        echo '
        <div class="col-sm-3">
        <div class="card">
          <div class="form-group">
             <form action="index.php?Pg=LoginControl" method="post">
                 <h6>Üye Giriş Alanı</h6>
                 <input type="email" name="email"  class="form-control" style="margin-right:5px;margin-left:5px;;width:95%" id="emailLogin" aria-describedby="emailHelp" placeholder="Email Adresi">
                 <div class="p-1"></div>
                 <input type="password" name="password" class="form-control" style="margin-right:5px;margin-left:5px;;width:95%" id="passwordLogin" placeholder="Şifre">
                 <div class="p-1"></div>
                 <div style="align-items:center; justify-content: center;display: flex;"><button type="submit" style="cursor:pointer;" role="button" class="btn btn-primary btn-sm">Üye Girişi Yap</button></div>
             </form>  
          </div>
        </div>          
        </div>
     ';
     }
     else
     {
         echo '
        <div class="col-sm-3">
        <div class="card">
        <ul id="LoginMenuArea">
            <li>
            <a href="#" id="navbarDropdownSiparislerim" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Email Ayarları</a>
            </li>
            <li>
            <a href="#" id="navbarDropdownSiparislerim" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Parolamı Değiştir</a>
            </li>
            <li>
            <a href="#" id="navbarDropdownSiparislerim" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Adreslerim</a>
            </li>
            <li>
            <a href="#" id="navbarDropdownSiparislerim" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Siparişlerim </a> <span class="badge badge-pill badge-warning"> 3</span>
            </li>
            ';
            if($this->DbLayer->IsAdmin($_SESSION["LoginUser"]))
            {
                echo '
                <li>
                <a href="index.php?Pg=EBakkalPanel">E-Bakkal Panel</a>
                </li> 
                ';       
            }
            echo '
            <li>
            <a href="index.php?Pg=Logout"> Çıkış Yap </a>
            </li>
        </ul>
        </div>          
        </div>
        ';
     }

    }
    public function Logout()
    {     
        echo '
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Güle güle!</h4>
            <p>Üye Çıkışı Başarılı. Birazdan Yönlendirileceksiniz.</p>
            <hr>
            <p class="mb-0">EBakkal ~ 2017</p>
        </div>
        ';
        $_SESSION["LoginUser"] = "";
        header("Refresh:2; url=index.php");
    }
    public function LoginControl()
    {
        echo '<div class="col-sm-9">';
        
        $email = $_POST["email"];
        $password = $_POST["password"];

        
        $query = $this->DbLayer->db->prepare("SELECT id FROM eb_users WHERE email=:email AND password=:pass");
        $query->bindValue(':email',$email);
        $query->bindValue(':pass',$password);
        $query->execute();
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
         
        if(count($rows)==1)
        {
            $_SESSION["LoginUser"] = $email;
            echo '
            <div class="alert alert-success" role="alert">
                <h4 class="alert-heading">Hoşgeldiniz!</h4>
                <p>Üye Girişi Başarılı. Birazdan Yönlendirileceksiniz.</p>
                <hr>
                <p class="mb-0">EBakkal ~ 2017</p>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%"></div>
                </div>
            </div>
            ';
            header("Refresh:1; url=index.php");
        }
        else
        {
            echo '
            <div class="alert alert-danger" role="alert">
            Üye Girişi Başarısız.<br/>
            Lütfen Girdiğiniz Bilgileri Kontrol Ediniz.
          </div>';
        }

        echo '</div>';

    }
	public function MiddleContentLayout()
	{
		switch($_GET["Pg"])
		{
			case "LoginControl":
			$this->LoginControl();
            break;

            case "Logout":
			$this->Logout();
            break;

            case "EBakkalPanel":
			$this->EBakkalPanel();
            break;
            
            default:
            $this->CarouselArea();
            break;
				
		}
	}
}
?>