<?php

if(isset($_POST)){

    require_once 'includes/conexion.php';

    //recoger los valores del forumario de actualizacion
    $nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($db, $_POST['nombre']) : false;//sirve para interpretas los datos como un string para que no hagan parte de la consulta sql
    $apellidos = isset($_POST['apellidos']) ? mysqli_real_escape_string($db, $_POST['apellidos'])  : false;
    $email = isset($_POST['email']) ? mysqli_real_escape_string($db, trim($_POST['email'])) : false;

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

    $guardar_usuario = false;
    if(count($errores) == 0){
        $usuario = $_SESSION['usuario'];
        $guardar_usuario = true;

        //comprobar si el email ya existe
        $sql = "SELECT id, email FROM usuarios WHERE email = '$email'";
        $isset_email = mysqli_query($db, $sql);
        $isset_user = mysqli_fetch_assoc($isset_email);

        if($isset_user['id'] == $usuario['id'] || empty($isset_user)){

            //actualizar usuarios en la bd
            $usuario = $_SESSION['usuario'];
            $sql = "UPDATE usuarios SET nombre = '$nombre', apellidos = '$apellidos', email = '$email'
                    WHERE id = ".$usuario['id'];
            $guardar = mysqli_query($db, $sql);

            var_dump(mysqli_error($db));

            if($guardar){
                $_SESSION['usuario']['nombre'] = $nombre;
                $_SESSION['usuario']['apellidos'] = $apellidos;
                $_SESSION['usuario']['email'] = $email;

                $_SESSION['completado'] = "tus datos se han actualizado con exito";
            }else{
                $_SESSION['errores']['general'] = "fallo al actualizar tus datos!!";
            }
        }else{
            $_SESSION['errores']['general'] = "el usuario ya existe!!";
        }


    }else{
        $_SESSION['errores'] = $errores;
        
    }
}

header('location: mis-datos.php');


?>