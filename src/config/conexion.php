<?php

/* Clase y funcion de conexion a la BD */
class db
{


    public function conexionDB()
    {
        $dbhost = "mdb-test.c6vunyturrl6.us-west-1.rds.amazonaws.com";
        $dbuser = "bsale_test";
        $dbpass = "bsale_test";
        $dbname = "bsale_test";
        $dbh = new PDO('mysql:host=' . $dbhost . '; dbname=' . $dbname . '; charset=UTF8', $dbuser, $dbpass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbh;
    }
}
