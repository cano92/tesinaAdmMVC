<?php
class db{

    const USERNAME = "grupo54";
    const PASSWORD = "N2MxMmJhYTc0MWI2";
	const HOST ="localhost";
	const DB = "grupo54";
    
    
    public function getConnection(){
        $u=self::USERNAME;
        $p=self::PASSWORD;
        $db=self::DB;
        $host=self::HOST;
         /**se le puede aplicar un try Cath para cuidar la coneccion a BD , error de bd access */
        $connection = new PDO("mysql:dbname=$db;host=$host", $u, $p);
        return $connection;
    }


}