<?php

//conexion
$servidor = 'localhost';
$usuario = 'root';
$password = '';
$database = 'blog';
$db = mysqli_connect($servidor, $usuario, $password, $database);

mysqli_query($db, "SET NAMES 'utf8'");

//iniciar sesion
if(!isset($_SESSION)){
    session_start();
}


?>