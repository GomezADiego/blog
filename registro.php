<?php

if(isset($_POST)){

    require_once 'includes/conexion.php';

    if(!isset($_SESSION)){
        session_start();
    }

    //recoger los valores del forumario de registro
    $nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($db, $_POST['nombre']) : false;//sirve para interpretas los datos como un string para que no hagan parte de la consulta sql
    $apellidos = isset($_POST['apellidos']) ? mysqli_real_escape_string($db, $_POST['apellidos'])  : false;
    $email = isset($_POST['email']) ? mysqli_real_escape_string($db, trim($_POST['email'])) : false;
    $password = isset($_POST['password']) ? mysqli_real_escape_string($db, $_POST['password']) : false;

    //array de errores
    $errores = array();

    //validar los datos antes de guardarlos en la base de datos

    //validar el nombre
    if(!empty($nombre) && !is_numeric($nombre) && !preg_match("/[0-9]/", $nombre)){
        $nombre_validado = true;
    }else{
        $nombre_validado = false;
        $errores['nombre'] = "el nombre no es valido";
    }
    
    //validar el apellido
    if(!empty($apellidos) && !is_numeric($apellidos) && !preg_match("/[0-9]/", $apellidos)){
        $apellidos_validado = true;
    }else{
        $apellidos_validado = false;
        $errores['apellidos'] = "el apellido no es valido";
    }
    
    //validar el email
    if(!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)){
        $email_validado = true;
    }else{
        $email_validado = false;
        $errores['email'] = "el email no es valido";
    }

    //validar la contraseña
    if(!empty($password)){
        $password_validado = true;
    }else{
        $password_validado = false;
        $errores['password'] = "la contraseña esta vacia";
    }

    $guardar_usuario = false;
    if(count($errores) == 0){
        $guardar_usuario = true;

        //cifrar la contraseña
        $password_segura = password_hash($password, PASSWORD_BCRYPT, ['cost'=>4]);//cifra la contraseña 4 veces
        //var_dump(password_verify($password,$password_segura));//para verificar si la contraseña es la misma

        //insertar usuarios en la bd
        $sql = "INSERT INTO usuarios VALUES(null, '$nombre', '$apellidos', '$email', '$password_segura', CURDATE());";
        $guardar = mysqli_query($db, $sql);

        var_dump(mysqli_error($db));

        if($guardar){
            $_SESSION['completado'] = "el registro se ha completado con exito";
        }else{
            $_SESSION['errores']['general'] = "fallo al guardar el usuario!!";
        }

    }else{
        $_SESSION['errores'] = $errores;
        header('location: index.php');
    }
}

header('location: index.php');


?>