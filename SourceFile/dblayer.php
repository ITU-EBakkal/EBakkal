<?php
session_start();
ob_start();
date_default_timezone_set('Europe/Istanbul');
?>
<?php
class DatabaseLayer
{
	public $db;
	
	public function OpenConnection()
	{

		
	}
    public function CloseConnection()
    {
        
	}

	public function UpdatePassword($Email ,$Password)
	{
		$query = $this->db->prepare("UPDATE eb_users SET password = :password WHERE email = :email");
		$query->bindValue(':email',$Email);
		$query->bindValue(':password',$Password);
		$query->execute();
	}

	public function PasswordControl($email , $password)
	{
		$query = $this->db->prepare("SELECT count(email) FROM eb_users WHERE email=:email AND password = :password");
		$query->bindValue(':email',$email);
		$query->bindValue(':password',$password);
        $query->execute();
		$Number = $query->fetch(PDO::FETCH_ASSOC);
		return $Number['count(email)'];
	}

	public function GetUserID($email)
	{
		$query = $this->db->prepare("SELECT id FROM eb_users WHERE email=:email");
        $query->bindValue(':email',$email);
        $query->execute();
		$rows = $query->fetch(PDO::FETCH_ASSOC);
		return $rows["id"];
	}
	public function AddProduct($ad,$ucret,$aciklama,$stok_sayisi,$cat_id,$img_path,$ebakkal_id)
	{

		$query = $this->db->prepare("INSERT INTO eb_products (ad,ucret,aciklama,stok_sayisi,cat_id,img_path,ebakkal_id) VALUES (:ad,:ucret,:aciklama,:stok_sayisi,:cat_id,:img_path,:ebakkal_id)");
		$query->bindValue(':ad',$ad);
		$query->bindValue(':aciklama',$aciklama);
		$query->bindValue(':stok_sayisi',$stok_sayisi);
		$query->bindValue(':cat_id',$cat_id);
		$query->bindValue(':img_path',$img_path);
		$query->bindValue(':ucret',$ucret);
		$query->bindValue(':ebakkal_id',$ebakkal_id);
        $query->execute();
	}

	public function AddUserBasket($ebakkal_id,$prod_id,$user_id)
	{
		$query = $this->db->prepare("INSERT INTO eb_baskets (ebakkal_id,prod_id,user_id) VALUES (:ebakkal_id,:prod_id,:user_id)");
		$query->bindValue(':ebakkal_id',$ebakkal_id);
		$query->bindValue(':prod_id',$prod_id);
		$query->bindValue(':user_id',$user_id);
		
		$query->execute();
		
	}

	public function GetActiveOrders()
	{
		$query = $this->db->prepare("SELECT id FROM eb_orders WHERE ebakkal_id = :ebakkal_id AND durum = 1");
        $query->bindValue(':ebakkal_id',$this->GetUserID($_SESSION["LoginUser"]));
        $query->execute();
		$rows = $query->fetchAll(PDO::FETCH_ASSOC);
		if(count($rows)>0)
			echo '<span class="badge badge-pill badge-warning">'.count($rows).'</span>';
		
	}
	public function Ekle()
	{
		$query = $this->db->prepare("INSERT INTO eb_users (email,password) VALUES('mk112','1234566')");
		$query->execute();		
	}
	public function IsEBakkal($email)
	{
		$query = $this->db->prepare("SELECT id FROM eb_users WHERE email=:email AND is_ebakkal=:is_eb");
        $query->bindValue(':email',$email);
        $query->bindValue(':is_eb',1);
        $query->execute();
		$rows = $query->fetchAll(PDO::FETCH_ASSOC);
		
		if(count($rows) == 1)
		{

			return true;
		}
		return false;
		
	}

	public function __construct()
	{
		try 
		{
			$this->db = new PDO("mysql:host=localhost;dbname=ebakkal_model", "root", "123456789");
			$this->db->query("SET CHARACTER SET utf8");
		} 
		    catch (PDOException $e ){
			print $e->getMessage();
	  	}
		
    }
    
}
?>