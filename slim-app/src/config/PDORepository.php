<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PDORepository
 *
 * @author fede
 */
abstract class PDORepository {
    
    const USERNAME = "grupo54";
    const PASSWORD = "N2MxMmJhYTc0MWI2";
	const HOST ="localhost";
	const DB = "grupo54";
    
    
    private function getConnection(){
        $u=self::USERNAME;
        $p=self::PASSWORD;
        $db=self::DB;
        $host=self::HOST;
         /**se le puede aplicar un try Cath para cuidar la coneccion a BD , error de bd access */
        $connection = new PDO("mysql:dbname=$db;host=$host", $u, $p);
        return $connection;
    }
    
    /**se le puede aplicar un try Cath la ejecucion de la consulta y la devuelve */    
    protected function queryList($sql){
        $connection = $this->getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        /**devuelve un obj de tipo PDO para poser ser estilizado por fetch style */
        return $stmt->fetchAll(PDO::FETCH_OBJ);;
    }

    /**para usar>>>>>   PDO   bindParam */
    protected function query($sql){
        $connection = $this->getConnection();
        $stmt = $connection->prepare($sql);
        /**devuelve un obj de tipo PDO para poser ser estilizado por fetch style */
        return $stmt;
    }

    protected function con(){
        return $this->getConnection();
    }

}
