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
    public function Deliver()
    {
        $this->DbLayer->db->query("UPDATE eb_orders SET durum = 2 WHERE id=".$_GET["Oid"]."");
        header("Refresh:1; url=index.php?Pg=EBakkalPanel");
    }
    public function FinishTransaction()
    {
        $this->DbLayer->db->query("UPDATE eb_orders SET durum = 0 WHERE id=".$_GET["Oid"]."");
        header("Refresh:1; url=index.php?Pg=EBakkalPanel");
    }
    public function GiveAnOrder()
    {
        echo '<div class="col-sm-9">';

        $query = $this->DbLayer->db->prepare("SELECT count(id) as adet FROM eb_baskets WHERE user_id=:user_id ");
        $query->bindValue(':user_id',$this->DbLayer->GetUserID($_SESSION["LoginUser"]));
        $query->execute();
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        $adet = $rows[0]["adet"];

        if($adet <=0)
            return;


        $query = $this->DbLayer->db->prepare("INSERT INTO eb_orders (ebakkal_id,user_id) VALUES (:ebakkal_id,:user_id)");
        $query->bindValue(':ebakkal_id',$_SESSION["SelectedEBakkal"]);
        $query->bindValue(':user_id',$this->DbLayer->GetUserID($_SESSION["LoginUser"]));
        $query->execute();


        $query = $this->DbLayer->db->prepare("SELECT id FROM eb_orders WHERE user_id=:user_id ORDER BY id DESC LIMIT 1");
        $query->bindValue(':user_id',$this->DbLayer->GetUserID($_SESSION["LoginUser"]));
        $query->execute();
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        $order_id = $rows[0]["id"];

        foreach($this->DbLayer->db->query('SELECT bsk.id as bsk_id,prd.id as pid,prd.ad as ad,bsk.count,prd.ucret as fiyat,bsk.count * prd.ucret as toplam FROM `eb_baskets` bsk INNER JOIN eb_products prd ON prd.id = bsk.prod_id WHERE bsk.user_id='.$this->DbLayer->GetUserID($_SESSION["LoginUser"]).' AND bsk.ebakkal_id ='.$_SESSION["SelectedEBakkal"].' ') as $listele) 
        {
            $this->DbLayer->db->query('INSERT INTO eb_order_details (order_id,product_id,product_count) VALUES ('.$order_id.','.$listele["pid"].','.$listele["count"].')');
            $this->DbLayer->db->query('DELETE FROM eb_baskets WHERE id = '.$listele["bsk_id"].' ');
        }

        echo '
        <div class="alert alert-info" role="alert">
        Siparişiniz İlgili Ebakkala Yönlendirildi...
        </div>';
        header("Refresh:1; url=index.php?Pg=MyOrders");
        
        echo '</div>';
    }
    
    public function ExcludeFromBasket()
    {
        $Pid = $_GET["Pid"];

        $this->DbLayer->db->query("DELETE FROM eb_baskets WHERE id=".$Pid."");
        header("Refresh:1; url=index.php?Pg=MyBasketArea");
        
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
        
        ';
        $eb_id = $this->DbLayer->GetUserID($_SESSION["LoginUser"]);
        foreach($this->DbLayer->db->query('SELECT id,tarih,user_id,durum FROM eb_orders WHERE ebakkal_id = '.$eb_id.' AND durum <> 0 ORDER BY durum ASC,id DESC') as $listele)
        {
            $ord_id = $listele["id"];
            $tarih  = $listele["tarih"];
            $user_id = $listele["user_id"];
            $durum = $listele["durum"];
            $que_usr = $this->DbLayer->db->prepare('SELECT id,ad,soyad,adres FROM eb_users WHERE id = 4');
            $que_usr->execute();
            $rows_user = $que_usr->fetchAll(PDO::FETCH_ASSOC);

            echo '<div style="margin-top:10px;margin-bottom:30px;" class="card col-sm-12"><fieldset><legend>'.$tarih.' |';
            
            if($durum==1)
            {
                echo '<span style="margin-left:5px;" class="badge badge-danger"> Hazırlanıyor</span> ';
            }
            else if($durum == 2)
            {
                echo '<span style="margin-left:5px;" class="badge badge-warning"> Sevkiyatta</span> ';
            }
            

            if($durum==1)
                echo '<a style="margin-right:15px;" href="index.php?Pg=Deliver&Oid='.$ord_id.'"> <img src="./img/deliver.png" width="32" height="32" alt="Sevkiyata Gönder" title="Sevkiyata Gönder" /></a>';
            else if($durum ==2)
            {
                echo '<a style="margin-right:15px;" href="index.php?Pg=FinishTransaction&Oid='.$ord_id.'"> <img src="./img/finish.png" width="32" height="32" alt="İşlemi Bitir" title="İşlemi Bitir" /></a>';
            }
            echo '
            </legend>
            ';

            echo '

            <table class="table table-hover">
            <thead>
              <tr>
                <th>Bilgiler</th>
                <th>Değerler</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">Müşternin Adı</th>
                <td>'.$rows_user[0]["ad"].'</td>
              </tr>
              <tr>
              <th scope="row">Müşternin Soyadı</th>
              <td>'.$rows_user[0]["soyad"].'</td>
            </tr>
            <tr>
                <th scope="row">Adres</th>
                <td>'.nl2br($rows_user[0]["adres"]).'</td>
            </tr>
            </tbody>
          </table>
            
            ';
            
            echo '
            <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">Ürün Adı</th>
                <th scope="col">Adet</th>
                <th scope="col">Fiyat</th>
                <th scope="col">Toplam</th>
              </tr>
            </thead>
            <tbody>';
            foreach($this->DbLayer->db->query('SELECT od.product_count,p.ad,p.ucret,p.ucret * od.product_count as tutar FROM eb_order_details od INNER JOIN eb_products p ON p.id = od.product_id WHERE od.order_id = '.$ord_id.'') as $listele) 
            {
                echo '
                <tr>
                  <th scope="row">'.$listele["ad"].'</th>
                  <td><input disabled style="width:70px; text-align:right;" class="form-control" type="number" value="'.$listele["product_count"].'" id="example-number-input"></td>
                  <td>'.number_format($listele["ucret"],3).'</td>
                  <td>'.number_format($listele["tutar"],3).'</td>
                </tr>';
            }
            $query = $this->DbLayer->db->prepare('SELECT SUM(p.ucret * od.product_count) as top_tutar FROM eb_order_details od INNER JOIN eb_products p ON p.id = od.product_id WHERE od.order_id = '.$ord_id.'');
            $query->execute();
            $rows = $query->fetchAll(PDO::FETCH_ASSOC);
            
              echo '
            </tbody>
          </table>
            ';
            echo '<span class="col-sm-12" style="float:right;color:orange;text-align:right;font-weight:bold; background-color:#333; margin:auto; font-size:26px;">'.number_format($rows[0]["top_tutar"],3).' TL</span>';
            echo '</fieldset>
            </div>';
            
        } 


        echo '
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
                    <div style="align-items:center; justify-content: center;display: flex;"><a href="index.php?Pg=FetchProduct&Cid=41"><img  class="d-block img-fluid" src="./img/bsk_1.png" alt="First slide"></a></div>
                </div>
                <div class="carousel-item">
                    <div style="align-items:center; justify-content: center;display: flex;"><a href="index.php?Pg=FetchProduct&Cid=16"><img class="d-block img-fluid" src="./img/bsk_2.png" alt="Second slide"></a></div>
                </div>
                <div class="carousel-item">
                    <div style="align-items:center; justify-content: center;display: flex;"><a href="index.php?Pg=FetchProduct&Cid=11"><img class="d-block img-fluid" src="./img/bsk_3.png" alt="Third slide"></a></div>
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
    public function MiddleBottomProducts()
    {
        $Cid = $_GET["Cid"];

        $sql;
        if($_SESSION["SelectedEBakkal"]=="")
        {
            if($Cid =="")
                $sql = "SELECT * FROM eb_products";
            else
                $sql = "SELECT * FROM eb_products WHERE cat_id = ".$Cid;
        }
        else
        {
            if($Cid == "")
                $sql = "SELECT * FROM eb_products WHERE ebakkal_id = ".$_SESSION["SelectedEBakkal"];
            else
                $sql = "SELECT * FROM eb_products WHERE ebakkal_id = ".$_SESSION["SelectedEBakkal"] ." AND cat_id = ".$Cid;
        }
        $i = 0;
        $query = $this->DbLayer->db->prepare($sql);
        $query->execute();
        $listele = $query->fetchAll();

        echo '<div style="margin-bottom:10px;" class ="row">';
        foreach($listele as $liste)
        {
            $ad = $liste["ad"];
            $ucret = $liste["ucret"];
            $id = $liste["id"];
            $img_path = $liste["img_path"];
            if(!file_exists("uploads/".$img_path))
                $img_path = "gorsel_yok.png";

            //echo $i. "<br/>";
            echo '<div  class="text-center card col-sm-3">
            <img style="min-height:150px;height:150px;" src="uploads/'.$img_path.'" alt="Ürün Resmi Yok" class="rounded img-thumbnail"> 
            <h6> '.$ad.' </h6>
            <hr/>
            <h5> '.$ucret.' TL</h5>
            <a role="button" style="color:white; margin-bottom:10px;" href="index.php?Pg=AddBasket&ProdID='.$id.'" class="btn btn-dark">Sepete Ekle</a>
            </div>';

            $i++;
        }
        echo '</div>';
        




    
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
        $imageFileType = strtolower(substr($_FILES["resim_yukleme"]["name"],-3));

        if (file_exists($target_file)) {
            echo '
            <div class="alert alert-danger" role="alert"><strong>Hata!!!!</strong> Dosya zaten mevcut</div>
            ';
            $uploadOk = 0;
        }
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            
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
    public function UserBasketCount()
    {
        if($_SESSION["SelectedEBakkal"]<=0)
        {
            return;
        }

        $query = $this->DbLayer->db->prepare("SELECT count(id) as cid FROM eb_baskets WHERE ebakkal_id=:ebakkal_id AND user_id=:user_id");
        $query->bindValue(':ebakkal_id',$_SESSION["SelectedEBakkal"]);
        $query->bindValue(':user_id',$this->DbLayer->GetUserID($_SESSION["LoginUser"]));
        $query->execute();
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        
        echo $rows[0]["cid"];
        
       
    }
    public function GetEBakkals()
	{
        if($_SESSION["SelectedEBakkal"]=="")
            echo '<option disabled value="0">Hizmet Alınacak EBakkalı Seçiniz</option>';
        
        
		foreach($this->DbLayer->db->query('SELECT * FROM eb_ebakkals WHERE durum = 1') as $listele) 
		{
		
			$ad = $listele['adi'];
            $eb_id = $listele['user_id'];
            if($eb_id==$_SESSION["SelectedEBakkal"])
                echo  '<option  selected value="'.$eb_id.'">'.$ad . '</option>';
            else
                echo  '<option value="'.$eb_id.'">'.$ad . '</option>';
		}

		// echo '
		// 
        // <option value="1">One</option>
        // <option value="2">Two</option>
		// <option value="3">Three</option>
		// ';
    }
    public function GetEBakkal($eb_id)
    {
        foreach($this->DbLayer->db->query('SELECT adi FROM eb_ebakkals WHERE user_id ='.$eb_id) as $listele) 
		{
			return $listele['adi'];
            
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

    public function MyAddress(){
        echo '
        <div class="col-sm-9">
        <div class="card">';
       
        echo '
        <form action="index.php?Pg=MyAddressControl" method="post">
        <!-- Form Name -->
        <legend>Adresim</legend>
        
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="lastname">İlçe</label>  
          <div class="col-md-5">
          <input id="ilce" name="ilce" type="text" placeholder="İlçenizi giriniz" class="form-control input-md" required="">
            
          </div>
        </div>
        
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="firstname">Mahalle</label>  
          <div class="col-md-5">
          <input id="mahalle" name="mahalle" type="text" placeholder="Mahallenizi giriniz" class="form-control input-md" required="">
            
          </div>
        </div>
        
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="email">Sokak</label>  
          <div class="col-md-5">
          <input id="sokak" name="sokak" type="text" placeholder="Sokağınızı giriniz" class="form-control input-md" required="">
          </div>
        </div>
          
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="aciklama">Adres Tarifi</label>
          <div class="col-md-5">
            <input id="tarif" name="tarif" type="text" style="height:150px" class="form-control input-md" required="">
            
          </div>
        </div>
     
        <!-- Button -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="confirmation"></label>
          <div class="col-md-4">
            <button id="kaydet" name="kaydet" class="btn btn-primary">Kaydet</button>
          </div>
        </div>
        
        </fieldset>
        </form>

        ';
        echo '</div></div>';

    }

    public function LoginSuccess()
    {
        echo '
        <div class="col-sm-3">
        <div class="card">
        <ul id="LoginMenuArea">
            <li>
            <a href="index.php?Pg=MyInfo" id="navbarDropdownSiparislerim" role="button"  aria-haspopup="true" aria-expanded="false">Bilgilerim</a>
            </li>
            <li>
            <a href="index.php?Pg=ChangePassword" id="navbarDropdownSiparislerim" role="button"  aria-haspopup="true" aria-expanded="false">Parolamı Değiştir</a>
            </li>
            <li>
            <a href="index.php?Pg=MyAddress" id="navbarDropdownSiparislerim" role="button"  aria-haspopup="true" aria-expanded="false">Adresim</a>
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
                <a style="font-weight:bold;" href="index.php?Pg=EBakkalPanel">E-Bakkal Panel</a> ';
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
        $_SESSION["SelectedEBakkal"] = "";
        header("Refresh:2; url=index.php");
    }
    function QuitAll()
    {
        $_SESSION["SelectedEBakkal"] = "";
        header("Refresh:1; url=index.php");
        
    }
    function SignupControl()
    {
        $Name = $_POST['isim'];
        $Surname = $_POST['soyisim'];
        $Email = $_POST['email'];
        $Password = $_POST['parola'];
        $PasswordApprove =$_POST['parolaonayla'];
        $Province = $_POST['il'];
        $Address = $_POST['adres'];
        
        if($Password != $PasswordApprove)
        {
            echo 'Parolalar eşleşmemektedir. Lütfen aynı parolaları giriniz';
            header("Refresh:1; url=index.php?Pg=Signup ");
        }

        else if($this->DbLayer->EmailControl($Email) == 1)
        {
            echo $Email . '   zaten kullanılmaktadır. Lütfen farklı bir mail adresi giriniz';
            header("Refresh:1; url=index.php?Pg=Signup ");
        }
        else
        {
            $this->DbLayer->AddUser($Name,$Surname,$Email,$Password, $Province,$Address );
            echo 'Üyelik işleminiz başarılı bir şekilde gerçekleşti';
            
        }



    }

    function AddBasket()
    {
        if($_SESSION["SelectedEBakkal"]<=0)
        {
            echo '
            <div class="alert alert-danger" role="alert">
            Bakkal Seçmediniz!!!<br/>
            Lütfen Bir Bakkal Seçiniz...
          </div>';
          return;
        }

        $ProdID = $_GET["ProdID"];
        $ebakkal_id = $_SESSION["SelectedEBakkal"];
        $user_id = $this->DbLayer->GetUserID($_SESSION["LoginUser"]);

        $this->DbLayer->AddUserBasket($ebakkal_id,$ProdID,$user_id);
        header("Refresh:1; url=index.php");
        
    }

    function MyBasketArea()
    {
        echo '
        <div class="col-sm-9">
        <div class="card">';

        if($_SESSION["SelectedEBakkal"]<=0 || $_SESSION["LoginUser"]=="")
        {
            echo '<div class="alert alert-danger" role="alert">
            Bakkal Seçmeden, Sepetteki Ürünlerinizi Göremezsiniz.
            </div>';
            echo '</div></div>';
            
            return;
        }

        echo '
        <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">Ürün Adı</th>
            <th scope="col">Adet</th>
            <th scope="col">Fiyat</th>
            <th scope="col">Toplam</th>
          </tr>
        </thead>
        <tbody>';
        foreach($this->DbLayer->db->query('SELECT bsk.id,prd.ad as ad,bsk.count,prd.ucret as fiyat,bsk.count * prd.ucret as toplam FROM `eb_baskets` bsk INNER JOIN eb_products prd ON prd.id = bsk.prod_id WHERE bsk.user_id='.$this->DbLayer->GetUserID($_SESSION["LoginUser"]).' AND bsk.ebakkal_id ='.$_SESSION["SelectedEBakkal"].' ') as $listele) 
        {
            echo '
            <tr>
              <th scope="row">'.$listele["ad"].'</th>
              <td><input disabled style="width:70px; text-align:right;" class="form-control" type="number" value="'.$listele["count"].'" id="example-number-input"></td>
              <td>'.number_format($listele["fiyat"],3).'</td>
              <td>'.number_format($listele["toplam"],3).'<span style="float:right;"><a href="index.php?Pg=ExcludeFromBasket&Pid='.$listele["id"].'"><img src="./img/del_bsk.png" alt="Sil" title="Ürünü Kaldır"/> </a></span></td>
            </tr>';
        }
        $query = $this->DbLayer->db->prepare('SELECT SUM(bsk.count * prd.ucret) as toplam FROM `eb_baskets` bsk INNER JOIN eb_products prd ON prd.id = bsk.prod_id WHERE bsk.user_id='.$this->DbLayer->GetUserID($_SESSION["LoginUser"]).' AND bsk.ebakkal_id ='.$_SESSION["SelectedEBakkal"].' ');
        $query->execute();
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        
          echo '
        </tbody>
      </table>
        ';

        echo '<span style="margin:auto; font-size:22px; font-weight:bold;">Toplam : '.number_format($rows[0]["toplam"],2).'</span>';
        echo '<a class="btn btn-primary" style="color:white; font-weight:bold;" href="index.php?Pg=GiveAnOrder" role="button">Siparişi Ver</a>';
        echo '</div></div>';
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
          <input id="isim" name="isim" type="text" placeholder="İsmininizi giriniz" class="form-control input-md" required="">
            
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
        
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="aciklama">Adres</label>
          <div class="col-md-5">
            <input id="parola" name="adres" type="text" style="height:150px" class="form-control input-md" required="">
            
          </div>
        </div>
        

        <!-- Multiple Radios (inline) -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="gender">Üyelik Türü</label>
          <div class="col-md-4"> 
          <label class="radio-inline" for="gender-1">
              <input type="radio" name="kullanici" id="gender-1" value="0" >
              Kullanici
            </label>
            <label class="radio-inline" for="gender-0">
              <input type="radio" name="kullanici" id="gender-0" value="1" >
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

    public function SelectEBakkal ()
    {
        $ebakkal_id = $_POST["bakkal"];
        $_SESSION["SelectedEBakkal"] = $ebakkal_id;
        header("Refresh:1; url=index.php");


    }

    public function ChangePasswordControl()
    {
        $email = $_POST['mailforpasswordchange'];
        $oldPassword = $_POST['oldpassword'];
        $newPassword = $_POST['newpassword'];
        $newPasswordApproved = $_POST['newpasswordapproved'];
     
        if($this->DbLayer->PasswordControl($email , $oldPassword) == 1)
        {

            if($newPassword == $newPasswordApproved)
            {
             $this->DbLayer->UpdatePassword($email , $newPassword);
             echo '
                 <div class="alert alert-success" role="alert">
                     <h4 class="alert-heading">BAŞARILI!</h4>
                     <p>Parolanız başarılı bir şekilde değiştirildi</p>
                     <hr>
                     <p class="mb-0">EBakkal ~ 2017</p>
                 </div>';
                 header("Refresh:3; url=index.php");

            }
            else
            {

             echo '
             <div class="alert alert-danger" role="alert">
                 <h4 class="alert-heading">HATA!</h4>
                 <p>Parolalar uyuşmamaktadır. Lütfen aynı değerleri giriniz</p>
                 <hr>
                 <p class="mb-0">EBakkal ~ 2017</p>
             </div>';

                
            }
        }

        else
        {
            
         echo '
         <div class="alert alert-danger" role="alert">
             <h4 class="alert-heading">HATA!</h4>
             <p>Mail adresi ve kullanıcı adı eşleşmemektedir. Güvenliğiniz için parolanızı değiştirmemekteyiz</p>
             <hr>
             <p class="mb-0">EBakkal ~ 2017</p>
         </div>';
            

        }

    }

    public  function ChangePassword()
    {
        echo'
            <div class="col-sm-9">
                <h3 class="text-center">Parolayı Değiştir</h3>
                <hr/>
                <form action ="index.php?Pg=ChangePasswordControl" method = "post">
                    <div class="form-group">
                        <label>Mail adresinizi giriniz :</label>
                        <input type="text" class="form-control" placeholder ="mail adresiniz" name = "mailforpasswordchange" style = "width : 250px;"/>
                    </div>
                    <div class="form-group">
                        <label>Eski parolanızı giriniz :</label>
                        <input type="password" class="form-control" placeholder = "eski parolanız"name = "oldpassword" style = "width : 250px;"/>
                    </div>
                     <div class="form-group">
                        <label>Yeni parolanızı giriniz :</label>
                        <input type="password" class="form-control" placeholder="yeni parolanız" name = "newpassword" style = "width : 250px;"/>
                    </div>
                     <div class="form-group">
                        <label>Yeni parolanızı tekrar giriniz :</label>
                        <input type="password" class="form-control" placeholder = "tekrar giriniz"name = "newpasswordapproved" style = "width : 250px"/>
                    </div>
                   ';

                   


                   echo'

                    <button class="btn btn-primary btn-sm center-block">
                        Parolamı Değiştir
                    </button>
                </form>
            </div>
        ';
        

    }

    public function MyAddressControl()
    {
        
    }

    public function LostPasswordControl(){
        $email = $_POST['email'];
     

        $query = $this->DbLayer->db->prepare("SELECT id FROM eb_users WHERE email=:email");
        $query->bindValue(':email',$email);
        $query->execute();
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
    
        if(count($rows)==1){
            echo '
            <div class="alert alert-success" role="alert">
                <h4 class="alert-heading">Şifremi Unuttum</h4>
                <p>Şifreniz mail adresinize başarılı bir şekilde gönderilmiştir.</p>
                <hr>
                <p class="mb-0">EBakkal ~ 2017</p>
                </div>
            ';
          
        }
        else{
            echo '
            <div class="alert alert-danger" role="alert">
            Mail Adresiniz Başarısız.<br/>
            Lütfen girdiğiniz mail adresinizi Kontrol Ediniz.
          </div>';
        
        }
    }
    public function LostPassword(){
       echo'
        <div class = "col-sm-9 ">
       ';
        echo '
        <form action="index.php?Pg=LostPasswordControl" method="post">
        <div class="form-gap"></div>
        <div class="container">


           <div class="row">
               <div class="col-md-4 col-md-offset-4">
                   <div class="panel panel-default">
                     <div class="panel-body">
                       <div class="text-center">
                         <h3><i class="fa fa-lock fa-4x"></i></h3>
                         <h2 class="text-center">Şifremi Unuttum?</h2>
                         <p>Şifrenizi buraya mail adresinizi yazarak sıfırlayabilirsiniz.</p>
                         <div class="panel-body">
           
                           <form id="register-form" role="form" autocomplete="off" class="form" method="post">
           
                             <div class="form-group">
                               <div class="input-group">
                                 <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                 <input id="email" name="email" placeholder="E-mail Adresi" class="form-control"  type="email">
                               </div>
                             </div>
                             <div class="form-group">
                               <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Parolayı Sıfırla" type="submit">
                             </div>
                             
                             <input type="hidden" class="hide" name="token" id="token" value=""> 
                           </form>
           
                         </div>
                       </div>
                     </div>
                   </div>
                 </div>
           </div>
       </div>
        ';
        echo'
        </div>
        ';
    }

	public function MiddleContentLayout()
	{
		switch($_GET["Pg"])
		{
			case "LoginControl":
			$this->LoginControl();
            break;

            case "ChangePassword":
			$this->ChangePassword();
            break;

            case "SelectEBakkal":
            $this->SelectEBakkal();
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

            case "SignupControl":
            $this->SignupControl();
            break;

            case "EBakkalPanel":
			$this->EBakkalPanel();
            break;

            case "QuitAll":
            $this->QuitAll();
            break;

            case "AddBasket":
            $this->AddBasket();
            break;

            case "LostPassword":
            $this->LostPassword();
            break;

            case "LostPasswordControl":
            $this->LostPasswordControl();
            break;

            case "GiveAnOrder":
            $this->GiveAnOrder();
            break;

            case "MyBasketArea":
            $this->MyBasketArea();
            break;

            case "MyAddress":
            $this->MyAddress();
            break;

            case "MyAddressControl":
            $this->MyAddressControl();
            break;

            case "ChangePasswordControl":
            $this->ChangePasswordControl();
            break;

            case "ExcludeFromBasket":
            $this->ExcludeFromBasket();
            break;

            case "Deliver":
            $this->Deliver();
            break;

            case "FinishTransaction":
            $this->FinishTransaction();
            break;
            
            default:
            $this->CarouselArea();
            break;
				
		}
	}
}
?>