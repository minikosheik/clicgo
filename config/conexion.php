<?php

class Conectar {
    protected $dbh;

    public function Conexion() {
        try {
            $this->dbh = new PDO(
                "sqlsrv:server=SISTEMAS\\SISTEMAS;database=clicgo;TrustServerCertificate=true",
                "clicgo",
                "Aislantes#2017.",
                array(PDO::SQLSRV_ATTR_ENCODING => PDO::SQLSRV_ENCODING_UTF8)
            );
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->dbh;
        } catch (Exception $e) {
            die("¡Error BD!: " . $e->getMessage());
        }
    }

    // En SQL Server esto realmente no es necesario, pero lo dejamos como placeholder
    public function set_names() {	
        return true;
    }

    public static function ruta() {
        return "http://localhost/ClicGo/";
    }
}
?>