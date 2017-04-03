<?php
class Database
{
    private static $dbName = 'hsrochef' ;
    private static $dbHost = 'localhost' ;
    private static $dbUsername = 'hsrochef';
    private static $dbUserPassword = '604056';
     
    private static $cont  = null;
     
    public function __construct() {
        die('Init function is not allowed');
    }
     
    public static function connect()
    {
       // One connection through whole application
       if ( null == self::$cont )
       {     
        try
        {
          self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbUserPassword); 
        }
        catch(PDOException $e)
        {
          die($e->getMessage()); 
        }
       }
       return self::$cont;
    }
     
    public static function disconnect()
    {
        self::$cont = null;
    }
	
	public function displayListTableContents()
	{
		$pdo = Database::connect();
		$sql = 'SELECT * FROM crudCustomers ORDER BY cust_id DESC';
		foreach ($pdo->query($sql) as $row) {
			echo '<tr>';
			echo '<td>'. $row['cust_name'] . '</td>';
			echo '<td>'. $row['cust_phone'] . '</td>';
			echo '<td>'. $row['cust_address'] . '</td>';
			echo '<td><a class="btn" href="read.php?id='.$row['cust_id'].'">Read</a></td>';
			echo '</tr>';
		}
		Database::disconnect();
	}
	
	public function displayListHeading()
	{
		echo '<div class=container><div class=row><h3>Rochefort CRUD Tables</h3></div><div class=row><p><a class="btn btn-success"href=create.php>Create</a><table class="table table-bordered table-striped"><thead><tr><th>Name<th>Email Address<th>Mobile Number<th>Action<tbody>';
	}
	
	public function importBootstrap()
	{
		echo '<!DOCTYPE html><html lang=en><meta charset=utf-8><link href=https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css rel=stylesheet><script src=https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js></script>';
	}
	
	public function displayListFooting()
	{
		echo '</tbody></table></div></div></body></html>';
	}
	
	public function displayListScreen() 
	{
		Database::importBootstrap();
		Database::displayListHeading();
		Database::displayListTableContents();
		Database::displayListFooting();
	}
}
?>





