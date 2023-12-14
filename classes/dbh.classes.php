<?php

class Dbh
{

    public function connect()
    {
        try {
            $username = "cosmicstryder_dkartzorodb";
            $password = "AlbaCaZapada";
            $dbh = new PDO('mysql:host=cosmicstryder.dk.mysql;dbname=cosmicstryder_dkartzorodb', $username, $password);
            return $dbh;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}
