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
        if(!($this->DbLayer->IsEBakkal($_SESSION["LoginUser"])))
            return;
        echo '
        <div class="col-sm-9">
        <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" href="#addProduct" role="tab">Ürün Gir</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#checkOrders" role="tab">Gelen Siparişler'; 
          $this->DbLayer->GetActiveOrders();
          echo '</a>
        </li>
      </ul>
      
      <!-- Tab panes -->
      <div class="tab-content">
        <div class="tab-pane active" id="addProduct" role="tabpanel">
        ';
        $this->AddProduct();
        echo '
        </div>
        <div class="tab-pane" id="checkOrders" role="tabpanel">
        Mert
        
        </div>
        
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
    public function AddProductControl()
    {
        if(!($this->DbLayer->IsEBakkal($_SESSION["LoginUser"])))
            return;
        $urunadi = $_POST["urunadi"];
        $stoksayisi = $_POST["stoksayisi"];
        $aciklama = $_POST["aciklama"];
        $urun_ucreti = $_POST["urun_ucreti"];
        $kategori = $_POST["kategori"];
        $resim = $_FILES["resim_yukleme"]["name"];
        $target_dir = "uploads/";
        $target_file = $target_dir.basename($resim);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

        // echo "Ürün Adı : ". $urunadi." <br/>";
        // echo "Ürün Ücreti : ". $urun_ucreti." <br/>";
        // echo "Kategori : ". $kategori." <br/>";
        // echo "Stok Sayısı : ". $stoksayisi." <br/>";
        // echo "Açıklama : ". $aciklama." <br/>";
        // echo "Resim : ". $target_file ." <br/>";

        if (file_exists($target_file)) {
            echo '
            <div class="alert alert-danger" role="alert"><strong>Hata!!!!</strong> Dosya zaten mevcut</div>
            ';
            $uploadOk = 0;
        }
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo '
            <div class="alert alert-danger" role="alert">
            <strong>Hata!!!!</strong> Lütfen Uygun Bir resim formatı seçiniz
            </div>
          ';
            $uploadOk = 0;
        }
        if ($uploadOk == 0) {

        // if everything is ok, try to upload file
        } else {
             copy($_FILES["resim_yukleme"]["tmp_name"], $target_file);
             $this->DbLayer->AddProduct($urunadi,$urun_ucreti,$aciklama,$stoksayisi,$kategori,$_FILES["resim_yukleme"]["name"],$this->DbLayer->GetUserID($_SESSION["LoginUser"]));
             echo '
             <div class="alert alert-info" role="alert">
             Ürün Başarıyla Yüklendi.
             </div>
           ';
        }

    }
    public function AddProduct()
    {
        echo '
              <div style="margin-top:20px;" class="form-group">
                 <form action="index.php?Pg=AddProductControl" enctype="multipart/form-data" method="post">
                     <input type="text" name="urunadi" class="form-control" style="padding-right:15px;padding-left:15px;" id="eklemeurunadi" aria-describedby="emailHelp" placeholder="Ürün Adı">
                     <div class="p-1"></div>
                     <div style="padding-right:5px;" class="input-group">
                        <input type="number" step="0.01" name="urun_ucreti" class="form-control" placeholder="Ürün Ücreti" aria-label="Ürün Ücreti">
                        <span class="input-group-addon">TL</span>
                        <span class="input-group-addon">0,00</span>
                    </div>
                    <div style="margin-bottom:0px;margin-top:5px;">
                        Kategori :
                        <select name="kategori" class="custom-select form-control-lg">
                        ';
                        foreach($this->DbLayer->db->query('SELECT * FROM eb_categories') as $listele) 
                        {
                        
                            $ad = $listele['ad'];
                            $kategori_numarasi = $listele['cat_num'];
                            
                            if($kategori_numarasi % 10 == 0)
                            {
                                echo '<option style="color:red;" disabled>'.$ad.'</option>';
                            }
                            else
                            {
                                echo  '<option value="'.$kategori_numarasi.'">'.$ad . '</option>';
                            }
                        }
                        echo '
                        </select>
                    
                        </div>
                     <div class="p-1"></div>
                     <input type="number" step="1" name="stoksayisi"  class="form-control" style="padding-right:15px;padding-left:15px;" id="eklemestoksayisi" aria-describedby="emailHelp" placeholder="Stok Sayisi">
                     <div class="p-1"></div>
                     Görsel Seç <input type="file" name="resim_yukleme" id="resim_yukleme">
                     <textarea name="aciklama" class="form-control" style="padding-right:15px;padding-left:15px; rows="3" id="eklemeaciklama" placeholder="Açıklama"></textarea>
                     <div class="p-1"></div>
                     <div style="align-items:center; justify-content: center;display: flex;"><button type="submit" style="cursor:pointer;" role="button" class="btn btn-primary btn-lg">Ürünü Ekle</button></div>
                 </form>  
              </div>
       ';
    }
    public function LoginSuccess()
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
            <a href="#" id="navbarDropdownSiparislerim" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Siparişlerim </a>';
            
            echo ' 
            </li>
            ';
            if($this->DbLayer->IsEBakkal($_SESSION["LoginUser"]))
            {
                echo '
                <li>
                <a href="index.php?Pg=EBakkalPanel#checkOrders">E-Bakkal Panel</a> ';
                $this->DbLayer->GetActiveOrders();
                echo '
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
          <a style="margin:5px;" class="btn btn-success btn-sm" href="index.php?Pg=Signup" role="button">Üye Ol</a>
          <a style="margin:5px;" class="btn btn-warning btn-sm" href="index.php?Pg=LostPassword" role="button">Şifremi Unuttum</a>
        </div>          
        </div>
     ';
     }
     else
     {
        $this->LoginSuccess();
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
    public function Signup()
    {
        echo '
        <div class="col-sm-9">
        <div class="card">';
        echo '
        <form action="index.php?Pg=SignupControl" method="post">
        <!-- Form Name -->
        <legend>Yeni Bir Hesap Oluştur</legend>
        
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="lastname">İsim</label>  
          <div class="col-md-5">
          <input id="isim" name="isim" type="text" placeholder="İsmninizi giriniz" class="form-control input-md" required="">
            
          </div>
        </div>
        
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="firstname">Soy isim</label>  
          <div class="col-md-5">
          <input id="soyisim" name="soyisim" type="text" placeholder="Soy isminizi giriniz" class="form-control input-md" required="">
            
          </div>
        </div>
        
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="email">E-mail</label>  
          <div class="col-md-5">
          <input id="email" name="email" type="email" placeholder="Mailinizi giriniz" class="form-control input-md" required="">
          <span class="help-block">(ebakkal@ebakkal.com)</span>  
          </div>
        </div>
        
        
        <!-- Password input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="password">Parola</label>
          <div class="col-md-5">
            <input id="parola" name="parola" type="password" placeholder="Parolanızı giriniz" class="form-control input-md" required="">
            
          </div>
        </div>
        
        <!-- Password input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="confirmasipassword">Parolanın Onaylanması</label>
          <div class="col-md-5">
            <input id="parolaonayla" name="parolaonayla" type="password" placeholder="Parolanızı giriniz" class="form-control input-md" required="">
            <span class="help-block">Parolanızı tekrar giriniz</span>
          </div>
        </div>
        
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="username">İl</label>  
          <div class="col-md-5">
          <input id="il" name="il" type="text" placeholder="İl giriniz" class="form-control input-md" required="">
            
          </div>
        </div>
        
        <!-- Multiple Radios (inline) -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="gender">Üyelik Türü</label>
          <div class="col-md-4"> 
          <label class="radio-inline" for="gender-1">
              <input type="radio" name="kullanici" id="gender-1" value="kullanici"checked="checked">
              Kullanici
            </label>
            <label class="radio-inline" for="gender-0">
              <input type="radio" name="bakkal" id="gender-0" value="bakkal" >
              Bakkal
            </label> 
          </div>
        </div>
        
        <!-- Button -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="confirmation"></label>
          <div class="col-md-4">
            <button id="uyeol" name="uyeol" class="btn btn-primary">Üye Ol</button>
          </div>
        </div>
        
        </fieldset>
        </form>

        ';
        echo '</div></div>';

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

            case "AddProductControl":
            $this->AddProductControl();
            break;

            case "AddProductControl":
            $this->AddProductControl();
            break;

            case "Logout":
			$this->Logout();
            break;

            case "Signup":
            $this->Signup();
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