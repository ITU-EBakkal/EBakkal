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
	
	public function Ekle()
	{
		$query = $this->db->prepare("INSERT INTO eb_users (email,password) VALUES('mk112','1234566')");
		$query->execute();		
	}
	public function IsAdmin($email)
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