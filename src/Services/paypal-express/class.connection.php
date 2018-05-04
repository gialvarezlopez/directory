<?php
abstract class connectionDB{
	
	private static $sServer = DATABASE_HOSTDB;
	private static $sDbname = DATABASE_NAME;
	private static $sUser = DATABASE_USER;
	private static $sPass = DATABASE_PASSWORD;
	private static $sPort = DATABASE_PORT;
	private static $conn = "";

	//public static $prefijo = "lp_";
	public static function conn() {
		try{
	    	$mbd = new PDO("mysql:host=".self::$sServer.";port=".self::$sPort.";dbname=".self::$sDbname."", self::$sUser, self::$sPass);
	    	$mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Enable all exception for PDO
	    	$mbd->exec("set names utf8");
	        //$this->conn = $mbd;
	        return self::$conn = $mbd;
	    }catch(PDOException $e){
	        echo 'It Could not connect to the database, Detail: ' . $e->getMessage();
	    }
	}
}
?>